    <div class="content-wrapper">
      <div class="userlogin" data-flashdata="<?= $this->session->flashdata('userlogin'); ?>"></div>
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0"><?= $title ?></h1>
            </div>

          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">

          <div class="row">
            <div class="col-12 col-sm-6 col-md-4">
              <div class="info-box">
                <span class="info-box-icon bg-secondary elevation-1">
                  <i class="fas fa-shopping-cart"></i>
                </span>

                <div class="info-box-content">
                  <span class="info-box-text">Total Order</span>
                  <span class="info-box-number">
                    <?= $totalOrder ?>
                    <small> Order</small>
                  </span>
                </div>
              </div>
            </div>

            <div class="clearfix hidden-md-up"></div>

            <div class="col-12 col-sm-6 col-md-4">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1">
                  <i class="fas fa-shopping-cart"></i>
                </span>

                <div class="info-box-content">
                  <span class="info-box-text">Order Diproses</span>
                  <span class="info-box-number">
                    <?= $orderProses ?>
                    <small> Order</small>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1">
                  <i class="fas fa-shopping-cart"></i>
                </span>

                <div class="info-box-content">
                  <span class="info-box-text">Order Selesai</span>
                  <span class="info-box-number">
                    <?= $orderSuccess ?>
                    <small> Order</small>
                  </span>
                </div>
              </div>
            </div>

          </div>

      </section>
    </div>