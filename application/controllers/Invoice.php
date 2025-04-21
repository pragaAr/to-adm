<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

use Mpdf\Mpdf;

class Invoice extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('datatables');

    $this->load->model('M_Invoice', 'Invoice');

    if (empty($this->session->userdata('id'))) {
      $this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
      redirect('auth');
    }
  }

  public function index()
  {
    $data['title']  = 'Data Invoice';

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/trans/invoice/index', $data);
    $this->load->view('layout/template/footer');
  }

  public function getInvoice()
  {
    header('Content-Type: application/json');

    echo $this->Invoice->getData();
  }

  public function getDetailData()
  {
    $nomor = $this->input->post('nomor');

    $query  = $this->Invoice->getDataByNomor($nomor);

    $datasj = $this->Invoice->getInvData($nomor);

    $reccu = [];

    foreach ($datasj as $item) {
      $reccu[] = $item->reccu;
    }

    $detail = $this->Invoice->getDetailData($nomor, $reccu);

    $response = [
      'nomor'   => $query->nomor_inv,
      'cust'    => $query->nama,
      'datasj'  => $datasj,
      'detail'  => $detail
    ];

    echo json_encode($response);
  }

  public function add()
  {
    $data['title']  = 'Tambah Data Invoice';

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/trans/invoice/add', $data);
    $this->load->view('layout/template/footer');
  }

  public function cekNomor()
  {
    $nomor    = $this->input->post('nomor');

    $cekdata  = $this->Invoice->getNomorInv($nomor);

    $response = str_replace('/', '-', $cekdata->nomor_inv);

    echo json_encode($response);
  }

  public function proses()
  {
    $userid     = $this->session->userdata('id');
    $countRow   = count($this->input->post('sj'));
    $rc         = $this->input->post('rc');
    $noorder    = $this->input->post('noorder');
    $tgl        = date('Y-m-d', strtotime($this->input->post('tgl')));
    $nomor      = $this->input->post('noinv');
    $sj         = $this->input->post('sj');
    $custid     = $this->input->post('pengirim');
    $cust       = strtolower($this->input->post('selectedCust'));
    $kode       = strtolower($this->input->post('selectedKodeCust'));
    $berat      = $this->input->post('valberat');
    $dateAdd    = date('Y-m-d H:i:s');
    $tipe       = 'invoice';
    $month      = date('m');
    $noReplace  = str_replace('/', '-', $nomor);

    $dataReccu = [];

    for ($a = 0; $a < $countRow; $a++) {
      $reccu = $rc[$a];
      if (!in_array($reccu, $dataReccu)) {
        $dataReccu[] = $reccu;
      }
    }

    $jmlreccu = count($dataReccu);

    $datainv = [
      'nomor_inv'   => $nomor,
      'cust_id'     => $custid,
      'jml_reccu'   => $jmlreccu,
      'jml_sj'      => $countRow,
      'dateAdd'     => $tgl,
      'user_id'     => $userid,
    ];

    $datadt = [];

    for ($i = 0; $i < $countRow; $i++) {
      array_push($datadt, ['nomor_inv' => $nomor]);
      $datadt[$i]['reccu']        = $rc[$i];
      $datadt[$i]['no_order']     = $noorder[$i];
      $datadt[$i]['surat_jalan']  = $sj[$i];
      $datadt[$i]['berat']        = $berat[$i];
    }

    $proses = $this->Invoice->addData($datainv, $datadt);

    if ($proses) {
      $response = [
        'status'    => 'success',
        'title'     => 'Success',
        'text'      => 'Data Berhasil Ditambahkan',
        'nomorinv'  => $noReplace
      ];
    } else {
      $response = [
        'status'    => 'error',
        'title'     => 'Error',
        'text'      => 'Data Gagal Ditambahkan',
        'nomorinv'  => null
      ];
    }

    echo json_encode($response);
  }

  function bulanRomawi($month)
  {
    switch ($month) {
      case 1:
        return 'i';
      case 2:
        return 'ii';
      case 3:
        return 'iii';
      case 4:
        return 'iv';
      case 5:
        return 'v';
      case 6:
        return 'vi';
      case 7:
        return 'vii';
      case 8:
        return 'viii';
      case 9:
        return 'ix';
      case 10:
        return 'x';
      case 11:
        return 'xi';
      case 12:
        return 'xii';
      default:
        return '';
    }
  }

  public function print()
  {
    $nomor  = $this->input->get('invoice');
    $ppn    = $this->input->get('ppn');

    if ($nomor === null) {
      echo 'tidak ada data yang ditampilkan';
    } else {
      $str    = str_replace('-', '/', $nomor);
      $upperstr = strtoupper($str);

      $query  = $this->Invoice->getDataByNomor($str);

      if ($query === null) {
        echo 'tidak ada data yang ditampilkan';
      } else {
        $datainv  = $this->Invoice->getInvData($str);

        $reccu = [];

        foreach ($datainv as $item) {
          $reccu[] = $item->reccu;
        }

        $detail = $this->Invoice->getDetailData($str, $reccu);

        $data = [
          'title'     => 'Invoice',
          'nomor'     => $query->nomor_inv,
          'cust'      => $query->nama,
          'tgl'       => $query->dateAdd,
          'datainv'   => $datainv,
          'detail'    => $detail,
          'ppnvalue'  => $ppn,
        ];

        $mpdf = new Mpdf([
          'mode'          => 'utf-8',
          'format'        => 'A4',
          'orientation'   => 'P',
          'SetTitle'      => $str,
          'margin_left'   => 5,
          'margin_right'  => 5,
          'margin_top'    => 5,
          'margin_bottom' => 20,
        ]);

        $content  = $this->load->view('layout/trans/invoice/print', $data, true);

        $mpdf->SetHTMLFooter("<p class='page-number-footer'>Invoice - $upperstr | Halaman {PAGENO} Dari {nb}</p>");
        $mpdf->AddPage();
        $mpdf->WriteHTML($content);

        $mpdf->Output("$str.pdf", 'I');
      }
    }
  }

  public function test()
  {
    $str      = 'ims/3/han/iv/24';

    $query    = $this->Invoice->getDataByNomor($str);

    $datainv  = $this->Invoice->getInvData($str);

    $reccu = [];

    foreach ($datainv as $item) {
      $reccu[] = $item->reccu;
    }

    $detail = $this->Invoice->getDetailData($reccu);

    $data = [
      'title'   => 'Invoice',
      'nomor'   => $query->nomor_inv,
      'cust'    => $query->nama,
      'datainv' => $datainv,
      'detail'  => $detail,
    ];

    $this->load->view('layout/trans/invoice/test', $data);
  }

  public function delete()
  {
    $nomor = $this->input->post('nomor');

    $data = $this->Invoice->deleteData($nomor, $jenis);

    echo json_encode($data);
  }
}
