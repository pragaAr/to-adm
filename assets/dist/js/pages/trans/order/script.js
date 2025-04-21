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

$("#orderTables").DataTable({
  ordering: true,
  order: [[0, "desc"]],

  initComplete: function () {
    var api = this.api();
    $("#orderTables_filter input")
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
    url: "http://localhost/hira-to-adm/order/getOrder",
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
      data: "nama_sopir",
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
      data: "asal_order",
      className: "text-center align-middle",
      render: function (data, type, row) {
        return data.toUpperCase();
      },
    },
    {
      data: "tujuan_order",
      className: "text-center align-middle",
      render: function (data, type, row) {
        return data.toUpperCase();
      },
    },
    {
      data: "jenis_muatan",
      className: "text-center align-middle",
      render: function (data, type, row) {
        return data.toUpperCase();
      },
    },
    {
      data: "status_order",
      className: "text-center text-capitalize align-middle",
      render: function (data, type, row) {
        if (data === "diproses") {
          return "<button type='button' class='btn border border-info btn-light text-info btn-sm' data-toggle='tooltip' title='Diproses' style='cursor: default;'> <i class='fas fa-clock'></i></button>";
        } else if (data === "selesai") {
          return "<button type='button' class='btn border border-success btn-light text-success btn-sm' data-toggle='tooltip' title='Selesai' style='cursor: default;'> <i class='fas fa-check'></i></button>";
        } else if (data === "disiapkan") {
          return "<button type='button' class='btn border border-warning btn-light text-warning btn-sm' data-toggle='tooltip' title='Disiapkan' style='cursor: default;'> <i class='fas fa-paper-plane'></i></button>";
        }
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

$("#addOrder").on("click", function () {
  $("#modalAddOrder").modal("show");
});

$("#modalAddOrder").on("shown.bs.modal", function () {
  $("#nominal").on("keypress", function (key) {
    if (key.charCode < 48 || key.charCode > 57) return false;
  });

  $(function () {
    $("#nominal").on("keydown keyup click change blur input", function (e) {
      $(this).val(format($(this).val()));
    });
  });

  $(".select-cust")
    .select2({
      placeholder: "Pilih Customer",
      ajax: {
        url: "http://localhost/hira-to-adm/customer/getListCustomer",
        dataType: "json",
        data: function (params) {
          return {
            q: params.term,
          };
        },
        processResults: function (data) {
          return {
            results: data,
          };
        },
      },
    })
    .on("select2:select", function (e) {
      const data = e.params.data;
      $("#namecust").val(data.text);
      $("#notelp").val(data.telp);

      $("#muatan").focus();
    });

  $.ajax({
    url: "http://localhost/hira-to-adm/order/getKdOrder",
    type: "GET",
    dataType: "json",
    success: function (data) {
      $("#ordernumber").val(data);
    },
  });

  $(".select-truck")
    .select2({
      placeholder: "Pilih Truck",
      ajax: {
        url: "http://localhost/hira-to-adm/armada/getListArmadaReady",
        dataType: "json",
        data: function (params) {
          return {
            q: params.term,
          };
        },
        processResults: function (data) {
          return {
            results: data,
          };
        },
      },
    })
    .on("select2:select", function (e) {
      const data = e.params.data;
      $("#platno").val(data.text);
    });

  $(".select-sopir")
    .select2({
      placeholder: "Pilih Sopir",
      ajax: {
        url: "http://localhost/hira-to-adm/sopir/getListSopirAvailable",
        dataType: "json",
        data: function (params) {
          return {
            q: params.term,
          };
        },
        processResults: function (data) {
          return {
            results: data,
          };
        },
      },
    })
    .on("select2:select", function (e) {
      const data = e.params.data;
      $("#namasopir").val(data.text);
    });
});

// addNewCustModal
$("#addNewCust").on("click", function () {
  $("#modalAddOrder").css("z-index", 1040);
  $("#modalAddNewCust").modal("show");
});

$("#modalAddNewCust").on("hide.bs.modal", function () {
  $("#modalAddOrder").css("z-index", 1050);
  $("#namacust").val("");
  $("#kodecust").val("");
  $("#notelpcust").val("");
  $("#alamatcust").val("");
});

$("#modalAddNewCust").on("shown.bs.modal", function () {
  $("#namacust").focus();
});

$("#btn_submitNewCust").on("click", function (e) {
  e.preventDefault();

  const namacust = $("#namacust").val();
  const kodecust = $("#kodecust").val();
  const notelpcust = $("#notelpcust").val();
  const alamatcust = $("#alamatcust").val();

  if (
    namacust === "" ||
    kodecust === "" ||
    notelpcust === "" ||
    alamatcust === ""
  ) {
    Swal.fire({
      icon: "warning",
      title: "Form wjib diisi!",
    });
  } else {
    $.ajax({
      url: "http://localhost/hira-to-adm/customer/addNewSelect",
      method: "POST",
      data: {
        nama: namacust,
        kode: kodecust,
        notelp: notelpcust,
        alamat: alamatcust,
      },
      success: function (response) {
        const res = JSON.parse(response);

        if (res.status != "error") {
          $("#namacust").val("");
          $("#kodecust").val("");
          $("#notelpcust").val("");
          $("#alamatcust").val("");

          Swal.fire({
            icon: "success",
            title: "Success!",
            text: "Customer Baru ditambahkan!",
          });

          const newOption = new Option(
            res.text.toUpperCase(),
            res.id,
            true,
            true
          );

          $("#custid").append(newOption).trigger("change");

          $("#modalAddNewCust").modal("hide");

          $("#namecust").val(res.text);
          $("#notelp").val(res.telp);

          $("#muatan").focus();
        }
      },
    });
  }
});
// addNewCustModal

$("#form_addOrder").on("submit", function (e) {
  e.preventDefault();

  const ordernumber = $("#ordernumber").val();
  const custid = $("#custid").val();
  const namecust = $("#namecust").val();
  const notelp = $("#notelp").val();
  const muatan = $("#muatan").val();
  const asal = $("#asal").val();
  const tujuan = $("#tujuan").val();
  const keterangan = $("#keterangan").val();

  const plat = $("#plat").val();
  const platno = $("#platno").val();
  const sopir = $("#sopir").val();
  const namasopir = $("#namasopir").val();
  const nominal = $("#nominal").val();

  Swal.fire({
    text: "Menyimpan data...",
    showConfirmButton: false,
    allowOutsideClick: false,
    didOpen: () => {
      Swal.showLoading();
    },
  });

  setTimeout(() => {
    $.ajax({
      url: "http://localhost/hira-to-adm/order/add",
      type: "POST",
      data: {
        ordernumber: ordernumber,
        custid: custid,
        namecust: namecust,
        notelp: notelp,
        muatan: muatan,
        asal: asal,
        tujuan: tujuan,
        keterangan: keterangan,

        plat: plat,
        platno: platno,
        sopir: sopir,
        namasopir: namasopir,
        nominal: nominal,
      },
      success: function (data) {
        Swal.close();

        $("#ordernumber").val("");
        $("#custid").val(null).trigger("change");
        $("#namecust").val("");
        $("#notelp").val("");
        $("#muatan").val("");
        $("#asal").val("");
        $("#tujuan").val("");

        $("#plat").val(null).trigger("change");
        $("#platno").val("");
        $("#sopir").val(null).trigger("change");
        $("#namasopir").val("");
        $("#nominal").val("");

        $("#modalAddOrder").modal("hide");

        const parsedData = JSON.parse(data);
        const status = parsedData.status;
        const message = parsedData.message;
        const noorder = parsedData.noorder;

        if (status) {
          Swal.fire({
            title: message,
            text: "Cetak DO ??",
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "Batal",
            confirmButtonText: "Ya, Cetak !",
          }).then((result) => {
            if (result.isConfirmed) {
              window.open(
                "http://localhost/hira-to-adm/order/print" + "?no_do=" + noorder
              );

              setTimeout(function () {
                window.open(
                  "http://localhost/hira-to-adm/sangu/print" +
                    "?no_do=" +
                    noorder
                );
              }, 1000);
            }
          });

          $("#orderTables").DataTable().ajax.reload(null, false);
        } else {
          Swal.fire({
            icon: "error",
            title: "Error!",
            text: message,
          });
        }
      },
    });
  }, 2000);

  return false;
});

$("#modalAddOrder").on("hide.bs.modal", function () {
  $("#ordernumber").val("");
  $("#custid").val(null).trigger("change");
  $("#namecust").val("");
  $("#notelp").val("");
  $("#muatan").val("");
  $("#asal").val("");
  $("#tujuan").val("");
  $("#keterangan").val("");
});

$("#modalUpdateOrder").on("shown.bs.modal", function () {
  $("#nominaledit").on("keypress", function (key) {
    if (key.charCode < 48 || key.charCode > 57) return false;
  });

  $(function () {
    $("#nominaledit").on("keydown keyup click change blur input", function (e) {
      $(this).val(format($(this).val()));
    });
  });
});

$("#orderTables").on("click", ".btn-edit", function (e) {
  const kd = $(this).data("kd");

  $.ajax({
    url: "http://localhost/hira-to-adm/order/getStatusSalesKd",
    type: "POST",
    data: {
      kd: kd,
    },
    success: function (response) {
      const parsedRes = JSON.parse(response);

      if (parsedRes.status === "") {
        $.ajax({
          url: "http://localhost/hira-to-adm/order/getDataKd",
          type: "POST",
          data: {
            kd: kd,
          },
          success: function (data) {
            const parsedata = JSON.parse(data);
            const custid = parsedata.customer_id;
            const truckid = parsedata.truck_id;
            const sopirid = parsedata.sopir_id;
            $("#oldtruckid").val(parsedata.truck_id);
            $("#oldsopirid").val(parsedata.sopir_id);
            $("#ordernumberedit").val(parsedata.no_order);
            $("#notelpedit").val(parsedata.kontak_order);
            $("#muatanedit").val(parsedata.jenis_muatan);
            $("#asaledit").val(parsedata.asal_order);
            $("#tujuanedit").val(parsedata.tujuan_order);
            $("#keteranganedit").val(parsedata.keterangan);
            $("#nominaledit").val(format(parsedata.nominal));
            $.ajax({
              url: "http://localhost/hira-to-adm/customer/getListCustomer",
              type: "GET",
              dataType: "json",
              success: function (custData) {
                const custedit = $(".select-custedit")
                  .select2({
                    placeholder: "Pilih Customer",
                    data: custData,
                  })
                  .on("select2:select", function (e) {
                    const data = e.params.data;
                    $("#notelpedit").val(data.telp);
                  });
                $.each(custData, function (i, cust) {
                  if (cust.id === custid) {
                    custedit.val(cust.id).trigger("change");
                    return false;
                  }
                });
              },
            });
            $.ajax({
              url: "http://localhost/hira-to-adm/order/getSelectedArmadaReady",
              type: "GET",
              data: { armada_id: truckid },
              dataType: "json",
              success: function (truckData) {
                const truckedit = $(".select-truckedit").select2({
                  placeholder: "Pilih Truck",
                  data: truckData,
                });
                $.each(truckData, function (i, truck) {
                  if (truck.id === truckid) {
                    truckedit.val(truck.id).trigger("change");
                    return false;
                  }
                });
              },
            });
            $.ajax({
              url: "http://localhost/hira-to-adm/order/getSelectedSopirAvailable",
              type: "GET",
              data: { sopir_id: sopirid },
              dataType: "json",
              success: function (sopirData) {
                const sopiredit = $(".select-sopiredit").select2({
                  placeholder: "Pilih Sopir",
                  data: sopirData,
                });
                $.each(sopirData, function (i, sopir) {
                  if (sopir.id === sopirid) {
                    sopiredit.val(sopir.id).trigger("change");
                    return false;
                  }
                });
              },
            });
          },
        });

        $("#modalUpdateOrder").modal("show");
      } else {
        Swal.fire({
          icon: "info",
          title: "Order sudah " + parsedRes.status,
          text: "Silahkan hapus data di penjualan dahulu!",
        });
      }

      $('[data-toggle="tooltip"]').tooltip("hide");
    },
  });
});

$("#form_updateOrder").on("submit", function (e) {
  e.preventDefault();

  const ordernumber = $("#ordernumberedit").val();
  const custid = $("#custidedit").val();
  const notelp = $("#notelpedit").val();
  const muatan = $("#muatanedit").val();
  const asal = $("#asaledit").val();
  const tujuan = $("#tujuanedit").val();
  const keterangan = $("#keteranganedit").val();

  const plat = $("#platedit").val();
  const oldplat = $("#oldtruckid").val();
  const sopir = $("#sopiredit").val();
  const oldsopir = $("#oldsopirid").val();
  const nominal = $("#nominaledit").val();

  Swal.fire({
    text: "Mengupdate data...",
    showConfirmButton: false,
    allowOutsideClick: false,
    didOpen: () => {
      Swal.showLoading();
    },
  });

  setTimeout(() => {
    $.ajax({
      url: "http://localhost/hira-to-adm/order/update",
      type: "POST",
      data: {
        ordernumber: ordernumber,
        custid: custid,
        notelp: notelp,
        muatan: muatan,
        asal: asal,
        tujuan: tujuan,
        keterangan: keterangan,

        plat: plat,
        oldplat: oldplat,
        sopir: sopir,
        oldsopir: oldsopir,
        nominal: nominal,
      },
      success: function (data) {
        const parsedData = JSON.parse(data);
        const status = parsedData.status;
        const message = parsedData.message;

        Swal.close();

        $("#ordernumberedit").val("");
        $("#custidedit").val(null).trigger("change");
        $("#notelpedit").val("");
        $("#muatanedit").val("");
        $("#asaledit").val("");
        $("#tujuanedit").val("");

        $("#platedit").val(null).trigger("change");
        $("#sopiredit").val(null).trigger("change");
        $("#nominaledit").val("");

        $("#modalUpdateOrder").modal("hide");

        Swal.fire({
          icon: status ? "success" : "error",
          title: status ? "Success!" : "Error!",
          text: message,
        }).then(() => {
          if (status) {
            $("#orderTables").DataTable().ajax.reload(null, false);
          }
        });
      },
      error: function () {
        Swal.close();
        Swal.fire({
          icon: "error",
          title: "Gagal!",
          text: "Terjadi kesalahan saat menghubungi server.",
        });
      },
    });
  }, 2000);

  return false;
});

$("#orderTables").on("click", ".btn-detail", function () {
  const kd = $(this).data("kd");

  $.ajax({
    url: "http://localhost/hira-to-adm/order/getDetail",
    type: "POST",
    dataType: "json",
    data: {
      kd: kd,
    },
    success: function (data) {
      $("#btnDetail").attr(
        "href",
        "http://localhost/hira-to-adm/order/print" + "?no_do=" + data.no_order
      );

      const formatedDate = new Date(data.dateAdd);

      $(".noorder").text(data.no_order);
      $(".muatan").text(data.jenis_muatan);
      $(".cust").text(data.nama_customer);
      $(".kontak").text(data.kontak_order);
      $(".asal").text(data.asal_order);
      $(".tujuan").text(data.tujuan_order);
      $(".tgl").text(
        formatedDate.toLocaleDateString("id-ID", {
          day: "2-digit",
          month: "2-digit",
          year: "numeric",
        })
      );

      $(".truck").text(data.platno);
      $(".supir").text(data.nama_sopir);
      $(".nominal").text("Rp. " + format(data.nominal));

      const tfoot = $("#tfoot_detailOrder");

      if (data.keterangan == "") {
        tfoot.css("display", "none");
      } else {
        tfoot.css("display", "table-footer-group");
        $(".keterangan").text(data.keterangan);
      }

      $("#modalDetailOrder").modal("show");

      $('[data-toggle="tooltip"]').tooltip("hide");
    },
  });
});

$("#orderTables").on("click", ".btn-delete", function () {
  const kd = $(this).data("kd");

  $.ajax({
    url: "http://localhost/hira-to-adm/order/getStatusSalesKd",
    type: "POST",
    data: {
      kd: kd,
    },
    success: function (response) {
      const parsedRes = JSON.parse(response);

      if (parsedRes.status === "") {
        Swal.fire({
          title: "Apakah anda yakin ?",
          text: "Data yang terkait akan di hapus !!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          cancelButtonText: "Batal",
          confirmButtonText: "Ya, Hapus !",
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire({
              text: "Mohon tunggu...",
              showConfirmButton: false,
              showConfirmButton: false,
              allowOutsideClick: false,
              allowEscapeKey: false,
              didOpen: () => {
                Swal.showLoading();
              },
            });

            setTimeout(() => {
              $.ajax({
                url: "http://localhost/hira-to-adm/order/delete",
                method: "POST",
                data: { kd: kd },
                success: function (data) {
                  const parsedData = JSON.parse(data);
                  const status = parsedData.status;
                  const message = parsedData.message;

                  Swal.fire({
                    icon: status ? "success" : "error",
                    title: status ? "Success!" : "Error!",
                    text: message,
                  }).then(() => {
                    if (status) {
                      $("#orderTables").DataTable().ajax.reload(null, false);
                    }
                  });
                },
              });
            }, 2000);
          }
        });
      } else {
        Swal.fire({
          icon: "info",
          title: "Order sudah " + parsedRes.status,
          text: "Silahkan hapus data di penjualan dahulu!",
        });
      }

      $('[data-toggle="tooltip"]').tooltip("hide");
    },
  });
});

$("#orderTables").on("click", ".btn-update", function () {
  const kd = $(this).data("kd");

  $.ajax({
    url: "http://localhost/hira-to-adm/order/getDataKd",
    method: "POST",
    data: { kd: kd },
    success: function (data) {
      const parsedData = JSON.parse(data);

      const id = parsedData.order_id;
      const no = parsedData.no_order;

      Swal.fire({
        title: "Apakah anda yakin ?",
        text: "Status akan di update !!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Batal",
        confirmButtonText: "Ya, Update !",
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
            text: "Mengupdate status...",
            showConfirmButton: false,
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
              Swal.showLoading();
            },
          });

          setTimeout(() => {
            $.ajax({
              url: "http://localhost/hira-to-adm/order/updateStatus",
              method: "POST",
              data: {
                id: id,
                no: no,
              },
              success: function (data) {
                const parsedData = JSON.parse(data);
                const status = parsedData.status;
                const message = parsedData.message;

                Swal.fire({
                  icon: status ? "success" : "error",
                  title: status ? "Success!" : "Error!",
                  text: message,
                }).then(() => {
                  if (status) {
                    $("#orderTables").DataTable().ajax.reload(null, false);
                  }
                });
              },
              error: function () {
                Swal.fire({
                  icon: "error",
                  title: "Gagal!",
                  text: "Terjadi kesalahan saat menghubungi server.",
                });
              },
            });
          }, 2000);
        }
      });
    },
  });
});

$("#orderTables").on("click", ".btn-print", function () {
  const kd = $(this).data("kd");

  $.ajax({
    url: "http://localhost/hira-to-adm/order/getDataKd",
    method: "POST",
    dataType: "JSON",
    data: {
      kd: kd,
    },
    success: function (data) {
      Swal.fire({
        title: "Cetak DO ?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Batal",
        confirmButtonText: "Ya, Cetak !",
      }).then((result) => {
        if (result.isConfirmed) {
          window.open(
            "http://localhost/hira-to-adm/order/print" +
              "?no_do=" +
              data.no_order
          );
        }
      });

      $('[data-toggle="tooltip"]').tooltip("hide");
    },
  });
});

$(document).on("select2:open", () => {
  document
    .querySelector(".select2-container--open .select2-search__field")
    .focus();
});
