<!-- <body class="hold-transition login-page" style="background-color:#343a40"> -->

<body class="hold-transition login-page" style="background-color:#454d55">
  <div class="userlogin" data-flashdata="<?= $this->session->flashdata('userlogin'); ?>"></div>
  <div class="flashrole" data-flashdata="<?= $this->session->flashdata('flashrole'); ?>"></div>
  <div class="userlogout" data-flashdata="<?= $this->session->flashdata('userlogout'); ?>"></div>
  <div class="wrongdata" data-flashdata="<?= $this->session->flashdata('wrongdata'); ?>"></div>
  <div class="registered" data-flashdata="<?= $this->session->flashdata('registered'); ?>"></div>
  <div class="login-box">
    <div class="login-logo">
      <img src="<?= base_url('assets/dist/img/logo-white.png') ?>" alt="Logo Hira" width="125" height="70">
    </div>
    <div class="card">
      <div class="card-body login-card-body" style="border-radius:10px;">
        <p class="login-box-msg">--Silahkan masuk dahulu--</p>

        <form action="<?= base_url('auth') ?>" method="post">
          <div class="form-group">
            <label for="username">
              Username
            </label>
            <div class="input-group mb-3">
              <input type="text" class="form-control" name="username" id="username" placeholder="Username Anda.." autocomplete="off" autofocus required oninvalid="this.setCustomValidity('Username wajib di isi!')" oninput="setCustomValidity('')">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-id-card"></span>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="pass">
              Password
            </label>
            <div class="input-group mb-3">
              <input type="password" class="form-control" name="pass" id="pass" placeholder="Password Anda.." autocomplete="off" required oninvalid="this.setCustomValidity('Password wajib di isi!')" oninput="setCustomValidity('')">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
          </div>
          <div class="mt-4">
            <button type="submit" class="btn btn-dark btn-block">Masuk</button>
          </div>
        </form>
        <div class="mt-4 text-center">
          <p>
            <strong>
              <a class="text-dark" href="https://hira-express.com" target="_blank">Hira Express</a>
              Made With 💖
            </strong>
          </p>
        </div>
      </div>
    </div>
  </div>