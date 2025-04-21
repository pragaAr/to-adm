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

  $("#nominal").on("keypress", function (key) {
    if (key.charCode < 48 || key.charCode > 57) return false;
  });

  $(function () {
    $("#nominal").on("keydown keyup click change blur input", function (e) {
      $(this).val(format($(this).val()));
    });
  });

  generateKode();

  $(".select-kry")
    .select2({
      placeholder: "PILIH KARYAWAN",
      ajax: {
        url: "http://localhost/hira-to-adm/karyawan/getKaryawanList",
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
      $("#selectedKry").val(e.params.data.text);
    });

  $("button#tambah").on("click", function (e) {
    const keperluan = $("#keperluan").val();
    const jmlitem = $("#item").val() ? $("#item").val() : 0;
    const nominal = $("#nominal").val()
      ? $("#nominal")
          .val()
          .replace(/[^\d.]/g, "")
      : 0;
    const formatedNominal = format(nominal);

    const newRow = `
          <tr class="cart text-center">
            <td class="text-uppercase rc">
                ${keperluan}
                <input type="hidden" name="keperluan_hidden[]" value="${keperluan}">
            </td>
            <td class="text-uppercase jmlitem">
                ${jmlitem}
                <input type="hidden" name="jmlitem_hidden[]" value="${jmlitem}">
            </td>
            <td class="text-uppercase text-right pr-4 nominal">
                ${formatedNominal}
                <input type="hidden" name="nominal_hidden[]" value="${nominal}">
            </td>
            <td class="aksi">
              <button type="button" class="btn btn-danger btn-sm border border-light" id="tombol-hapus" data-keperluan="${keperluan}">
                Hapus
              </button>
            </td>
          </tr>
  	`;

    $("#cart tbody").append(newRow);
    $("#tfoot").show();

    $("#keperluan").val("");
    $("#item").val("");
    $("#nominal").val("");

    $("#total").html("<span>" + total().toLocaleString() + "</span>");
    $("#total_hidden").val(total());
    $("#keperluan").focus();
  });

  $(document).on("click", "#tombol-hapus", function () {
    $(this).closest(".cart").remove();

    $("#total").html("<span>" + total().toLocaleString() + "</span>");
    $("#total_hidden").val(total());

    if ($("#tbody").children().length === 0) $("#tfoot").hide();
  });

  $("#formSubmit").on("submit", function (e) {
    e.preventDefault();

    let arrKeperluan = [];
    let arrItem = [];
    let arrNominal = [];

    const kode = $("#kode").val();
    const karyawan = $("#karyawan").val();
    const tanggal = $("#tanggal").val();
    const total = $("#total_hidden").val();

    $('input[name="keperluan_hidden[]"]').each(function () {
      const keperluan_hidden = $(this).val();
      arrKeperluan.push(keperluan_hidden);
    });

    $('input[name="jmlitem_hidden[]"]').each(function () {
      const jmlitem_hidden = $(this).val();
      arrItem.push(jmlitem_hidden);
    });

    $('input[name="nominal_hidden[]"]').each(function () {
      const nominal_hidden = $(this).val();
      arrNominal.push(nominal_hidden);
    });

    $.ajax({
      url: "http://localhost/hira-to-adm/pengeluaran_lain/proses",
      method: "POST",
      data: {
        keperluan: arrKeperluan,
        item: arrItem,
        nominal: arrNominal,
        kode: kode,
        karyawan: karyawan,
        tanggal: tanggal,
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
              "http://localhost/hira-to-adm/pengeluaran_lain/print" +
                "?nomor=" +
                resCode
            );
          }
          window.location.href =
            "http://localhost/hira-to-adm/pengeluaran_lain";
        });
      },
    });

    arrKeperluan = [];
    arrItem = [];
    arrNominal = [];

    $("#kode").val("");
    $("#karyawan").val("");
    $("#tanggal").val("");

    $("#cart tbody").empty();
    $("#tfoot").hide();
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

  function generateKode() {
    $.ajax({
      url: "http://localhost/hira-to-adm/pengeluaran_lain/getKode",
      type: "POST",
      dataType: "json",
      success: function (data) {
        $("#kode").val(data);
      },
    });
  }
});
