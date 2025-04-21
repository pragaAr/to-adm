<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Karyawan extends CI_Model
{
  public function getData()
  {
    $this->datatables->select('id, nama, usia, alamat, notelp, status')
      ->from('karyawan')
      ->add_column(
        'view',
        '<div class="btn-group" role="group">
          <a href="javascript:void(0);" class="btn btn-sm btn-warning text-white border border-light btn-edit" data-id="$1" data-toggle="tooltip" title="Edit">
            <i class="fas fa-pencil-alt fa-sm"></i>
          </a>
          <a href="javascript:void(0);" class="btn btn-sm btn-danger text-white border border-light btn-delete" data-id="$1" data-toggle="tooltip" title="Hapus">
            <i class="fas fa-trash fa-sm"></i>
          </a>
        </div>',
        'id, nama, usia, alamat, notelp, status'
      );

    return $this->datatables->generate();
  }

  // ----------------------------------for select2----------------------------------
  public function listKaryawan()
  {
    $this->db->select('id, nama')
      ->from('karyawan');

    $res = $this->db->get()->result();

    return $res;
  }

  public function searchListKaryawan($keyword)
  {
    $this->db->select('id, nama')
      ->from('karyawan')
      ->like('nama', $keyword);

    $res = $this->db->get()->result();

    return $res;
  }
  // ----------------------------------for select2----------------------------------

  public function getId($id)
  {
    return $this->db->get_where('Karyawan', ['id' => $id])->row();
  }

  public function addData($data)
  {
    return $this->db->insert('karyawan', $data);
  }

  public function editData($data, $where)
  {
    return $this->db->update('karyawan', $data, $where);
  }

  public function deleteData($id)
  {
    return $this->db->delete('karyawan', ['id' => $id]);
  }
}
