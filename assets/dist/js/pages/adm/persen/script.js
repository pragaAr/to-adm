$.fn.dataTableExt.oApi.fnPagingInfo = function (oSettings) {
  return {
    iStart: oSettings._iDisplayStart,
    iEnd: oSettings.fnDisplayEnd(),
    iLength: oSettings._iDisplayLength,
    iTotal: oSettings.fnRecordsTotal(),
    iFilteredTotal: oSettings.fnRecordsDisplay(),
    iPage: Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
    iTotalPages: Math.ceil(
      oSettings.fnRecordsDisplay() / oSettings._iDisplayLength
    ),
  };
};

$("#persenTables").DataTable({
  ordering: true,
  order: [[0, "desc"]],

  initComplete: function () {
    var api = this.api();
    $("#persenTables_filter input")
      .off(".DT")
      .on("input.DT", function () {
        api.search(this.value).draw();
      });
  },
  lengthChange: false,
  autoWidth: false,
  processing: true,
  serverSide: true,
  ajax: {
    url: "http://localhost/hira-to-adm/persensopir/getPersenSopir",
    type: "POST",
    dataType: "json",
  },
  columns: [
    {
      data: "id",
      className: "text-center align-middle",
    },
    {
      data: "kd",
      className: "text-center align-middle",
      render: function (data, type, row) {
        return data.toUpperCase();
      },
    },
    {
      data: "nama",
      className: "text-center align-middle",
      render: function (data, type, row) {
        return data.toUpperCase();
      },
    },
    {
      data: "jml_order",
      className: "text-center align-middle",
      render: function (data, type, row) {
        return data;
      },
    },
    {
      data: "total_diterima",
      className: "text-center align-middle",
      render: function (data, type, row) {
        const tot = data != '' ? data : 0;
        var value = parseFloat(tot);
        return (
          "Rp. " + value.toLocaleString("id-ID", { minimumFractionDigits: 0 })
        );
      },
    },
    {
      data: "dateAdd",
      className: "text-center align-middle",
      render: function (data, type, row) {
        var date = new Date(data);
        return date.toLocaleDateString("id-ID", {
          day: "2-digit",
          month: "2-digit",
          year: "numeric",
        });
      },
    },
    {
      data: "view",
      className: "text-center align-middle",
    },
  ],

  fnDrawCallback: function (oSettings) {
    $('[data-toggle="tooltip"]').tooltip();
  },

  rowCallback: function (row, data, iDisplayIndex) {
    var info = this.fnPagingInfo();
    var page = info.iPage;
    var length = info.iLength;
    var index = page * length + (iDisplayIndex + 1);
    $("td:eq(0)", row).html(index + ".");
  },
});

