<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?= $title ?></h1>
        </div>
        <div class="col-sm-6">
          <div class="breadcrumb float-sm-right">
            <a href="<?= base_url('pengeluaran_lain/add') ?>" class="btn btn-dark border border-light">
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
              <div class="table-responsive">
                <table id="etcTables" class="table table-bordered table-striped" width="100%" cellspacing="0">
                  <thead class="text-center">
                    <tr>
                      <th>No.</th>
                      <th>Kode</th>
                      <th>Nama</th>
                      <th>Jml Nominal</th>
                      <th>Jml Keperluan</th>
                      <th>Tanggal</th>
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

<!-- modalDetail -->
<div class="modal fade" id="modalDetail" data-backdrop="static">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Detail Pengeluaran Lain</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center justify-content-between">
          <p id="kd_kry"></p>
          <p id="tgl"></p>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="tableDetail" style="width: 100%" cellspacing="0">
            <thead>
              <tr>
                <th class="text-center align-middle" style="width: 10%">No.</th>
                <th class="text-center align-middle" style="width: 40%">Keperluan</th>
                <th class="text-center align-middle" style="width: 20%">Item</th>
                <th class="text-center align-middle" style="width: 30%">Nominal</th>
              </tr>
            </thead>
            <tbody id="tbodyDetail">

            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>
</div>