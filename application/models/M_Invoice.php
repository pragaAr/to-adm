<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class M_Invoice extends CI_Model
{
  public function getData()
  {
    $this->datatables->select('a.id, a.nomor_inv, b.nama, a.jml_reccu, a.jml_sj , a.dateAdd')
      ->from('invoice a')
      ->join('customer b', 'b.id = a.cust_id')
      ->add_column(
        'view',
        '<div class="btn-group" role="group">
          <a href="javascript:void(0);" class="btn btn-sm btn-primary text-white border border-light btn-print" data-nomor="$2" data-toggle="tooltip" title="Cetak">
            <i class="fas fa-print fa-sm"></i>
          </a>
          <a href="javascript:void(0);" class="btn btn-sm btn-success text-white border border-light btn-detail" data-nomor="$2" data-toggle="tooltip" title="Detail">
            <i class="fas fa-eye fa-sm"></i>
          </a>
          <a href="javascript:void(0);" class="btn btn-sm btn-danger text-white border border-light btn-delete" data-nomor="$2" data-toggle="tooltip" title="Hapus">
            <i class="fas fa-trash fa-sm"></i>
          </a>
        </div>',
        'id, nomor_inv, nama, jml_reccu, jml_sj, dateAdd'
      );

    return $this->datatables->generate();
  }

  public function generateNomorInvoice($cust, $tipe)
  {
    $this->db->where('customer', $cust)
      ->where('jenis', $tipe)
      ->order_by('id', 'DESC');

    $query = $this->db->get('nomor_surat', 1);

    if ($query->num_rows() > 0) {
      $row = $query->row();
      return $row->nomor_angka + 1;
    } else {
      return 1;
    }
  }

  public function getNomorInv($nomor)
  {
    $this->db->select('nomor_inv')
      ->from('invoice')
      ->where('nomor_inv', $nomor);

    $query = $this->db->get()->row();

    return $query;
  }

  public function getDataByNomor($str)
  {
    $this->db->select('a.nomor_inv, b.nama, a.jml_reccu, a.jml_sj, a.dateAdd')
      ->from('invoice a')
      ->where('a.nomor_inv', $str)
      ->join('customer b', 'b.id = a.cust_id');

    $query = $this->db->get()->row();

    return $query;
  }

  public function getInvData($str)
  {
    $getreccu = $this->db->select('reccu')
      ->from('detail_inv')
      ->where('nomor_inv', $str)
      ->get()->result();

    $reccu_values = [];

    foreach ($getreccu as $item) {
      $reccu_values[] = $item->reccu;
    }

    $this->db->select('order_masuk.dateAdd as dateOrder, armada.platno, penjualan.reccu, penjualan.kota_asal, penjualan.kota_tujuan, penjualan.berat, penjualan.hrg_kg, penjualan.total_hrg, penjualan.dateAdd as dateReccu')
      ->from('penjualan')
      ->join('order_masuk', 'order_masuk.id = penjualan.order_id')
      ->join('sangu_sopir', 'sangu_sopir.no_order = order_masuk.no_order')
      ->join('armada', 'armada.id = sangu_sopir.truck_id')
      ->where_in('penjualan.reccu', $reccu_values);

    $query = $this->db->get()->result();

    return $query;
  }

  public function getDetailData($nomor, $reccu)
  {
    $this->db->select('reccu, surat_jalan, berat')
      ->from('detail_inv')
      ->where('nomor_inv', $nomor)
      ->where_in('reccu', $reccu);

    $query = $this->db->get()->result();

    return $query;
  }

  public function addData($datainv, $datadt)
  {
    $this->db->trans_start();

    $this->db->insert('invoice', $datainv);
    $this->db->insert_batch('detail_inv', $datadt);

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
      // Transaksi gagal
      return false;
    } else {
      // Transaksi berhasil
      return true;
    }
  }

  public function updateData($kd, $data, $detail)
  {
    $where = array(
      'kd_inv'   => $kd
    );

    $this->db->update('invoice', $data, $where);
    $this->db->delete('detail_inv', $where);
    $this->db->insert_batch('detail_inv', $detail);
  }

  public function deleteData($nomor)
  {
    $this->db->delete('invoice', ['nomor_inv' => $nomor]);
    $this->db->delete('detail_inv', ['nomor_inv' => $nomor]);
  }
}
