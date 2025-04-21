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

$("#armadaTables").DataTable({
  ordering: true,
  initComplete: function () {
    var api = this.api();
    $("#armadaTables_filter input")
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
    url: "http://localhost/hira-to-adm/armada/getArmada",
    type: "POST",
    dataType: "json",
  },
  columns: [
    {
      data: "id",
      className: "text-center",
    },
    {
      data: "platno",
      className: "text-center",
      render: function (data, type, row) {
        return data.toUpperCase();
      },
    },
    {
      data: "merk",
      className: "text-center",
      render: function (data, type, row) {
        return data.toUpperCase();
      },
    },
    {
      data: "status_truck",
      className: "text-center",
      render: function (data, type, row) {
        return data === "1" ? "Dipakai" : "Ready";
      },
    },
    {
      data: "dateKeur",
      searchable: false,
      className: "text-center",
      render: function (data, type, row) {
        if (data === null) {
          return "-";
        } else {
          var date = new Date(data);
          return date.toLocaleDateString("id-ID", {
            day: "2-digit",
            month: "2-digit",
            year: "numeric",
          });
        }
      },
    },
    {
      data: "dateAdd",
      searchable: false,
      className: "text-center",
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
      className: "text-center",
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

$("#btn_add").on("click", function () {
  $("#modalAdd").modal("show");
});

$("#modalAdd").on("shown.bs.modal", function () {
  $("#platno").focus();
});

$("#form_add").on("submit", function (e) {
  e.preventDefault();

  const platno = $("#platno").val();
  const merk = $("#merk").val();
  const keur = $("#keur").val();

  $.ajax({
    url: "http://localhost/hira-to-adm/armada/add",
    type: "POST",
    data: {
      platno: platno,
      merk: merk,
      keur: keur,
    },
    success: function (data) {
      if (data === "true") {
        $("#platno").val("");
        $("#merk").val("");
        $("#keur").val("");

        $("#modalAdd").modal("hide");

        Swal.fire({
          icon: "success",
          title: "Success!",
          text: "Data Armada ditambahkan!",
        });

        $("#armadaTables").DataTable().ajax.reload(null, false);
      }
    },
  });

  // return false;
});

$("#modalEdit").on("shown.bs.modal", function () {
  $("#platnoedit").focus();
});

$("#armadaTables").on("click", ".btn-edit", function (e) {
  const id = $(this).data("id");

  $.ajax({
    url: "http://localhost/hira-to-adm/armada/getId",
    type: "POST",
    data: {
      id: id,
    },
    success: function (data) {
      const parsedata = JSON.parse(data);

      $("#id").val(parsedata.id);
      $("#platnoedit").val(parsedata.platno);
      $("#merkedit").val(parsedata.merk);
      $("#keuredit").val(parsedata.dateKeur);

      $("#modalEdit").modal("show");

      $('[data-toggle="tooltip"]').tooltip("hide");
    },
  });
});

$("#form_edit").on("submit", function () {
  const id = $("#id").val();
  const platno = $("#platnoedit").val();
  const merk = $("#merkedit").val();
  const keur = $("#keuredit").val();

  $.ajax({
    type: "POST",
    url: "http://localhost/hira-to-adm/armada/update",
    data: {
      id: id,
      platno: platno,
      merk: merk,
      keur: keur,
    },
    success: function (data) {
      if (data === "true") {
        $("#id").val("");
        $("#platnoedit").val("");
        $("#merkedit").val("");
        $("#keuredit").val("");

        $("#modalEdit").modal("hide");

        Swal.fire({
          icon: "success",
          title: "Success!",
          text: "Data Armada diubah!",
        });

        $("#armadaTables").DataTable().ajax.reload(null, false);
      }
    },
  });

  return false;
});

$("#armadaTables").on("click", ".btn-delete", function () {
  const id = $(this).data("id");

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
        url: "http://localhost/hira-to-adm/armada/delete",
        method: "POST",
        data: { id: id },
        success: function (data) {
          Swal.fire({
            icon: "success",
            title: "Success!",
            text: "Data Armada dihapus!",
          });

          $("#armadaTables").DataTable().ajax.reload(null, false);
        },
      });
    }
  });
});

$(document).on("select2:open", () => {
  document
    .querySelector(".select2-container--open .select2-search__field")
    .focus();
});
