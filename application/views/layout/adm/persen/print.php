<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?></title>

  <style>
    body {
      color: #1d1d1d;
    }

    p {
      font-size: 12px;
      margin: 0;
    }

    .container {
      margin: 0 10px;
    }

    .logo {
      width: 15%;
      float: left;
    }

    img {
      width: 100%;
    }

    .identity {
      padding-left: 250px;
      text-decoration: underline;
    }

    .title-name {
      padding-top: 20px;
      font-size: 22px;
    }

    .clear {
      clear: both;
    }

    hr {
      border: none;
      height: 1.5px;
      color: #000;
      background-color: #000;
      margin: 2px 0;
    }

    .text-capitalize {
      text-transform: capitalize;
    }

    .text-uppercase {
      text-transform: uppercase;
    }

    .underline {
      text-decoration: underline;
    }

    .text-right {
      text-align: right;
    }

    .text-center {
      text-align: center;
    }

    .text-right {
      text-align: right;
    }

    .end {
      margin-top: 25px;
      padding-right: 10px;
      text-align: right;
    }

    .font-bold {
      font-weight: bold;
    }

    .mt-1 {
      margin-top: 5px;
    }

    .mt-2 {
      margin-top: 10px;
    }

    .title-table {
      font-size: 12px;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .table-head {
      width: 100%;
      border: none;
    }

    .th-head {
      font-size: 12px;
      padding: 3px;
    }

    .td-head {
      font-size: 12px;
      padding: 3px;
    }

    .table-order {
      width: 100%;
      border: 0.8px solid #000;
      border-collapse: collapse;
    }

    .th-order,
    .td-order {
      border: 0.8px solid #000;
      font-size: 12px;
      text-align: center;
      padding: 10px 5px;
    }

    .table-sangu {
      width: 100%;
      border: 0.8px solid #000;
      border-collapse: collapse;
    }

    .th-sangu,
    .td-sangu {
      border: 0.8px solid #000;
      font-size: 12px;
      text-align: center;
      padding: 10px 5px;
    }

    .table-persen {
      width: 100%;
      border: none;
    }

    .td-persen {
      font-size: 12px;
      padding: 10px 5px;
    }

    .pb-avoid {
      page-break-inside: avoid;
    }

    .page-number-footer {
      text-align: right;
      font-style: italic;
      font-size: 11px;
    }
  </style>
</head>

<body>

  <div class="container">
    <div class="logo">
      <img src="<?= base_url('assets/dist/img/logo-red.png') ?>">
    </div>

    <div class="identity">
      <h3 class="title-name">
        <?= strtoupper($title) ?>
      </h3>
    </div>

    <div class="clear"></div>

    <hr>

    <div class="mt-1">
      <div class="text-uppercase font-bold" style="width:100%; text-align:right">
        <p>Nama Sopir : <?= $sopir->nama ?></p>
      </div>
    </div>

    <div class="mt-1">
      <p class="title-table">Order Penjualan</p>
      <table class="table-order">
        <thead>
          <tr>
            <th class="th-order">No.</th>
            <th class="th-order">Customer</th>
            <th class="th-order">Tanggal</th>
            <th class="th-order">Plat <br> Nomor</th>
            <th class="th-order" style="width:10%">Tonase</th>
            <th class="th-order" style="width:13%">Harga Kg</th>
            <th class="th-order" style="width:15%">Biaya</th>
            <th class="th-order" style="width:6%">%</th>
            <th class="th-order" style="width:6%">%</th>
            <th class="th-order" style="width:15%">Total</th>
          </tr>
        </thead>
        <tbody>

          <?php 
          $no = 1;
          $jmlTotalBiayaOrder = 0;
          $jmlTotalSangu = 0;

          foreach ($order as $order) : 
            $biaya = floatval($order->tot_biaya);
            $ps1 = floatval($order->persen1);
            $ps2 = floatval($order->persen2);
            $penyebut = 100; // Tidak perlu floatval karena 100 sudah float

            $totBiayaOrder = $biaya; // Default jika kedua persen adalah 0

            if ($ps1 != 0) {
              $totBiayaOrder *= ($ps1 / $penyebut);
            }
            if ($ps2 != 0) {
              $totBiayaOrder *= ($ps2 / $penyebut);
            }

            $jmlTotalBiayaOrder += $totBiayaOrder;
            $upJmlTotalBiayaOrder = ceil($jmlTotalBiayaOrder)
          ?>

            <tr>
              <td class="td-order"><?= $no++; ?>.</td>
              <td class="td-order text-uppercase"><?= $order->nama ?></td>
              <td class="td-order"><?= date('d/m/y', strtotime($order->tglReccu)) ?></td>
              <td class="td-order text-uppercase"><?= $order->platno ?></td>
              <td class="td-order text-right"><?= number_format($order->berat) ?> Kg</td>
              <td class="td-order text-right">Rp. <?= number_format($order->hrg_kg) ?></td>
              <td class="td-order text-right">Rp. <?= number_format($order->tot_biaya) ?></td>
              <td class="td-order"><?= $order->persen1 ?>%</td>
              <td class="td-order"><?= $order->persen2 ?>%</td>

              <td class="td-order text-right">Rp. <?= number_format(ceil($totBiayaOrder)) ?></td>
            </tr>

          <?php endforeach ?>

          <tr>
            <td class="td-order text-uppercase font-bold" colspan="9">jumlah</td>
            <td class="td-order text-right">Rp. <?= number_format($upJmlTotalBiayaOrder) ?></td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="mt-2 pb-avoid">
      <p class="title-table">Sangu</p>
      <table class="table-sangu">
        <thead>
          <tr>
            <th class="th-sangu" style="width:6%">No.</th>
            <th class="th-sangu" style="width:22%">Terima <br> Sangu</th>
            <th class="th-sangu" style="width:20%">Tanggal</th>
            <th class="th-sangu" style="width:18%">Nominal</th>
            <th class="th-sangu" style="width:16%">Tambahan</th>
            <th class="th-sangu" style="width:18%">Total</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $no = 1;

          foreach ($sangu as $sangu) : 
            $a = floatval($sangu->nominal_sangu);
            $b = $sangu->tambahan != '' ? floatval($sangu->tambahan) : 0;

            $c = $a + $b;
          ?>
          
            <tr>
              <td class="td-sangu"><?= $no++ ?>.</td>
              <td class="td-sangu text-uppercase"><?= $sangu->nama ?></td>
              <td class="td-sangu"><?= date('d/m/y', strtotime($sangu->tglSangu)) ?></td>
              <td class="td-sangu text-right">Rp. <?= number_format($sangu->nominal_sangu) ?></td>
              <td class="td-sangu text-right">Rp. <?= $sangu->tambahan != '' ? number_format($sangu->tambahan) : 0 ?></td>
              <td class="td-sangu text-right">Rp. <?= number_format($c) ?></td>
            </tr>

            <?php
            $jmlTotalSangu += $c;
            ?>
          <?php endforeach ?>
          <tr>
            <td class="td-sangu text-uppercase font-bold" colspan="5">jumlah</td>
            <td class="td-sangu text-right">Rp. <?= number_format($jmlTotalSangu) ?></td>
          </tr>
        </tbody>
      </table>

      <div class="mt-1">
        <table class="table-persen">
          <tr>
            <td class="td-persen font-bold" style="width:60%">Persen (Jumlah Order Penjualan - Jumlah Sangu) </td>
            <td class="td-persen font-bold text-center" style="width:6%">:</td>

            <?php
            $totOrder = floatval($upJmlTotalBiayaOrder);
            $totSangu = floatval($jmlTotalSangu);

            $totPersen = $totOrder - $totSangu;
            ?>

            <td class="td-persen font-bold text-right">Rp. <?= number_format($totPersen) ?></td>
          </tr>
        </table>

      </div>
    </div>

  </div>

</body>

</html>