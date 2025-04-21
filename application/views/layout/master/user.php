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
                <table id="userTables" class="table table-bordered table-striped" width="100%" cellspacing="0">
                  <thead class="text-center">
                    <tr>
                      <th>No.</th>
                      <th>Nama</th>
                      <th>Username</th>
                      <th>Role</th>
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
        <h4 class="modal-title">Tambah Data User</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="font-size:14px;">
        <form id="form_add">
          <div class="form-group">
            <label for="nama">
              Nama User
            </label>
            <input type="text" class="form-control text-capitalize" name="nama" id="nama" placeholder="Nama User.." autofocus autocomplete="off" required oninvalid="this.setCustomValidity('Nama User wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="username">
              Username
            </label>
            <input type="text" class="form-control" name="username" id="username" placeholder="Username.." autocomplete="off" required oninvalid="this.setCustomValidity('Username wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="pass">
              Password
            </label>
            <input type="password" class="form-control" name="pass" id="pass" placeholder="Password.." autocomplete="off" required oninvalid="this.setCustomValidity('Password wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="role">
              Role
            </label>
            <input type="text" class="form-control text-capitalize" name="role" id="role" placeholder="Role.." autocomplete="off" required oninvalid="this.setCustomValidity('Role wajib di isi!')" oninput="setCustomValidity('')">
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
        <h4 class="modal-title">Edit Data User</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="font-size:14px;">
        <form id="form_edit">
          <div class="form-group">
            <label for="namaedit">
              Nama User
            </label>
            <input type="hidden" class="form-control" name="id" id="id" readonly>
            <input type="text" class="form-control text-capitalize" name="namaedit" id="namaedit" placeholder="Nama User.." autofocus autocomplete="off" required oninvalid="this.setCustomValidity('Nama User wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="usernameedit">
              Username
            </label>
            <input type="text" class="form-control" name="usernameedit" id="usernameedit" placeholder="Username.." autocomplete="off" required oninvalid="this.setCustomValidity('Username wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="passedit">
              Password
            </label>
            <input type="password" class="form-control" name="passedit" id="passedit" placeholder="Password.." autocomplete="off">
          </div>
          <div class="form-group">
            <label for="roleedit">
              Role
            </label>
            <input type="text" class="form-control text-capitalize" name="roleedit" id="roleedit" placeholder="Role.." autocomplete="off" required oninvalid="this.setCustomValidity('Role wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div>
            <button type="submit" class="btn btn-dark float-right">
              Simpan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>