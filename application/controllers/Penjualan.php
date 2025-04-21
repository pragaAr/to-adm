<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

use Mpdf\Mpdf;

class Penjualan extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('datatables');

    $this->load->model('M_Sangu', 'Sangu');
    $this->load->model('M_Penjualan', 'Sales');

    if (empty($this->session->userdata('id'))) {
      $this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
      redirect('auth');
    }
  }

  public function index()
  {
    $data['title']  = 'Data Penjualan';

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/trans/penjualan/index', $data);
    $this->load->view('layout/template/footer');
  }

  public function getReccu()
  {
    $data = $this->Sales->generateReccu();

    echo json_encode($data);
  }

  public function getPenjualan()
  {
    header('Content-Type: application/json');

    echo $this->Sales->getData();
  }

  public function getDataKd()
  {
    $kd   = $this->input->post('kd');
    $data = $this->Sales->getDataByKd($kd);

    echo json_encode($data);
  }

  public function getOrderId()
  {
    $id   = $this->input->post('id');
    $data = $this->Sales->getDataOrderById($id);

    echo json_encode($data);
  }

  public function getListReccu()
  {
    $keyword = $this->input->get('q');

    $data = !$keyword ? $this->Sales->getReccu() : $this->Sales->getSearchReccu($keyword);

    $response = [];

    foreach ($data as $reccu) {
      $response[] = [
        'id'        => $reccu->no_order,
        'text'      => strtoupper($reccu->reccu),
        'jenis'     => $reccu->jenis,
        'berat'     => $reccu->berat,
        'hrgkg'     => $reccu->hrg_kg,
        'hrgbrg'    => $reccu->hrg_borong,
        'totalhrg'  => $reccu->total_hrg,
        'pengirim'  => strtoupper($reccu->pengirim),
        'penerima'  => strtoupper($reccu->penerima),
      ];
    }

    echo json_encode($response);
  }

  public function getListReccuForTravelDoc()
  {
    $reccu = $this->input->post('reccu');

    $data = $this->Sales->getReccuForTravelDoc($reccu);

    echo json_encode($data);
  }

  public function getListCustomerReccu()
  {
    $cust = $this->input->post('cust');

    $data = $this->Sales->getDataCustomerReccu($cust);

    echo json_encode($data);
  }

  public function cek()
  {
    $reccu  = $this->input->post('reccu');
    $cek    = $this->Sales->cekReccu($reccu);

    echo json_encode($cek);
  }

  public function add()
  {
    $userid       = $this->session->userdata('id');
    $reccu        = trim($this->input->post('reccu'));
    $noorder      = trim($this->input->post('noorder'));
    $tglreccu     = date('Y-m-d', strtotime($this->input->post('tglreccu')));
    $textnoorder  = trim($this->input->post('textnoorder'));
    $jenis        = trim($this->input->post('jenis'));
    $muatan       = trim($this->input->post('muatan'));
    $berat        = preg_replace("/[^0-9\.]/", "", $this->input->post('berat'));
    $hrgborong    = preg_replace("/[^0-9\.]/", "", $this->input->post('borong'));
    $hrgtonase    = preg_replace("/[^0-9\.]/", "", $this->input->post('tonase'));
    $pengirim     = trim($this->input->post('pengirim'));
    $kotaasal     = trim($this->input->post('asal'));
    $alamatasal   = trim($this->input->post('alamatasal'));
    $penerima     = trim($this->input->post('penerima'));
    $kotatujuan   = trim($this->input->post('tujuan'));
    $alamattujuan = trim($this->input->post('alamattujuan'));
    $biaya        = preg_replace("/[^0-9\.]/", "", $this->input->post('biaya'));
    $pembayaran   = trim($this->input->post('pembayaran'));
    $dateAdd      = date('Y-m-d H:i:s');

    $data = array(
      'reccu'         => strtolower($reccu),
      'order_id'      => strtolower($noorder),
      'jenis'         => strtolower($jenis),
      'muatan'        => strtolower($muatan),
      'berat'         => $berat,
      'hrg_borong'    => strtolower($jenis) === 'borong' ? $hrgborong : '0',
      'hrg_kg'        => strtolower($jenis) === 'borong' ? '0' : $hrgtonase,
      'pengirim'      => strtolower($pengirim),
      'kota_asal'     => strtolower($kotaasal),
      'alamat_asal'   => strtolower($alamatasal),
      'penerima'      => strtolower($penerima),
      'kota_tujuan'   => strtolower($kotatujuan),
      'alamat_tujuan' => strtolower($alamattujuan),
      'total_hrg'     => $biaya,
      'pembayaran'    => strtolower($pembayaran),
      'user_id'       => $userid,
      'dateAdd'       => $tglreccu,
      'datePelunasan' => strtolower($pembayaran) === 'lunas' ? $dateAdd : null,
    );

    $dataorder = array(
      'status_sales'  => 'disiapkan',
    );

    $where = array(
      'id'  => $noorder
    );

    $dataReccu = strtolower($reccu);

    $result = $this->Sales->addData($data, $dataorder, $where);

    if ($result) {
      echo json_encode([
        'status' => true,
        'reccu' => $dataReccu,
        'message' => 'Penjualan ditambahkan.'
      ]);
    } else {
      echo json_encode([
        'status' => false,
        'message' => 'Gagal menambah penjualan.'
      ]);
    }
  }

  public function update()
  {
    $penjualanid    = $this->input->post('penjualanid');
    $noorder        = trim($this->input->post('noorder'));
    $tglreccu       = date('Y-m-d', strtotime($this->input->post('tglreccu')));

    $jenis          = trim($this->input->post('jenis'));
    $berat          = preg_replace("/[^0-9\.]/", "", $this->input->post('berat'));
    $hrgborong      = preg_replace("/[^0-9\.]/", "", $this->input->post('borong'));
    $hrgtonase      = preg_replace("/[^0-9\.]/", "", $this->input->post('tonase'));
    $penerima       = trim($this->input->post('penerima'));
    $alamatasal     = trim($this->input->post('alamatasal'));
    $alamattujuan   = trim($this->input->post('alamattujuan'));
    $biaya          = preg_replace("/[^0-9\.]/", "", $this->input->post('biaya'));
    $pembayaran     = trim($this->input->post('pembayaran'));
    $oldpayment     = trim($this->input->post('oldpayment'));
    $oldpelunasan   = $this->input->post('datepelunasan') === '' ? null : date('Y-m-d H:i:s', strtotime($this->input->post('datepelunasan')));
    $dateAdd        = date('Y-m-d H:i:s');

    if (strtolower($oldpayment) === 'tempo' && strtolower($pembayaran) === 'tempo') {
      $datePelunasan = $oldpelunasan;
    } elseif (strtolower($oldpayment) === 'lunas' && strtolower($pembayaran) === 'lunas') {
      $datePelunasan = $oldpelunasan;
    } elseif (strtolower($oldpayment) === 'lunas' && strtolower($pembayaran) === 'tempo') {
      $datePelunasan = null;
    } elseif (strtolower($oldpayment) === 'tempo' && strtolower($pembayaran) === 'lunas') {
      $datePelunasan = $dateAdd;
    } else {
      $datePelunasan = null;
    }

    $data = array(
      'jenis'         => strtolower($jenis),
      'berat'         => $berat,
      'hrg_borong'    => strtolower($jenis) === 'borong' ? $hrgborong : '0',
      'hrg_kg'        => strtolower($jenis) === 'borong' ? '0' : $hrgtonase,
      'alamat_asal'   => strtolower($alamatasal),
      'penerima'      => strtolower($penerima),
      'alamat_tujuan' => strtolower($alamattujuan),
      'total_hrg'     => $biaya,
      'pembayaran'    => strtolower($pembayaran),
      'dateAdd'       => $tglreccu,
      'datePelunasan' => $datePelunasan
    );

    $wherepenjualanid = array(
      'id'  => $penjualanid
    );

    $result = $this->Sales->editData($data, $wherepenjualanid);

    if ($result) {
      echo json_encode([
        'status' => true,
        'message' => 'Penjualan berhasil diupdate.'
      ]);
    } else {
      echo json_encode([
        'status' => false,
        'message' => 'Penjualan tidak berubah.'
      ]);
    }
  }

  public function print()
  {
    $reccu = $this->input->get('reccu');

    if ($reccu === null) {
      echo 'tidak ada data yang ditampilkan';
    } else {
      $cekReccu  = $this->Sales->cekReccu($reccu);

      if ($cekReccu === null) {
        echo 'tidak ada data yang ditampilkan';
      } else {
        $kd = $cekReccu->no_order;
        $rc = $cekReccu->reccu;

        // ubah gambar ke format base 64
        $imgPath  = 'assets/dist/img/logo-red.png';
        $type     = pathinfo($imgPath, PATHINFO_EXTENSION);
        $data     = file_get_contents($imgPath);
        $base64   = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $this->load->library('pdf');

        $data = [
          'title' => 'Hira Express - Print Reccu',
          'plat'  => $this->Sangu->getPlatByOrder($kd),
          'sales' => $this->Sales->getDataByKd($rc),
          'img'   => $base64
        ];

        $upper = strtoupper($reccu);
        $this->pdf->generate('layout/trans/penjualan/print', $data, "Reccu-$upper", 'A6', 'portrait');
      }
    }
  }

  public function delete()
  {
    $id = $this->input->post('id');
    $no = $this->input->post('no');

    $result = $this->Sales->deleteData($id, $no);

    if ($result) {
      echo json_encode([
        'status' => true,
        'message' => 'Penjualan berhasil dihapus.'
      ]);
    } else {
      echo json_encode([
        'status' => false,
        'message' => 'Gagal menghapus penjualan.'
      ]);
    }
  }
}
