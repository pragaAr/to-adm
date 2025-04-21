<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Pengeluaran_lain extends CI_Model
{
  public function generateKode()
  {
    $this->db->select('RIGHT(pengeluaran_lain.kd,3) as kd', FALSE)
      ->order_by('kd', 'DESC')
      ->limit(1);

    $query = $this->db->get('pengeluaran_lain');

    if ($query->num_rows() <> 0) {
      $data = $query->row();
      $kode = intval($data->kd) + 1;
    } else {
      $kode = 1;
    }

    $batas = str_pad($kode, 5, "0", STR_PAD_LEFT);
    $kodetampil = "pl-" . $batas;

    return $kodetampil;
  }

  public function getData()
  {
    $this->datatables->select('a.id, a.kd, a.jml_nominal, a.jml_keperluan, a.dateAdd, b.nama')
      ->from('pengeluaran_lain a')
      ->join('karyawan b', 'b.id = a.karyawan_id')
      ->add_column(
        'view',
        '<div class="btn-group" role="group">
          <a href="javascript:void(0);" class="btn btn-sm btn-info text-white border border-light btn-print" data-toggle="tooltip" title="Cetak" data-kd="$2">
            <i class="fas fa-print fa-sm"></i>
          </a>
          <a href="javascript:void(0);" class="btn btn-sm btn-success text-white border border-light btn-detail" data-toggle="tooltip" title="Detail" data-kd="$2">
            <i class="fas fa-eye fa-sm"></i>
          </a>
          <a href="javascript:void(0);" class="btn btn-sm btn-danger text-white border border-light btn-delete" data-kd="$2" data-toggle="tooltip" title="Hapus">
            <i class="fas fa-trash fa-sm"></i>
          </a>
        </div>',
        'id, kd, jml_nominal, jml_keperluan, nama, dateAdd'
      );

    return $this->datatables->generate();
  }

  public function cekKode($kd)
  {
    $query = $this->db->get_where('pengeluaran_lain', ['kd' => $kd]);

    return $query->num_rows();
  }

  public function getDataByKd($kd)
  {
    $this->db->select('a.kd, a.jml_nominal, a.jml_keperluan, a.dateAdd, a.karyawan_id, b.nama')
      ->from('pengeluaran_lain a')
      ->where('a.kd', $kd)
      ->join('karyawan b', 'b.id = a.karyawan_id');

    $query = $this->db->get()->row();

    return $query;
  }

  public function getDetailDataByKd($kd)
  {
    $this->db->select('keperluan, jml_item, nominal')
      ->from('detail_pl')
      ->where('kd', $kd);

    $query = $this->db->get()->result();

    return $query;
  }

  public function addData($data, $detail)
  {
    $this->db->trans_start();

    $this->db->insert('pengeluaran_lain', $data);
    $this->db->insert_batch('detail_pl', $detail);

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
      // Transaksi gagal
      return false;
    } else {
      // Transaksi berhasil
      return true;
    }
  }

  public function deleteData($kd)
  {
    $this->db->trans_start();

    $this->db->delete('pengeluaran_lain', ['kd' => $kd]);
    $this->db->delete('detail_pl', ['kd' => $kd]);

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
      // Transaksi gagal
      return false;
    } else {
      // Transaksi berhasil
      return true;
    }
  }
}
