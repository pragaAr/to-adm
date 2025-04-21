<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekening extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_Rekening', 'Rek');

    if (empty($this->session->userdata('id'))) {
      $this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
      redirect('auth');
    }
  }

  public function index()
  {
    $data['title']  = 'Data Rekening';
    $data['rek']    = $this->Rek->getData();

    $this->form_validation->set_rules('norek', 'Nomor Rekening', 'trim|required');
    $this->form_validation->set_rules('namarek', 'Nama Rekening', 'trim|required');
    $this->form_validation->set_rules('jenisrek', 'Jenis Rekening', 'trim|required');

    if ($this->form_validation->run() == false) {
      $this->load->view('layout/template/header', $data);
      $this->load->view('layout/template/navbar');
      $this->load->view('layout/template/sidebar');
      $this->load->view('layout/administrasi/rekening', $data);
      $this->load->view('layout/template/footer');
    } else {
      $this->Rek->addData();
      $this->session->set_flashdata('inserted', 'Data berhasil ditambahkan!');
      redirect('rekening');
    }
  }

  public function getNo()
  {
    $no   = $this->input->post('no_rek');
    $data = $this->Rek->getNo($no);

    echo json_encode($data);
  }

  public function update()
  {
    $no = $this->input->post('norekold');
    $this->Rek->editData($no);
    $this->session->set_flashdata('updated', 'Data berhasil diubah!');
    redirect('rekening');
  }

  public function delete($no)
  {
    $this->Rek->deleteData($no);
    $this->session->set_flashdata('deleted', 'Data berhasil dihapus!');
    redirect('rekening');
  }
}
