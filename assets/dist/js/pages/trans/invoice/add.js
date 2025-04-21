$(document).ready(function () {
  $("#tfoot").hide();

  $(document).keypress(function (e) {
    if (e.which == "13") {
      e.preventDefault();
    }
  });

  $(document).on("select2:open", () => {
    document
      .querySelector(".select2-container--open .select2-search__field")
      .focus();
  });

  let cartInvoice = [];

  $(".select-pengirim")
    .select2({
      placeholder: "PILIH CUSTOMER",
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

      $("#selectedCust").val(data.text);
      $("#selectedKodeCust").val(data.kode);

      $.ajax({
        url: "http://localhost/hira-to-adm/penjualan/getListCustomerReccu",
        type: "POST",
        dataType: "json",
        data: {
          cust: data.text,
        },
        success: function (data) {
          if (data.length === 0) {
            $("#reccu").empty();
            $(".select-reccu").val(null).trigger("change");
          } else {
            let html = "";
            for (let count = 0; count < data.length; count++) {
              html +=
                '<option value="' +
                data[count].reccu +
                '">' +
                data[count].reccu.toUpperCase() +
                "</option>";
            }
            $("#reccu").empty();

            $("#reccu").append(html);

            $(".select-reccu").val(null).trigger("change");

            resetOther();
          }
        },
      });
    });

  $(".select-reccu")
    .select2({
      placeholder: "PILIH RECCU",
    })
    .on("select2:select", function (e) {
      const selectedReccu = e.params.data.id;

      let dataCart = {
        id: selectedReccu,
        text: selectedReccu,
      };

      const isInCart = cartInvoice.some((emp) => emp.id === selectedReccu);

      if (isInCart) {
        Swal.fire({
          icon: "warning",
          title: "Oops!",
          text: "Reccu sudah dipilih!",
        });
      } else {
        cartInvoice.push(dataCart);

        $.ajax({
          url: "http://localhost/hira-to-adm/penjualan/getListReccuForTravelDoc",
          type: "POST",
          dataType: "json",
          data: {
            reccu: selectedReccu,
          },
          success: function (data) {
            $("#selectedReccu").val(data.reccu);
            $("#selectedOrder").val(data.no_order);
            $("#jenis").val(data.jenis);
            $("#berat").val(data.berat);
            $("#penerima").val(data.penerima);
            $("#hrgkg").val(format(data.hrg_kg));
            $("#hrgbrg").val(format(data.hrg_borong));
            $("#tothrg").val(format(data.total_hrg));
          },
          error: function (xhr, status, error) {
            console.error("Error:", error);
          },
        });

        $.ajax({
          url: "http://localhost/hira-to-adm/traveldoc/getDataByReccu",
          type: "POST",
          dataType: "json",
          data: {
            reccu: selectedReccu,
          },
          success: function (data) {
            if (data.length === 0) {
              Swal.fire({
                icon: "error",
                title: "Silahkan pilih Reccu lain!",
                text: "Tidak ada data Surat Jalan!",
              });
            } else {
              $.each(data, function (index, item) {
                const newRow = `
                  <tr class="cart text-center">
                    <input type="hidden" name="noorder_hidden[]" value="${item.no_order}">
                    <td class="text-uppercase rc">
                        ${item.reccu}
                        <input type="hidden" name="rc_hidden[]" value="${item.reccu}">
                    </td>
                    <td class="text-uppercase sj">
                        ${item.surat_jalan}
                        <input type="hidden" name="sj_hidden[]" value="${item.surat_jalan}">
                    </td>
                    <td class="text-uppercase berat">
                        ${item.berat}
                        <input type="hidden" name="berat_hidden[]" value="${item.berat}">
                    </td>
                    <td class="aksi">
                      <button type="button" class="btn btn-danger btn-sm border border-light" id="tombol-hapus" data-sj="${item.reccu}" data-id="${item.reccu}">
                        Hapus
                      </button>
                    </td>
                  </tr>
                `;

                $("#cart tbody").append(newRow);
              });

              $("#tgl").focus();

              $("#pengirim").prop("disabled", true);
              $("#tfoot").show();
            }
          },
          error: function (xhr, status, error) {
            console.error("Error:", error);
          },
        });
      }
    });

  $(document).on("click", "#tombol-hapus", function () {
    let idToRemove = $(this).data("id");

    if (typeof idToRemove !== "string") {
      idToRemove = idToRemove.toString();
    }

    cartInvoice = cartInvoice.filter((item) => item.id !== idToRemove);

    $('[data-id="' + idToRemove + '"]')
      .closest(".cart")
      .remove();

    if ($("#tbody").children().length === 0) {
      $("#tfoot").hide();
      $("#pengirim").prop("disabled", false);
    }

    resetOther();
  });

  // =================form on submit=================
  $("#formSubmit").on("submit", function (e) {
    e.preventDefault();

    let noorderInvoice = [];
    let rcInvoice = [];
    let sjInvoice = [];
    let valberatInvoice = [];

    const tgl = $("#tgl").val();
    const noinv = $("#noinv").val();
    const custid = $("#pengirim").val();
    const selectedCust = $("#selectedCust").val();
    const selectedKodeCust = $("#selectedKodeCust").val();

    $('input[name="noorder_hidden[]"]').each(function () {
      const noorder_hidden = $(this).val();
      noorderInvoice.push(noorder_hidden);
    });

    $('input[name="rc_hidden[]"]').each(function () {
      const rc_hidden = $(this).val();
      rcInvoice.push(rc_hidden);
    });

    $('input[name="sj_hidden[]"]').each(function () {
      const sj_hidden = $(this).val();
      sjInvoice.push(sj_hidden);
    });

    $('input[name="berat_hidden[]"]').each(function () {
      const berat_hidden = $(this).val();
      valberatInvoice.push(berat_hidden);
    });

    $.ajax({
      url: "http://localhost/hira-to-adm/invoice/proses",
      method: "POST",
      data: {
        tgl: tgl,
        noinv: noinv,
        pengirim: custid,
        noorder: noorderInvoice,
        rc: rcInvoice,
        sj: sjInvoice,
        valberat: valberatInvoice,
        selectedCust: selectedCust,
        selectedKodeCust: selectedKodeCust,
      },
      success: function (response) {
        const parsedRes = JSON.parse(response);

        const text = parsedRes.text;
        const no = parsedRes.nomorinv;

        Swal.fire({
          title: text,
          text: "Cetak Invoice ?",
          icon: "info",
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
              no +
              "&ppn=" +
              ppn;
            window.open(url);
          }
          window.location.href = "http://localhost/hira-to-adm/invoice";
        });
      },
    });

    cartInvoice = [];
    noorderInvoice = [];
    rcInvoice = [];
    sjInvoice = [];
    valberatInvoice = [];

    reset();
  });
  // =================form on submit=================

  function resetOther() {
    $(".select-reccu").val(null).trigger("change");
    $("#selectedReccu").val("");
    $("#selectedOrder").val("");
    $("#penerima").val("");
    $("#jenis").val("");
    $("#berat").val("");
    $("#hrgkg").val("");
    $("#hrgbrg").val("");
    $("#tothrg").val("");
  }

  function reset() {
    $(".select-pengirim").val(null).trigger("change");
    $(".select-pengirim").prop("disabled", false);
    $(".select-reccu").val(null).trigger("change");
    $("#selectedReccu").val("");
    $("#selectedOrder").val("");
    $("#selectedCust").val("");
    $("#selectedKodeCust").val("");
    $("#penerima").val("");
    $("#jenis").val("");
    $("#berat").val("");
    $("#hrgkg").val("");
    $("#hrgbrg").val("");
    $("#tothrg").val("");

    $("#cart tbody").empty();
    $("#tfoot").hide();
  }
});

document.getElementById("tgl").addEventListener("click", function (event) {
  this.showPicker ? this.showPicker() : this.click();
});