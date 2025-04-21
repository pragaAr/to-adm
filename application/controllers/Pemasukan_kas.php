<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pemasukan_kas extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_Pemasukan_kas', 'Pemasukan');

    if (empty($this->session->userdata('id'))) {
      $this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
      redirect('auth');
    }
  }

  public function index()
  {
    $data['title']        = 'Data Pemasukan Kas';
    $data['pemasukan']    = $this->Pemasukan->getData();

    $this->form_validation->set_rules('jenis', 'Jenis Pemasukan', 'trim|required');
    $this->form_validation->set_rules('dari', 'Terima Dari', 'trim|required');
    $this->form_validation->set_rules('nominal', 'Nominal', 'trim|required');
    $this->form_validation->set_rules('keterangan', 'Keterang', 'trim|required');

    if ($this->form_validation->run() == false) {
      $this->load->view('layout/template/header', $data);
      $this->load->view('layout/template/navbar');
      $this->load->view('layout/template/sidebar');
      $this->load->view('layout/administrasi/pemasukan-kas', $data);
      $this->load->view('layout/template/footer');
    } else {
      $this->Pemasukan->addData();
      $this->session->set_flashdata('inserted', 'Data berhasil ditambahkan!');
      redirect('pemasukan_kas');
    }
  }

  public function getId()
  {
    $id   = $this->input->post('id_pemasukan');
    $data = $this->Pemasukan->getId($id);

    echo json_encode($data);
  }

  public function update()
  {
    $id = $this->input->post('idpemasukan');
    $this->Pemasukan->editData($id);
    $this->session->set_flashdata('updated', 'Data berhasil diubah!');
    redirect('pemasukan_kas');
  }

  public function delete($id)
  {
    $this->Pemasukan->deleteData($id);
    $this->session->set_flashdata('deleted', 'Data berhasil dihapus!');
    redirect('pemasukan_kas');
  }
}
