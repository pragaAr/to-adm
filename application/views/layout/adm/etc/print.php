<?php
function penyebut($nilai)
{
  $nilai = abs($nilai);
  $huruf = array(
    '', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan',
    'sepuluh', 'sebelas', 'dua belas', 'tiga belas', 'empat belas', 'lima belas', 'enam belas',
    'tujuh belas', 'delapan belas', 'sembilan belas', 'dua puluh', 30 => 'tiga puluh',
    40 => 'empat puluh', 50 => 'lima puluh', 60 => 'enam puluh', 70 => 'tujuh puluh',
    80 => 'delapan puluh', 90 => 'sembilan puluh'
  );

  $temp = "";

  if ($nilai < 12) {
    $temp = " " . $huruf[$nilai];
  } else if ($nilai < 20) {
    $temp = penyebut($nilai - 10) . " belas";
  } else if ($nilai < 100) {
    $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
  } else if ($nilai < 200) {
    $temp = " seratus" . penyebut($nilai - 100);
  } else if ($nilai < 1000) {
    $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
  } else if ($nilai < 2000) {
    $temp = " seribu" . penyebut($nilai - 1000);
  } else if ($nilai < 1000000) {
    $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
  } else if ($nilai < 1000000000) {
    $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
  } else if ($nilai < 1000000000000) {
    $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
  } else if ($nilai < 1000000000000000) {
    $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
  }
  return $temp;
}

?>

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
      width: 17%;
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

    .end {
      margin-top: 25px;
      padding-right: 10px;
      text-align: right;
    }

    .font-bold {
      font-weight: bold;
    }

    .mt-1 {
      margin-top: 10px;
    }

    .table-data {
      width: 100%;
      border: none;
    }

    .th-data {
      border: none;
      font-size: 14px;
      padding: 5px;
    }

    .td-data {
      font-size: 14px;
      padding: 3px 2px;
      line-height: 1.3;
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
      <table class="table-data">
        <tr>
          <td class="td-data" style="width:25%">Nama</td>
          <td class="td-data" style="width:5%">:</td>
          <td class="td-data"><?= strtoupper($kry) ?></td>
        </tr>
        <tr>
          <td class="td-data" style="width:25%">Nominal</td>
          <td class="td-data" style="width:5%">:</td>
          <td class="td-data"> Rp. <?= number_format($total) ?> (<?= penyebut($total) ?> rupiah )</td>
        </tr>
        <tr>
          <td class="td-data" style="width:25%">Untuk Keperluan</td>
          <td class="td-data" style="width:5%">:</td>

          <?php $first = true; ?>

          <?php foreach ($detail as $row) : ?>
            <?php if (!$first) : ?>

        </tr>
        <tr>
          <td class="td-data"></td>
          <td class="td-data"></td>

        <?php endif; ?>

        <td class="td-data">
          <?= strtoupper($row->keperluan) ?>, <?= strtoupper($row->jml_item) ?>, Rp. <?= number_format($row->nominal) ?>
        </td>

        <?php $first = false; ?>
      <?php endforeach; ?>

        </tr>

      </table>
      <div class="end">
        <p>Semarang, <?= date('d F Y') ?></p>
      </div>
      <table id="table-foot" style="width:100%; margin-top:20px; font-size:12px;">
        <tr>
          <th class="text-center">Menyetujui :</th>
          <th class="text-center">Mengetahui :</th>
          <th class="text-center">Penerima :</th>
        </tr>
        <tr>
          <td style="padding-top:70px; text-align:center;">
            <span class="dash"></span>
          </td>
          <td style="padding-top:70px; text-align:center;">
            <span class="dash"></span>
          </td>
          <td style="padding-top:70px; text-align:center;">
            <span class="dash"></span>
          </td>
        </tr>
        <tr>
          <td style="text-align:center;">....................</td>
          <td style="text-align:center;">....................</td>
          <td style="text-align:center;">....................</td>
        </tr>
      </table>

    </div>
  </div>

</body>

</html>