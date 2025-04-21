<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?></title>

  <style>
    body {
      color: #1d1d1d;
    }

    .container {
      margin: 0 10px;
    }

    .logo {
      width: 17%;
      float: left;
    }

    img {
      width: 100%;
    }

    .identity {
      text-align: center;
      padding-right: 100px;
    }

    .cname {
      font-size: 20px;
      font-weight: bold;
      text-transform: uppercase;
      margin: 0;
      padding-bottom: 1px;
    }

    .cdetail {
      margin: 0;
      font-size: 12px;
      color: #303030;
    }

    hr {
      border: none;
      height: 1.5px;
      color: #000;
      background-color: #000;
    }

    .data-title {
      font-size: 14px;
      text-align: center;
      font-weight: bold;
    }

    .data-title p {
      margin: 0;
    }

    .content {
      margin-top: 20px;
    }

    .table-content {
      width: 100%;
      border: 0.8px solid black;
      border-collapse: collapse;
    }

    .th-content,
    .td-content {
      border: 1px solid #000;
      font-size: 12px;
      text-align: center;
      padding: 10px 5px;
    }

    .page-number-footer {
      text-align: right;
      font-style: italic;
      font-size: 11px;
    }

    .upper {
      text-transform: uppercase;
    }

    .bold{
      font-weight:bold;
    }
  </style>
</head>

<body>

  <div class="container">

    <div class="logo">
      <img src="<?= base_url('assets/dist/img/logo-red.png') ?>">
    </div>

    <div class="identity">
      <p class="cname">
        pt. hira adya naranata
      </p>
      <p class="cdetail">Komplek Pangkalan Truk Genuk Blok AA No.35, Jl. Raya Kaligawe Km 56, Semarang</p>
      <p class="cdetail">Telp : (024) 6582208; +628112940481</p>
      <p class="cdetail">Website : https://hira-express.com Email : hira.express.transport@gmail.com</p>
    </div>

    <hr>

    <div class="data-title">
      <?php
      $dayUm = date('D', strtotime($dataum->dateAdd));
      if ($dayUm == 'Sun') {  ?>
        <p class="upper">Daftar penerima uang makan <br>
          <?= 'Minggu, ' . date('d F Y', strtotime($dataum->dateAdd)) ?>
        </p>
      <?php } elseif ($dayUm == 'Mon') { ?>
        <p class="upper">Daftar penerima uang makan <br>
          <?= 'Senin, ' . date('d F Y', strtotime($dataum->dateAdd)) ?>
        </p>
      <?php } elseif ($dayUm == 'Tue') { ?>
        <p class="upper">Daftar penerima uang makan <br>
          <?= 'Selasa, ' . date('d F Y', strtotime($dataum->dateAdd)) ?>
        </p>
      <?php } elseif ($dayUm == 'Wed') { ?>
        <p class="upper">Daftar penerima uang makan <br>
          <?= 'Rabu, ' . date('d F Y', strtotime($dataum->dateAdd)) ?>
        </p>
      <?php } elseif ($dayUm == 'Thu') { ?>
        <p class="upper">Daftar penerima uang makan <br>
          <?= 'Kamis, ' . date('d F Y', strtotime($dataum->dateAdd)) ?>
        </p>
      <?php } elseif ($dayUm == 'Fri') { ?>
        <p class="upper">Daftar penerima uang makan <br>
          <?= 'Jumat, ' . date('d F Y', strtotime($dataum->dateAdd)) ?>
        </p>
      <?php } elseif ($dayUm == 'Sat') { ?>
        <p class="upper">Daftar penerima uang makan <br>
          <?= 'Sabtu, ' . date('d F Y', strtotime($dataum->dateAdd)) ?>
        </p>
      <?php } ?>
    </div>

    <div class="content">
      <table class="table-content">
        <thead>
          <tr>
            <th class="th-content" style="width:7%">NO.</th>
            <th class="th-content">NAMA</th>
            <th class="th-content">BAGIAN</th>
            <th class="th-content">NOMINAL</th>
            <th class="th-content" style="width:20%">TANDA TANGAN</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $total = 0;
          $no = 1;
          foreach ($detailum as $detail) : ?>
            <tr>
              <td class="td-content"><?= $no ?>.</td>
              <td class="td-content"><?= strtoupper($detail->nama) ?></td>
              <td class="td-content"><?= strtoupper($detail->status) ?></td>
              <td class="td-content">Rp. <?= number_format($detail->nominal) ?></td>
              <td class="td-content"></td>
            </tr>
            <?php 
            $total += $detail->nominal;
            $no++ ?>
          <?php endforeach ?>
          <tr>
            <td class="td-content bold" colspan="3"> TOTAL</td>
            <td class="td-content bold"> Rp. <?=number_format($total)?></td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>
</body>

</html>