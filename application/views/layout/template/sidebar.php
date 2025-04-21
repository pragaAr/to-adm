 <aside class="main-sidebar sidebar-dark-primary elevation-4">
   <a href="<?= base_url('home') ?>" class="brand-link">
     <img src="<?= base_url('assets/') ?>dist/img/logo-sm.png" alt="Hira Logo Sm" class="brand-image img-circle" style="opacity: .8">
     <span class="brand-text font-weight-bold ml-3">Hira Express</span>
   </a>

   <div class="sidebar">
     <nav class="mt-2">
       <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

         <li class="nav-item">
           <a href=" <?= base_url('home') ?>" class="nav-link <?= $this->uri->segment(1) == 'home' || $this->uri->segment(1) == '' ? 'active' : '' ?>">
             <i class="nav-icon fas fa-home"></i>
             <p>
               Home
             </p>
           </a>
         </li>

         <li class="nav-header">Operasional</li>

         <li class="nav-item <?= $this->uri->segment(1) == 'armada' || $this->uri->segment(1) == 'karyawan' || $this->uri->segment(1) == 'sopir' || $this->uri->segment(1) == '' ? 'menu-open' : '' ?>">

           <a href="#" class="nav-link <?= $this->uri->segment(1) == 'armada' || $this->uri->segment(1) == 'karyawan' || $this->uri->segment(1) == 'sopir' || $this->uri->segment(1) == '' ? 'active' : '' ?>">
             <i class="nav-icon fas fa-server"></i>
             <p>
               Master
               <i class="right fas fa-angle-right"></i>
             </p>
           </a>

           <ul class="nav nav-treeview">
             <li class="nav-item">
               <a href="<?= base_url('armada') ?>" class="nav-link <?= $this->uri->segment(1) == 'armada' || $this->uri->segment(1) == '' ? 'active bg-secondary' : '' ?>">
                 <i class="fas fa-truck-moving nav-icon"></i>
                 <p>Armada</p>
               </a>
             </li>

             <li class="nav-item">
               <a href="<?= base_url('karyawan') ?>" class="nav-link <?= $this->uri->segment(1) == 'karyawan' || $this->uri->segment(1) == '' ? 'active bg-secondary' : '' ?>">
                 <i class="fas fa-user-tie nav-icon"></i>
                 <p>Karyawan</p>
               </a>
             </li>

             <li class="nav-item">
               <a href="<?= base_url('sopir') ?>" class="nav-link <?= $this->uri->segment(1) == 'sopir' || $this->uri->segment(1) == '' ? 'active bg-secondary' : '' ?>">
                 <i class="far fa-user nav-icon"></i>
                 <p>Sopir</p>
               </a>
             </li>

           </ul>
         </li>

         <li class="nav-item">
           <a href="<?= base_url('user') ?>" class="nav-link <?= $this->uri->segment(1) == 'user' || $this->uri->segment(1) == '' ? 'active' : '' ?>">
             <i class="nav-icon fas fa-user-lock"></i>
             <p>User</p>
           </a>
         </li>

         <li class="nav-header">Administrasi</li>

         <li class="nav-item <?= $this->uri->segment(1) == 'uangmakan' || $this->uri->segment(1) == 'sangu' || $this->uri->segment(1) == 'persensopir' || $this->uri->segment(1) == 'pengeluaran_lain' || $this->uri->segment(1) == '' ? 'menu-open' : '' ?>">

           <a href="#" class="nav-link <?= $this->uri->segment(1) == 'uangmakan' || $this->uri->segment(1) == 'sangu' || $this->uri->segment(1) == 'persensopir' || $this->uri->segment(1) == 'pengeluaran_lain' || $this->uri->segment(1) == '' ? 'active' : '' ?>">
             <i class="nav-icon fas fa-balance-scale-right"></i>
             <p>
               Pengeluaran Kas
               <i class="right fas fa-angle-right"></i>
             </p>
           </a>

           <ul class="nav nav-treeview">
             <li class="nav-item">
               <a href="<?= base_url('uangmakan') ?>" class="nav-link <?= $this->uri->segment(1) == 'uangmakan' || $this->uri->segment(1) == '' ? 'active bg-secondary' : '' ?>">
                 <i class="nav-icon fas fa-hand-holding-usd"></i>
                 <p>Uang Makan</p>
               </a>
             </li>

             <li class="nav-item">
               <a href="<?= base_url('sangu') ?>" class="nav-link <?= $this->uri->segment(1) == 'sangu' || $this->uri->segment(1) == '' ? 'active bg-secondary' : '' ?>">
                 <i class="nav-icon fas fa-wallet"></i>
                 <p>Sangu Sopir</p>
               </a>
             </li>

             <li class="nav-item">
               <a href="<?= base_url('persensopir') ?>" class="nav-link <?= $this->uri->segment(1) == 'persensopir' || $this->uri->segment(1) == '' ? 'active bg-secondary' : '' ?>">
                 <i class="nav-icon fas fa-percentage"></i>
                 <p>Persen Sopir</p>
               </a>
             </li>

             <li class="nav-item">
               <a href="<?= base_url('pengeluaran_lain') ?>" class="nav-link <?= $this->uri->segment(1) == 'pengeluaran_lain' || $this->uri->segment(1) == '' ? 'active bg-secondary' : '' ?>">
                 <i class="nav-icon fas fa-coins"></i>
                 <p>Lain-lain</p>
               </a>
             </li>

           </ul>
         </li>

         <li class="nav-header">Transaksi</li>

         <li class="nav-item">
           <a href="<?= base_url('customer') ?>" class="nav-link <?= $this->uri->segment(1) == 'customer' || $this->uri->segment(1) == '' ? 'active' : '' ?>">
             <i class="nav-icon fas fa-portrait"></i>
             <p>Customer</p>
           </a>
         </li>

         <li class="nav-item">
           <a href="<?= base_url('order') ?>" class="nav-link <?= $this->uri->segment(1) == 'order' || $this->uri->segment(1) == '' ? 'active' : '' ?>">
             <i class="nav-icon fas fa-cart-plus"></i>
             <p>Order</p>
           </a>
         </li>

         <li class="nav-item">
           <a href="<?= base_url('penjualan') ?>" class="nav-link <?= $this->uri->segment(1) == 'penjualan' || $this->uri->segment(1) == '' ? 'active' : '' ?>">
             <i class="nav-icon far fa-clipboard"></i>
             <p>
               Penjualan
             </p>
           </a>
         </li>

         <li class="nav-item <?= $this->uri->segment(1) == 'invoice' || $this->uri->segment(1) == 'traveldoc' || $this->uri->segment(1) == '' ? 'menu-open' : '' ?>">
           <a href="#" class="nav-link <?= $this->uri->segment(1) == 'invoice' || $this->uri->segment(1) == 'traveldoc' || $this->uri->segment(1) == '' ? 'active' : '' ?>">
             <i class="nav-icon fas fa-folder"></i>
             <p>
               Dokumen
               <i class="right fas fa-angle-right"></i>
             </p>
           </a>
           <ul class="nav nav-treeview">
             <li class="nav-item">
               <a href="<?= base_url('traveldoc') ?>" class="nav-link <?= $this->uri->segment(1) == 'traveldoc' || $this->uri->segment(1) == '' ? 'active bg-secondary' : '' ?>">
                 <i class="fas fa-envelope-open nav-icon"></i>
                 <p>Surat Jalan</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="<?= base_url('invoice') ?>" class="nav-link <?= $this->uri->segment(1) == 'invoice' || $this->uri->segment(1) == '' ? 'active bg-secondary' : '' ?>">
                 <i class="nav-icon fas fa-file-invoice"></i>
                 <p>Invoice</p>
               </a>
             </li>
           </ul>
         </li>

       </ul>
     </nav>
   </div>
 </aside>