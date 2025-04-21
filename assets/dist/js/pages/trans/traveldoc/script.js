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

$("#sjTables").DataTable({
  ordering: true,
  order: [[0, "desc"]],

  initComplete: function () {
    var api = this.api();
    $("#sjTables_filter input")
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
    url: "http://localhost/hira-to-adm/traveldoc/getTraveldoc",
    type: "POST",
    dataType: "json",
  },
  columns: [
    {
      data: "id",
      className: "text-center align-middle",
    },
    {
      data: "nomor_surat",
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

$("#sjTables").on("click", ".btn-print", function () {
  const nomor = $(this).data("nomor");

  $.ajax({
    url: "http://localhost/hira-to-adm/traveldoc/cekNomor",
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
        confirmButtonText: "Ya, Cetak !",
      }).then((result) => {
        if (result.value) {
          window.open(
            "http://localhost/hira-to-adm/traveldoc/print" +
              "?surat_jalan=" +
              data
          );
        }
      });

      $('[data-toggle="tooltip"]').tooltip("hide");
    },
  });
});

$("#sjTables").on("click", ".btn-detail", function () {
  const nomor = $(this).data("nomor");

  $.ajax({
    url: "http://localhost/hira-to-adm/traveldoc/getDetailData",
    method: "POST",
    dataType: "JSON",
    data: {
      nomor: nomor,
    },
    success: function (data) {
      const tbodyDetail = $("#tbodyDetail");
      tbodyDetail.empty();

      let sumtotal = 0;

      const nosurat = $(".nosurat");
      nosurat.text("No. " + data.nomor.toUpperCase());

      const customer = $(".customer");
      customer.text(data.cust.toUpperCase());

      for (let i = 0; i < data.datasj.length; i++) {
        let totalSuratJalan = 0;

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
        row.append(
          "<td class='text-uppercase align-middle'>" +
            data.datasj[i].platno +
            "</td>"
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
              "<td class='text-capitalize align-middle' style='background:#434649' colspan='2'>" +
                data.detail[j].ket +
                "</td>"
            );

            detailrow.append(
              "<td class='text-uppercase align-middle' style='background:#434649'>" +
                data.detail[j].surat_jalan +
                "</td>"
            );

            if (data.detail[j].retur == 0) {
              detailrow.append(
                "<td class='text-uppercase align-middle' style='background:#434649'></td>"
              );
            } else {
              detailrow.append(
                "<td class='text-capitalize align-middle' style='background:#434649'> Retur " +
                  data.detail[j].retur +
                  "</td>"
              );
            }

            if (data.detail[j].berat == 0) {
              detailrow.append(
                "<td class='text-uppercase align-middle' style='background:#434649'></td>"
              );
            } else {
              detailrow.append(
                "<td class='text-capitalize align-middle' style='background:#434649'>" +
                  data.detail[j].berat +
                  " Kg</td>"
              );
            }

            detailrow.append(
              "<td class='text-uppercase align-middle' style='background:#434649'></td>"
            );
            detailrow.append(
              "<td class='text-uppercase align-middle' style='background:#434649'></td>"
            );

            tbodyDetail.append(detailrow);
          }
        }
      }

      const sumrow = $("<tr>");

      sumrow.append(
        "<td class='text-capitalize align-middle font-weight-bold' colspan='7'> Jumlah </td>"
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

$("#sjTables").on("click", ".btn-delete", function () {
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
        url: "http://localhost/hira-to-adm/traveldoc/delete",
        method: "POST",
        data: { nomor: nomor },
        success: function (data) {
          Swal.fire({
            icon: "success",
            title: "Success!",
            text: "Data Surat Jalan dihapus!",
          });

          $("#sjTables").DataTable().ajax.reload(null, false);
        },
      });
    }
  });
});
