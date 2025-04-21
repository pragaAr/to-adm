<div class="content-wrapper">
  <div class="inserted" data-flashdata="<?= $this->session->flashdata('inserted'); ?>"></div>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?= $title ?></h1>
        </div>
        <div class="col-sm-6">
          <div class="breadcrumb float-sm-right">
            <a href="<?= base_url('persensopir') ?>" class="btn btn-dark border border-light">
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
                  <div class="form-group col-md-6">
                    <label for="kd">Kd Persen</label>
                    <input type="text" name="kd" id="kd" class="form-control text-uppercase" required readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="tgl">Tanggal</label>
                    <input type="text" name="tgl" id="tgl" class="form-control text-capitalize" value="<?= date('d-m-Y') ?>" readonly>
                  </div>
                </div>

                <h6 class="font-weight-bold">Data Order Penjualan</h6>
                <hr class="bg-secondary">

                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="sopirid">Nama Sopir</label>
                    <select name="sopirid" id="sopirid" class="form-control select-sopir" style="width:100%;" required>
                      <option value=""></option>
                    </select>
                    <input type="hidden" name="namasopir" id="namasopir" class="form-control text-capitalize" readonly>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="noorder">No Order</label>
                    <select name="noorder" id="noorder" class="form-control select-noorder" style="width:100%;">
                      <option value=""></option>

                    </select>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="platno">Plat No</label>
                    <input type="text" name="platno" id="platno" class="form-control text-uppercase" placeholder="Plat No..." readonly>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="pengirim">Pengirim</label>
                    <input type="text" name="pengirim" id="pengirim" class="form-control text-capitalize" placeholder="Pengirim..." readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="penerima">Penerima</label>
                    <input type="text" name="penerima" id="penerima" class="form-control text-capitalize" placeholder="Penerima..." readonly>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="muatan">Muatan</label>
                    <input type="text" name="muatan" id="muatan" class="form-control text-capitalize" placeholder="Muatan..." readonly>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="asaltujuan">Asal-Tujuan</label>
                    <input type="text" name="asaltujuan" id="asaltujuan" class="form-control text-capitalize" placeholder="Asal-Tujuan..." readonly>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="totharga">Total Biaya</label>
                    <input type="text" name="totharga" id="totharga" class="form-control" placeholder="Total Biaya..." value="0" readonly>
                  </div>
                </div>

                <h6 class="font-weight-bold">Data Sangu</h6>
                <hr class="bg-secondary">

                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="sangu">Sangu</label>
                    <input type="text" name="sangu" id="sangu" class="form-control" placeholder="Sangu..." value="0" readonly>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="tambahan">Tambahan</label>
                    <input type="text" name="tambahan" id="tambahan" class="form-control" placeholder="Tambahan..." value="0" readonly>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="totsangu">Total Sangu</label>
                    <input type="text" name="totsangu" id="totsangu" class="form-control" placeholder="Total Sangu..." value="0" readonly>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="persen1">Persen 1</label>
                    <input type="text" name="persen1" id="persen1" class="form-control" maxlength="2" placeholder="Persen 1..." value="0">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="persen2">Persen 2</label>
                    <input type="text" name="persen2" id="persen2" class="form-control" maxlength="2" placeholder="Persen 2..." value="0">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="biayaxpersen">Biaya X Persen</label>
                    <input type="text" name="biayaxpersen" id="biayaxpersen" class="form-control" placeholder="Jumlah Diterima..." value="0" readonly>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md">
                    <button type="button" class="btn btn-primary border border-light btn-block mt-1" id="tambah" disabled>
                      <i class="fa fa-plus"></i>
                      Tambah
                    </button>
                  </div>
                </div>

                <h6 class="font-weight-bold">List Persen Sopir</h6>
                <hr class="bg-secondary">

                <div class="table-responsive mt-4">
                  <table class="table table-bordered" id="cart" width="100%" cellspacing="0">
                    <thead class="text-center">
                      <tr>
                        <td class="align-middle">
                          <strong>No Order</strong>
                        </td>
                        <td class="align-middle">
                          <strong>Jml Biaya</strong>
                        </td>
                        <td class="align-middle" style="width:7%">
                          <strong>% 1</strong>
                        </td>
                        <td class="align-middle" style="width:7%">
                          <strong>% 2</strong>
                        </td>
                        <td class="align-middle">
                          <strong>Jml Sangu</strong>
                        </td>
                        <td class="align-middle">
                          <strong>(Jml Biaya X %1 X %2) - Jml Sangu</strong>
                        </td>
                        <td class="align-middle">
                          <strong>Aksi</strong>
                        </td>
                      </tr>
                    </thead>
                    <tbody id="tbody">
                    </tbody>
                    <tfoot id="tfoot">
                      <tr>
                        <td colspan="2" class="align-middle text-center pr-4">
                          <h4 class="font-weight-bold">Diterima</h4>
                        </td>
                        <td colspan="4" class="align-middle text-right pr-4">
                          <h4 class="font-weight-bold m-0 p-0" id="total"></h4>
                        </td>
                        <td class="align-middle text-center">
                          <input type="hidden" name="total_hidden" id="total_hidden" value="">
                          <button type="submit" class="btn btn-dark btn-sm border border-light">
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