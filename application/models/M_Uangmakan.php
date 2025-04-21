<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Uangmakan extends CI_Model
{
  public function getKd()
  {
    $this->db->select('RIGHT(uang_makan.kd_um,3) as kd_um', FALSE)
      ->order_by('kd_um', 'DESC')
      ->limit(1);

    $query = $this->db->get('uang_makan');

    if ($query->num_rows() <> 0) {
      $data = $query->row();
      $kode = intval($data->kd_um) + 1;
    } else {
      $kode = 1;
    }

    $batas      = str_pad($kode, 5, "0", STR_PAD_LEFT);
    $kodetampil = "um-" . $batas;

    return $kodetampil;
  }

  public function getData()
  {
    $role = $this->session->userdata('role');

    $this->datatables->select('id, kd_um, jml_penerima, jml_nominal, dateAdd')
      ->from('uang_makan');

    if ($role == 'admin') {
      $this->datatables->add_column(
        'view',
        '<div class="btn-group" role="group">
            <a href="javascript:void(0);" class="btn btn-sm btn-primary text-white border border-light btn-print" data-kd="$2" data-toggle="tooltip" title="Print">
              <i class="fas fa-print fa-sm"></i>
            </a>
            <a href="javascript:void(0);" class="btn btn-sm btn-success text-white border border-light btn-detail" data-kd="$2" data-toggle="tooltip" title="Detail">
              <i class="fas fa-eye fa-sm"></i>
            </a>
            <a href="javascript:void(0);" class="btn btn-sm btn-danger text-white border border-light btn-delete" data-kd="$2" data-toggle="tooltip" title="Hapus">
              <i class="fas fa-trash fa-sm"></i>
            </a>
          </div>',
        'id, kd_um, jml_penerima, jml_nominal, dateAdd'
      );
    } else if ($role == 'petugas') {
      $this->datatables->add_column(
        'view',
        '<div class="btn-group" role="group">
            <a href="javascript:void(0);" class="btn btn-sm btn-success text-white border border-light btn-detail" data-kd="$2" data-toggle="tooltip" title="Detail">
              <i class="fas fa-eye fa-sm"></i>
            </a>
          </div>',
        'id, kd_um, jml_penerima, jml_nominal, dateAdd'
      );
    }

    return $this->datatables->generate();
  }


  public function getId($id)
  {
    return $this->db->get_where('uang_makan', ['id_um' => $id])->row();
  }

  public function getDataKdUm($kd)
  {
    return $this->db->get_where('uang_makan', ['kd_um' => $kd])->row();
  }

  public function cekKode($no)
  {
    return $this->db->get_where('uang_makan', ['kd_um' => $no])->row();
  }

  public function getDetailKdUm($kd)
  {
    $this->db->select('detail_um.kd_um, detail_um.karyawan_id, detail_um.nominal, karyawan.id, karyawan.nama, karyawan.status');
    $this->db->from('detail_um');
    $this->db->where('detail_um.kd_um', $kd);
    $this->db->join('karyawan', 'karyawan.id = detail_um.karyawan_id');
    $query = $this->db->get()->result();
    return $query;
  }

  public function getDataByKd($kd)
  {
    $this->db->select('kd_um, jml_penerima, jml_nominal, dateAdd')
      ->from('uang_makan')
      ->where('kd_um', $kd);

    $query = $this->db->get()->row();

    return $query;
  }

  public function getDetailByKd($kd)
  {
    $this->db->select('um.kd_um, um.dateAdd, dt.kd_um, dt.karyawan_id, dt.nominal, k.id, k.nama, k.status')
      ->from('detail_um dt')
      ->where('dt.kd_um', $kd)
      ->join('uang_makan um', 'um.kd_um = dt.kd_um')
      ->join('karyawan k', 'k.id = dt.karyawan_id');

    $query = $this->db->get()->result();

    return $query;
  }

  public function addData($data, $detail)
  {
    $query = $this->db->insert('uang_makan', $data);
    $query = $this->db->insert_batch('detail_um', $detail);

    if ($query) {
      return true;
    } else {
      return false;
    }
  }

  public function deleteData($kd)
  {
    $this->db->delete('uang_makan', ['kd_um' => $kd]);
    $this->db->delete('detail_um', ['kd_um' => $kd]);
  }
}
