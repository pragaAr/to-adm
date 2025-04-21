<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_User extends CI_Model
{
  public function getData()
  {
    $this->datatables->select('id, nama, username, role')
      ->from('user')
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
        'id, nama, username, role'
      );

    return $this->datatables->generate();
  }

  public function getId($id)
  {
    return $this->db->get_where('user', ['id' => $id])->row();
  }

  public function addData($data)
  {
    return $this->db->insert('user', $data);
  }

  public function editData($data, $where)
  {
    return $this->db->update('user', $data, $where);
  }

  public function deleteData($id)
  {
    return $this->db->delete('user', ['id' => $id]);
  }
}
