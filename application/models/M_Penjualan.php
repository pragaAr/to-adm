<?php defined('BASEPATH') or exit('No direct script access allowed');
class M_Penjualan extends CI_Model
{
  public function generateReccu()
  {
    $last_code = $this->db->select('reccu')->order_by('reccu', 'DESC')->limit(1)->get('penjualan')->row('reccu');

    if (!$last_code) {
      return '007698';
    }

    $last_number = (int)substr($last_code, 2);

    $next_number = str_pad($last_number + 1, 6, '0', STR_PAD_LEFT);

    $kode = $next_number;

    return $kode;
  }

  public function getData()
  {
    $this->datatables->select('
                              p.id, p.reccu, p.order_id, 
                              om.no_order, om.dateAdd as tgl_order, 
                              p.jenis, p.muatan, p.berat, p.hrg_borong, p.hrg_kg, 
                              p.pengirim, p.kota_asal, p.alamat_asal, p.penerima, p.kota_tujuan, p.alamat_tujuan, 
                              p.total_hrg, p.pembayaran
                              ')
      ->from('penjualan p')
      ->join('order_masuk om', 'om.id = p.order_id')
      ->add_column(
        'view',
        '<div class="btn-group" role="group">
          <a href="javascript:void(0);" class="btn btn-sm btn-info text-white border border-light btn-print" data-reccu="$2" data-toggle="tooltip" title="Cetak">
            <i class="fas fa-print fa-sm"></i>
          </a>
          <a href="javascript:void(0);" class="btn btn-sm btn-success text-white border border-light btn-detail" data-toggle="tooltip" title="Detail" data-kd="$2">
            <i class="fas fa-eye fa-sm"></i>
          </a>
          <a href="javascript:void(0);" class="btn btn-sm btn-warning text-white border border-light btn-edit" data-kd="$2" data-toggle="tooltip" title="Edit">
            <i class="fas fa-pencil-alt fa-sm"></i>
          </a>
          <a href="javascript:void(0);" class="btn btn-sm btn-danger text-white border border-light btn-delete" data-kd="$3" data-toggle="tooltip" title="Hapus">
            <i class="fas fa-trash fa-sm"></i>
          </a>
        </div>',
        'id, reccu, no_order, jenis, muatan, berat, hrg_borong, hrg_kg, pengirim, kota_asal, alamat_asal, penerima, kota_tujuan, alamat_tujuan, total_hrg, pembayaran, dateAdd'
      );

    return $this->datatables->generate();
  }

  public function cekReccu($reccu)
  {
    $this->db->select('om.no_order, p.reccu, p.pembayaran')
      ->from('penjualan p')
      ->join('order_masuk om', 'om.id = p.order_id')
      ->where('p.reccu', $reccu);

    $query = $this->db->get()->row();

    return $query;
  }

  public function getDataByKd($rc)
  {
    $this->db->select('
                      p.id, p.reccu, 
                      om.id as id_order, om.no_order, om.dateAdd as dateorder, 
                      p.jenis, p.muatan, p.berat, p.hrg_borong, 
                      p.hrg_kg, p.pengirim, p.kota_asal, p.alamat_asal, 
                      p.penerima, p.kota_tujuan, p.alamat_tujuan, 
                      p.total_hrg, p.pembayaran, 
                      p.dateAdd, p.datePelunasan
                      ')
      ->from('penjualan p')
      ->join('order_masuk om', 'om.id = p.order_id')
      ->where('p.reccu', $rc);

    $query = $this->db->get()->row();

    return $query;
  }

  public function getDataOrderById($id)
  {
    $this->db->select('a.order_id, b.no_order')
      ->from('penjualan a')
      ->from('order_masuk b', 'b.id = a.order_id')
      ->where('order_id', $id);

    $query = $this->db->get()->row();

    return $query;
  }

  public function getReccu()
  {
    $this->db->select('p.reccu, p.pengirim, p.penerima, p.jenis, p.berat, p.hrg_kg, p.hrg_borong, p.total_hrg, om.no_order')
      ->from('penjualan p')
      ->join('order_masuk om', 'om.id = p.order_id');

    $query = $this->db->get()->result();

    return $query;
  }

  public function getSearchReccu($keyword)
  {
    $this->db->select('p.reccu, p.pengirim, p.penerima, p.jenis, p.berat, p.hrg_kg, p.hrg_borong, p.total_hrg, om.no_order')
      ->from('penjualan')
      ->join('order_masuk om', 'om.id = p.order_id')
      ->like('p.reccu', $keyword);;

    $query = $this->db->get()->result();

    return $query;
  }

  public function getReccuForTravelDoc($reccu)
  {
    $this->db->select('p.reccu, p.penerima, p.jenis, p.berat, p.hrg_kg, p.hrg_borong, p.total_hrg, om.id as id_order, om.no_order, om.customer_id')
      ->from('penjualan p')
      ->join('order_masuk om', 'om.id = p.order_id')
      // ->where('p.reccu NOT IN (SELECT reccu FROM detail_sj)')
      ->like('p.reccu', $reccu);

    $query = $this->db->get()->row();

    return $query;
  }

  // public function getSearchReccuForTravelDoc($keyword)
  // {
  //   $this->db->select('p.reccu, p.pengirim, p.penerima, p.jenis, p.berat, p.hrg_kg, p.hrg_borong, p.total_hrg, om.no_order, om.customer_id')
  //     ->from('penjualan')
  //     ->join('order_masuk om', 'om.id = p.order_id')
  //     ->where('p.reccu NOT IN (SELECT reccu FROM detail_sj)')
  //     ->like('p.reccu', $keyword);

  //   $query = $this->db->get()->result();

  //   return $query;
  // }

  public function getDataCustomerReccu($cust)
  {
    $this->db->select('reccu')
      ->from('penjualan')
      ->where('pengirim', $cust);

    $query = $this->db->get()->result();

    return $query;
  }

  public function countData()
  {
    return $this->db->get('penjualan')->num_rows();
  }

  public function getNoOrder($no)
  {
    return $this->db->get_where('penjualan', ['no_order' => $no])->row();
  }

  public function getNoOrderPenjualan($no)
  {
    return $this->db->get_where('penjualan', ['no_order' => $no])->row();
  }

  public function getDataCust()
  {
    $this->db->select('DiSTINCT(pengirim)');
    $this->db->from('penjualan');
    $query = $this->db->get()->result();
    return $query;
  }

  public function getOrderCust($post)
  {
    $this->db->select('no_order');
    $this->db->from('penjualan');
    $this->db->where('penjualan.invAdd =', null);
    $this->db->where('pengirim', $post);
    $this->db->where('pembayaran=', "tempo");

    $query = $this->db->get()->result();
    return $query;
  }

  public function getOrderSopir($noorder)
  {
    $this->db->select('penjualan.no_order, penjualan.jenis_penjualan, penjualan.muatan, penjualan.pengirim, penjualan.kota_asal, penjualan.kota_tujuan, penjualan.total_harga, order_masuk.no_order, sangu_order.no_order, sangu_order.sopir_id, sangu_order.nominal, sangu_order.tambahan');
    $this->db->from('penjualan');
    $this->db->where('penjualan.no_order', $noorder);
    $this->db->join('order_masuk', 'order_masuk.no_order = penjualan.no_order');
    $this->db->join('sangu_order', 'sangu_order.no_order = penjualan.no_order');

    $query = $this->db->get()->row();
    return $query;
  }

  public function getDataOrderCust($no)
  {
    $this->db->select('penjualan.no_order, penjualan.surat_jalan, penjualan.kota_asal, penjualan.kota_tujuan, penjualan.berat, penjualan.harga_kg, penjualan.total_harga, penjualan.dateAdd, penjualan.invAdd, sangu_order.no_order, sangu_order.platno');
    $this->db->from('penjualan');
    $this->db->where('penjualan.no_order', $no);
    $this->db->join('sangu_order', 'sangu_order.no_order = penjualan.no_order');
    $query = $this->db->get()->row();
    return $query;
  }

  public function addData($data, $dataorder, $where)
  {
    $this->db->trans_start();

    $this->db->insert('penjualan', $data);
    $this->db->update('order_masuk', $dataorder, $where);

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
      return false;
    } else {
      return true;
    }
  }

  public function editData($data, $wherepenjualanid)
  {
    $this->db->update('penjualan', $data, $wherepenjualanid);

    if ($this->db->affected_rows() > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function deleteData($id, $no)
  {
    $this->db->trans_start();

    $dataorder = [
      'status_sales'  => '',
    ];

    $wherenoorder = [
      'no_order' => $no
    ];

    $whereidorder = [
      'order_id' => $id
    ];

    $this->db->delete('penjualan', $whereidorder);
    $this->db->update('order_masuk', $dataorder, $wherenoorder);

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
      return false;
    } else {
      return true;
    }
  }
}
