<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_Customer extends CI_Model
{
  public function getData()
  {
    $this->datatables->select('id, nama, kode, notelp, alamat')
      ->from('customer')
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
        'id, nama, kode, notelp, alamat'
      );

    return $this->datatables->generate();
  }

  public function getDataNama()
  {
    $this->db->select('nama')
      ->from('customer');

    $query = $this->db->get()->result();

    return $query;
  }

  public function getDataByName($nama)
  {
    $this->db->select('*')
      ->from('customer')
      ->where('nama', $nama);

    $query = $this->db->get()->row();

    return $query;
  }

  // for select2 and search
  public function getListData()
  {
    $this->db->select('id, nama, kode, notelp')
      ->from('customer')
      ->order_by('nama', 'asc');

    $res = $this->db->get()->result();

    return $res;
  }

  public function getSearchListData($keyword)
  {
    $this->db->select('id, nama, kode, notelp')
      ->from('customer')
      ->like('nama', $keyword);

    $res = $this->db->get()->result();

    return $res;
  }
  // end for select2 and search

  public function countData()
  {
    return $this->db->get('customer')->num_rows();
  }

  public function getId($id)
  {
    return $this->db->get_where('customer', ['id' => $id])->row();
  }

  public function getCustomerByNama($nama)
  {
    return $this->db->get_where('customer', ['nama' => $nama])->row();
  }

  public function addData($data)
  {
    return $this->db->insert('customer', $data);
  }

  public function addNewData($datacust)
  {
    $this->db->insert('customer', $datacust);

    return $this->db->insert_id();
  }

  public function editData($data, $where)
  {
    return $this->db->update('customer', $data, $where);
  }

  public function deleteData($id)
  {
    return $this->db->delete('customer', ['id' => $id]);
  }
}
