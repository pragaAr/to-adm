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

$("#invTables").DataTable({
  ordering: true,
  order: [[0, "desc"]],

  initComplete: function () {
    var api = this.api();
    $("#invTables_filter input")
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
    url: "http://localhost/hira-to-adm/invoice/getInvoice",
    type: "POST",
    dataType: "json",
  },
  columns: [
    {
      data: "id",
      className: "text-center align-middle",
    },
    {
      data: "nomor_inv",
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
      data: "jml_reccu",
      className: "text-center align-middle",
      render: function (data, type, row) {
        return data;
      },
    },
    {
      data: "jml_sj",
      className: "text-center align-middle",
      render: function (data, type, row) {
        return data.toUpperCase();
      },
    },
    {
      data: "dateAdd",
      searchable: false,
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

$("#invTables").on("click", ".btn-print", function () {
  const nomor = $(this).data("nomor");

  $.ajax({
    url: "http://localhost/hira-to-adm/invoice/cekNomor",
    method: "POST",
    dataType: "JSON",
    data: {
      nomor: nomor,
    },
    success: function (data) {
      Swal.fire({
        title: "Cetak surat jalan ?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Batal",
        confirmButtonText: "Cetak tanpa PPN",
        showDenyButton: true,
        denyButtonText: "Cetak dengan PPN",
        denyButtonColor: "#3085d6",
      }).then((result) => {
        if (result.isConfirmed || result.isDenied) {
          const ppn = result.isConfirmed ? "false" : "true";
          const url =
            "http://localhost/hira-to-adm/invoice/print" +
            "?invoice=" +
            data +
            "&ppn=" +
            ppn;
          window.open(url);
        }
      });
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
  $('[data-toggle="tooltip"]').tooltip("hide");
});

$("#invTables").on("click", ".btn-detail", function () {
  const nomor = $(this).data("nomor");

  $.ajax({
    url: "http://localhost/hira-to-adm/invoice/getDetailData",
    method: "POST",
    dataType: "JSON",
    data: {
      nomor: nomor,
    },
    success: function (data) {
      const tbodyDetail = $("#tbodyDetail");
      tbodyDetail.empty();

      let sumtotal = 0;

      const noinv = $(".noinv");
      noinv.text("No. " + data.nomor.toUpperCase());

      const customer = $(".customer");
      customer.text(data.cust.toUpperCase());

      for (let i = 0; i < data.datasj.length; i++) {
        let totalSuratJalan = 0;
        let totalReccu = 0;

        const dateOrder = new Date(data.datasj[i].dateOrder);

        formatedTgl =
          ("0" + dateOrder.getDate()).slice(-2) +
          "/" +
          ("0" + (dateOrder.getMonth() + 1)).slice(-2) +
          "/" +
          dateOrder.getFullYear();

        const row = $("<tr>");

        row.append(
          "<td class='text-center align-middle'>" + (i + 1) + "." + "</td>"
        );
        row.append(
          "<td class='text-uppercase align-middle'>" + formatedTgl + "</td>"
        );

        for (let j = 0; j < data.detail.length; j++) {
          if (data.detail[j].reccu == data.datasj[i].reccu) {
            totalSuratJalan++;
          }
        }

        row.append(
          "<td class='text-uppercase align-middle'> Total Surat Jalan " +
            totalSuratJalan +
            "</td>"
        );

        row.append(
          "<td class='text-uppercase align-middle'>" +
            data.datasj[i].platno +
            "</td>"
        );

        row.append(
          "<td class='text-uppercase align-middle'>" +
            data.datasj[i].reccu +
            "</td>"
        );

        row.append(
          "<td class='text-uppercase align-middle'>" +
            data.datasj[i].kota_asal +
            "-" +
            data.datasj[i].kota_tujuan +
            "</td>"
        );

        row.append(
          "<td class='text-capitalize align-middle'>" +
            data.datasj[i].berat +
            " Kg </td>"
        );

        row.append(
          "<td class='text-capitalize align-middle'> Rp. " +
            format(data.datasj[i].hrg_kg) +
            "</td>"
        );

        row.append(
          "<td class='text-capitalize align-middle'> Rp. " +
            format(data.datasj[i].total_hrg) +
            "</td>"
        );

        tbodyDetail.append(row);

        sumtotal += parseFloat(data.datasj[i].total_hrg);

        for (let j = 0; j < data.detail.length; j++) {
          const detailrow = $("<tr>");

          if (data.detail[j].reccu == data.datasj[i].reccu) {
            detailrow.append(
              "<td class='text-capitalize align-middle' style='background:#434649'></td>"
            );

            detailrow.append(
              "<td class='text-capitalize align-middle' style='background:#434649'></td>"
            );

            detailrow.append(
              "<td class='text-uppercase align-middle' style='background:#434649'>" +
                data.detail[j].surat_jalan +
                "</td>"
            );

            detailrow.append(
              "<td class='text-capitalize align-middle' style='background:#434649'></td>"
            );

            detailrow.append(
              "<td class='text-uppercase align-middle' style='background:#434649'></td>"
            );
            detailrow.append(
              "<td class='text-uppercase align-middle' style='background:#434649'></td>"
            );
            detailrow.append(
              "<td class='text-uppercase align-middle' style='background:#434649'></td>"
            );

            detailrow.append(
              "<td class='text-capitalize align-middle' style='background:#434649'></td>"
            );

            detailrow.append(
              "<td class='text-capitalize align-middle' style='background:#434649'></td>"
            );

            tbodyDetail.append(detailrow);
          }
        }
      }

      const sumrow = $("<tr>");

      sumrow.append(
        "<td class='text-capitalize align-middle font-weight-bold' colspan='8'> Jumlah </td>"
      );

      sumrow.append(
        "<td class='text-capitalize align-middle font-weight-bold'> Rp. " +
          format(sumtotal) +
          " </td>"
      );

      tbodyDetail.append(sumrow);

      $("#modalDetail").modal("show");

      $('[data-toggle="tooltip"]').tooltip("hide");
    },
  });
});

$("#invTables").on("click", ".btn-delete", function () {
  const nomor = $(this).data("nomor");

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
        url: "http://localhost/hira-to-adm/invoice/delete",
        method: "POST",
        data: { nomor: nomor },
        success: function (data) {
          Swal.fire({
            icon: "success",
            title: "Success!",
            text: "Data Invoice dihapus!",
          });

          $("#invTables").DataTable().ajax.reload(null, false);
        },
      });
    }
  });
});
