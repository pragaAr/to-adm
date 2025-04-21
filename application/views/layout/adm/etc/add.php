<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?= $title ?></h1>
        </div>
        <div class="col-sm-6">
          <div class="breadcrumb float-sm-right">
            <a href="<?= base_url('pengeluaran_lain') ?>" class="btn btn-dark border border-light">
              <i class=" fas fa-arrow-left"></i>
              Kembali
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
            <div class="card-body" style="font-size:14px;">

              <form id="formSubmit">
                <div class="form-row">
                  <div class="form-group col-lg-4 col-md-4 col-sm-12">
                    <label for="kode">Kode</label>
                    <input type="text" name="kode" id="kode" class="form-control text-uppercase" placeholder="Kode.." readonly>
                  </div>

                  <div class="form-group col-lg-4 col-md-4 col-sm-12">
                    <label for="karyawan">Karyawan</label>
                    <select name="karyawan" id="karyawan" class="form-control select-kry" style="width:100%" required>
                      <option value=""></option>

                    </select>
                    <input type="hidden" name="selectedKry" id="selectedKry" class="form-control" required readonly>
                  </div>

                  <div class="form-group col-lg-4 col-md-4 col-sm-12">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control text-uppercase" required>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-lg-3 col-md-4 col-sm-12">
                    <label for="keperluan">Keperluan</label>
                    <input type="text" name="keperluan" id="keperluan" class="form-control text-uppercase" placeholder="Keperluan.." autocomplete="off">
                  </div>

                  <div class="form-group col-lg-3 col-md-4 col-sm-12">
                    <label for="item">Jumlah Item</label>
                    <input type="text" name="item" id="item" class="form-control text-uppercase" placeholder="Jumlah Item.." autocomplete="off">
                  </div>

                  <div class="form-group col-lg-3 col-md-4 col-sm-12">
                    <label for="nominal">Nominal</label>
                    <input type="text" name="nominal" id="nominal" class="form-control text-uppercase" placeholder="Nominal.." autocomplete="off">
                  </div>

                  <div class="form-group col-lg-3 col-md col-sm-12 d-flex align-items-end">
                    <button type="button" class="btn btn-primary border border-light btn-block mt-4" id="tambah" style="height:calc(1.5em + 0.75rem + 2px);">
                      <i class="fa fa-plus"></i>
                      Tambah
                    </button>
                  </div>
                </div>

                <hr style="border: 1px solid #6c757d;">

                <h5 class="mb-3">List Detail Pengeluaran</h5>
                <div class="table-responsive">
                  <table class="table table-bordered" id="cart" width="100%" cellspacing="0">
                    <thead class="text-center">
                      <tr>
                        <td>
                          <strong>Keperluan</strong>
                        </td>
                        <td>
                          <strong>Jumlah Item</strong>
                        </td>
                        <td>
                          <strong>Nominal</strong>
                        </td>
                        <td>
                          <strong>Aksi</strong>
                        </td>
                      </tr>
                    </thead>
                    <tbody id="tbody">
                    </tbody>
                    <tfoot id="tfoot">
                      <tr>
                        <td colspan="2" class="align-middle text-center text-uppercase">Jumlah</td>
                        <td class="align-middle text-right pr-4">
                          <h4 class="font-weight-bold m-0 p-0" id="total"></h4>
                        </td>
                        <td class="align-middle text-center">
                          <input type="hidden" name="total_hidden" id="total_hidden" value="">
                          <button type="submit" class="btn btn-dark border border-light btn-block">
                            Simpan
                          </button>
                        </td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>