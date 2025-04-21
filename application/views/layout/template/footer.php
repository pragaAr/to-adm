 <footer class="main-footer">
   <strong>Copyright &copy; <?= date('Y') ?>
     <a class="text-light" href="https://hira-express.com" class="text-light">
       Hira Express
     </a>
   </strong>
   Made With 💖
   <div class="float-right d-none d-sm-inline-block">
     <b>
       ver
     </b>
     0.1.0
   </div>
 </footer>

 </div>

 <script src="<?= base_url('assets/') ?>plugins/jquery/jquery.min.js"></script>

 <script src="<?= base_url('assets/') ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

 <script src="<?= base_url('assets/') ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

 <script src="<?= base_url('assets/') ?>dist/js/adminlte.js"></script>

 <script src="<?= base_url('assets/') ?>plugins/datatables/jquery.dataTables.min.js"></script>
 <script src="<?= base_url('assets/') ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
 <script src="<?= base_url('assets/') ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
 <script src="<?= base_url('assets/') ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

 <script src="<?= base_url('assets/') ?>plugins/sweetalert2/sweetalert2.min.js"></script>

 <script src="<?= base_url('assets/') ?>plugins/select2/js/select2.full.min.js"></script>

 <script src="<?= base_url('assets/') ?>dist/js/pages/clock.js"></script>

 <script src="<?= base_url('assets/') ?>dist/js/pages/number-format.js"></script>



 <?php if ($this->uri->segment(1) == 'home') { ?>

   <!-- <script src="<?= base_url('assets/') ?>dist/js/pages/home.js"></script> -->
   <script>
     const userlogin = $(".userlogin").data("flashdata");

     if (userlogin) {
       Swal.fire({
         icon: "success",
         title: "Login berhasil!",
         text: userlogin,
       });
     }
   </script>

 <?php } else if ($this->uri->segment(1) == 'armada') { ?>

   <script src="<?= base_url('assets/') ?>dist/js/pages/master/armada.js"></script>

 <?php } else if ($this->uri->segment(1) == 'customer') { ?>

   <script src="<?= base_url('assets/') ?>dist/js/pages/master/customer.js"></script>

 <?php } else if ($this->uri->segment(1) == 'karyawan') { ?>

   <script src="<?= base_url('assets/') ?>dist/js/pages/master/karyawan.js"></script>

 <?php } else if ($this->uri->segment(1) == 'sopir') { ?>

   <script src="<?= base_url('assets/') ?>dist/js/pages/master/sopir.js"></script>

 <?php } else if ($this->uri->segment(1) == 'user') { ?>

   <script src="<?= base_url('assets/') ?>dist/js/pages/master/user.js"></script>

 <?php } else if ($this->uri->segment(1) == 'uangmakan' && $this->uri->segment(2) == '') { ?>

   <script src="<?= base_url('assets/') ?>dist/js/pages/adm/uangmakan/script.js"></script>

 <?php } else if ($this->uri->segment(1) == 'uangmakan' && $this->uri->segment(2) == 'add') { ?>

   <script src="<?= base_url('assets/') ?>dist/js/pages/adm/uangmakan/add.js"></script>

 <?php } else if ($this->uri->segment(1) == 'order') { ?>

   <script src="<?= base_url('assets/') ?>dist/js/pages/trans/order/script.js"></script>

 <?php } else if ($this->uri->segment(1) == 'sangu') { ?>

   <script src="<?= base_url('assets/') ?>dist/js/pages/adm/sangu/script.js"></script>

 <?php } else if ($this->uri->segment(1) == 'pengeluaran_lain' && $this->uri->segment(2) == '') { ?>

   <script src="<?= base_url('assets/') ?>dist/js/pages/adm/etc/script.js"></script>

 <?php } else if ($this->uri->segment(1) == 'pengeluaran_lain' && $this->uri->segment(2) == 'add') { ?>

   <script src="<?= base_url('assets/') ?>dist/js/pages/adm/etc/add.js"></script>

 <?php } else if ($this->uri->segment(1) == 'penjualan') { ?>

   <script src="<?= base_url('assets/') ?>dist/js/pages/trans/sales/script.js"></script>

 <?php } else if ($this->uri->segment(1) == 'traveldoc' && $this->uri->segment(2) == '') { ?>

   <script src="<?= base_url('assets/') ?>dist/js/pages/trans/traveldoc/script.js"></script>

 <?php } else if ($this->uri->segment(1) == 'traveldoc' && $this->uri->segment(2) == 'add') { ?>

   <script src="<?= base_url('assets/') ?>dist/js/pages/trans/traveldoc/add.js"></script>

 <?php } else if ($this->uri->segment(1) == 'persensopir' && $this->uri->segment(2) == '') { ?>

   <script src="<?= base_url('assets/') ?>dist/js/pages/adm/persen/script.js"></script>

 <?php } else if ($this->uri->segment(1) == 'persensopir' && $this->uri->segment(2) == 'add') { ?>

   <script src="<?= base_url('assets/') ?>dist/js/pages/adm/persen/add.js"></script>

 <?php } else if ($this->uri->segment(1) == 'invoice' && $this->uri->segment(2) == '') { ?>

   <script src="<?= base_url('assets/') ?>dist/js/pages/trans/invoice/script.js"></script>

 <?php } else if ($this->uri->segment(1) == 'invoice' && $this->uri->segment(2) == 'add') { ?>

   <script src="<?= base_url('assets/') ?>dist/js/pages/trans/invoice/add.js"></script>

 <?php } ?>

 </body>

 </html>