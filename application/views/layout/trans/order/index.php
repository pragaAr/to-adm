<div class="content-wrapper">
  <section class="content-header">

    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?= $title ?></h1>
        </div>
        <div class="col-sm-6">
          <div class="breadcrumb float-sm-right">
            <button type="button" class="btn btn-dark border border-light" id="addOrder">
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
                <p class="font-italic">#Untuk Searching tanggal, gunakan format Year-month-day</p>
                <table id="orderTables" class="table table-bordered table-striped" width="100%" cellspacing="0">
                  <thead class="text-center">
                    <tr>
                      <th>No.</th>
                      <th>No Order</th>
                      <th>Sopir</th>
                      <th>Customer</th>
                      <th>Asal</th>
                      <th>Tujuan</th>
                      <th>Muatan</th>
                      <th>Status</th>
                      <th>Tgl</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody style="font-size:14px;">

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

<!-- modalAddOrder -->
<div class="modal fade" id="modalAddOrder" data-backdrop="static">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Order</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding-left: 2rem !important; padding-right: 2rem !important; font-size:14px;">

        <form id="form_addOrder">

          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="ordernumber">
                No Order
              </label>
              <input type="text" class="form-control text-uppercase" name="ordernumber" id="ordernumber" required readonly>
            </div>
            <div class="form-group col-md-4">
              <label for="custid">
                Customer
              </label>
              <div class="input-group">
                <select name="custid" id="custid" class="form-control select-cust" style="width:100%" required oninvalid="this.setCustomValidity('Customer wajib di isi!')" oninput="setCustomValidity('')">
                  <option value=""></option>
                </select>
                <div class="input-group-append">
                  <button type="button" class="btn btn-info border border-light" id="addNewCust">
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
              </div>
              <input type="hidden" class="form-control" name="namecust" id="namecust">
            </div>
            <div class="form-group col-md-4">
              <label for="notelp">
                No Telepon
              </label>
              <input type="text" class="form-control text-uppercase" name="notelp" id="notelp" placeholder="No Telepon.." autocomplete="off" required oninvalid="this.setCustomValidity('No Telepon Customer wajib di isi!')" oninput="setCustomValidity('')">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="muatan">
                Jenis Muatan
              </label>
              <input type="text" class="form-control text-uppercase" name="muatan" id="muatan" placeholder="Jenis Muatan.." autocomplete="off" required oninvalid="this.setCustomValidity('Jenis Muatan wajib di isi!')" oninput="setCustomValidity('')">
            </div>
            <div class="form-group col-md-4">
              <label for="asal">
                Asal Order
              </label>
              <input type="text" class="form-control text-uppercase" name="asal" id="asal" placeholder="Kota Asal.." autocomplete="off" required oninvalid="this.setCustomValidity('Kota Asal wajib di isi!')" oninput="setCustomValidity('')">
            </div>
            <div class="form-group col-md-4">
              <label for="tujuan">
                Tujuan Order
              </label>
              <input type="text" class="form-control text-uppercase" name="tujuan" id="tujuan" placeholder="Kota Tujuan.." autocomplete="off" required oninvalid="this.setCustomValidity('Kota Tujuan wajib di isi!')" oninput="setCustomValidity('')">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md">
              <label for="keterangan">
                Keterangan
              </label>
              <input type="text" class="form-control text-uppercase" name="keterangan" id="keterangan" placeholder="Keterangan.." autocomplete="off">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="plat">
                Truck
              </label>
              <select name="plat" id="plat" class="form-control text-uppercase select-truck" style="width: 100%;" required oninvalid="this.setCustomValidity('Plat Nomor wajib di isi!')" oninput="setCustomValidity('')">
                <option value=""></option>
              </select>
              <input type="hidden" class="form-control" name="platno" id="platno">
            </div>
            <div class="form-group col-md-4">
              <label for="sopir">
                Sopir
              </label>
              <select name="sopir" id="sopir" class="form-control text-uppercase select-sopir" style="width: 100%;" required oninvalid="this.setCustomValidity('Sopir wajib di isi!')" oninput="setCustomValidity('')">
                <option value=""></option>
              </select>
              <input type="hidden" class="form-control" name="namasopir" id="namasopir">
            </div>
            <div class="form-group col-md-4">
              <label for="nominal">
                Nominal Sangu
              </label>
              <input type="text" name="nominal" id="nominal" class="form-control" placeholder="Nominal Sangu.." autocomplete="off" required oninvalid="this.setCustomValidity('Nominal wajib di isi!')" oninput="setCustomValidity('')">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md">
              <button type="submit" class="btn btn-dark border border-light btn-block mt-2">
                Simpan
              </button>
            </div>
          </div>

        </form>

      </div>
    </div>
  </div>
</div>

