<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

use Mpdf\Mpdf;

class Persensopir extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('datatables');

    $this->load->model('M_Persensopir', 'Persen');

    if (empty($this->session->userdata('id'))) {
      $this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
      redirect('auth');
    }
  }

  public function index()
  {
    $data['title'] = 'Data Persen Sopir';

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/adm/persen/index', $data);
    $this->load->view('layout/template/footer');
  }

  public function getPersenSopir()
  {
    header('Content-Type: application/json');

    echo $this->Persen->getData();
  }

  public function cek()
  {
    $kd   = $this->input->post('kd');
    $cek  = $this->Persen->cekKode($kd);

    echo json_encode($cek);
  }

  public function getDetailData()
  {
    $kd         = $this->input->post('kd');
    $query      = $this->Persen->getDataByKd($kd);
    $salesorder = $this->Persen->dataSalesOrderByKd($kd);
    $sanguorder = $this->Persen->dataSanguOrderByKd($kd);

    $response = [
      'kdpersen'    => $query->kd,
      'sopir'       => $query->nama,
      'salesorder'  => $salesorder,
      'sanguorder'  => $sanguorder
    ];

    echo json_encode($response);
  }

  public function add()
  {
    $data['title']  = 'Tambah Data Persen Sopir';

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/adm/persen/add', $data);
    $this->load->view('layout/template/footer');
  }

  public function getGenerateKd()
  {
    $data = $this->Persen->getKd();

    echo json_encode($data);
  }

  public function proses()
  {
    $count        = count($this->input->post('noorder'));

    $kd           = $this->input->post('kd');
    $date         = date('Y-m-d H:i:s');
    $sopirid      = $this->input->post('sopirid');
    $noorder      = $this->input->post('noorder');
    $platno       = $this->input->post('platno');
    $totharga     = preg_replace("/[^0-9\.]/", "", $this->input->post('totharga'));
    $persen1      = $this->input->post('persen1');
    $persen2      = $this->input->post('persen2');
    $totsangu     = preg_replace("/[^0-9\.]/", "", $this->input->post('totsangu'));
    $diterima     = preg_replace("/[^0-9\.]/", "", $this->input->post('diterima'));
    $totditerima  = preg_replace("/[^0-9\.]/", "", $this->input->post('total'));
    $userid       = $this->session->userdata('id');

    $data = [
      'kd'              => $kd,
      'sopir_id'        => $sopirid,
      'jml_order'       => $count,
      'total_diterima'  => $totditerima,
      'user_id'         => $userid,
      'dateAdd'         => $date,
    ];

    $detail = [];

    for ($i = 0; $i < $count; $i++) {
      array_push($detail, ['no_order'  => $noorder[$i]]);
      $detail[$i]['kd']         = $kd;
      $detail[$i]['platno']     = $platno[$i];
      $detail[$i]['persen1']    = $persen1[$i];
      $detail[$i]['persen2']    = $persen2[$i];
      $detail[$i]['tot_biaya']  = $totharga[$i];
      $detail[$i]['tot_sangu']  = $totsangu[$i];
      $detail[$i]['diterima']   = $diterima[$i];
    }

    $dataOrder = [];

    for ($j = 0; $j < $count; $j++) {
      $dataOrder[] = array(
        'no_order'          => $noorder[$j],
        'status_persen'     => 1,
        'kd_persen'         => $kd
      );
    }

    $proses = $this->Persen->addData($data, $detail, $dataOrder);

    if ($proses) {
      $response = [
        'status'  => 'success',
        'title'   => 'Success',
        'text'    => 'Data Berhasil Ditambahkan',
        'kd'      => $kd
      ];
    } else {
      $response = [
        'status'  => 'error',
        'title'   => 'Error',
        'text'    => 'Data Gagal Ditambahkan',
        'kd'      => null
      ];
    }

    echo json_encode($response);
  }

  public function print()
  {
    $kd  = $this->input->get('kode');

    if ($kd === null) {
      echo 'tidak ada data yang ditampilkan';
    } else {

      $cekkd  = $this->Persen->cekKode($kd);

      if ($cekkd === 0) {
        echo 'tidak ada data yang ditampilkan';
      } else {
        $sopir = $this->Persen->getSopirByKdPersen($kd);
        $order = $this->Persen->getDataOrderPersenByKdPersen($kd);
        $sangu = $this->Persen->getDataSanguOrderByKdPersen($kd);

        $data = [
          'title' => 'Persen Sopir',
          'sopir' => $sopir,
          'order' => $order,
          'sangu' => $sangu,
        ];

        $content  = $this->load->view('layout/adm/persen/print', $data, true);

        $mpdf = new Mpdf([
          'mode'          => 'utf-8',
          'format'        => 'A5',
          'orientation'   => 'L',
          'SetTitle'      => "pengeluaran-kas-persen-sopir-$kd",
          'margin_left'   => 5,
          'margin_right'  => 5,
          'margin_top'    => 5,
          'margin_bottom' => 5,
        ]);

        $upper = strtoupper($kd);

        $mpdf->SetHTMLFooter("<p class='page-number-footer'>Persen Sopir - $upper | Halaman {PAGENO} dari {nb}</p>");
        $mpdf->AddPage();
        $mpdf->WriteHTML($content);

        $mpdf->Output("$kd.pdf", 'I');
      }
    }
  }

  public function delete()
  {
    $kd   = $this->input->post('kd');
    $noorder = $this->Persen->getDataDetailPersenByKd($kd);

    $updateOrder = [];

    foreach ($noorder as $res) {
      $updateOrder[] = array(
        'no_order'      => $res['no_order'],
        'status_persen' => 0,
        'kd_persen'     => '',
      );
    }

    $response = $this->Persen->deleteData($kd, $updateOrder);

    echo json_encode($response);
  }
}
