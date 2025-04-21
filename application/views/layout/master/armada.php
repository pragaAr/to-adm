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
                <table id="armadaTables" class="table table-bordered table-striped" width="100%" cellspacing="0">
                  <thead class="text-center">
                    <tr>
                      <th class="align-middle">No.</th>
                      <th class="align-middle">Plat Nomor</th>
                      <th class="align-middle">Merk</th>
                      <th class="align-middle">Status</th>
                      <th class="align-middle">Tanggal Keur</th>
                      <th class="align-middle">Tanggal Add</th>
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
        <h4 class="modal-title">Tambah Data Armada</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="font-size:14px;">
        <form id="form_add">
          <div class="form-group">
            <label for="platno">
              Plat No
            </label>
            <input type="text" class="form-control text-uppercase" name="platno" id="platno" placeholder="Plat No.." autofocus autocomplete="off" required oninvalid="this.setCustomValidity('Plat No wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="merk">
              Merk
            </label>
            <input type="text" class="form-control text-uppercase" name="merk" id="merk" placeholder="Merk.." autocomplete="off" required oninvalid="this.setCustomValidity('Merk wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="keur">
              Tanggal Keur
            </label>
            <input type="date" class="form-control" name="keur" id="keur">
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
        <h4 class="modal-title">Edit Data Armada</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="font-size:14px;">
        <form id="form_edit">
          <div class="form-group">
            <label for="platnoedit">
              Plat No
            </label>
            <input type="hidden" class="form-control" name="id" id="id" readonly>
            <input type="text" class="form-control text-uppercase" name="platnoedit" id="platnoedit" placeholder="Plat No.." autofocus autocomplete="off" required oninvalid="this.setCustomValidity('Plat No wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="merkedit">
              Merk
            </label>
            <input type="text" class="form-control text-uppercase" name="merkedit" id="merkedit" placeholder="Merk.." autocomplete="off" required oninvalid="this.setCustomValidity('Merk wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="keuredit">
              Tanggal Keur
            </label>
            <input type="date" class="form-control" name="keuredit" id="keuredit">
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