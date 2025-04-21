<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?= $title ?></h1>
        </div>
        <div class="col-sm-6">

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
                <table id="sanguTables" class="table table-bordered table-striped" style="width:100%" cellspacing="0">
                  <thead class="text-center">
                    <tr>
                      <th>No.</th>
                      <th>No Order</th>
                      <th>Truck</th>
                      <th>Sopir</th>
                      <th>Nominal</th>
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

<!-- modalEditSangu -->
<div class="modal fade" id="modalEditSangu" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Data Sangu</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_updateSangu">
          <div class="form-group">
            <label for="noorder">
              No Order
            </label>
            <input type="text" class="form-control text-uppercase" name="noorder" id="noorder" readonly>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="platno">
                Truck
              </label>
              <input type="text" class="form-control text-uppercase" name="platno" id="platno" readonly>
            </div>
            <div class="form-group col-md-6">
              <label for="sopir">
                Sopir
              </label>
              <input type="text" class="form-control text-uppercase" name="sopir" id="sopir" readonly>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="nominal">
                Nominal
              </label>
              <input type="text" class="form-control" name="nominal" id="nominal" placeholder="Nominal.." readonly>
            </div>
            <div class="form-group col-md-6">
              <label for="tambahan">
                Tambahan
              </label>
              <input type="text" class="form-control" name="tambahan" id="tambahan" value="0" placeholder="Tambahan..">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="keterangan">
                Keterangan
              </label>
              <input type="text" class="form-control text-capitalize" name="keterangan" id="keterangan" placeholder="Keterangan..">
            </div>
            <div class="form-group col-md-6">
              <label for="tanggal">
                Tanggal
              </label>
              <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?=date('Y-m-d')?>">
            </div>
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

<!-- modalDetailSangu -->
<div class="modal fade" id="modalDetailSangu" data-backdrop="static">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Detail Data</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12 col-md-12">
            <h5>Data Order</h5>
            <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thead>
                  <tr>
                    <th>No Order</th>
                    <th>Muatan</th>
                    <th>Customer</th>
                    <th>Kontak</th>
                    <th>Asal</th>
                    <th>Tujuan</th>
                    <th>Tanggal</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="text-uppercase">
                    <td class="noorder"></td>
                    <td class="muatan"></td>
                    <td class="cust"></td>
                    <td class="kontak"></td>
                    <td class="asal"></td>
                    <td class="tujuan"></td>
                    <td class="tgl"></td>
                  </tr>
                </tbody>
              </table>
            </div>

          </div>
          <div class="col-lg-12 col-md-12">
            <h5>Data Sangu</h5>
            <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thead>
                  <tr>
                    <th>No Order</th>
                    <th>Truck</th>
                    <th>Supir</th>
                    <th>Nominal</th>
                    <th>Tambahan</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="text-uppercase">
                    <td class="noorder"></td>
                    <td class="truck"></td>
                    <td class="supir"></td>
                    <td class="nominal"></td>
                    <td class="tambahan"></td>
                  </tr>
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>