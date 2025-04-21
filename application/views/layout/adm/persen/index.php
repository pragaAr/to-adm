<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?= $title ?></h1>
        </div>
        <div class="col-sm-6">
          <div class="breadcrumb float-sm-right">
            <a href="<?= base_url('persensopir/add') ?>" class="btn btn-dark border border-light">
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
                <table id="persenTables" class="table table-bordered table-striped" style="width:100%" cellspacing="0">
                  <thead class="text-center">
                    <tr>
                      <th>No.</th>
                      <th>Kd</th>
                      <th>Sopir</th>
                      <th>Jml Order</th>
                      <th>Total Diterima</th>
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
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Detail Persen Sopir</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding: 2rem !important; font-size:14px;">
        <div class="d-flex justify-content-between align-items-start flex-wrap mb-3">
          <div class="font-weight-bold">
            <p class="text-uppercase mb-0 kd-sopir"></p>
          </div>
          <button class="btn btn-primary border border-light" id="printDetail" data-toggle="tooltip" title="Print">
            <i class="fas fa-print"></i>
          </button>
        </div>
        <div class="table-responsive">
          <p class="text-uppercase">Data Order Penjualan</p>
          <table class="table table-bordered" width="100%">
            <thead class="text-center" style="border:1.5px solid rgb(145, 143, 143) !important;">
              <th class="align-middle" width="5%" style="border-color: rgb(145, 143, 143) !important;">No</th>
              <th class="align-middle" style="border-color: rgb(145, 143, 143) !important;">Customer</th>
              <th class="align-middle" style="border-color: rgb(145, 143, 143) !important;">Tanggal</th>
              <th class="align-middle" style="border-color: rgb(145, 143, 143) !important;">Plat Nomor</th>
              <th class="align-middle" style="border-color: rgb(145, 143, 143) !important;">Tonase</th>
              <th class="align-middle" style="border-color: rgb(145, 143, 143) !important;">Harga Kg</th>
              <th class="align-middle" style="border-color: rgb(145, 143, 143) !important;">Biaya</th>
              <th class="align-middle" style="border-color: rgb(145, 143, 143) !important;">%</th>
              <th class="align-middle" style="border-color: rgb(145, 143, 143) !important;">%</th>
              <th class="align-middle" style="border-color: rgb(145, 143, 143) !important;">Total</th>
            </thead>
            <tbody class="text-center" style="border:1.5px solid rgb(145, 143, 143) !important;" id="tbodyOrderPenjualan">

            </tbody>
          </table>
        </div>

        <div class="table-responsive">
          <p class="text-uppercase">Data Sangu</p>
          <table class="table table-bordered" width="100%">
            <thead class="text-center" style="border:1.5px solid rgb(145, 143, 143) !important;">
              <th class="align-middle" width="5%" style="border-color: rgb(145, 143, 143) !important;">No</th>
              <th class="align-middle" style="border-color: rgb(145, 143, 143) !important;">Terima Sangu</th>
              <th class="align-middle" style="border-color: rgb(145, 143, 143) !important;">Tanggal</th>
              <th class="align-middle" style="border-color: rgb(145, 143, 143) !important;">Nominal</th>
              <th class="align-middle" style="border-color: rgb(145, 143, 143) !important;">Tambahan</th>
              <th class="align-middle" style="border-color: rgb(145, 143, 143) !important;">Total</th>
            </thead>
            <tbody class="text-center" style="border:1.5px solid rgb(145, 143, 143) !important;" id="tbodySanguOrder">

            </tbody>
          </table>
        </div>
        <div class="d-flex justify-content-between align-items-center font-weight-bold">
          <p>Persen (Jumlah Order Penjualan - Jumlah Sangu) : </p>
          <p class="pr-4" id="totalDiterima"></p>
        </div>
      </div>
    </div>
  </div>
</div>