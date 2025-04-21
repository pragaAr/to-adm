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
                <table id="sopirTables" class="table table-bordered table-striped" width="100%" cellspacing="0">
                  <thead class="text-center">
                    <tr>
                      <th>No.</th>
                      <th>Nama Sopir</th>
                      <th>Alamat</th>
                      <th>Kontak</th>
                      <th>Status</th>
                      <th>Aksi</th>
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
        <h4 class="modal-title">Tambah Data Sopir</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="font-size:14px;">
        <form id="form_add">
          <div class="form-group">
            <label for="nama">
              Nama Sopir
            </label>
            <input type="text" class="form-control text-uppercase" name="nama" id="nama" placeholder="Nama Sopir.." autofocus autocomplete="off" required oninvalid="this.setCustomValidity('Nama Sopir wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="alamat">
              Alamat Sopir
            </label>
            <input type="text" class="form-control text-uppercase" name="alamat" id="alamat" placeholder="Alamat Sopir.." autocomplete="off" required oninvalid="this.setCustomValidity('Alamat Sopir wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="notelp">
              No Telepon
            </label>
            <input type="text" class="form-control text-uppercase" name="notelp" id="notelp" placeholder="No Telepon.." autocomplete="off" required oninvalid="this.setCustomValidity('No Telepon Sopir wajib di isi!')" oninput="setCustomValidity('')">
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
        <h4 class="modal-title">Edit Data Sopir</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="font-size:14px;">
        <form id="form_edit">
          <div class="form-group">
            <label for="namaedit">
              Nama Sopir
            </label>
            <input type="hidden" class="form-control" name="id" id="id" readonly>
            <input type="text" class="form-control text-uppercase" name="namaedit" id="namaedit" placeholder="Nama Sopir.." autofocus autocomplete="off" required oninvalid="this.setCustomValidity('Nama Sopir wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="alamatedit">
              Alamat Sopir
            </label>
            <input type="text" class="form-control text-uppercase" name="alamatedit" id="alamatedit" placeholder="Alamat Sopir.." autocomplete="off" required oninvalid="this.setCustomValidity('Alamat Sopir wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="notelpedit">
              No Telepon
            </label>
            <input type="text" class="form-control" name="notelpedit" id="notelpedit" placeholder="No Telepon Sopir.." autocomplete="off" required oninvalid="this.setCustomValidity('No Telepon Sopir wajib di isi!')" oninput="setCustomValidity('')">
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

<!-- modalHistory -->
<div class="modal fade" id="modalHistory" data-backdrop="static">
  <div class="modal-dialog modal-xl modal-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-capitalize" id="modalTitle"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="timeline" id="timeline">

        </div>

      </div>
    </div>
  </div>
</div>