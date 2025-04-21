<div class="content-wrapper">
  <div class="inserted" data-flashdata="<?= $this->session->flashdata('inserted'); ?>"></div>
  <div class="updated" data-flashdata="<?= $this->session->flashdata('updated'); ?>"></div>
  <div class="deleted" data-flashdata="<?= $this->session->flashdata('deleted'); ?>"></div>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?= $title ?></h1>
        </div>
        <div class="col-sm-6">
          <div class="breadcrumb float-sm-right">
            <a href="" class="btn btn-dark" data-toggle="modal" data-target="#addKas">
              <i class=" fas fa-plus"></i>
              Tambah
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <table id="dtable" class="table table-bordered table-striped">
                <thead class="text-center">
                  <tr>
                    <th width="10%">No.</th>
                    <th>Jenis</th>
                    <th>Dari</th>
                    <th>No Order</th>
                    <th>Nominal</th>
                    <th>Keterangan</th>
                    <th>Tanggal</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody class="text-center" style="font-size:14px;">
                  <?php $no = 1;
                  foreach ($pemasukan as $data) : ?>
                    <tr>
                      <td><?= $no ?>.</td>
                      <td><?= strtoupper($data->jenis_pemasukan) ?></td>
                      <td><?= strtoupper($data->dari) ?></td>
                      <td><?= strtoupper($data->no_order) ?></td>
                      <td>Rp. <?= number_format($data->nominal) ?></td>
                      <td><?= strtoupper($data->keterangan) ?></td>
                      <td><?= date('d-m-Y', strtotime($data->dateAdd)) ?></td>
                      <td>
                        <div class="btn-group" role="group">
                          <a href="" class="btn btn-sm btn-warning text-white btn-edit-pemasukan" title="Edit" data-id="<?= $data->id_pemasukan ?>">
                            <i class="fas fa-pencil-alt"></i>
                          </a>
                          <a href="<?= base_url('pemasukan_kas/delete/') . $data->id_pemasukan ?>" class="btn btn-sm btn-danger text-white btn-delete" title="Hapus">
                            <i class="fas fa-trash"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                    <?php $no++ ?>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- addKas -->
<form action="<?= base_url('pemasukan_kas') ?>" method="POST">
  <div class="modal fade" id="addKas" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Data Pemasukan Kas</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="font-size:14px;">
          <div class="form-group">
            <label for="jenis">
              Jenis Pemasukan
              <span class="text-white">*</span>
            </label>
            <select name="jenis" id="jenis" class="form-control select2" style="width:100%;" required oninvalid="this.setCustomValidity('Jenis Pemasukan wajib di isi!')" oninput="setCustomValidity('')">
              <option value="" selected disabled>-Pilih Jenis Pemasukan-</option>
              <option value="">Pemasukan 1</option>
              <option value="">Pemasukan 2</option>
              <option value="">Pemasukan 3</option>
              <option value="">Pemasukan 4</option>
            </select>
          </div>
          <div class="form-group">
            <label for="dari">
              Terima Dari
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control" name="dari" id="dari" placeholder="Terima Dari.." required oninvalid="this.setCustomValidity('Terima Dari wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="noorder">
              No Order
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control" name="noorder" id="noorder" placeholder="No Order.." required oninvalid="this.setCustomValidity('No Order wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="nominal">
              Nominal
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control" name="nominal" id="nominal" placeholder="Nominal.." required oninvalid="this.setCustomValidity('Nominal wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="keterangan">
              Keterangan
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control text-capitalize" name="keterangan" placeholder="Keterangan.." required oninvalid="this.setCustomValidity('Keterangan wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div>
            <button type="submit" class="btn btn-dark float-right">
              Simpan
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

<!-- editPemasukan -->
<form action="<?= base_url('pemasukan_kas/update') ?>" method="POST">
  <div class="modal fade" id="editPemasukan" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Data Pemasukan Kas</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="font-size:14px;">
          <div class="form-group">
            <label for="karyawanedit">
              Nama Karyawan
              <span class="text-white">*</span>
            </label>
            <select name="karyawanedit" class="form-control select2 karyawanedit" style="width:100%;" required oninvalid="this.setCustomValidity('Nama Karyawan wajib di isi!')" oninput="setCustomValidity('')">
              <option value="">-Pilih Karyawan-</option>
              <?php foreach ($karyawanedit as $data) : ?>
                <option value="<?= $data->id_karyawan ?>"><?= ucwords($data->nama) ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="form-group">
            <label for="nominaledit">
              Nominal
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control nominaledit" name="nominaledit" id="nominaledit" placeholder="Nominal.." required oninvalid="this.setCustomValidity('Nominal wajib di isi!')" oninput="setCustomValidity('')">
            <input type="hidden" name="idlain" class="form-control idlain" required readonly>
          </div>
          <div class="form-group">
            <label for="keteranganedit">
              Keterangan
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control text-capitalize keteranganedit" name="keteranganedit" placeholder="Keterangan.." required oninvalid="this.setCustomValidity('Keterangan wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div>
            <button type="submit" class="btn btn-dark float-right">
              Simpan
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>