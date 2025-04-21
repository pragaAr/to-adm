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

$("#sopirTables").DataTable({
  ordering: true,
  initComplete: function () {
    var api = this.api();
    $("#sopirTables_filter input")
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
    url: "http://localhost/hira-to-adm/sopir/getSopir",
    type: "POST",
    dataType: "json",
  },
  columns: [
    {
      data: "id",
      className: "text-center",
    },
    {
      data: "nama",
      className: "text-center",
      render: function (data, type, row) {
        return data.toUpperCase();
      },
    },
    {
      data: "alamat",
      className: "text-center",
      render: function (data, type, row) {
        return data.toUpperCase();
      },
    },
    {
      data: "notelp",
      className: "text-center",
      render: function (data, type, row) {
        return data.toUpperCase();
      },
    },
    {
      data: "status_sopir",
      className: "text-center",
      render: function (data, type, row) {
        return data === "1" ? "Terima Order" : "Available";
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
  $("#nama").focus();
});

$("#form_add").on("submit", function () {
  const nama = $("#nama").val();
  const alamat = $("#alamat").val();
  const notelp = $("#notelp").val();

  $.ajax({
    url: "http://localhost/hira-to-adm/sopir/add",
    type: "POST",
    data: {
      nama: nama,
      alamat: alamat,
      notelp: notelp,
    },
    success: function (data) {
      if (data === "true") {
        $("#nama").val("");
        $("#alamat").val("");
        $("#notelp").val("");

        $("#modalAdd").modal("hide");

        Swal.fire({
          icon: "success",
          title: "Success!",
          text: "Data Sopir ditambahkan!",
        });

        $("#sopirTables").DataTable().ajax.reload(null, false);
      }
    },
  });

  return false;
});

$("#modalEdit").on("shown.bs.modal", function () {
  $("#namaedit").focus();
});

$("#sopirTables").on("click", ".btn-edit", function (e) {
  const id = $(this).data("id");

  $.ajax({
    url: "http://localhost/hira-to-adm/sopir/getId",
    type: "POST",
    data: {
      id: id,
    },
    success: function (data) {
      const parsedata = JSON.parse(data);

      $("#id").val(parsedata.id);
      $("#namaedit").val(parsedata.nama);
      $("#alamatedit").val(parsedata.alamat);
      $("#notelpedit").val(parsedata.notelp);

      $("#modalEdit").modal("show");

      $('[data-toggle="tooltip"]').tooltip("hide");
    },
  });
});

$("#form_edit").on("submit", function () {
  const id = $("#id").val();
  const nama = $("#namaedit").val();
  const alamat = $("#alamatedit").val();
  const notelp = $("#notelpedit").val();

  $.ajax({
    type: "POST",
    url: "http://localhost/hira-to-adm/sopir/update",
    data: {
      id: id,
      nama: nama,
      alamat: alamat,
      notelp: notelp,
    },
    success: function (data) {
      if (data === "true") {
        $("#id").val("");
        $("#namaedit").val("");
        $("#alamatedit").val("");
        $("#notelpedit").val("");

        $("#modalEdit").modal("hide");

        Swal.fire({
          icon: "success",
          title: "Success!",
          text: "Data Sopir diubah!",
        });

        $("#sopirTables").DataTable().ajax.reload(null, false);
      }
    },
  });

  return false;
});

$("#sopirTables").on("click", ".btn-delete", function () {
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
        url: "http://localhost/hira-to-adm/sopir/delete",
        method: "POST",
        data: { id: id },
        success: function (data) {
          Swal.fire({
            icon: "success",
            title: "Success!",
            text: "Data Sopir dihapus!",
          });

          $("#sopirTables").DataTable().ajax.reload(null, false);
        },
      });
    }
  });
});

$("#sopirTables").on("click", ".btn-history", function () {
  const id = $(this).data("id");
  const nama = $(this).data("nama");

  const modalTitle = $("#modalTitle");
  modalTitle.text("History Order " + nama);

  $.ajax({
    url: "http://localhost/hira-to-adm/sopir/history",
    method: "POST",
    data: { id: id },
    success: function (response) {
      const res = JSON.parse(response);

      if (res.length === 0) {
        Swal.fire({
          icon: "info",
          title: "Belum ada history!",
        });
      } else {
        const timeline = $("#timeline");
        timeline.empty();

        $.each(res, function (index, item) {
          const date = new Date(item.tgl_order);

          const dateOrder = date.toLocaleDateString("id-ID", {
            day: "2-digit",
            month: "2-digit",
            year: "numeric",
          });

          const status =
            item.status_order == "selesai"
              ? '<i class="fas fa-check-circle text-success"></i>'
              : '<i class="fas fa-clock"></i>';

          const tambahanSangu =
            item.tambahan_sangu == "0"
              ? ""
              : '<p class="text-capitalize">' +
                item.ket_tambahan_sangu +
                "</p>";

          const timelineItem = `
            <div class="time-label">
                <span class="bg-info" id="timelineDate">${dateOrder}</span>
            </div>
            <div>
              <i class="fas fa-arrow-right bg-info"></i>
              <div class="timeline-item" style="background-color:#484d53">
                <span class="time">
                  ${status}
                </span>
                <h3 class="timeline-header text-uppercase" id="timelineHeader">
                  do : ${item.no_order}
                </h3>
                <div class="timeline-body" id="timelineBody">
                  <div class="table-responsive">
                    <table id="tableTimeline" class="table table-borderless" style="width:100%" celspacing="0">
                      <tr>
                        <th class="align-middle text-uppercase p-1">Customer</th>
                        <th class="align-middle text-uppercase p-1">Asal-Tujuan</th>
                        <th class="align-middle text-uppercase p-1">Muatan</th>
                      </tr>
                      <tr>
                        <td class="align-middle text-uppercase p-1">
                          ${item.nama_cust}
                        </td>
                        <td class="align-middle text-uppercase p-1">
                          ${item.asal_order} - ${item.tujuan_order}
                        </td>
                        <td class="align-middle text-uppercase p-1">
                          ${item.jenis_muatan}
                        </td>
                      </tr>
                      <tr>
                        <th class="align-middle text-uppercase p-1">Plat Nomor</th>
                        <th class="align-middle text-uppercase p-1">Sangu</th>
                        <th class="align-middle text-uppercase p-1">Tambahan</th>
                      </tr>
                      <tr>
                        <td class="align-middle text-uppercase p-1">
                          ${item.platno}
                        </td>
                        <td class="align-middle p-1">
                          Rp. ${format(item.nominal_sangu)}
                        </td>
                        <td class="align-middle p-1">
                          Rp. ${format(item.tambahan_sangu)}
                        </td>
                      </tr>
                    </table>
                      ${tambahanSangu}
                  </div>
                </div>
              </div>
            </div>`;

          timeline.append(timelineItem);
        });

        $("#modalHistory").modal("show");
      }
    },
  });

  $('[data-toggle="tooltip"]').tooltip("hide");
});
