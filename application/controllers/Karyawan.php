<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');
class Karyawan extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('datatables');

    $this->load->model('M_Karyawan', 'Karyawan');

    if (empty($this->session->userdata('id'))) {
      $this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
      redirect('auth');
    }
  }

  public function index()
  {
    $data['title']  = 'Data Karyawan';

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/master/karyawan', $data);
    $this->load->view('layout/template/footer');
  }

  public function getKaryawan()
  {
    header('Content-Type: application/json');

    echo $this->Karyawan->getData();
  }

  public function getId()
  {
    $id   = $this->input->post('id');
    $data = $this->Karyawan->getId($id);

    echo json_encode($data);
  }

  public function getKaryawanList()
  {
    $keyword = $this->input->get('q');

    $data = !$keyword ? $this->Karyawan->listKaryawan() : $this->Karyawan->searchListKaryawan($keyword);

    $response = [];

    foreach ($data as $karyawan) {
      $response[] = [
        'id'    => $karyawan->id,
        'text'  => ucwords($karyawan->nama),
      ];
    }

    echo json_encode($response);
  }


  public function add()
  {
    $nama   = trim($this->input->post('nama'));
    $usia   = trim($this->input->post('usia'));
    $alamat = trim($this->input->post('alamat'));
    $notelp = trim($this->input->post('notelp'));
    $status = trim($this->input->post('status'));
    $addAt  = date('Y-m-d H:i:s');

    $data = [
      'nama'    => strtolower($nama),
      'usia'    => strtolower($usia),
      'alamat'  => strtolower($alamat),
      'notelp'  => strtolower($notelp),
      'status'  => strtolower($status),
      'dateAdd' => $addAt,
    ];

    $data = $this->Karyawan->addData($data);

    echo json_encode($data);
  }

  public function update()
  {
    $id     = $this->input->post('id');
    $nama   = trim($this->input->post('nama'));
    $usia   = trim($this->input->post('usia'));
    $alamat = trim($this->input->post('alamat'));
    $notelp = trim($this->input->post('notelp'));
    $status = trim($this->input->post('status'));

    $data = [
      'nama'    => strtolower($nama),
      'usia'    => strtolower($usia),
      'alamat'  => strtolower($alamat),
      'notelp'  => strtolower($notelp),
      'status'  => strtolower($status),
    ];

    $where = [
      'id' => $id
    ];

    $data = $this->Karyawan->editData($data, $where);

    echo json_encode($data);
  }

  public function delete()
  {
    $id   = $this->input->post('id');
    $data = $this->Karyawan->deleteData($id);

    echo json_encode($data);
  }
}
