<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-lg-12 d-flex justify-content-between align-items-center flex-wrap">
          <h1><?= $title ?></h1>

          <div class="mb-1">
            <button type="button" class="btn btn-dark border border-light" id="addPenjualan">
              <i class="fas fa-plus"></i>
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
              <div class="table-responsive mb-2">
                <p class="font-italic">#Untuk Searching tanggal, gunakan format Year-month-day</p>
                <table id="salesTables" class="table table-bordered table-striped" style="width:100%" cellspacing="0">
                  <thead class="text-center">
                    <tr>
                      <th>No.</th>
                      <th>Reccu</th>
                      <th>No Order</th>
                      <th>Jenis</th>
                      <th>Pengirim</th>
                      <th>Muatan</th>
                      <th>Total</th>
                      <th>Tgl Order</th>
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

<!-- modalAddPenjualan -->
<div class="modal fade" id="modalAddPenjualan" data-backdrop="static">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Penjualan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding:1rem 2rem; font-size:14px;">
      <form id="form_add">
          <div class="form-row">
            <div class="form-group col-lg-3 col-md-6">
              <label for="reccu">
                Reccu
              </label>
              <input type="text" class="form-control text-uppercase" name="reccu" id="reccu" placeholder="Reccu.." readonly>
            </div>
            <div class="form-group col-lg-3 col-md-6">
              <label for="noorder">
                No Order
              </label>
              <select name="noorder" id="noorder" class="form-control select-noorder" style="width:100%" required>
                <option value=""></option>

              </select>
              <input type="hidden" class="form-control" name="textnoorder" id="textnoorder" readonly>
            </div>
            <div class="form-group col-lg-3 col-md-6">
              <label for="tglorder">
                Tanggal Order
              </label>
              <input type="date" class="form-control text-uppercase" name="tglorder" id="tglorder" readonly>
            </div>
            <div class="form-group col-lg-3 col-md-6">
              <label for="tglreccu">
                Tanggal Reccu
              </label>
              <input type="date" class="form-control text-uppercase" name="tglreccu" id="tglreccu">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-lg-3 col-md-6">
              <label for="pengirim">
                Customer
              </label>
              <input type="text" class="form-control text-uppercase" name="pengirim" id="pengirim" placeholder="Nama Pengirim.." readonly>
            </div>
            <div class="form-group col-lg-3 col-md-6">
              <label for="muatan">
                Muatan
              </label>
              <input type="text" class="form-control text-uppercase" name="muatan" id="muatan" placeholder="Muatan.." readonly>
            </div>
            <div class="form-group col-lg-3 col-md-6">
              <label for="asal">
                Asal
              </label>
              <input type="text" class="form-control text-uppercase" name="asal" id="asal" placeholder="Asal.." readonly>
            </div>
            <div class="form-group col-lg-3 col-md-6">
              <label for="tujuan">
                Tujuan
              </label>
              <input type="text" class="form-control text-uppercase" name="tujuan" id="tujuan" placeholder="Tujuan.." readonly>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-lg-4">
              <label for="penerima">
                Penerima
              </label>
              <input name="penerima" id="penerima" class="form-control text-uppercase" placeholder="Nama Penerima.." required autocomplete="off" oninvalid="this.setCustomValidity('Nama Penerima wajib di isi!')" oninput="setCustomValidity('')">
            </div>
            <div class="form-group col-lg-4">
              <label for="alamatasal">
                Alamat Asal
              </label>
              <input type="text" class="form-control text-uppercase" name="alamatasal" id="alamatasal" maxlength="60" placeholder="Alamat Asal.." required autocomplete="off">
            </div>
            <div class="form-group col-lg-4">
              <label for="alamattujuan">
                Alamat Tujuan
              </label>
              <input type="text" class="form-control text-uppercase" name="alamattujuan" id="alamattujuan" maxlength="60" placeholder="Alamat Tujuan.." required autocomplete="off">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="jenis">
                Jenis
              </label>
              <select name="jenis" id="jenis" class="form-control text-uppercase select-jenis" style="width:100%" required>
                <option value=""></option>
                <option value="borong">BORONGAN</option>
                <option value="tonase">TONASE</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="pembayaran">
                Pembayaran
              </label>
              <select name="pembayaran" id="pembayaran" class="form-control text-uppercase select-pembayaran" style="width:100%" required>
                <option value=""></option>
                <option value="lunas">LUNAS</option>
                <option value="tempo">TEMPO</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="berat">
                Berat
              </label>
              <input type="text" class="form-control text-uppercase" name="berat" id="berat" placeholder="Berat dalam Kilo.." autocomplete="off">
            </div>
            <div class="form-group col-md-4" id="harga-tonase">
              <label for="tonase">
                Harga Tonase
              </label>
              <input name="tonase" id="tonase" class="form-control text-uppercase" placeholder="Harga Tonase.." autocomplete="off">
            </div>
            <div class="form-group col-md-4" id="harga-borong">
              <label for="borong">
                Harga Borong
              </label>
              <input name="borong" id="borong" class="form-control text-uppercase" placeholder="Harga Borong.." autocomplete="off">
            </div>
            <div class="form-group col-md-12" id="total-harga">
              <label for="biaya">
                Total Harga
              </label>
              <input name="biaya" id="biaya" class="form-control text-uppercase" placeholder="Total Harga.." readonly>
            </div>

            <div class="form-group col-md-12">
              <button type="submit" class="btn btn-dark btn-block border border-light">
                Simpan
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- modalUpdatePenjualan -->
<div class="modal fade" id="modalUpdatePenjualan" data-backdrop="static">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Update Penjualan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding:1rem 2rem; font-size:14px;">
      <form id="form_update">
          <div class="form-row">
            <div class="form-group col-lg-3 col-md-6">
              <label for="reccuedit">
                Reccu
              </label>
              <input type="text" class="form-control text-uppercase" name="reccuedit" id="reccuedit" placeholder="Reccu.." readonly>
              <input type="hidden" class="form-control" name="penjualanid" id="penjualanid" readonly>
            </div>
            <div class="form-group col-lg-3 col-md-6">
              <label for="noorderedit">
                No Order
              </label>
              <input type="text" class="form-control text-uppercase" name="noorderedit" id="noorderedit" placeholder="No Order.." readonly>
            </div>
            <div class="form-group col-lg-3 col-md-6">
              <label for="tglorderedit">
                Tanggal Order
              </label>
              <input type="date" class="form-control text-uppercase" name="tglorderedit" id="tglorderedit" readonly>
            </div>
            <div class="form-group col-lg-3 col-md-6">
              <label for="tglreccuedit">
                Tanggal Reccu
              </label>
              <input type="date" class="form-control text-uppercase" name="tglreccuedit" id="tglreccuedit">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-lg-3 col-md-6">
              <label for="pengirimedit">
                Customer
              </label>
              <input type="text" class="form-control text-uppercase" name="pengirimedit" id="pengirimedit" placeholder="Nama Pengirim.." readonly>
            </div>
            <div class="form-group col-lg-3 col-md-6">
              <label for="asaledit">
                Asal
              </label>
              <input type="text" class="form-control text-uppercase" name="asaledit" id="asaledit" placeholder="Asal.." readonly>
            </div>
            <div class="form-group col-lg-3 col-md-6">
              <label for="tujuanedit">
                Tujuan
              </label>
              <input type="text" class="form-control text-uppercase" name="tujuanedit" id="tujuanedit" placeholder="Tujuan.." readonly>
            </div>
            <div class="form-group col-lg-3 col-md-6">
              <label for="muatanedit">
                Muatan
              </label>
              <input type="text" class="form-control text-uppercase" name="muatanedit" id="muatanedit" placeholder="Muatan.." readonly>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-lg-4">
              <label for="penerimaedit">
                Penerima
              </label>
              <input name="penerimaedit" id="penerimaedit" class="form-control text-uppercase" placeholder="Nama Penerima.." required autocomplete="off" oninvalid="this.setCustomValidity('Nama Penerima wajib di isi!')" oninput="setCustomValidity('')">
            </div>
            <div class="form-group col-lg-4">
              <label for="alamatasaledit">
                Alamat Asal
              </label>
              <input type="text" class="form-control text-uppercase" name="alamatasaledit" id="alamatasaledit" maxlength="60" placeholder="Alamat Asal.." required autocomplete="off">
            </div>
            <div class="form-group col-lg-4">
              <label for="alamattujuanedit">
                Alamat Tujuan
              </label>
              <input type="text" class="form-control text-uppercase" name="alamattujuanedit" id="alamattujuanedit" maxlength="60" placeholder="Alamat Tujuan.." required autocomplete="off">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="jenisedit">
                Jenis Penjualan
              </label>
              <select name="jenisedit" id="jenisedit" class="form-control text-uppercase select-jenisedit" style="width:100%" required>
                <option value=""></option>
                <option value="borong">BORONG</option>
                <option value="tonase">TONASE</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="pembayaranedit">
                Pembayaran
              </label>
              <select name="pembayaranedit" id="pembayaranedit" class="form-control text-uppercase select-pembayaranedit" style="width:100%" required>
                <option value=""></option>
                <option value="lunas">LUNAS</option>
                <option value="tempo">TEMPO</option>
              </select>
              <input type="hidden" class="form-control" name="datepelunasan" id="datepelunasan">
              <input type="hidden" class="form-control" name="oldpayment" id="oldpayment">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="beratedit">
                Berat
              </label>
              <input type="text" class="form-control text-uppercase" name="beratedit" id="beratedit" placeholder="Berat dalam Kilo.." autocomplete="off">
            </div>
            <div class="form-group col-md-4" id="harga-tonaseedit">
              <label for="tonaseedit">
                Harga Tonase
              </label>
              <input name="tonaseedit" id="tonaseedit" class="form-control text-uppercase" placeholder="Harga Tonase.." autocomplete="off">
            </div>
            <div class="form-group col-md-4" id="harga-borongedit">
              <label for="borongedit">
                Harga Borong
              </label>
              <input name="borongedit" id="borongedit" class="form-control text-uppercase" placeholder="Harga Borong.." autocomplete="off">
            </div>
            <div class="form-group col-md-12" id="total-hargaedit">
              <label for="biayaedit">
                Total Harga
              </label>
              <input name="biayaedit" id="biayaedit" class="form-control text-uppercase" placeholder="Total Harga.." readonly>
            </div>
            <div class="form-group col-md-12">
              <button type="submit" class="btn btn-dark btn-block border border-light">
                Simpan
              </button>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

