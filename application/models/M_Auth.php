<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Auth extends CI_MODEL
{
  public function cekLogin($uname)
  {
    return $this->db->get_where('user', ['username' => $uname])->row();
  }

  // public function register()
  // {
  //   $data = array(
  //     'nama'      => $this->input->post('nama'),
  //     'username'  => $this->input->post('username'),
  //     'pass'      => password_hash($this->input->post('pass'), PASSWORD_DEFAULT),
  //     'role'      => 'petugas',
  //     'dateAdd'   => date('Y-m-d H:i:s')
  //   );

  //   $this->db->insert('user', $data);
  // }
}
