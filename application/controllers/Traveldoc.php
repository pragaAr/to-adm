<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

use Mpdf\Mpdf;

class Traveldoc extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('datatables');

    $this->load->model('M_Traveldoc', 'SJ');

    if (empty($this->session->userdata('id'))) {
      $this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
      redirect('auth');
    }
  }

  public function index()
  {
    $data['title']  = 'Data Surat Jalan';

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/trans/surat-jalan/index', $data);
    $this->load->view('layout/template/footer');
  }

  public function add()
  {
    $data['title']  = 'Tambah Data Surat Jalan';

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/trans/surat-jalan/add', $data);
    $this->load->view('layout/template/footer');
  }

  public function getTraveldoc()
  {
    header('Content-Type: application/json');

    echo $this->SJ->getData();
  }

  public function getDetailData()
  {
    $nomor = $this->input->post('nomor');

    $query  = $this->SJ->getDataByNomor($nomor);

    $datasj = $this->SJ->getTandaTerimaData($nomor);

    $reccu = [];

    foreach ($datasj as $item) {
      $reccu[] = $item->reccu;
    }

    $detail = $this->SJ->getDetailData($reccu);

    $response = [
      'nomor'   => $query->nomor_surat,
      'cust'    => $query->nama,
      'datasj'  => $datasj,
      'detail'  => $detail
    ];

    echo json_encode($response);
  }

  public function getReccuByCust()
  {
    $cust = $this->input->post('cust');

    $response = $this->SJ->getDataReccuByCust($cust);

    echo json_encode($response);
  }

  public function getDataByReccu()
  {
    $reccu = $this->input->post('reccu');

    $response = $this->SJ->getDataDetailByReccu($reccu);

    echo json_encode($response);
  }

  public function cekNomor()
  {
    $nomor    = $this->input->post('nomor');

    $cekdata  = $this->SJ->getNomorSuratJalan($nomor);

    $response = str_replace('/', '-', $cekdata->nomor_surat);

    echo json_encode($response);
  }

  public function proses()
  {
    $userid     = $this->session->userdata('id');
    $countRow   = count($this->input->post('sj'));
    $rc         = $this->input->post('rc');
    $noorder    = $this->input->post('noorder');
    $sj         = $this->input->post('sj');
    $custid     = $this->input->post('pengirim');
    $cust       = strtolower($this->input->post('selectedCust'));
    $kode       = strtolower($this->input->post('selectedKodeCust'));
    $tgl        = date('Y-m-d', strtotime($this->input->post('tgl')));
    $ket        = $this->input->post('ket');
    $berat      = $this->input->post('valberat');
    $retur      = $this->input->post('valretur');
    $dateAdd    = date('Y-m-d H:i:s');
    $tipe       = 'surat_jalan';
    $month      = date('m');

    $querynomor = $this->SJ->generateNomorSuratJalan($cust, $tipe);

    $romawi     = $this->bulanRomawi($month);

    $nomor      = $kode . '/' . $querynomor . '/han/' . $romawi . '/' . date('y');
    $noReplace  = str_replace('/', '-', $nomor);

    $dataReccu = [];

    for ($a = 0; $a < $countRow; $a++) {
      $reccu = $rc[$a];
      if (!in_array($reccu, $dataReccu)) {
        $dataReccu[] = $reccu;
      }
    }

    $jmlreccu = count($dataReccu);

    $datasj = [
      'nomor_surat' => $nomor,
      'cust_id'     => $custid,
      'jml_reccu'   => $jmlreccu,
      'jml_sj'      => $countRow,
      'dateAdd'     => $tgl,
      'user_id'     => $userid,
    ];

    $datadt = [];

    for ($i = 0; $i < $countRow; $i++) {
      array_push($datadt, ['nomor_surat' => $nomor]);
      $datadt[$i]['reccu']        = $rc[$i];
      $datadt[$i]['no_order']     = $noorder[$i];
      $datadt[$i]['ket']          = $ket[$i];
      $datadt[$i]['surat_jalan']  = $sj[$i];
      $datadt[$i]['berat']        = $berat[$i];
      $datadt[$i]['retur']        = $retur[$i];
    }

    $datasurat = [
      'customer'    => $cust,
      'jenis'       => $tipe,
      'nomor_angka' => $querynomor,
      'nomor'       => $nomor,
      'dateAdd'     => $dateAdd
    ];

    $proses = $this->SJ->addData($datasj, $datadt, $datasurat);

    if ($proses) {
      $response = [
        'status'      => 'success',
        'title'       => 'Success',
        'text'        => 'Data Berhasil Ditambahkan',
        'nomorsurat'  => $noReplace
      ];
    } else {
      $response = [
        'status'      => 'error',
        'title'       => 'Error',
        'text'        => 'Data Gagal Ditambahkan',
        'nomorsurat'  => null
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
    $nomor  = $this->input->get('surat_jalan');

    if ($nomor === null) {
      echo 'tidak ada data yang ditampilkan';
    } else {
      $str    = str_replace('-', '/', $nomor);

      $query  = $this->SJ->getDataByNomor($str);

      if ($query === null) {
        echo 'tidak ada data yang ditampilkan';
      } else {
        $datasj = $this->SJ->getTandaTerimaData($str);

        $reccu = [];

        foreach ($datasj as $item) {
          $reccu[] = $item->reccu;
        }

        $detail = $this->SJ->getDetailData($reccu);

        $data = [
          'title'   => 'Tanda Terima Surat Jalan',
          'nomor'   => $query->nomor_surat,
          'cust'    => $query->nama,
          'tgl'     => $query->dateAdd,
          'datasj'  => $datasj,
          'detail'  => $detail,
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

        $content  = $this->load->view('layout/trans/surat-jalan/print', $data, true);

        $upperstr = strtoupper($str);

        $mpdf->SetHTMLFooter("<p class='page-number-footer'>Tanda Terima Surat Jalan - $upperstr | Halaman {PAGENO} Dari {nb}</p>");
        $mpdf->AddPage();
        $mpdf->WriteHTML($content);

        $mpdf->Output("tanda-terima-sj-$str.pdf", 'I');
      }
    }
  }

  public function delete()
  {
    $nomor = $this->input->post('nomor');
    $jenis = 'surat_jalan';

    $data = $this->SJ->deleteData($nomor, $jenis);

    echo json_encode($data);
  }
}
