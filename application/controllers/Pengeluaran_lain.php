<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

use Mpdf\Mpdf;

class Pengeluaran_lain extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('datatables');

    $this->load->model('M_Pengeluaran_lain', 'Etc');

    if (empty($this->session->userdata('id'))) {
      $this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
      redirect('auth');
    }
  }

  public function index()
  {
    $data['title']  = 'Data Pengeluaran Lain-lain';

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/adm/etc/index', $data);
    $this->load->view('layout/template/footer');
  }

  public function getPengeluaranLain()
  {
    header('Content-Type: application/json');

    echo $this->Etc->getData();
  }

  public function getKode()
  {
    $data = $this->Etc->generateKode();

    echo json_encode($data);
  }

  public function cek()
  {
    $kd   = $this->input->post('kd');
    $cek  = $this->Etc->cekKode($kd);

    echo json_encode($cek);
  }

  public function getDetail()
  {
    $kd     = $this->input->post('kd');

    $data   = $this->Etc->getDataByKd($kd);
    $detail = $this->Etc->getDetailDataByKd($kd);

    $response = [
      'data'   => $data,
      'detail' => $detail
    ];

    echo json_encode($response);
  }

  public function add()
  {
    $data['title']  = 'Tambah Pengeluaran Lain-lain';

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/adm/etc/add', $data);
    $this->load->view('layout/template/footer');
  }

  public function proses()
  {
    $count      = count($this->input->post('keperluan'));

    $kd         = $this->input->post('kode');
    $tanggal    = date('Y-m-d', strtotime($this->input->post('tanggal')));
    $kryid      = $this->input->post('karyawan');

    $keperluan  = $this->input->post('keperluan');
    $item       = $this->input->post('item');
    $nominal    = preg_replace("/[^0-9\.]/", "", $this->input->post('nominal'));
    $total      = preg_replace("/[^0-9\.]/", "", $this->input->post('total'));
    $userid     = $this->session->userdata('id');

    $data = [
      'kd'            => $kd,
      'karyawan_id'   => $kryid,
      'jml_nominal'   => $total,
      'jml_keperluan' => $count,
      'tanggal'       => $tanggal,
      'dateAdd'       => date('Y-m-d H:i:s'),
      'user_id'       => $userid,
    ];

    $detail = [];

    for ($i = 0; $i < $count; $i++) {
      array_push($detail, ['kd' => $kd]);
      $detail[$i]['keperluan']  = $keperluan[$i];
      $detail[$i]['jml_item']   = $item[$i];
      $detail[$i]['nominal']    = $nominal[$i];
    }

    $proses = $this->Etc->addData($data, $detail);

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
    $kode  = $this->input->get('nomor');

    if ($kode === null) {
      echo 'tidak ada data yang ditampilkan';
    } else {
      $query = $this->Etc->getDataByKd($kode);

      if ($query === null) {
        echo 'tidak ada data yang ditampilkan';
      } else {
        $detail   = $this->Etc->getDetailDataByKd($kode);
        $upperstr = strtoupper($kode);

        $data = [
          'title'   => 'Pengeluaran Kas',
          'kode'    => $query->kd,
          'kry'     => $query->nama,
          'total'   => $query->jml_nominal,
          'tgl'     => $query->tanggal,
          'detail'  => $detail,
        ];

        $mpdf = new Mpdf([
          'mode'          => 'utf-8',
          'format'        => [165, 215],
          'orientation'   => 'L',
          'SetTitle'      => "pengeluaran-kas-lain-lain-$kode",
          'margin_left'   => 5,
          'margin_right'  => 5,
          'margin_top'    => 5,
          'margin_bottom' => 10,
        ]);

        $content  = $this->load->view('layout/adm/etc/print', $data, true);

        $mpdf->SetHTMLFooter("<p class='page-number-footer'>Pengeluaran Kas Lain-lain - $upperstr | Halaman {PAGENO} Dari {nb}</p>");
        $mpdf->AddPage();
        $mpdf->WriteHTML($content);

        $mpdf->Output("$kode.pdf", 'I');
      }
    }
  }

  public function delete()
  {
    $kd   = $this->input->post('kd');

    $data = $this->Etc->deleteData($kd);

    echo json_encode($data);
  }
}
