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
            <a href="" class="btn btn-dark" data-toggle="modal" data-target="#addRek">
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
                    <th>Nomor Rekening</th>
                    <th>Nama Rekening</th>
                    <th>Jenis Rekening</th>
                    <th width="20%">Actions</th>
                  </tr>
                </thead>
                <tbody class="text-center" style="font-size:14px;">
                  <?php $no = 1;
                  foreach ($rek as $data) : ?>
                    <tr>
                      <td><?= $no ?>.</td>
                      <td><?= strtoupper($data->no_rek) ?></td>
                      <td><?= strtoupper($data->nama_rek) ?></td>
                      <td><?= strtoupper($data->jenis_rek) ?></td>
                      <td>
                        <div class="btn-group" role="group">
                          <a href="" class="btn btn-sm btn-warning text-white btn-edit-rek" title="Edit" data-id="<?= $data->no_rek ?>">
                            <i class="fas fa-pencil-alt"></i>
                          </a>
                          <a href="<?= base_url('rekening/delete/') . $data->no_rek ?>" class="btn btn-sm btn-danger text-white btn-delete" title="Hapus">
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

<!-- addRek -->
<form action="<?= base_url('rekening') ?>" method="POST">
  <div class="modal fade" id="addRek" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Data Rekening</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="norek">
              Nomor Rekening
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control text-uppercase" name="norek" placeholder="Nomor Rekening.." required oninvalid="this.setCustomValidity('Nomor Rekening wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="namarek">
              Nama Rekening
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control text-uppercase" name="namarek" placeholder="Nama Rekening.." required oninvalid="this.setCustomValidity('Nama Rekening wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="jenisrek">
              Jenis Rekening
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control text-uppercase" name="jenisrek" placeholder="Jenis Rekening.." required oninvalid="this.setCustomValidity('Jenis Rekening wajib di isi!')" oninput="setCustomValidity('')">
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

<!-- editRek -->
<form action="<?= base_url('rekening/update') ?>" method="POST">
  <div class="modal fade" id="editRek" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Data Rekening</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="norek">
              Nomor Rekening
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control text-uppercase norekold" name="norekold" readonly>
            <input type="text" class="form-control text-uppercase norek" name="norek" placeholder="Nomor Rekening.." required oninvalid="this.setCustomValidity('Nomor Rekening wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="namarek">
              Nama Rekening
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control text-uppercase namarek" name="namarek" placeholder="Nama Rekening.." required oninvalid="this.setCustomValidity('Nama Rekening wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="jenisrek">
              Jenis Rekening
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control text-uppercase jenisrek" name="jenisrek" placeholder="Jenis Rekening.." required oninvalid="this.setCustomValidity('Jenis Rekening wajib di isi!')" oninput="setCustomValidity('')">
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