<!-- modalDetailPenjualan -->
<div class="modal fade" id="modalDetailPenjualan" data-backdrop="static">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Detail Penjualan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding:1rem 2rem; font-size:14px;">
        <div class="table-responsive mb-2">
          <h5 class="font-weight-bold">Data Order</h5>
          <div class="dropdown-divider"></div>
          <table class="table table-bordered my-3" id="tableDetailOrder" style="width:100%" cellspacing="0">
            <thead class="text-center">
              <tr>
                <th class="align-middle">Tanggal Order</th>
                <th class="align-middle">No Order</th>
                <th class="align-middle">Muatan</th>
                <th class="align-middle">Customer Order</th>
                <th class="align-middle">Asal</th>
                <th class="align-middle">Tujuan</th>
              </tr>
            </thead>
            <tbody class="text-center" id="tbodyDetailOrder">
              <tr>
                <td class="align-middle text-uppercase" id="dtTanggal"></td>
                <td class="align-middle text-uppercase" id="dtNoOrder"></td>
                <td class="align-middle text-uppercase" id="dtMuatan"></td>
                <td class="align-middle text-uppercase" id="dtCustOrder"></td>
                <td class="align-middle text-uppercase" id="dtAsal"></td>
                <td class="align-middle text-uppercase" id="dtTujuan"></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="table-responsive mb-2">

          <h5 class="font-weight-bold">Data Penjualan</h5>
          <div class="dropdown-divider"></div>

          <table class="table table-bordered my-3" id="tableDetailPenjualan" style="width:100%" cellspacing="0">
            <thead class="text-center">
              <tr>
                <th class="align-middle" colspan="2">Reccu</th>
                <th class="align-middle text-uppercase" colspan="2" id="dtReccu"></th>
                <th class="align-middle" colspan="2">Tanggal Reccu</th>
                <th class="align-middle text-uppercase" colspan="2" id="dtTglReccu"></th>
              </tr>
              <tr>
                <th class="align-middle">Jenis Penjualan</th>
                <th class="align-middle">Berat</th>
                <th class="align-middle">Harga/Kg</th>
                <th class="align-middle">Harga Borong</th>
                <th class="align-middle">Alamat Asal</th>
                <th class="align-middle">Alamat Tujuan</th>
                <th class="align-middle">Penerima</th>
                <th class="align-middle">Total Harga</th>
              </tr>
            </thead>
            <tbody class="text-center" id="tbodyDetailPenjualan">
              <tr>
                <td class="align-middle text-uppercase" id="dtJenis"></td>
                <td class="align-middle" id="dtBerat"></td>
                <td class="align-middle" id="dtHrgKg"></td>
                <td class="align-middle" id="dtHrgBorong"></td>
                <td class="align-middle text-uppercase" id="dtAlamatAsal"></td>
                <td class="align-middle text-uppercase" id="dtAlamatTujuan"></td>
                <td class="align-middle text-uppercase" id="dtPenerima"></td>
                <td class="align-middle" id="dtBiaya"></td>
              </tr>
              <tr>
                <th colspan="4" class="align-middle text-uppercase">Status Pembayaran</th>
                <th colspan="5" class="align-middle text-uppercase" id="dtStatusBayar"></th>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>