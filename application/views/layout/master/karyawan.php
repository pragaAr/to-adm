<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?= $title ?></h1>
        </div>
        <div class="col-sm-6">
          <div class="breadcrumb float-sm-right">
            <button class="btn btn-dark border border-light" id="btn_add">
              <i class=" fas fa-plus"></i>
              Tambah
            </button>
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
              <div class="table-responsive">
                <table id="karyawanTables" class="table table-bordered table-striped" width="100%" cellspacing="0">
                  <thead class="text-center">
                    <tr>
                      <th class="align-middle">No.</th>
                      <th class="align-middle">Nama</th>
                      <th class="align-middle">Usia</th>
                      <th class="align-middle">Alamat</th>
                      <th class="align-middle">Kontak</th>
                      <th class="align-middle">Status/Bagian</th>
                      <th class="align-middle">Aksi</th>
                    </tr>
                  </thead>
                  <tbody class="text-center" style="font-size:14px;">

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- modalAdd -->
<div class="modal fade" id="modalAdd" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Data Karyawan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="font-size:14px;">
        <form id="form_add">
          <div class="form-group">
            <label for="nama">
              Nama
            </label>
            <input type="text" class="form-control text-uppercase" name="nama" id="nama" placeholder="Nama.." autofocus autocomplete="off" required oninvalid="this.setCustomValidity('Nama wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="usia">
              Usia
            </label>
            <input type="text" class="form-control text-uppercase" name="usia" id="usia" placeholder="Usia.." autocomplete="off" required oninvalid="this.setCustomValidity('Usia wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="alamat">
              Alamat
            </label>
            <input type="text" class="form-control text-uppercase" name="alamat" id="alamat" placeholder="Alamat.." autocomplete="off" required oninvalid="this.setCustomValidity('Alamat wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="notelp">
              Kontak
            </label>
            <input type="text" class="form-control text-uppercase" name="notelp" id="notelp" placeholder="Kontak.." autocomplete="off" required oninvalid="this.setCustomValidity('Kontak wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="status">
              Status/Bagian
            </label>
            <input type="text" class="form-control text-uppercase" name="status" id="status" placeholder="Status.." autocomplete="off" required oninvalid="this.setCustomValidity('Status wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div>
            <button type="submit" class="btn btn-dark border border-light float-right">
              Simpan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- modalEdit -->
<div class="modal fade" id="modalEdit" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Data Karyawan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="font-size:14px;">
        <form id="form_edit">
          <div class="form-group">
            <label for="namaedit">
              Nama
            </label>
            <input type="hidden" class="form-control" name="id" id="id" readonly>
            <input type="text" class="form-control text-uppercase" name="namaedit" id="namaedit" placeholder="Nama.." autofocus autocomplete="off" required oninvalid="this.setCustomValidity('Nama wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="usiaedit">
              Usia
            </label>
            <input type="text" class="form-control text-uppercase" name="usiaedit" id="usiaedit" placeholder="Usia.." autocomplete="off" required oninvalid="this.setCustomValidity('Usia wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="alamatedit">
              Alamat
            </label>
            <input type="text" class="form-control text-uppercase" name="alamatedit" id="alamatedit" placeholder="Alamat.." autocomplete="off" required oninvalid="this.setCustomValidity('Alamat wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="notelpedit">
              Kontak
            </label>
            <input type="text" class="form-control text-uppercase" name="notelpedit" id="notelpedit" placeholder="Kontak.." autocomplete="off" required oninvalid="this.setCustomValidity('Kontak wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="statusedit">
              Status/Bagian
            </label>
            <input type="text" class="form-control text-uppercase" name="statusedit" id="statusedit" placeholder="Status.." autocomplete="off" required oninvalid="this.setCustomValidity('Status wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div>
            <button type="submit" class="btn btn-dark border border-light float-right">
              Simpan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>