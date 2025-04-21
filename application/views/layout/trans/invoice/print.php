<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice</title>

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
      margin-bottom: 1.5px;

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
      text-align: center;
    }

    .data-title h4 {
      margin: 0;
      font-size: 16px;
    }

    .data-content {
      margin-top: 10px;
    }

    .table-content {
      width: 100%;
      border-collapse: collapse;
      border: 1px solid #000;
    }

    .th-content,
    .td-content {
      border: 1px solid #000;
      font-size: 12px;
      text-align: center;
      padding: 5px;
      vertical-align: middle;
    }

    .th-content {
      text-transform: uppercase;
    }

    .td-content {
      text-transform: capitalize;
      height: 40px;
    }

    .td-content-numerik {
      border: 1px solid #000;
      font-size: 12px;
      text-align: center;
      padding: 5px;
      vertical-align: middle;
      height: 40px;
    }

    .td-content-numerik {
      text-transform: capitalize;
    }

    .td-content-empty {
      border: 1px solid #000;
      font-size: 12px;
      text-align: center;
      padding: 5px;
      vertical-align: middle;
      height: 40px;
    }

    .font-bold {
      font-weight: bold;
    }

    .uppercase {
      text-transform: uppercase;
    }

    .danger {
      color: red;
    }

    .payment-metod {
      page-break-inside: avoid;
    }

    .table-payment {
      width: 60%;
    }

    .th-payment,
    .td-payment {
      border: none;
      font-size: 12px;
      text-align: left;
      padding: 5px 10px 0;
    }

    .payment-desc {
      font-size: 12px;
    }

    .signature {
      margin-top: 20px;
      margin-bottom: 10px !important;
      page-break-inside: avoid;
    }

    .table-signature {
      width: 100%;
    }

    .td-signature {
      font-size: 12px;
      text-align: center;
      padding: 5px 10px 0;
    }

    .space {
      height: 80px;
    }

    .space-dpp {
      height: 15px;
    }

    .nama,
    .pembilang {
      border-bottom: 1px solid black !important;
    }

    .border {
      width: 65%;
      float: right;
      margin-bottom: 10px;
      border-bottom: 3px double black;
    }

    .jumlah {
      width: 100%;
    }

    .jumlah p {
      text-align: right;
      font-size: 12px;
      font-weight: bold;
    }

    .center {
      text-align: center;
    }

    .col-dpp {
      margin-top: 15px;
      page-break-inside: avoid;
    }

    .table-dpp {
      width: 100%;
      border-collapse: collapse;
    }

    .td-dpp {
      font-size: 12px;
      padding: 5px;
    }

    .right {
      text-align: right;
    }

    .pr-0 {
      padding-right: 0;
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
      <p class="cname">
        pt. hira adya naranata
      </p>
      <p class="cdetail">Komplek Pangkalan Truk Genuk Blok AA No.35, Jl. Raya Kaligawe Km 56, Semarang</p>
      <p class="cdetail">Telp : (024) 6582208; +628112940481</p>
      <p class="cdetail">Website : https://hira-express.com Email : hira.express.transport@gmail.com</p>
    </div>

    <hr>

    <div class="data-title">
      <h4><?= strtoupper($title) ?> <?= strtoupper($cust) ?></h4>
      <h4>No : <?= strtoupper($nomor) ?></h4>
    </div>

    <div class="data-content">
      <table class="table-content">
        <thead>
          <tr>
            <th class="th-content" style="width:5%">No.</th>
            <th class="th-content" style="width:10%">Tanggal</th>
            <th class="th-content" style="width:17%">Surat Jalan</th>
            <th class="th-content" style="width:10%">Nomor Polisi</th>
            <th class="th-content" style="width:9%">Reccu</th>
            <th class="th-content" style="width:17%">Asal-Tujuan</th>
            <th class="th-content" style="width:8%">Berat</th>
            <th class="th-content" style="width:9%">Ongkir</th>
            <th class="th-content" style="width:15%">Total</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sumtotal = 0;
          $no = 1;

          foreach ($datainv as $data) :
            $panjang = count($datainv);
          ?>

            <tr>
              <td class="td-content"><?= $no++ ?>.</td>
              <td class="td-content"><?= date('d/m/Y', strtotime($data->dateReccu)) ?></td>

              <?php
              $total_reccu = 0;
              foreach ($detail as $dtdetaildata) {
                if ($dtdetaildata->reccu == $data->reccu)
                  $total_reccu++;
              } ?>

              <td class="td-content">Total Surat Jalan <?= $total_reccu ?></td>
              <td class="td-content uppercase"><?= $data->platno ?></td>

              <td class="td-content uppercase"><?= $data->reccu ?></td>
              <td class="td-content"><?= $data->kota_asal ?>-<?= $data->kota_tujuan ?></td>
              <td class="td-content"><?= $data->berat ?> Kg</td>
              <td class="td-content">Rp. <?= number_format($data->hrg_kg) ?></td>
              <td class="td-content">Rp. <?= number_format($data->total_hrg) ?></td>
            </tr>

            <?php foreach ($detail as $dtdetail) : ?>

              <?php if ($dtdetail->reccu == $data->reccu) { ?>
                <tr>
                  <td class="td-content"></td>
                  <td class="td-content"></td>
                  <td class="td-content uppercase"><?= $dtdetail->surat_jalan ?></td>
                  <td class="td-content"></td>
                  <td class="td-content"></td>
                  <td class="td-content"></td>
                  <td class="td-content"></td>
                  <td class="td-content"></td>
                  <td class="td-content"></td>
                </tr>
              <?php } ?>
            <?php endforeach ?>

            <?php if ($panjang < 2) { ?>
            <?php } else { ?>
              <tr>
                <td class="td-content-empty"></td>
                <td class="td-content-empty"></td>
                <td class="td-content-empty"></td>
                <td class="td-content-empty"></td>
                <td class="td-content-empty"></td>
                <td class="td-content-empty"></td>
                <td class="td-content-empty"></td>
                <td class="td-content-empty"></td>
                <td class="td-content-empty"></td>
              </tr>
            <?php } ?>

            <?php
            $sumtotal += $data->total_hrg;
            ?>

          <?php endforeach ?>

          <tr>
            <td colspan="8" class="td-content font-bold uppercase">Jumlah</td>
            <td class="td-content-numerik font-bold">Rp. <?= number_format($sumtotal) ?></td>
          </tr>
        </tbody>
      </table>

      <?php if ($ppnvalue === "true") { ?>
        <div class="col-dpp">
          <table class="table-dpp">
            <tr>
              <td class="td-dpp" rowspan="2" style="width:35%"></td>
              <td class="td-dpp center" rowspan="2" style="width:9%">DPP</td>
              <td class="td-dpp center" rowspan="2" style="width:18%">Rp. <?= number_format($sumtotal) ?></td>
              <td class="td-dpp center" rowspan="2" style="width:5%">X</td>
              <td class="td-dpp pembilang center" style="width:10%">100%</td>
              <td class="td-dpp center" rowspan="2" style="width:5%">=</td>

              <?php
              $a = $sumtotal;
              $pembilang = 100;
              $penyebut = 101.1;
              $persen = 1.1;
              $mod = 100;

              $dpp = $a * ($pembilang / $mod) / ($penyebut / $mod);

              $ppn = $dpp * ($persen / $mod);

              $jml = $dpp + $ppn;
              ?>

              <td class="td-dpp right" rowspan="2" style="width:18%">Rp. <?= number_format($dpp) ?></td>
            </tr>
            <tr>
              <td class="td-dpp center">101.1%</td>
            </tr>
            <tr>
              <td class="space-dpp" colspan="7"></td>
            </tr>
            <tr>
              <td class="td-dpp"></td>
              <td class="td-dpp center">PPN</td>
              <td colspan="3" class="td-dpp center">1.1%</td>
              <td class="td-dpp center">=</td>
              <td class="td-dpp right">Rp. <?= number_format($ppn) ?></td>
            </tr>
          </table>
        </div>
        <div class="border"></div>
        <div class="jumlah">
          <p>JUMLAH &emsp;&emsp;&emsp;&emsp;&emsp; <span> Rp. <?= number_format($jml) ?></span></p>
        </div>
      <?php } else { ?>

      <?php } ?>

      <div class="payment-metod">
        <p class="payment-desc">Mohon tagihan dapat ditransfer ke rekening :</p>
        <table class="table-payment">
          <tr>
            <th class="th-payment" style="width:25%">Bank</th>
            <td class="td-payment">: BCA KCU SOLO BARU</td>
          </tr>
          <tr>
            <th class="th-payment" style="width:25%">Atas Nama</th>
            <td class="td-payment">: PT. HIRA ADYA NARANATA</td>
          </tr>
          <tr>
            <th class="th-payment" style="width:25%">No Acc</th>
            <td class="td-payment">: 773 550 6161</td>
          </tr>
        </table>
      </div>

      <div class="signature">
        <table class="table-signature">
          <tr>
            <td style="width:70%"></td>
            <td class="td-signature">Semarang,  <?= date('d-m-Y', strtotime($tgl)) ?></td>
          </tr>
          <tr>
            <td style="width:70%"></td>
            <td class="td-signature" style="width:30%">PT. HIRA ADYA NARANATA</td>
          </tr>
          <tr>
            <td style="width:70%"></td>
            <td class="td-signature" style="width:30%" class="space"></td>
          </tr>
          <tr>
            <td style="width:70%"></td>
            <td class="td-signature nama" style="width:30%">( David Prathama Widiatmo, S.Ak )</td>
          </tr>
          <tr>
            <td style="width:70%"></td>
            <td class="td-signature" style="width:30%">Manager</td>
          </tr>
        </table>
      </div>
    </div>
  </div>

</body>

</html>