<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_Sopir extends CI_Model
{
  public function getData()
  {
    $this->datatables->select('id, nama, alamat, notelp, status_sopir')
      ->from('sopir')
      ->add_column(
        'view',
        '<div class="btn-group" role="group">
          <a href="javascript:void(0);" class="btn btn-sm btn-info text-white border border-light btn-history" data-id="$1" data-nama="$2" data-toggle="tooltip" title="History Order">
            <i class="fas fa-history fa-sm"></i>
          </a>
          <a href="javascript:void(0);" class="btn btn-sm btn-warning text-white border border-light btn-edit" data-id="$1" data-toggle="tooltip" title="Edit">
            <i class="fas fa-pencil-alt fa-sm"></i>
          </a>
          <a href="javascript:void(0);" class="btn btn-sm btn-danger text-white border border-light btn-delete" data-id="$1" data-toggle="tooltip" title="Hapus">
            <i class="fas fa-trash fa-sm"></i>
          </a>
        </div>',
        'id, nama, alamat, notelp, status_sopir'
      );

    return $this->datatables->generate();
  }

  public function getId($id)
  {
    return $this->db->get_where('sopir', ['id' => $id])->row();
  }

  public function getDataHistoryOrder($id)
  {
    $this->db->select('a.id, a.nama as nama_sopir, b.no_order, b.nominal as nominal_sangu, b.tambahan as tambahan_sangu, b.keterangan as ket_tambahan_sangu, c.asal_order, c.tujuan_order, c.jenis_muatan, c.status_order, c.dateAdd as tgl_order, d.nama as nama_cust, e.platno')
      ->from('sopir a')
      ->where('a.id', $id)
      ->join('sangu_sopir b', 'b.sopir_id = a.id')
      ->join('order_masuk c', 'c.no_order = b.no_order')
      ->join('customer d', 'd.id = c.customer_id')
      ->join('armada e', 'e.id = b.truck_id')
      ->order_by('b.id', 'desc')
      ->group_by('b.no_order');

    $query = $this->db->get()->result();

    return $query;
  }

  // for select2 and search
  public function getListData()
  {
    $this->db->select('id, nama')
      ->from('sopir')
      ->order_by('nama', 'asc');

    $res = $this->db->get()->result();

    return $res;
  }

  public function getSearchListData($keyword)
  {
    $this->db->select('id, nama')
      ->from('sopir')
      ->like('nama', $keyword);

    $res = $this->db->get()->result();

    return $res;
  }
  // end for select2 and search

  // for select2 and search
  public function getListDataAvailable()
  {
    $this->db->select('id, nama')
      ->from('sopir')
      ->where('status_sopir', 0)
      ->order_by('nama', 'asc');

    $res = $this->db->get()->result();

    return $res;
  }

  public function getSearchListDataAvailable($keyword)
  {
    $this->db->select('id, nama')
      ->from('sopir')
      ->where('status_sopir', 0)
      ->like('nama', $keyword);

    $res = $this->db->get()->result();

    return $res;
  }
  // end for select2 and search

  public function addData($data)
  {
    return $this->db->insert('sopir', $data);
  }

  public function editData($data, $where)
  {
    return $this->db->update('sopir', $data, $where);
  }

  public function deleteData($id)
  {
    return $this->db->delete('sopir', ['id' => $id]);
  }

  public function getSelectedSopirAvailable($id, $key)
  {
    $this->db->select('id, nama')
      ->from('sopir')
      ->where('status_sopir', 0)
      ->order_by('nama', 'asc');

    if ($id) {
      $this->db->or_where('id', $id);
    }

    if ($key) {
      $this->db->like('nama', $key);
    }

    $res = $this->db->get()->result();

    return $res;
  }
}
