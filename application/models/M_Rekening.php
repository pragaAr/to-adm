<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class M_Rekening extends CI_Model
{
  public function getData()
  {
    return $this->db->get('rekening')->result();
  }

  public function getNo($no)
  {
    return $this->db->get_where('rekening', ['no_rek' => $no])->row();
  }

  public function addData()
  {
    $norek    = $this->input->post('norek');
    $namarek  = $this->input->post('namarek');
    $jenisrek = $this->input->post('jenisrek');
    $dateAdd  = date('Y-m-d H:i:s');

    $data = array(
      'no_rek'      => strtolower($norek),
      'nama_rek'    => strtolower($namarek),
      'jenis_rek'   => strtolower($jenisrek),
      'dateAdd'     => $dateAdd
    );

    $this->db->insert('rekening', $data);
  }

  public function editData($no)
  {
    $norek    = $this->input->post('norek');
    $namarek  = $this->input->post('namarek');
    $jenisrek = $this->input->post('jenisrek');

    $data = array(
      'no_rek'     => strtolower($norek),
      'nama_rek'   => strtolower($namarek),
      'jenis_rek'  => strtolower($jenisrek),
    );

    $where = array('no_rek' => $no);

    $this->db->update('rekening', $data, $where);
  }

  public function deleteData($no)
  {
    return $this->db->delete('rekening', ['no_rek' => $no]);
  }
}
