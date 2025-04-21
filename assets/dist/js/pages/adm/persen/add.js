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

  $("#persen1").on("keypress", function (key) {
    if (key.charCode < 48 || key.charCode > 57) return false;
  });

  $("#persen2").on("keypress", function (key) {
    if (key.charCode < 48 || key.charCode > 57) return false;
  });

  generateKode();

  function generateKode() {
    $.ajax({
      url: "http://localhost/hira-to-adm/persensopir/getGenerateKd",
      type: "GET",
      success: function (data) {
        const parsedata = JSON.parse(data);

        $("#kd").val(parsedata);
      },
    });
  }

  let cartPersen = [];

  $(".select-sopir")
    .select2({
      placeholder: "PILIH SOPIR",
      ajax: {
        url: "http://localhost/hira-to-adm/sopir/getListSopir",
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
      reset();

      const data = e.params.data;

      $("#namasopir").val(data.text);

      $.ajax({
        url: "http://localhost/hira-to-adm/order/getOrderBySopir",
        type: "POST",
        dataType: "json",
        data: {
          sopir: data.id,
        },
        success: function (data) {
          if (data.length === 0) {
            $("#noorder").empty();
            $(".select-noorder").val(null).trigger("change");
          } else {
            let html = "";
            for (let count = 0; count < data.length; count++) {
              html +=
                '<option value="' +
                data[count].no_order +
                '">' +
                data[count].no_order.toUpperCase() +
                "</option>";
            }
            $("#noorder").empty();

            $("#noorder").append(html);

            $(".select-noorder").val(null).trigger("change");
          }
        },
      });
    });

  $(".select-noorder")
    .select2({
      placeholder: "PILIH NO ORDER",
    })
    .on("select2:select", function (e) {
      const selectedNoOrder = e.params.data.id;

      const isInCart = cartPersen.some((emp) => emp.id === selectedNoOrder);

      if (isInCart) {
        Swal.fire({
          icon: "warning",
          title: "Oops!",
          text: "No Order sudah ada di list!",
        });

        $(".select-noorder").val(null).trigger("change");
      } else {
        $.ajax({
          url: "http://localhost/hira-to-adm/order/getOrderPenjualanDetail",
          type: "POST",
          dataType: "json",
          data: {
            noorder: selectedNoOrder,
          },
          success: function (data) {
            if (data === null) {
              Swal.fire({
                icon: "warning",
                title: "Oops!",
                text:
                  "Tidak ditemukan data penjualan dari " +
                  selectedNoOrder.toUpperCase(),
              });

              $(".select-noorder").val(null).trigger("change");
            } else {
              $("#platno").val(data.platno);
              $("#pengirim").val(data.pengirim);
              $("#penerima").val(data.penerima);
              $("#muatan").val(data.muatan);
              $("#asaltujuan").val(data.kota_asal + "-" + data.kota_tujuan);
              $("#totharga").val(format(data.total_hrg));
              $("#sangu").val(format(data.sangu));
              $("#tambahan").val(format(data.tambahan));
              const s = parseFloat(data.sangu);
              const t = parseFloat(data.tambahan);
              $("#totsangu").val(format(s + t));

              $("#persen1").focus();
            }
          },
          error: function (xhr, status, error) {
            console.error("Error:", error);
          },
        });
      }
    });

  $("#persen1").on("input keyup change", function () {
    $("#biayaxpersen").val(hitungDiterima());
  });

  $("#persen2").on("input keyup change", function () {
    $("#biayaxpersen").val(hitungDiterima());
  });

  $("button#tambah").on("click", function (e) {
    const noorder = $("#noorder").val();
    const platno = $("#platno").val();

    const dataCart = {
      id: noorder,
      text: noorder,
    };

    const isInCart = cartPersen.some((emp) => emp.id === dataCart.id);

    if (isInCart) {
      Swal.fire({
        icon: "warning",
        title: "Oops!",
        text: "No Order sudah ada di list!",
      });

      $(".select-noorder").val(null).trigger("change");
    } else {
      cartPersen.push(dataCart);

      const totharga = $("#totharga")
        .val()
        .replace(/[^\d.]/g, "");
      const persen1 = $("#persen1").val() === "" ? 0 : $("#persen1").val();
      const persen2 = $("#persen2").val() === "" ? 0 : $("#persen2").val();
      const totsangu = $("#totsangu")
        .val()
        .replace(/[^\d.]/g, "");

      const biayaxpersen = $("#biayaxpersen")
        .val()
        .replace(/[^\d.]/g, "");

      const diterima = parseFloat(biayaxpersen) - parseFloat(totsangu);

      const formatedTotHarga = format(totharga);
      const formatedTotSangu = format(totsangu);
      const formatedDiterima = format(diterima);

      const newRow = `
        <tr class="text-center row-cart">
          <td class="text-uppercase noorder">
            ${noorder}
            <input type="hidden" name="noorder_hidden[]" value="${noorder}">
            <input type="hidden" name="platno_hidden[]" value="${platno}">
          </td>
          <td class="text-right pr-4 totharga">
            ${formatedTotHarga}
            <input type="hidden" name="totharga_hidden[]" value="${totharga}">
          </td>
          <td class="persen1">
            ${persen1}
            <input type="hidden" name="persen1_hidden[]" value="${persen1}">
          </td>
          <td class="persen2">
            ${persen2}
            <input type="hidden" name="persen2_hidden[]" value="${persen2}">
          </td>
          <td class="text-right pr-4 totsangu">
            ${formatedTotSangu}
            <input type="hidden" name="totsangu_hidden[]" value="${totsangu}">
          </td>
          <td class="text-right pr-4 diterima">
            ${formatedDiterima}
            <input type="hidden" name="diterima_hidden[]" value="${diterima}">
          </td>
          <td class="action">
            <button type="button" class="btn btn-danger border border-light btn-sm" id="tombol-hapus" data-noorder="${noorder}">
              Hapus
            </button>
          </td>
        </tr>
      `;

      $("#cart tbody").append(newRow);

      $(".select-noorder").val(null).trigger("change");
      $("#tambah").prop("disabled", true);
      $("#total").html(
        "<span>" + total_diterima().toLocaleString() + "</span>"
      );
      $("#total_hidden").val(total_diterima());
      $("#tfoot").show();

      reset();
    }
  });

  $(document).on("click", "#tombol-hapus", function () {
    const noOrderToRemove = $(this).data("noorder");

    cartPersen = cartPersen.filter((item) => item.id !== noOrderToRemove);

    $(this).closest(".row-cart").remove();

    $(".select-noorder").val(null).trigger("change");
    $("#tambah").prop("disabled", true);
    $("#total").html("<span>" + total_diterima().toLocaleString() + "</span>");
    $("#total_hidden").val(total_diterima());

    if ($("#tbody").children().length === 0) $("#tfoot").hide();
  });

  $("#formSubmit").on("submit", function (e) {
    e.preventDefault();

    let arrNoOrder = [];
    let arrPlatNo = [];
    let arrTotHarga = [];
    let arrPersen1 = [];
    let arrPersen2 = [];
    let arrTotSangu = [];
    let arrDiterima = [];

    const kd = $("#kd").val();
    const sopirId = $("#sopirid").val();
    const total = $("#total_hidden").val();

    $('input[name="noorder_hidden[]"]').each(function () {
      const noorder_hidden = $(this).val();
      arrNoOrder.push(noorder_hidden);
    });

    $('input[name="platno_hidden[]"]').each(function () {
      const platno_hidden = $(this).val();
      arrPlatNo.push(platno_hidden);
    });

    $('input[name="totharga_hidden[]"]').each(function () {
      const totharga_hidden = $(this).val();
      arrTotHarga.push(totharga_hidden);
    });

    $('input[name="persen1_hidden[]"]').each(function () {
      const persen1_hidden = $(this).val();
      arrPersen1.push(persen1_hidden);
    });

    $('input[name="persen2_hidden[]"]').each(function () {
      const persen2_hidden = $(this).val();
      arrPersen2.push(persen2_hidden);
    });

    $('input[name="totsangu_hidden[]"]').each(function () {
      const totsangu_hidden = $(this).val();
      arrTotSangu.push(totsangu_hidden);
    });

    $('input[name="diterima_hidden[]"]').each(function () {
      const diterima_hidden = $(this).val();
      arrDiterima.push(diterima_hidden);
    });

    $.ajax({
      url: "http://localhost/hira-to-adm/persensopir/proses",
      method: "POST",
      data: {
        noorder: arrNoOrder,
        platno: arrPlatNo,
        totharga: arrTotHarga,
        persen1: arrPersen1,
        persen2: arrPersen2,
        totsangu: arrTotSangu,
        diterima: arrDiterima,
        kd: kd,
        sopirid: sopirId,
        total: total,
      },
      success: function (response) {
        const parsedRes = JSON.parse(response);

        const resCode = parsedRes.kd;
        const resText = parsedRes.text;

        Swal.fire({
          title: resText,
          text: "Cetak pengeluaran kas ?",
          icon: "info",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          cancelButtonText: "Batal",
          confirmButtonText: "Ya, Cetak !",
        }).then((result) => {
          if (result.value) {
            window.open(
              "http://localhost/hira-to-adm/persensopir/print" +
                "?kode=" +
                resCode
            );
          }
          window.location.href = "http://localhost/hira-to-adm/persensopir";
        });
      },
    });

    cartPersen = [];
    arrNoOrder = [];
    arrPlatNo = [];
    arrTotHarga = [];
    arrPersen1 = [];
    arrPersen2 = [];
    arrTotSangu = [];
    arrDiterima = [];

    reset();

    $(".select-sopir").val(null).trigger("change");

    $("#cart tbody").empty();
    $("#tfoot").hide();
  });

  function hitungDiterima() {
    let valTotHarga = $("#totharga")
      .val()
      .replace(/[^\d.]/g, "");
    let valPersen1 = $("#persen1")
      .val()
      .replace(/[^\d.]/g, "");
    let valPersen2 = $("#persen2")
      .val()
      .replace(/[^\d.]/g, "");

    let persen1 = parseFloat(valPersen1 / 100);
    let persen2 = parseFloat(valPersen2 / 100);
    let biaya = parseFloat(valTotHarga);

    if (persen1 === 0 && persen2 === 0) {
      let biayaXpersen = parseFloat(biaya);
      $("#tambah").prop("disabled", false);

      return format(biayaXpersen);
    } else if (persen1 !== 0 && persen2 === 0) {
      let biayaXpersen = parseFloat(biaya * persen1);
      $("#tambah").prop("disabled", false);

      return format(biayaXpersen);
    } else if (persen1 === 0 && persen2 !== 0) {
      let biayaXpersen = parseFloat(biaya * persen2);
      $("#tambah").prop("disabled", false);

      return format(biayaXpersen);
    } else if (persen1 !== 0 && persen2 !== 0) {
      let biayaXpersen = parseFloat(biaya * persen1 * persen2);
      $("#tambah").prop("disabled", false);

      return format(Math.ceil(biayaXpersen));
    }
  }

  function total_diterima() {
    let hasil = 0;
    $(".diterima").each(function () {
      hasil += parseFloat(
        $(this)
          .text()
          .replace(/[^\d.]/g, "")
      );
    });

    return Math.ceil(hasil);
  }

  function reset() {
    $("#platno").val("");
    $("#pengirim").val("");
    $("#penerima").val("");
    $("#muatan").val("");
    $("#asaltujuan").val("");
    $("#totharga").val("0");
    $("#sangu").val("0");
    $("#tambahan").val("0");
    $("#totsangu").val("0");
    $("#persen1").val("0");
    $("#persen2").val("0");
    $("#biayaxpersen").val("0");
  }
});
