<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class M_Order extends CI_Model
{
  public function getKd()
  {
    $this->db->select('RIGHT(order_masuk.no_order,3) as no_order', FALSE)
      ->order_by('no_order', 'DESC')
      ->limit(1);

    $query = $this->db->get('order_masuk');

    if ($query->num_rows() <> 0) {
      $data = $query->row();
      $kode = intval($data->no_order) + 1;
    } else {
      $kode = 1;
    }

    $batas = str_pad($kode, 5, "0", STR_PAD_LEFT);
    $kodetampil = "orm-" . $batas;

    return $kodetampil;
  }

  public function getData()
  {
    $this->datatables->select('om.id, om.no_order, s.nama as nama_sopir, om.asal_order, om.tujuan_order, om.jenis_muatan, om.status_order, om.dateAdd, cust.nama')
      ->from('order_masuk om')
      ->join('customer cust', 'cust.id = om.customer_id')
      ->join('sangu_sopir ss', 'ss.no_order = om.no_order')
      ->join('sopir s', 's.id = ss.sopir_id')
      ->add_column(
        'view',
        '<div class="btn-group" role="group">
          
        </div>',
        'id, no_order, nama_sopir, asal_order, tujuan_order, jenis_muatan, status_order, dateAdd, nama'
      );

    $res  = $this->datatables->generate();

    $data = json_decode($res, true);

    foreach ($data['data'] as &$row) {
      $no_order = html_escape($row['no_order']);
      if ($row['status_order'] != 'selesai') {

        $row['view'] = '<div class="btn-group" role="group">
                          <a href="javascript:void(0);" class="btn btn-sm btn-light border border-light btn-update" data-toggle="tooltip" title="Update Status" data-kd="' . $no_order . '">
                            <i class="fas fa-check fa-sm"></i>
                          </a>
                          <a href="javascript:void(0);" class="btn btn-sm btn-info text-white border border-light btn-print" data-toggle="tooltip" title="Cetak" data-kd="' . $no_order . '">
                            <i class="fas fa-print fa-sm"></i>
                          </a>
                          <a href="javascript:void(0);" class="btn btn-sm btn-success text-white border border-light btn-detail" data-kd="' . $no_order . '" data-toggle="tooltip" title="Detail">
                            <i class="fas fa-eye fa-sm"></i>
                          </a>
                          <a href="javascript:void(0);" class="btn btn-sm btn-warning text-white border border-light btn-edit" data-kd="' . $no_order . '" data-toggle="tooltip" title="Edit">
                            <i class="fas fa-pencil-alt fa-sm"></i>
                          </a>
                          <a href="javascript:void(0);" class="btn btn-sm btn-danger text-white border border-light btn-delete" data-kd="' . $no_order . '" data-toggle="tooltip" title="Hapus">
                            <i class="fas fa-trash fa-sm"></i>
                          </a>
                        </div>';
      } else {
        $row['view'] = '<div class="btn-group" role="group">
                          <a href="javascript:void(0);" class="btn btn-sm btn-info text-white border border-light btn-print" data-toggle="tooltip" title="Cetak" data-kd="' . $no_order . '">
                            <i class="fas fa-print fa-sm"></i>
                          </a>
                          <a href="javascript:void(0);" class="btn btn-sm btn-success text-white border border-light btn-detail" data-kd="' . $no_order . '" data-toggle="tooltip" title="Detail">
                            <i class="fas fa-eye fa-sm"></i>
                          </a>
                          <a href="javascript:void(0);" class="btn btn-sm btn-warning text-white border border-light btn-edit" data-kd="' . $no_order . '" data-toggle="tooltip" title="Edit">
                            <i class="fas fa-pencil-alt fa-sm"></i>
                          </a>
                          <a href="javascript:void(0);" class="btn btn-sm btn-danger text-white border border-light btn-delete" data-kd="' . $no_order . '" data-toggle="tooltip" title="Hapus">
                            <i class="fas fa-trash fa-sm"></i>
                          </a>
                        </div>';
      }
    }

    $res = json_encode($data);

    echo $res;
  }

  public function countData()
  {
    return $this->db->get('order_masuk')->num_rows();
  }

  public function countProsesData()
  {
    return $this->db->get_where('order_masuk', ['status_order' => 'diproses'])->num_rows();
  }

  public function countSuccessData()
  {
    return $this->db->get_where('order_masuk', ['status_order' => 'selesai'])->num_rows();
  }

  public function getOrderId($kd)
  {
    $this->db->select('id as order_id, no_order')
      ->from('order_masuk ')
      ->where('no_order', $kd);

    $query = $this->db->get()->row();

    return $query;
  }

  public function getOrderStatusSalesByKd($kd)
  {
    $this->db->select('status_sales')
      ->from('order_masuk')
      ->where('no_order', $kd);

    $query = $this->db->get()->row();

    return $query;
  }

  public function getDataByKd($kd)
  {
    $this->db->select('om.id as order_id, om.no_order, om.customer_id, om.asal_order, om.tujuan_order, om.kontak_order, om.jenis_muatan, om.keterangan, ss.truck_id, ss.sopir_id, ss.nominal')
      ->from('order_masuk om')
      ->where('om.no_order', $kd)
      ->join('sangu_sopir ss', 'ss.no_order = om.no_order');

    $query = $this->db->get()->row();

    return $query;
  }

  public function getOrderDiproses()
  {
    $this->db->select('om.id, om.no_order, om.asal_order, om.tujuan_order, om.jenis_muatan, om.status_order, om.keterangan, om.dateAdd, cust.nama')
      ->from('order_masuk om')
      ->where('om.status_sales =', '')
      ->join('customer cust', 'cust.id = om.customer_id')
      ->order_by('om.id', 'DESC');

    $query = $this->db->get()->result();

    return $query;
  }

  public function getSearchOrderDiproses($keyword)
  {
    $this->db->select('om.id, om.no_order, om.asal_order, om.tujuan_order, om.jenis_muatan, om.status_order, om.keterangan, om.dateAdd, cust.nama')
      ->from('order_masuk om')
      ->where('om.status_sales =', '')
      ->join('customer cust', 'cust.id = om.customer_id')
      ->order_by('om.id', 'DESC')
      ->like('om.no_order', $keyword);

    $query = $this->db->get()->result();

    return $query;
  }

  public function getOrderPenjualan()
  {
    $this->db->select('om.id, om.no_order, om.asal_order, om.tujuan_order, om.jenis_muatan, om.status_order, om.keterangan, om.dateAdd, cust.nama')
      ->from('order_masuk om')
      ->join('customer cust', 'cust.id = om.customer_id');

    $query = $this->db->get()->result();

    return $query;
  }

  public function getSearchOrderPenjualan($keyword)
  {
    $this->db->select('om.id, om.no_order, om.asal_order, om.tujuan_order, om.jenis_muatan, om.status_order, om.keterangan, om.dateAdd, cust.nama')
      ->from('order_masuk om')
      ->join('customer cust', 'cust.id = om.customer_id')
      ->like('om.no_order', $keyword);

    $query = $this->db->get()->result();

    return $query;
  }

  public function getDataOrderBySopir($sopir)
  {
    $this->db->select('ss.id, ss.no_order')
      ->from('sangu_sopir ss')
      ->where('sopir_id', $sopir)
      ->join('order_masuk om', 'om.no_order = ss.no_order')
      ->where('om.status_order', 'selesai')
      ->where('om.status_persen', 0);

    $query = $this->db->get()->result();

    return $query;
  }

  public function getDataOrderPenjualanDetail($noorder)
  {
    $this->db->select('ss.id as id_sangu, ss.no_order, ss.nominal as sangu, ss.tambahan, om.id as id_order, ar.platno, p.pengirim, p.penerima, p.kota_asal, p.kota_tujuan, p.muatan, p.total_hrg')
      ->from('sangu_sopir ss')
      ->where('ss.no_order', $noorder)
      ->join('armada ar', 'ar.id = ss.truck_id')
      ->join('order_masuk om', 'om.no_order = ss.no_order')
      ->join('penjualan p', 'p.order_id = om.id');

    $query = $this->db->get()->row();

    return $query;
  }

  public function printOrder($kd)
  {
    $this->db->select('om.id as order_id, om.no_order, om.asal_order, om.tujuan_order, om.kontak_order, om.jenis_muatan, om.keterangan, om.dateAdd, cust.nama as nama_customer, ss.nominal, ss.tambahan, ar.platno, so.nama as nama_sopir')
      ->from('order_masuk om')
      ->where('om.no_order', $kd)
      ->join('customer cust', 'cust.id = om.customer_id')
      ->join('sangu_sopir ss', 'ss.no_order = om.no_order')
      ->join('armada ar', 'ar.id = ss.truck_id')
      ->join('sopir so', 'so.id = ss.sopir_id');

    $query = $this->db->get()->row();

    return $query;
  }

  public function addData($dataOrder, $dataSangu, $whereTruck, $whereSopir, $updateStatusTruck, $updateStatusSopir)
  {
    $this->db->trans_start();

    $this->db->insert('order_masuk', $dataOrder);
    $this->db->insert('sangu_sopir', $dataSangu);
    $this->db->update('armada', $updateStatusTruck, $whereTruck);
    $this->db->update('sopir', $updateStatusSopir, $whereSopir);

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
      return false;
    } else {
      return true;
    }
  }

  public function updateData($dataOrder, $dataSangu, $where, $whereOldTruck, $whereOldSopir, $oldDataTruck, $oldDataSopir, $whereNewTruck, $whereNewSopir, $newDataTruck, $newDataSopir)
  {
    $this->db->trans_start();

    $this->db->update('order_masuk', $dataOrder, $where);
    $this->db->update('sangu_sopir', $dataSangu, $where);

    $this->db->update('armada', $oldDataTruck, $whereOldTruck);
    $this->db->update('armada', $newDataTruck, $whereNewTruck);

    $this->db->update('sopir', $oldDataSopir, $whereOldSopir);
    $this->db->update('sopir', $newDataSopir, $whereNewSopir);

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
      return false;
    } else {
      return true;
    }
  }

  public function deleteData($kd, $whereSopir, $whereTruck, $updateSopir, $updateTruck)
  {
    $this->db->trans_start();

    $this->db->update('armada', $updateTruck, $whereTruck);
    $this->db->update('sopir', $updateSopir, $whereSopir);

    $this->db->select('b.order_id')
      ->from('order_masuk a')
      ->join('penjualan b', 'b.order_id = a.id')
      ->where('a.no_order', $kd);

    $query = $this->db->get()->row();

    if ($query == !null) {
      $this->db->delete('penjualan', ['order_id' => $query->order_id]);
    }

    $this->db->delete('order_masuk', ['no_order' => $kd]);
    $this->db->delete('sangu_sopir', ['no_order' => $kd]);

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
      return false;
    } else {
      return true;
    }
  }

  public function updateStatusOrder($id, $truckid, $sopirid)
  {
    $this->db->trans_start();

    $statusOrder  = [
      'status_order'      => 'selesai',
      'dateUpdateStatus'  => date('Y-m-d H:i:s')
    ];

    $whereidorder = ['id' => $id];

    $this->db->update('order_masuk', $statusOrder, $whereidorder);

    $statussopir  = ['status_sopir' => 0];

    $wheresopirid = ['id' => $sopirid];

    $this->db->update('sopir', $statussopir, $wheresopirid);

    $statustruck  = ['status_truck' => 0];

    $wheretruckid = ['id' => $truckid];

    $this->db->update('armada', $statustruck, $wheretruckid);

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
      return false;
    } else {
      return true;
    }
  }
}
