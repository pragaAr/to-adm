<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

use Mpdf\Mpdf;

class Order extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('datatables');

    $this->load->model('M_Order', 'Order');
    $this->load->model('M_Sangu', 'Sangu');
    $this->load->model('M_Sopir', 'Sopir');
    $this->load->model('M_Armada', 'Armada');

    if (empty($this->session->userdata('id'))) {
      $this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
      redirect('auth');
    }
  }

  public function index()
  {
    $data['title'] = 'Data Order';

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/trans/order/index', $data);
    $this->load->view('layout/template/footer');
  }

  public function getKdOrder()
  {
    $data = $this->Order->getKd();

    echo json_encode($data);
  }

  public function getOrder()
  {
    header('Content-Type: application/json');

    echo $this->Order->getData();
  }

  public function getStatusSalesKd()
  {
    $kd   = $this->input->post('kd');

    $query = $this->Order->getOrderStatusSalesByKd($kd);

    $data = [
      'status' => $query->status_sales
    ];

    echo json_encode($data);
  }

  public function getDataKd()
  {
    $kd   = $this->input->post('kd');

    $data = $this->Order->getDataByKd($kd);

    echo json_encode($data);
  }

  public function getListOrder()
  {
    $keyword = $this->input->get('q');

    $data = !$keyword ? $this->Order->getOrderDiproses() : $this->Order->getSearchOrderDiproses($keyword);

    $response = [];
    foreach ($data as $order) {
      $response[] = [
        'id'      => $order->id,
        'text'    => strtoupper($order->no_order),
        'cust'    => strtoupper($order->nama),
        'asal'    => strtoupper($order->asal_order),
        'tujuan'  => strtoupper($order->tujuan_order),
        'muatan'  => strtoupper($order->jenis_muatan),
        'ket'     => strtoupper($order->keterangan),
        'tgl'     => date('Y-m-d', strtotime(($order->dateAdd))),
      ];
    }

    echo json_encode($response);
  }

  public function getListOrderPenjualan()
  {
    $keyword = $this->input->get('q');

    $data = !$keyword ? $this->Order->getOrderPenjualan() : $this->Order->getSearchOrderPenjualan($keyword);

    $response = [];
    foreach ($data as $order) {
      $response[] = [
        'id'      => $order->id,
        'text'    => strtoupper($order->no_order),
        'cust'    => strtoupper($order->nama),
        'asal'    => strtoupper($order->asal_order),
        'tujuan'  => strtoupper($order->tujuan_order),
        'muatan'  => strtoupper($order->jenis_muatan),
        'ket'     => strtoupper($order->keterangan),
        'tgl'     => date('d-m-Y', strtotime(($order->dateAdd))),
      ];
    }

    echo json_encode($response);
  }

  public function getOrderBySopir()
  {
    $sopir    = $this->input->post('sopir');

    $response = $this->Order->getDataOrderBySopir($sopir);

    echo json_encode($response);
  }

  public function getOrderPenjualanDetail()
  {
    $noorder  = $this->input->post('noorder');

    $response = $this->Order->getDataOrderPenjualanDetail($noorder);

    echo json_encode($response);
  }

  public function getId()
  {
    $kd   = $this->input->post('kd');

    $data = $this->Order->getOrderId($kd);

    echo json_encode($data);
  }

  public function getDetail()
  {
    $kd   = $this->input->post('kd');

    $data = $this->Order->printOrder($kd);

    echo json_encode($data);
  }

  public function getSelectedSopirAvailable()
  {
    $sopir_id = $this->input->get('sopir_id');
    $keyword = $this->input->get('q');

    $data = $this->Sopir->getSelectedSopirAvailable($sopir_id, $keyword);

    $response = [];
    foreach ($data as $sopir) {
      $response[] = [
        'id'    => $sopir->id,
        'text'  => ucwords($sopir->nama),
      ];
    }

    echo json_encode($response);
  }

  public function getSelectedArmadaReady()
  {
    $armada_id = $this->input->get('armada_id');
    $keyword = $this->input->get('q');

    $data = $this->Armada->getSelectedArmadaReady($armada_id, $keyword);

    $response = [];
    foreach ($data as $armada) {
      $response[] = [
        'id'    => $armada->id,
        'text'  => strtoupper($armada->platno),
      ];
    }

    echo json_encode($response);
  }

  public function add()
  {
    $noorder      = strtolower($this->input->post('ordernumber'));
    $custid       = $this->input->post('custid');
    $notelp       = strtolower($this->input->post('notelp'));
    $asal         = strtolower($this->input->post('asal'));
    $tujuan       = strtolower($this->input->post('tujuan'));
    $muatan       = strtolower($this->input->post('muatan'));
    $keterangan   = strtolower($this->input->post('keterangan'));

    $plat         = $this->input->post('plat');
    $sopir        = $this->input->post('sopir');
    $nominal      = preg_replace("/[^0-9\.]/", "", $this->input->post('nominal'));

    $user         = $this->session->userdata('id');
    $addAt        = date('Y-m-d H:i:s');

    $dataOrder = [
      'no_order'      => $noorder,
      'customer_id'   => $custid,
      'asal_order'    => $asal,
      'tujuan_order'  => $tujuan,
      'kontak_order'  => $notelp,
      'jenis_muatan'  => $muatan,
      'keterangan'    => $keterangan,
      'status_order'  => 'diproses',
      'user_id'       => $user,
      'dateAdd'       => $addAt,
    ];

    $dataSangu = [
      'no_order'  => strtolower($noorder),
      'truck_id'  => $plat,
      'sopir_id'  => $sopir,
      'nominal'   => strtolower($nominal),
      'tambahan'  => '0',
      'user_id'   => $user,
      'dateAdd'   => $addAt
    ];

    $whereTruck = [
      'id' => $plat
    ];

    $whereSopir = [
      'id' => $sopir
    ];

    $updateStatusTruck = [
      'status_truck' => 1
    ];

    $updateStatusSopir = [
      'status_sopir' => 1
    ];

    $result = $this->Order->addData($dataOrder, $dataSangu, $whereTruck, $whereSopir, $updateStatusTruck, $updateStatusSopir);

    $dataNoOrder = strtolower($noorder);

    if ($result) {
      echo json_encode([
        'status' => true,
        'noorder' => $dataNoOrder,
        'message' => 'Order ditambahkan.'
      ]);
    } else {
      echo json_encode([
        'status' => false,
        'message' => 'Gagal menambah order.'
      ]);
    }
  }

  public function update()
  {
    $noorder      = strtolower($this->input->post('ordernumber'));
    $custid       = $this->input->post('custid');
    $notelp       = $this->input->post('notelp');
    $asal         = strtolower($this->input->post('asal'));
    $tujuan       = strtolower($this->input->post('tujuan'));
    $muatan       = strtolower($this->input->post('muatan'));
    $keterangan   = strtolower($this->input->post('keterangan'));

    $plat         = $this->input->post('plat');
    $sopir        = $this->input->post('sopir');
    $oldplat      = $this->input->post('oldplat');
    $oldsopir     = $this->input->post('oldsopir');
    $nominal      = preg_replace("/[^0-9\.]/", "", $this->input->post('nominal'));

    $dataOrder = [
      'customer_id'   => $custid,
      'asal_order'    => $asal,
      'tujuan_order'  => $tujuan,
      'kontak_order'  => $notelp,
      'jenis_muatan'  => $muatan,
      'keterangan'    => $keterangan,
    ];

    $dataSangu = [
      'truck_id'  => $plat,
      'sopir_id'  => $sopir,
      'nominal'   => $nominal,
    ];

    $where = [
      'no_order' => $noorder
    ];

    $whereOldTruck = [
      'id' => $oldplat
    ];

    $whereOldSopir = [
      'id' => $oldsopir
    ];

    $oldDataTruck = [
      'status_truck' => 0
    ];

    $oldDataSopir = [
      'status_sopir' => 0
    ];

    $whereNewTruck = [
      'id' => $plat
    ];

    $whereNewSopir = [
      'id' => $sopir
    ];

    $newDataTruck = [
      'status_truck' => 1
    ];

    $newDataSopir = [
      'status_sopir' => 1
    ];

    $response = $this->Order->updateData($dataOrder, $dataSangu, $where, $whereOldTruck, $whereOldSopir, $oldDataTruck, $oldDataSopir, $whereNewTruck, $whereNewSopir, $newDataTruck, $newDataSopir);

    if ($response) {
      echo json_encode([
        'status' => true,
        'message' => 'Order berhasil diupdate.'
      ]);
    } else {
      echo json_encode([
        'status' => false,
        'message' => 'Gagal mengupdate order.'
      ]);
    }
  }

  public function updateStatus()
  {
    $id = $this->input->post('id');
    $kd = $this->input->post('no');

    $query = $this->Sangu->getDataTrucSopirkByKdOrder($kd);

    $truckid = $query->truck_id;
    $sopirid = $query->sopir_id;

    if (!$truckid || !$sopirid) {
      echo json_encode([
        'status' => false,
        'message' => 'Truck atau Sopir tidak terdeteksi untuk order ini.'
      ]);
      return;
    }

    $result = $this->Order->updateStatusOrder($id, $truckid, $sopirid);

    if ($result) {
      echo json_encode([
        'status' => true,
        'message' => 'Status berhasil diupdate.'
      ]);
    } else {
      echo json_encode([
        'status' => false,
        'message' => 'Gagal mengupdate status.'
      ]);
    }
  }

  public function delete()
  {
    $kd = $this->input->post('kd');

    $dataTruckSopir = $this->Sangu->getDataTrucSopirkByKdOrder($kd);

    $whereSopir = [
      'id' => $dataTruckSopir->sopir_id
    ];

    $whereTruck = [
      'id' => $dataTruckSopir->truck_id
    ];

    $updateSopir = [
      'status_sopir' => 0
    ];

    $updateTruck = [
      'status_truck' => 0
    ];

    $result = $this->Order->deleteData($kd, $whereSopir, $whereTruck, $updateSopir, $updateTruck);

    if ($result) {
      echo json_encode([
        'status' => true,
        'message' => 'Data berhasil dihapus.'
      ]);
    } else {
      echo json_encode([
        'status' => false,
        'message' => 'Gagal menghapus data.'
      ]);
    }
  }

  public function print()
  {
    $kd  = $this->input->get('no_do');

    if ($kd === null) {
      echo 'tidak ada data yang ditampilkan';
    } else {

      $query  = $this->Order->printOrder($kd);

      if ($query === null) {
        echo 'tidak ada data yang ditampilkan';
      } else {

        // ubah gambar ke format base 64
        $imgPath  = 'assets/dist/img/logo-red.png';
        $type     = pathinfo($imgPath, PATHINFO_EXTENSION);
        $data     = file_get_contents($imgPath);
        $base64   = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $data = [
          'title'   => 'DO Order',
          'detail'  => $query,
          'img'     => $base64
        ];

        $formatKd = strtoupper($kd);

        $content  = $this->load->view('layout/trans/order/print', $data, true);

        $mpdf = new Mpdf([
          'mode'          => 'utf-8',
          'format'        => [165, 215],
          'orientation'   => 'L',
          'SetTitle'      => "order-$kd",
          'margin_left'   => 5,
          'margin_right'  => 5,
          'margin_top'    => 5,
          'margin_bottom' => 10,
        ]);

        $mpdf->SetHTMLFooter("<p class='page-number-footer'>No Order : $formatKd | Halaman {PAGENO} Dari {nb}</p>");
        $mpdf->AddPage();
        $mpdf->WriteHTML($content);

        $mpdf->Output("surat-order-$kd.pdf", 'I');
      }
    }
  }
}
