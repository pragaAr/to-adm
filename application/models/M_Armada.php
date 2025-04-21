<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_Armada extends CI_Model
{
  public function getData()
  {
    $this->datatables->select('id, platno, merk, status_truck, dateKeur, dateAdd')
      ->from('armada')
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
        'id, platno, merk, status_truck, dateKeur, dateAdd'
      );

    return $this->datatables->generate();
  }

  public function getId($id)
  {
    return $this->db->get_where('armada', ['id' => $id])->row();
  }

  // for select2 and search
  public function getListData()
  {
    $this->db->select('id, platno')
      ->from('armada')
      ->order_by('platno', 'asc');

    $res = $this->db->get()->result();

    return $res;
  }

  public function getSearchListData($keyword)
  {
    $this->db->select('id, platno')
      ->from('armada')
      ->like('platno', $keyword);

    $res = $this->db->get()->result();

    return $res;
  }
  // end for select2 and search

  // for select2 and search
  public function getListDataReady()
  {
    $this->db->select('id, platno')
      ->from('armada')
      ->where('status_truck', 0)
      ->order_by('platno', 'asc');

    $res = $this->db->get()->result();

    return $res;
  }

  public function getSearchListDataReady($keyword)
  {
    $this->db->select('id, platno')
      ->from('armada')
      ->where('status_truck', 0)
      ->like('platno', $keyword);

    $res = $this->db->get()->result();

    return $res;
  }
  // end for select2 and search

  public function addData($data)
  {
    return $this->db->insert('armada', $data);
  }

  public function editData($data, $where)
  {
    return $this->db->update('armada', $data, $where);
  }

  public function deleteData($id)
  {
    return $this->db->delete('armada', ['id' => $id]);
  }

  public function getSelectedArmadaReady($id, $key)
  {
    $this->db->select('id, platno')
      ->from('armada')
      ->where('status_truck', 0)
      ->order_by('platno', 'asc');

    if ($id) {
      $this->db->or_where('id', $id);
    }

    if ($key) {
      $this->db->like('platno', $key);
    }

    $res = $this->db->get()->result();

    return $res;
  }
}
