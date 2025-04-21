<script src="<?= base_url('assets/') ?>plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/') ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets/') ?>plugins/sweetalert2/sweetalert2.min.js"></script>

<script src="<?= base_url('assets/') ?>dist/js/adminlte.min.js"></script>

<script>
  const flashrole = $('.flashrole').data('flashdata');

  if (flashrole) {
    Swal.fire({
      icon: 'error',
      title: 'Eheemmm!!',
      text: flashrole,
    });
  }

  const wrongdata = $('.wrongdata').data('flashdata');

  if (wrongdata) {
    Swal.fire({
      icon: 'error',
      title: 'Ops!',
      text: wrongdata,
    });
  }

  const userlogout = $('.userlogout').data('flashdata');

  if (userlogout) {
    Swal.fire({
      icon: 'success',
      title: 'Anda telah keluar',
      text: userlogout,
    });
  }

  const registered = $('.registered').data('flashdata');

  if (registered) {
    Swal.fire({
      icon: 'success',
      title: 'Anda telah terdaftar',
      text: registered,
    });
  }
</script>
</body>

</html>