<!-- modalUpdateOrder -->
<div class="modal fade" id="modalUpdateOrder" data-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Update Order</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding-left: 2rem !important; padding-right: 2rem !important; font-size:14px;">

        <form id="form_updateOrder">

          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="ordernumberedit">
                No Order
              </label>
              <input type="text" class="form-control text-uppercase" name="ordernumberedit" id="ordernumberedit" required readonly>
            </div>
            <div class="form-group col-md-4">
              <label for="custidedit">
                Customer
              </label>
              <select name="custidedit" id="custidedit" class="form-control select-custedit" style="width:100%" required oninvalid="this.setCustomValidity('Customer wajib di isi!')" oninput="setCustomValidity('')">
                <option value=""></option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="notelpedit">
                No Telepon
              </label>
              <input type="text" class="form-control text-uppercase" name="notelpedit" id="notelpedit" placeholder="No Telepon.." autocomplete="off" required oninvalid="this.setCustomValidity('No Telepon Customer wajib di isi!')" oninput="setCustomValidity('')">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="muatanedit">
                Jenis Muatan
              </label>
              <input type="text" class="form-control text-uppercase" name="muatanedit" id="muatanedit" placeholder="Jenis Muatan.." autocomplete="off" required oninvalid="this.setCustomValidity('Jenis Muatan wajib di isi!')" oninput="setCustomValidity('')">
            </div>
            <div class="form-group col-md-4">
              <label for="asaledit">
                Asal Order
              </label>
              <input type="text" class="form-control text-uppercase" name="asaledit" id="asaledit" placeholder="Kota Asal.." autocomplete="off" required oninvalid="this.setCustomValidity('Kota Asal wajib di isi!')" oninput="setCustomValidity('')">
            </div>
            <div class="form-group col-md-4">
              <label for="tujuanedit">
                Tujuan Order
              </label>
              <input type="text" class="form-control text-uppercase" name="tujuanedit" id="tujuanedit" placeholder="Kota Tujuan.." autocomplete="off" required oninvalid="this.setCustomValidity('Kota Tujuan wajib di isi!')" oninput="setCustomValidity('')">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md">
              <label for="keteranganedit">
                Keterangan
              </label>
              <input type="text" class="form-control text-uppercase" name="keteranganedit" id="keteranganedit" placeholder="Keterangan.." autocomplete="off">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="platedit">
                Truck
              </label>
              <select name="platedit" id="platedit" class="form-control text-uppercase select-truckedit" style="width: 100%;" required oninvalid="this.setCustomValidity('Plat Nomor wajib di isi!')" oninput="setCustomValidity('')">
                <option value=""></option>
              </select>
              <input type="hidden" class="form-control" name="oldtruckid" id="oldtruckid">
            </div>
            <div class="form-group col-md-4">
              <label for="sopiredit">
                Sopir
              </label>
              <select name="sopiredit" id="sopiredit" class="form-control text-uppercase select-sopiredit" style="width: 100%;" required oninvalid="this.setCustomValidity('Sopir wajib di isi!')" oninput="setCustomValidity('')">
                <option value=""></option>
              </select>
              <input type="hidden" class="form-control" name="oldsopirid" id="oldsopirid">
            </div>
            <div class="form-group col-md-4">
              <label for="nominaledit">
                Nominal
              </label>
              <input type="text" name="nominaledit" id="nominaledit" class="form-control" placeholder="Nominal.." autocomplete="off" required oninvalid="this.setCustomValidity('Nominal wajib di isi!')" oninput="setCustomValidity('')">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md">
              <button type="submit" class="btn btn-dark border border-light btn-block">
                Simpan Perubahan
              </button>
            </div>
          </div>

        </form>

      </div>
    </div>
  </div>
</div>

<!-- modalDetailOrder -->
<div class="modal fade" id="modalDetailOrder" data-backdrop="static">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Detail Data</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="font-size:14px;">
        <form id="form_detail" method="post">
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
                  <tfoot id="tfoot_detailOrder">
                    <tr>
                      <th colspan="2">Keterangan</th>
                      <td colspan="5" class="keterangan"></td>
                    </tr>
                  </tfoot>
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
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="text-uppercase">
                      <td class="noorder"></td>
                      <td class="truck"></td>
                      <td class="supir"></td>
                      <td class="nominal"></td>
                    </tr>
                  </tbody>
                </table>
              </div>

            </div>
          </div>
          <div class="row">
            <div class="col-lg-12 col-md-12">
              <a href="" type="button" target="_blank" id="btnDetail" class="btn btn-primary border border-light float-right">
                <i class="fas fa-print"></i>
                Cetak
              </a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- modalAddNewCust -->
<div class="modal fade" id="modalAddNewCust" data-backdrop="static" style="z-index: 1060;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Data Customer</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="font-size:14px;">
        <form id="form_add">
          <div class="form-group">
            <label for="namacust">
              Nama Customer
            </label>
            <input type="text" class="form-control text-uppercase" name="namacust" id="namacust" placeholder="Nama Customer.." required autofocus autocomplete="off">
          </div>
          <div class="form-group">
            <label for="kodecust">
              Kode Customer
            </label>
            <input type="text" class="form-control text-uppercase" name="kodecust" id="kodecust" placeholder="Kode Customer.." required autocomplete="off">
          </div>
          <div class="form-group">
            <label for="notelpcust">
              No Telepon
            </label>
            <input type="text" class="form-control text-uppercase" name="notelpcust" id="notelpcust" placeholder="No Telepon.." required autocomplete="off">
          </div>
          <div class="form-group">
            <label for="alamatcust">
              Alamat
            </label>
            <input type="text" class="form-control text-uppercase" name="alamatcust" id="alamatcust" placeholder="Alamat.." required autocomplete="off">
          </div>
          <div>
            <button type="submit" id="btn_submitNewCust" class="btn btn-dark border border-light float-right">
              Simpan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>