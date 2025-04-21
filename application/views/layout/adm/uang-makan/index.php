<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?= $title ?></h1>
        </div>
        <div class="col-sm-6">
          <div class="breadcrumb float-sm-right">
            <a href="<?= base_url('uangmakan/add') ?>" class="btn btn-dark border border-light">
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
                <p class="font-italic">#Untuk Searching tanggal, gunakan format Year-month-day</p>
                <table id="umTables" class="table table-bordered table-striped" width="100%" cellspacing="0">
                  <thead class="text-center">
                    <tr>
                      <th>No.</th>
                      <th>Kode</th>
                      <th>Penerima</th>
                      <th>Total</th>
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
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Detail Uang Makan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding: 1rem 2rem !important; font-size:14px;">

        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
          <div>
            <small class="text-uppercase mb-0 kdtgl"></small><br>
            <small class="text-uppercase font-weight-bold mb-0 total"></small>
          </div>
          <button type="button" id="btn_printDetail" class="btn btn-primary border border-light">Print</button>
          <input type="hidden" name="kdum" id="kdum" class="form-control" readonly>
        </div>
        <table class="table table-bordered" width="100%">
          <thead class="text-center" style="border:1.5px solid rgb(145, 143, 143) !important;">
            <th width="10%" style="border-color: rgb(145, 143, 143) !important;">No.</th>
            <th style="border-color: rgb(145, 143, 143) !important;">Penerima</th>
            <th style="border-color: rgb(145, 143, 143) !important;">Nominal</th>
          </thead>
          <tbody class="text-center" id="tbodyDetail" style="border:1.5px solid rgb(145, 143, 143) !important;">
          </tbody>
        </table>

      </div>
    </div>
  </div>
</div>