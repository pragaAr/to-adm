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

$("#etcTables").DataTable({
  ordering: true,
  order: [[0, "desc"]],

  initComplete: function () {
    var api = this.api();
    $("#etcTables_filter input")
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
    url: "http://localhost/hira-to-adm/pengeluaran_lain/getPengeluaranLain",
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
      data: "jml_nominal",
      className: "text-center align-middle",
      render: function (data, type, row) {
        return "Rp. " + format(data);
      },
    },
    {
      data: "jml_keperluan",
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

$("#etcTables").on("click", ".btn-detail", function () {
  const kd = $(this).data("kd");

  $.ajax({
    url: "http://localhost/hira-to-adm/pengeluaran_lain/cek",
    method: "POST",
    data: { kd: kd },
    success: function (data) {
      if (data !== "1") {
        Swal.fire({
          icon: "warning",
          title: "Oops!",
          text: "Data tidak ditemukan!",
        });
      } else {
        $.ajax({
          url: "http://localhost/hira-to-adm/pengeluaran_lain/getDetail",
          method: "POST",
          data: { kd: kd },
          success: function (response) {
            const parsedRes = JSON.parse(response);
            console.log(parsedRes);

            const date = new Date(parsedRes.data.dateAdd);

            $("#modalDetail").modal("show");
            $("#kd_kry").html(
              parsedRes.data.kd.toUpperCase() +
                "-" +
                parsedRes.data.nama.toUpperCase()
            );

            $("#tgl").html(
              date.toLocaleDateString("id-ID", {
                day: "2-digit",
                month: "2-digit",
                year: "numeric",
              })
            );

            const tbodyDetail = $("#tbodyDetail");
            tbodyDetail.empty();

            let sumNominal = 0;

            for (let i = 0; i < parsedRes.detail.length; i++) {
              const row = $("<tr>");
              row.append(
                "<td class='text-center align-middle'>" +
                  (i + 1) +
                  "." +
                  "</td>"
              );
              row.append(
                "<td class='text-uppercase align-middle'>" +
                  parsedRes.detail[i].keperluan.toUpperCase() +
                  "</td>"
              );
              row.append(
                "<td class='text-uppercase align-middle'>" +
                  parsedRes.detail[i].jml_item.toUpperCase() +
                  "</td>"
              );
              row.append(
                "<td class='text-right pr-4 align-middle'> Rp. " +
                  format(parsedRes.detail[i].nominal) +
                  "</td>"
              );

              sumNominal += parseFloat(parsedRes.detail[i].nominal);
              tbodyDetail.append(row);
            }

            const tfoot = $("<tr>");

            tfoot.append(
              "<td colspan='3' class='text-uppercase text-center align-middle'>Jumlah Pengeluaran</td>"
            );

            tfoot.append(
              "<td class='text-right pr-4 align-middle'>Rp. " +
                format(sumNominal) +
                "</td>"
            );

            tbodyDetail.append(tfoot);
          },
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

  $('[data-toggle="tooltip"]').tooltip("hide");
});

$("#etcTables").on("click", ".btn-print", function () {
  const kd = $(this).data("kd");

  $.ajax({
    url: "http://localhost/hira-to-adm/pengeluaran_lain/cek",
    method: "POST",
    data: { kd: kd },
    success: function (data) {
      if (data !== "1") {
        Swal.fire({
          icon: "warning",
          title: "Oops!",
          text: "Data tidak ditemukan!",
        });
      } else {
        Swal.fire({
          title: "Cetak pengeluaran kas ?",
          icon: "question",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          cancelButtonText: "Batal",
          confirmButtonText: "Ya, Cetak PDF",
        }).then((result) => {
          if (result.isConfirmed) {
            const url =
              "http://localhost/hira-to-adm/pengeluaran_lain/print" +
              "?nomor=" +
              kd;
            window.open(url);
          }
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

  $('[data-toggle="tooltip"]').tooltip("hide");
});

$("#etcTables").on("click", ".btn-delete", function () {
  const kd = $(this).data("kd");

  $.ajax({
    url: "http://localhost/hira-to-adm/pengeluaran_lain/cek",
    method: "POST",
    data: { kd: kd },
    success: function (data) {
      if (data !== "1") {
        Swal.fire({
          icon: "warning",
          title: "Oops!",
          text: "Data tidak ditemukan!",
        });
      } else {
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
          if (result.isConfirmed) {
            $.ajax({
              url: "http://localhost/hira-to-adm/pengeluaran_lain/delete",
              method: "POST",
              data: { kd: kd },
              success: function (res) {
                if (res === "true") {
                  Swal.fire({
                    icon: "success",
                    title: "Success!",
                    text: "Data Pengeluaran Lain dihapus!",
                  });
                } else {
                  Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text: "Data Pengeluaran Lain gagal dihapus!",
                  });
                }

                $("#etcTables").DataTable().ajax.reload(null, false);
              },
              error: function (xhr, status, error) {
                console.error("Error:", error);

                Swal.fire({
                  icon: "error",
                  title: "Error!",
                  text: "Terjadi kesalahan pada server!",
                });
              },
            });
          }
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
});