$("#persenTables").on("click", ".btn-detail", function () {
  const kd = $(this).data("kd");

  $.ajax({
    url: "http://localhost/hira-to-adm/persensopir/getDetailData",
    method: "POST",
    dataType: "JSON",
    data: {
      kd: kd,
    },
    success: function (data) {

      $("#printDetail").attr("data-kd", kd);

      const tbodyOrderPenjualan = $("#tbodyOrderPenjualan");
      tbodyOrderPenjualan.empty();

      const tbodySanguOrder = $("#tbodySanguOrder");
      tbodySanguOrder.empty();

      $(".kd-sopir").text(kd + " - " + data.sopir);

      const salesorder = data.salesorder;
      const sanguorder = data.sanguorder;
      let sumTotal = 0;
      let sumSangu = 0;

      for (let i = 0; i < salesorder.length; i++) {
        const tglReccu = new Date(salesorder[i].tglReccu);

        const row = $("<tr>");
        row.append(
          "<td class='align-middle text-center'>" + (i + 1) + "." + "</td>"
        );

        row.append(
          "<td class='align-middle text-uppercase'>" +
            salesorder[i].namaCustomer +
            "</td>"
        );

        row.append(
          "<td class='align-middle text-uppercase text-center'>" +
          tglReccu.toLocaleDateString("id-ID", {
              day: "2-digit",
              month: "2-digit",
              year: "numeric",
            }) +
            "</td>"
        );

        row.append(
          "<td class='align-middle text-uppercase text-center'>" +
            salesorder[i].platno +
            "</td>"
        );

        row.append(
          "<td class='align-middle text-uppercase text-center'>" +
            format(salesorder[i].berat) +
            "</td>"
        );

        row.append(
          "<td class='align-middle text-right pr-4'>Rp. " +
            format(salesorder[i].hrg_kg) +
            "</td>"
        );

        row.append(
          "<td class='align-middle text-uppercase text-right pr-4'>Rp. " +
            format(salesorder[i].tot_biaya) +
            "</td>"
        );

        row.append(
          "<td class='align-middle text-right pr-4'>" +
            salesorder[i].persen1 +
            "%</td>"
        );

        row.append(
          "<td class='align-middle text-right pr-4'>" +
            salesorder[i].persen2 +
            "%</td>"
        );

        const penyebut = 100;
        const p1 = parseFloat(salesorder[i].persen1);
        const p2 = parseFloat(salesorder[i].persen2);
        const biaya = parseFloat(salesorder[i].tot_biaya);

        let faktor = 1; // Faktor default jika kedua persen adalah 0

        if (p1 !== 0) faktor *= p1 / penyebut;
        if (p2 !== 0) faktor *= p2 / penyebut;

        const totalBiaya = biaya * faktor;
        const upTotalBiaya = Math.ceil(totalBiaya)

        row.append(
          "<td class='align-middle text-right pr-4'>Rp. " +
            format(upTotalBiaya) +
            "</td>"
        );

        sumTotal += upTotalBiaya;
        tbodyOrderPenjualan.append(row);
      }

      const footOrder = $("<tr>");

      footOrder.append(
        "<td colspan='9' class='align-middle text-uppercase text-center'>Jumlah diterima</td>"
      );

      footOrder.append(
        "<td class='align-middle text-right pr-4'>Rp. " +
          format(sumTotal) +
          "</td>"
      );

      tbodyOrderPenjualan.append(footOrder);

      // ------------------sangu order------------------
      for (let j = 0; j < sanguorder.length; j++) {
        const tglSanguOrder = new Date(sanguorder[j].tglOrder);
        const tambahanSangu = sanguorder[j].tambahan != '' ? sanguorder[j].tambahan : 0;

        const row = $("<tr>");
        row.append(
          "<td class='align-middle text-center'>" + (j + 1) + "." + "</td>"
        );

        row.append(
          "<td class='align-middle text-uppercase'>" +
            sanguorder[j].namaCustomer +
            "</td>"
        );

        row.append(
          "<td class='align-middle text-uppercase text-center'>" +
            tglSanguOrder.toLocaleDateString("id-ID", {
              day: "2-digit",
              month: "2-digit",
              year: "numeric",
            }) +
            "</td>"
        );

        row.append(
          "<td class='align-middle text-uppercase text-right pr-4'>Rp. " +
            format(sanguorder[j].nominal) +
            "</td>"
        );

        row.append(
          "<td class='align-middle text-uppercase text-right pr-4'>Rp. " +
            format(tambahanSangu) +
            "</td>"
        );

        const sangu = parseFloat(sanguorder[j].nominal);
        const tambahan = parseFloat(tambahanSangu);
        const totalSangu = sangu + tambahan;

        row.append(
          "<td class='align-middle text-right pr-4'>Rp. " +
            format(totalSangu) +
            "</td>"
        );

        sumSangu += totalSangu;

        tbodySanguOrder.append(row);
      }

      const footSangu = $("<tr>");

      footSangu.append(
        "<td colspan='5' class='align-middle text-uppercase text-center'>Jumlah diterima</td>"
      );

      footSangu.append(
        "<td class='align-middle text-right pr-4'>Rp. " +
          format(sumSangu) +
          "</td>"
      );

      tbodySanguOrder.append(footSangu);
      // ------------------sangu order------------------

      $("#totalDiterima").html("Rp. " + format(sumTotal - sumSangu));

      $("#modalDetail").modal("show");

      $('[data-toggle="tooltip"]').tooltip("hide");
    },
  });
});

$("#persenTables").on("click", ".btn-print", function () {
  const kd = $(this).data("kd");

  requestData(kd);

  $('[data-toggle="tooltip"]').tooltip("hide");
});

$("#persenTables").on("click", ".btn-delete", function () {
  const kd = $(this).data("kd");

  Swal.fire({
    title: "Apakah anda yakin ?",
    text: "Data akan di hapus !!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    cancelButtonText: "Batal",
    confirmButtonText: "Ya, Hapus !",
  }).then((result) => {
    if (result.value) {
      $.ajax({
        url: "http://localhost/hira-to-adm/persensopir/delete",
        method: "POST",
        data: { kd: kd },
        success: function (data) {
          Swal.fire({
            icon: "success",
            title: "Success!",
            text: "Data Persen Sopir dihapus!",
          });

          $("#persenTables").DataTable().ajax.reload(null, false);
        },
      });
    }
  });
});

$("#printDetail").on("click", function () {
  const kd = $(this).data("kd");

  requestData(kd);

  $('[data-toggle="tooltip"]').tooltip("hide");
});

function requestData(kd) {
  $.ajax({
    url: "http://localhost/hira-to-adm/persensopir/cek",
    method: "POST",
    dataType: "JSON",
    data: {
      kd: kd,
    },
    success: function (data) {
      if (data === 1) {
        Swal.fire({
          title: "Cetak Persen Sopir ?",
          icon: "question",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          cancelButtonText: "Batal",
          confirmButtonText: "Ya, Cetak!",
        }).then((result) => {
          if (result.isConfirmed) {
            const url =
              "http://localhost/hira-to-adm/persensopir/print" + "?kode=" + kd;
            window.open(url);
          }
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "Error!",
          text: "Data tidak ditemukan!",
        });
      }
    },
    error: function (xhr, status, error) {
      console.error("Error:", error);

      Swal.fire({
        icon: "error",
        title: "Error!",
        text: "Permintaan tidak dapat diproses!",
      });
    },
  });
}
