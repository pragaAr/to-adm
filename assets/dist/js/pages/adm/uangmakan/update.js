$(document).ready(function () {
  let cart = [];

  const kd = $("#kd").val();

  $.ajax({
    url: "http://localhost/hira-to-adm/uangmakan/getDetailData",
    method: "POST",
    data: { kd: kd },
    success: function (data) {
      const resdetail = JSON.parse(data);
      console.log(resdetail);

      cart = resdetail.map((resdetail) => ({
        id: resdetail.karyawan_id,
        selected: true,
      }));

      console.log(cart);
    },
    error: function (xhr, status, error) {
      console.error(error);
    },
  });

  $("#nominal").on("keypress", function (key) {
    if (key.charCode < 48 || key.charCode > 57) return false;
  });

  $(function () {
    $("#nominal").on("keydown keyup click change blur input", function (e) {
      $(this).val(format($(this).val()));
    });
  });
});
