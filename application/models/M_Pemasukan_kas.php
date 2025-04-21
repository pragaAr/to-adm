<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class M_Pemasukan_kas extends CI_Model
{
  public function getData()
  {
    $this->db->select('pemasukan.id_pemasukan, pemasukan.jenis_pemasukan, pemasukan.no_order, pemasukan.dari, pemasukan.nominal, pemasukan.keterangan, pemasukan.dateAdd, penjualan.no_order, penjualan.pengirim');
    $this->db->from('pemasukan');
    $this->db->join('penjualan', 'penjualan.no_order = pemasukan.no_order', 'left');
    $query = $this->db->get()->result();
    return $query;
  }

  public function getId($id)
  {
    $this->db->select('pemasukan.id_pemasukan, pemasukan.jenis_pemasukan, pemasukan.no_order, pemasukan.dari, pemasukan.nominal, pemasukan.keterangan, pemasukan.dateAdd, penjualan.no_order, penjualan.pengirim');
    $this->db->from('pemasukan');
    $this->db->join('penjualan', 'penjualan.no_order = pemasukan.no_order', 'left');
    $this->db->where('pemasukan.id_pemasukan', $id);
    $query = $this->db->get()->row();
    return $query;
  }

  public function addData()
  {
    $jenis      = $this->input->post('jenis');
    $noorder    = $this->input->post('noorder');
    $dari       = $this->input->post('dari');
    $nominal    = preg_replace("/[^0-9\.]/", "", $this->input->post('nominal'));
    $keterangan = $this->input->post('keterangan');
    $user       = $this->session->userdata('id_user');
    $dateAdd    = date('Y-m-d H:i:s');

    $data = array(
      'jenis_pemasukan' => strtolower($jenis),
      'no_order'        => strtolower($noorder),
      'dari'            => strtolower($dari),
      'nominal'         => strtolower($nominal),
      'keterangan'      => strtolower($keterangan),
      'user_id'         => strtolower($user),
      'dateAdd'         => $dateAdd
    );

    $this->db->insert('pemasukan', $data);
  }

  public function editData($id)
  {
    $jenis      = $this->input->post('jenis');
    $noorder    = $this->input->post('noorder');
    $dari       = $this->input->post('dari');
    $nominal    = preg_replace("/[^0-9\.]/", "", $this->input->post('nominal'));
    $keterangan = $this->input->post('keterangan');
    $user       = $this->session->userdata('id_user');

    $data = array(
      'jenis_pemasukan' => strtolower($jenis),
      'no_order'        => strtolower($noorder),
      'dari'            => strtolower($dari),
      'nominal'         => strtolower($nominal),
      'keterangan'      => strtolower($keterangan),
      'user_id'         => strtolower($user),
    );

    $where = array('id_pemasukan' => $id);

    $this->db->update('pemasukan', $data, $where);
  }

  public function deleteData($id)
  {
    return $this->db->delete('pemasukan', ['id_pemasukan' => $id]);
  }
}
