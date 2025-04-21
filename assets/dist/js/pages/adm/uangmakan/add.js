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

  generateKode();

  $("#nominal").on("keypress", function (key) {
    if (key.charCode < 48 || key.charCode > 57) return false;
  });

  $(function () {
    $("#nominal").on("keydown keyup click change blur input", function (e) {
      $(this).val(format($(this).val()));
    });
  });

  function generateKode() {
    $.ajax({
      url: "http://localhost/hira-to-adm/uangmakan/getGenerateKd",
      type: "GET",
      success: function (data) {
        const parsedata = JSON.parse(data);

        $("#kd").val(parsedata);

        $("#nominal").focus();
      },
    });
  }

  let cart = [];

  $(".select-karyawan")
    .select2({
      placeholder: "Pilih Karyawan",
      selectOnClose: false,
      ajax: {
        url: "http://localhost/hira-to-adm/karyawan/getKaryawanList",
        dataType: "JSON",
        delay: 250,
        data: function (params) {
          return {
            q: params.term,
          };
        },
        processResults: function (data) {
          $.each(data, function (index, value) {
            value.text = value.text.toUpperCase();
          });
          return {
            results: data,
          };
        },
        cache: false,
      },
    })
    .on("select2:select", function (e) {
      const data = e.params.data;

      $("#namakry").val(data.text);

      $("#tambah").prop("disabled", false);
    });

  $("button#tambah").on("click", function (e) {
    const idkry = $("#idkry").val();
    const namakry = $("#namakry").val();
    const nominal = $("#nominal").val() === "" ? 0 : $("#nominal").val();

    const dataCart = {
      id: idkry,
      text: namakry,
    };

    const isInCart = cart.some((emp) => emp.id === dataCart.id);

    if (isInCart) {
      Swal.fire({
        icon: "warning",
        title: "Oops!",
        text: "Penerima sudah ada di list!",
      });
    } else {
      cart.push(dataCart);

      const newRow = `
      <tr class="text-center row-cart">
        <td class="text-uppercase nama">
            ${namakry}
            <input type="hidden" name="nama_hidden[]" value="${namakry}">
        </td>
            <input type="hidden" name="id_hidden[]" value="${idkry}">
        <td class="text-right pr-4 nominal">
            ${nominal}
            <input type="hidden" name="nominal_hidden[]" value="${nominal}">
        </td>
        <td class="action">
            <button type="button" class="btn btn-danger border border-light btn-sm" id="tombol-hapus" data-nama="${namakry}" data-id="${idkry}">
              Hapus
            </button>
        </td>
      </tr>
        `;

      $("#cart tbody").append(newRow);

      $(".select-karyawan").val(null).trigger("change");

      $("#tambah").prop("disabled", true);

      $("#total").html("<p class='mb-0'>" + total().toLocaleString() + "</p>");
      $("#total_hidden").val(total());

      $("#tfoot").show();
    }
  });

  $(document).on("click", "#tombol-hapus", function () {
    let idToRemove = $(this).data("id");

    if (typeof idToRemove !== "string") {
      idToRemove = idToRemove.toString();
    }

    cart = cart.filter((item) => item.id !== idToRemove);

    $(this).closest(".row-cart").remove();

    $("#total").html("<p>" + total().toLocaleString() + "</p>");
    $("#total_hidden").val(total());

    $(".select-karyawan").val(null).trigger("change");

    if ($("#tbody").children().length === 0) $("#tfoot").hide();
  });

  function total() {
    let hasil = 0;
    $(".nominal").each(function () {
      hasil += parseFloat(
        $(this)
          .text()
          .replace(/[^\d.]/g, "")
      );
    });

    return hasil;
  }

  // =================form on submit=================
  $("#formSubmit").on("submit", function (e) {
    e.preventDefault();

    let id = [];
    let nominal = [];

    const kd = $("#kd").val();
    const total = $("#total_hidden").val();

    $('input[name="id_hidden[]"]').each(function () {
      const id_hidden = $(this).val();
      id.push(id_hidden);
    });

    $('input[name="nominal_hidden[]"]').each(function () {
      const nominal_hidden = $(this).val();
      nominal.push(nominal_hidden);
    });

    $.ajax({
      url: "http://localhost/hira-to-adm/uangmakan/proses",
      method: "POST",
      data: {
        id: id,
        nominal: nominal,
        total: total,
        kd: kd,
      },
      success: function (response) {
        const parsedRes = JSON.parse(response);

        const resCode = parsedRes.kd_um;
        const resText = parsedRes.text;

        Swal.fire({
          title: resText,
          text: "Cetak List Uangmakan ?",
          icon: "info",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          cancelButtonText: "Batal",
          confirmButtonText: "Ya, Cetak !",
        }).then((result) => {
          if (result.isConfirmed) {
            window.open(
              "http://localhost/hira-to-adm/uangmakan/print" +
                "?nomor=" +
                resCode
            );
          }
          window.location.href = "http://localhost/hira-to-adm/uangmakan";
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

    cart = [];
    id = [];
    nominal = [];

    $(".select-karyawan").val(null).trigger("change");
    $("#namakry").val("");
    $("#nominal").val("");

    $("#cart tbody").empty();
    $("#tfoot").hide();
  });
  // =================form on submit=================
});
