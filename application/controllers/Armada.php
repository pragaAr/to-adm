<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class Armada extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('datatables');

    $this->load->model('M_Armada', 'Armada');

    if (empty($this->session->userdata('id'))) {
      $this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
      redirect('auth');
    }
  }

  public function index()
  {
    $data['title']  = 'Data Armada';

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/master/armada', $data);
    $this->load->view('layout/template/footer');
  }

  public function getArmada()
  {
    header('Content-Type: application/json');

    echo $this->Armada->getData();
  }

  public function getId()
  {
    $id   = $this->input->post('id');
    $data = $this->Armada->getId($id);

    echo json_encode($data);
  }

  public function getListArmada()
  {
    $keyword = $this->input->get('q');

    $data = !$keyword ? $this->Armada->getListData() : $this->Armada->getSearchListData($keyword);

    $response = [];
    foreach ($data as $cust) {
      $response[] = [
        'id'    => $cust->id,
        'text'  => strtoupper($cust->platno),
      ];
    }

    echo json_encode($response);
  }

  public function getListArmadaReady()
  {
    $keyword = $this->input->get('q');

    $data = !$keyword ? $this->Armada->getListDataReady() : $this->Armada->getSearchListDataReady($keyword);

    $response = [];
    foreach ($data as $cust) {
      $response[] = [
        'id'    => $cust->id,
        'text'  => strtoupper($cust->platno),
      ];
    }

    echo json_encode($response);
  }

  public function add()
  {
    $platno = trim($this->input->post('platno'));
    $merk   = trim($this->input->post('merk'));
    $keur   = $this->input->post('keur') ? date('Y-m-d', strtotime($this->input->post('keur'))) : null;
    $addAt  = date('Y-m-d H:i:s');

    $data = [
      'platno'    => strtolower($platno),
      'merk'      => strtolower($merk),
      'dateKeur'  => $keur,
      'dateAdd'   => $addAt,
    ];

    $response = $this->Armada->addData($data);

    echo json_encode($response);
  }

  public function update()
  {
    $id     = $this->input->post('id');
    $platno = trim($this->input->post('platno'));
    $merk   = trim($this->input->post('merk'));
    $keur   = $this->input->post('keur') ? date('Y-m-d', strtotime($this->input->post('keur'))) : null;

    $data = [
      'platno'    => strtolower($platno),
      'merk'      => strtolower($merk),
      'dateKeur'  => $keur,
    ];

    $where = [
      'id' => $id
    ];

    $data = $this->Armada->editData($data, $where);

    echo json_encode($data);
  }

  public function delete()
  {
    $id   = $this->input->post('id');
    $data = $this->Armada->deleteData($id);

    echo json_encode($data);
  }
}
