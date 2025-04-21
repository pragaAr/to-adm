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

$("#sanguTables").DataTable({
  ordering: true,
  order: [[0, "desc"]],

  initComplete: function () {
    var api = this.api();
    $("#sanguTables_filter input")
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
    url: "http://localhost/hira-to-adm/sangu/getSangu",
    type: "POST",
    dataType: "json",
  },
  columns: [
    {
      data: "id",
      className: "text-center align-middle",
    },
    {
      data: "no_order",
      className: "text-center align-middle",
      render: function (data, type, row) {
        return data.toUpperCase();
      },
    },
    {
      data: "platno",
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
      data: "nominal",
      className: "text-center align-middle",
      render: function (data, type, row) {
        if (row.tambahan == "0") {
          return "Rp. " + format(data);
        } else {
          return (
            "Rp. " +
            format(data) +
            "<i class='fas fa-exclamation pl-2' data-toggle='tooltip' title='Ada tambahan Rp. " +
            format(row.tambahan) +
            "'></i>"
          );
        }
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

$("#sanguTables").on("click", ".btn-edit", function () {
  const kd = $(this).data("kd");

  $.ajax({
    url: "http://localhost/hira-to-adm/sangu/getDataKd",
    method: "POST",
    dataType: "JSON",
    data: {
      kd: kd,
    },
    success: function (data) {
      $("#noorder").val(data.no_order);
      $("#platno").val(data.platno);
      $("#sopir").val(data.nama);
      $("#nominal").val(format(data.nominal));
      $("#tambahan").val(format(data.tambahan));

      $("#keterangan").val(data.keterangan);

      const d = new Date(data.dateTambahanAdd);
      const tanggal = String(d.getDate()).padStart(2, "0");
      const bulan = String(d.getMonth() + 1).padStart(2, "0");
      const tahun = d.getFullYear();

      if (data.dateTambahanAdd === null) {
        $("#tanggal").val("");
      } else {
        $("#tanggal").val(`${tahun}-${bulan}-${tanggal}`);
      }

      $("#tanggal").val(`${tahun}-${bulan}-${tanggal}`);

      $("#modalEditSangu").modal("show");

      $('[data-toggle="tooltip"]').tooltip("hide");
    },
  });
});

$("#modalEditSangu").on("shown.bs.modal", function () {
  $("#tambahan").focus();

  $("#tambahan").on("keypress", function (key) {
    if (key.charCode < 48 || key.charCode > 57) return false;
  });

  $(function () {
    $("#tambahan").on("keydown keyup click change blur input", function (e) {
      $(this).val(format($(this).val()));
    });
  });
});

$("#form_updateSangu").on("submit", function (e) {
  e.preventDefault();

  const noorder = $("#noorder").val();
  const tambahan = $("#tambahan").val();
  const keterangan = $("#keterangan").val();
  const tgl = $("#tanggal").val();

  $.ajax({
    url: "http://localhost/hira-to-adm/sangu/update",
    type: "POST",
    data: {
      noorder: noorder,
      tambahan: tambahan,
      keterangan: keterangan,
      tgl: tgl,
    },
    success: function (data) {
      $("#noorder").val("");
      $("#platno").val("");
      $("#sopir").val("");
      $("#nominal").val("");
      $("#tambahan").val("");

      $("#modalEditSangu").modal("hide");

      Swal.fire({
        icon: "success",
        title: "Success!",
        text: "Data Sangu diubah!",
      });

      $("#sanguTables").DataTable().ajax.reload(null, false);
    },
  });

  return false;
});

$("#sanguTables").on("click", ".btn-detail", function () {
  const kd = $(this).data("kd");

  $.ajax({
    url: "http://localhost/hira-to-adm/sangu/getDetail",
    type: "POST",
    dataType: "json",
    data: {
      kd: kd,
    },
    success: function (data) {
      $("#btnDetail").attr(
        "href",
        "http://localhost/hira-to-adm/order/print/" + data.no_order
      );

      $(".noorder").text(data.no_order);
      $(".muatan").text(data.jenis_muatan);
      $(".cust").text(data.nama_customer);
      $(".kontak").text(data.kontak_order);
      $(".asal").text(data.asal_order);
      $(".tujuan").text(data.tujuan_order);
      $(".tgl").text(data.dateAdd);

      $(".truck").text(data.platno);
      $(".supir").text(data.nama_sopir);
      $(".nominal").text("Rp. " + format(data.nominal));
      $(".tambahan").text("Rp. " + format(data.tambahan));

      $("#modalDetailSangu").modal("show");

      $('[data-toggle="tooltip"]').tooltip("hide");
    },
  });
});

$("#sanguTables").on("click", ".btn-printsangu", function () {
  const kd = $(this).data("kd");

  $.ajax({
    url: "http://localhost/hira-to-adm/sangu/cekKd",
    method: "POST",
    dataType: "JSON",
    data: {
      kd: kd,
    },
    success: function (data) {
      if (data !== null) {
        Swal.fire({
          title: "Cetak Pengeluaran kas ?",
          icon: "question",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          cancelButtonText: "Batal",
          confirmButtonText: "Ya, Cetak !",
        }).then((result) => {
          if (result.value) {
            window.open(
              "http://localhost/hira-to-adm/sangu/print" +
                "?no_do=" +
                data.no_order
            );
          }
        });
      } else {
        console.log("data tidak ditemukan");
      }

      $('[data-toggle="tooltip"]').tooltip("hide");
    },
  });
});

$("#sanguTables").on("click", ".btn-printtambahan", function () {
  const kd = $(this).data("kd");

  $.ajax({
    url: "http://localhost/hira-to-adm/sangu/cekKd",
    method: "POST",
    dataType: "JSON",
    data: {
      kd: kd,
    },
    success: function (data) {
      if (data !== null) {
        Swal.fire({
          title: "Cetak Pengeluaran kas ?",
          icon: "question",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          cancelButtonText: "Batal",
          confirmButtonText: "Ya, Cetak !",
        }).then((result) => {
          if (result.value) {
            window.open(
              "http://localhost/hira-to-adm/sangu/printTambahan" +
                "?no_do=" +
                data.no_order
            );
          }
        });
      } else {
        console.log("data tidak ditemukan");
      }

      $('[data-toggle="tooltip"]').tooltip("hide");
    },
  });
});
