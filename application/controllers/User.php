<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');
class User extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('datatables');

    $this->load->model('M_User', 'User');

    if (empty($this->session->userdata('id'))) {
      $this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
      redirect('auth');
    }
  }

  public function index()
  {
    $data['title']  = 'Data User';

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/master/user', $data);
    $this->load->view('layout/template/footer');
  }

  public function getUser()
  {
    header('Content-Type: application/json');

    echo $this->User->getData();
  }

  public function getId()
  {
    $id   = $this->input->post('id');
    $data = $this->User->getId($id);

    echo json_encode($data);
  }

  public function add()
  {
    $nama     = trim($this->input->post('nama'));
    $username = trim($this->input->post('username'));
    $pass     = $this->input->post('pass');
    $role     = trim($this->input->post('role'));
    $addAt    = date('Y-m-d H:i:s');

    $data = [
      'nama'      => strtolower($nama),
      'username'  => strtolower($username),
      'pass'      => password_hash($pass, PASSWORD_DEFAULT),
      'role'      => strtolower($role),
      'dateAdd'   => $addAt,
    ];

    $response = $this->User->addData($data);

    echo json_encode($response);
  }

  public function update()
  {
    $id       = $this->input->post('id');
    $nama     = trim($this->input->post('nama'));
    $username = trim($this->input->post('username'));
    $pass     = $this->input->post('pass');
    $role     = trim($this->input->post('role'));

    if (!empty($pass)) {
      $data = [
        'nama'      => strtolower($nama),
        'username'  => strtolower($username),
        'pass'      => password_hash($pass, PASSWORD_DEFAULT),
        'role'      => strtolower($role),
      ];
    } else {
      $data = [
        'nama'      => strtolower($nama),
        'username'  => strtolower($username),
        'role'      => strtolower($role),
      ];
    }

    $where = [
      'id' => $id
    ];

    $response = $this->User->editData($data, $where);

    echo json_encode($response);
  }

  public function delete()
  {
    $id       = $this->input->post('id');
    $response = $this->User->deleteData($id);

    echo json_encode($response);
  }
}
