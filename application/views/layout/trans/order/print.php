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

    p {
      margin: 0;
    }

    .container {
      margin: 0 10px;
    }

    .logo {
      width: 16%;
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

    .data-title .p-no-order {
      margin: 20px 0;
      font-weight: bold;
      text-transform: uppercase;
      font-size: 16px;
    }

    .data-title .p-title-desc {
      margin-bottom: 5px;
      font-size: 14px;
    }

    .uppercase {
      text-transform: uppercase;
    }

    .bold {
      font-weight: bold;
    }

    .content {
      margin-top: 20px;
    }

    .content p {
      margin-bottom: 3px;
    }

    .w-60 {
      width: 60%;
    }

    .w-40 {
      width: 40%;
    }

    .signature {
      margin-top: 40px;
    }

    .signature .ttd {
      float: right;
      text-align: center;
    }

    .signature .ttd p {
      font-size: 14px;
    }

    .signature .ttd h4 {
      font-size: 16px;
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
      <img src="<?= $img ?>">
    </div>

    <div class="identity">
      <p class="cname">
        pt. hira adya naranata
      </p>
      <p class="cdetail">Komplek Pangkalan Truk Genuk Blok AA No.35, Jl. Raya Kaligawe Km 56, Semarang</p>
      <!-- <p class="cdetail"></p> -->
      <p class="cdetail">Telp : (024) 6582208; +628112940481</p>
      <p class="cdetail">Website : https://hira-express.com Email : hira.express.transport@gmail.com</p>
    </div>

    <hr>

    <div class="data-title">
      <p class="p-no-order">no order : <?= $detail->no_order ?></p>
      <p class="p-title-desc">Semarang, <?= date('d F Y', strtotime($detail->dateAdd)) ?></p>
      <p class="p-title-desc">Kepada Yth,</p>
      <p class="p-title-desc uppercase"><?= $detail->nama_customer ?></p>
      <p class="p-title-desc"><?= ucwords($detail->keterangan) ?>.</p>
      <p class="p-title-desc">Di <?= ucwords($detail->asal_order) ?>.</p>

    </div>

    <div class="content">
      <p>Dengan hormat,</p>
      <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Bersama ini, truk kami dengan Nomor Polisi
        <span class="bold uppercase">
          <?= $detail->platno ?>,
        </span>
        Pengemudi
        <span class="bold">
          <?= ucwords($detail->nama_sopir) ?>
        </span>
        dan Kernet
        <span class="bold">-.</span>
      </p>
      <p>Mohon diberi muatan berupa
        <span class="bold">
          <?= ucwords($detail->jenis_muatan) ?>,
        </span>
        dengan tujuan ke
        <span class="bold">
          <?= ucwords($detail->tujuan_order) ?>.
        </span>
      </p>
    </div>

    <div class="signature">
      <div class="w-60"></div>
      <div class="ttd w-40">
        <p>Hormat kami,</p>
        <h4 class="uppercase"> pt. hira adya naranata</h4>
      </div>
    </div>

  </div>

</body>

</html>