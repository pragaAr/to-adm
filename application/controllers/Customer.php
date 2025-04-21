<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class Customer extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('datatables');

		$this->load->model('M_Customer', 'Customer');

		if (empty($this->session->userdata('id'))) {
			$this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
			redirect('auth');
		}
	}

	public function index()
	{
		$data['title'] 	= 'Data Customer';

		$this->load->view('layout/template/header', $data);
		$this->load->view('layout/template/navbar');
		$this->load->view('layout/template/sidebar');
		$this->load->view('layout/master/customer', $data);
		$this->load->view('layout/template/footer');
	}

	public function getCustomer()
	{
		header('Content-Type: application/json');

		echo $this->Customer->getData();
	}

	public function getId()
	{
		$id   = $this->input->post('id');
		$data = $this->Customer->getId($id);

		echo json_encode($data);
	}

	public function getDataCustomer()
	{
		$nama	= $this->input->post('nama');
		$data = $this->Customer->getDataByName($nama);

		echo json_encode($data);
	}

	public function getListCustomer()
	{
		$keyword = $this->input->get('q');

		$data = !$keyword ? $this->Customer->getListData() : $this->Customer->getSearchListData($keyword);

		$response = [];
		foreach ($data as $cust) {
			$response[] = [
				'id'    => $cust->id,
				'text'  => strtoupper($cust->nama),
				'kode'  => strtoupper($cust->kode),
				'telp'  => ucwords($cust->notelp),
			];
		}

		echo json_encode($response);
	}

	public function add()
	{
		$nama 	= trim($this->input->post('nama'));
		$kode 	= trim($this->input->post('kode'));
		$notelp = trim($this->input->post('notelp'));
		$alamat	= trim($this->input->post('alamat'));
		$addAt  = date('Y-m-d H:i:s');

		$data = [
			'nama'    => strtolower($nama),
			'kode'    => strtolower($kode),
			'notelp'  => strtolower($notelp),
			'alamat'  => strtolower($alamat),
			'dateAdd'	=> $addAt,
		];

		$data = $this->Customer->addData($data);

		echo json_encode($data);
	}

	public function addNewSelect()
	{
		$nama 	= trim($this->input->post('nama'));
		$kode 	= trim($this->input->post('kode'));
		$notelp = trim($this->input->post('notelp'));
		$alamat	= trim($this->input->post('alamat'));
		$addAt  = date('Y-m-d H:i:s');

		// Cek apakah nomor telepon sudah ada dalam database
		$ceknama = $this->Customer->getCustomerByNama($nama);
		if ($ceknama) {
			// Jika nomor telepon sudah ada, kembalikan pesan error
			$response = [
				'status'	=> 'error',
				'msg'			=> 'Customer sudah terdaftar.',
			];
			echo json_encode($response);
			return;
		}

		$datacust = array(
			'nama'  	=> strtolower($nama),
			'kode'    => strtolower($kode),
			'notelp'  => strtolower($notelp),
			'alamat'  => strtolower($alamat),
			'dateAdd'	=> $addAt,
		);

		$this->Customer->addNewData($datacust);

		$custid = $this->db->insert_id();

		$response = [
			'id'			=> $custid,
			'text'  	=> ucwords($nama),
			'kode'  	=> ucwords($kode),
			'telp'  	=> $notelp,
			'status'	=> 'success',
		];

		echo json_encode($response);
	}

	public function update()
	{
		$id     = $this->input->post('id');
		$nama 	= trim($this->input->post('nama'));
		$kode 	= trim($this->input->post('kode'));
		$notelp = trim($this->input->post('notelp'));
		$alamat	= trim($this->input->post('alamat'));

		$data = [
			'nama'    => strtolower($nama),
			'kode'    => strtolower($kode),
			'notelp'	=> strtolower($notelp),
			'alamat'  => strtolower($alamat),
		];

		$where = [
			'id' => $id
		];

		$data = $this->Customer->editData($data, $where);

		echo json_encode($data);
	}

	public function delete()
	{
		$id   = $this->input->post('id');
		$data = $this->Customer->deleteData($id);

		echo json_encode($data);
	}
}
