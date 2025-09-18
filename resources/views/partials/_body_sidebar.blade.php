<div class="iq-sidebar  sidebar-default ">
    <div class="iq-sidebar-logo d-flex align-items-center">
        <a href="{{ route('dashboard') }}" class="header-logo">
            <img src="{{ asset('images/logo.png') }}" alt="logo">
            <h2 class=" light-logo">CRM</h2>
        </a>
        <div class="iq-menu-bt-sidebar ml-0">
            <i class="las la-bars wrapper-menu"></i>
        </div>
    </div>
    <div class="data-scrollbar" data-scroll="1">
        <nav class="iq-sidebar-menu">
            <h6 class="sidebar-text text-uppercase ">Dashboard</h6>
            <ul id="iq-sidebar-toggle" class="iq-menu">
                <li class="{{ activeRoute('dashboard') }}">
                    <a href="{{ route('dashboard') }}" class="svg-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"
                            width="15" height="15">
                            <path
                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                        <span class="ml-3 side-menu-title">Dashboard</span>
                    </a>
                </li>
                
                <li class="list-sidebar">
                    <a href="#pembelian" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-bag-icon lucide-shopping-bag"><path d="M16 10a4 4 0 0 1-8 0"/><path d="M3.103 6.034h17.794"/><path d="M3.4 5.467a2 2 0 0 0-.4 1.2V20a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6.667a2 2 0 0 0-.4-1.2l-2-2.667A2 2 0 0 0 17 2H7a2 2 0 0 0-1.6.8z"/></svg>
                        <span class="ml-3 side-menu-title">Pembelian</span>
                        <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                        <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                    </a>
                    <ul id="pembelian" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="list-subtitle">
                            <a href="{{ url('product') }}">
                                <i class="las la-minus"></i><span class="subtitle">Product Data</span>
                            </a>
                        </li>
                        <li class="list-subtitle">
                            <a href="{{ url('purchase_request') }}">
                                <i class="las la-minus"></i><span class="subtitle">Purchase Requisition<br>(Permintaan Barang)</span>
                            </a>
                        </li>
                        <li class="list-subtitle">
                            <a href="{{ url('purchase_order') }}">
                                <i class="las la-minus"></i><span class="subtitle">Purchase Order<br>(Pengadaan Bahan Baku)</span>
                            </a>
                        </li>
                        <li class="list-subtitle">
                            <a href="{{ url('department') }}">
                                <i class="las la-minus"></i><span class="subtitle">Retur Barang</span>
                            </a>
                        </li>
                        <li class="list-subtitle">
                            <a href="{{ url('license') }}">
                                <i class="las la-minus"></i><span class="subtitle">Tagihan Pembelian</span>
                            </a>
                        </li>
                        <li class="list-subtitle">
                            <a href="{{ url('license') }}">
                                <i class="las la-minus"></i><span class="subtitle">Pembelian Barang<br>Konsumtif/Internal</span>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="list-sidebar">
                    <a href="#kas" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-banknote-arrow-up-icon lucide-banknote-arrow-up"><path d="M12 18H4a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5"/><path d="M18 12h.01"/><path d="M19 22v-6"/><path d="m22 19-3-3-3 3"/><path d="M6 12h.01"/><circle cx="12" cy="12" r="2"/></svg>
                        <span class="ml-3 side-menu-title">Bukti dan Kas</span>
                        <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                        <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                    </a>
                    <ul id="kas" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="list-subtitle">
                            <a href="#">
                                <i class="las la-minus"></i><span class="subtitle">Bukti Kas Keluar</span>
                            </a>
                        </li>
                        <li class="list-subtitle">
                            <a href="#">
                                <i class="las la-minus"></i><span class="subtitle">Laporan Bukti<br>Kas Keluar</span>
                            </a>
                        </li>

                    </ul>
                </li>


                <li class="list-sidebar">
                    <a href="#purchase-report" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-tickets-plane-icon lucide-tickets-plane"><path d="M10.5 17h1.227a2 2 0 0 0 1.345-.52L18 12"/><path d="m12 13.5 3.75.5"/><path d="m4.5 8 10.58-5.06a1 1 0 0 1 1.342.488L18.5 8"/><path d="M6 10V8"/><path d="M6 14v1"/><path d="M6 19v2"/><rect x="2" y="8" width="20" height="13" rx="2"/></svg>
                        <span class="ml-3 side-menu-title">Laporan Pembelian</span>
                        <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                        <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                    </a>
                    <ul id="purchase-report" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="list-subtitle">
                            <a href="#">
                                <i class="las la-minus"></i><span class="subtitle">Jadwal Kedatangan<br>Material</span>
                            </a>
                        </li>
                        <li class="list-subtitle">
                            <a href="#">
                                <i class="las la-minus"></i><span class="subtitle">Tagihan Pembelian<br>Material</span>
                            </a>
                        </li>
                        <li class="list-subtitle">
                            <a href="#">
                                <i class="las la-minus"></i><span class="subtitle">Backlog Pembelian<br>(Transaksi Keluar)</span>
                            </a>
                        </li>
                        <li class="list-subtitle">
                            <a href="#">
                                <i class="las la-minus"></i><span class="subtitle">Hutang Ke<br>Supplier</span>
                            </a>
                        </li>

                    </ul>
                </li>



                <li class="list-sidebar">
                    <a href="#stock-report" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-proportions-icon lucide-proportions"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="M12 9v11"/><path d="M2 9h13a2 2 0 0 1 2 2v9"/></svg>
                        <span class="ml-3 side-menu-title">Laporan Stok</span>
                        <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                        <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                    </a>
                    <ul id="stock-report" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="list-subtitle">
                            <a href="#">
                                <i class="las la-minus"></i><span class="subtitle">Stok + Harga Beli</span>
                            </a>
                        </li>
                        <li class="list-subtitle">
                            <a href="{{ url('vehicle_merk') }}">
                                <i class="las la-minus"></i><span class="subtitle">Stok Bedasarkan Umur</span>
                            </a>
                        </li>
                        
                        <li class="list-subtitle">
                            <a href="{{ url('vehicle_owner') }}">
                                <i class="las la-minus"></i><span class="subtitle">Stok Berdasarkan Umur <br>(include harga)</span>
                            </a>
                        </li>
                        <li class="list-subtitle">
                            <a href="{{ url('branch') }}">
                                <i class="las la-minus"></i><span class="subtitle">Barang Terjual</span>
                            </a>
                        </li>
                        

                    </ul>
                </li>


                <li class="list-sidebar">
                    <a href="#purchase-reminder" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bell-ring-icon lucide-bell-ring"><path d="M10.268 21a2 2 0 0 0 3.464 0"/><path d="M22 8c0-2.3-.8-4.3-2-6"/><path d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326"/><path d="M4 2C2.8 3.7 2 5.7 2 8"/></svg>
                        <span class="ml-3 side-menu-title">Reminder</span>
                        <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                        <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                    </a>
                    <ul id="purchase-reminder" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="list-subtitle">
                            <a href="#">
                                <i class="las la-minus"></i><span class="subtitle">Reminder Jatuh <br>Tempo Pembelian</span>
                            </a>
                        </li>
                        <li class="list-subtitle">
                            <a href="#">
                                <i class="las la-minus"></i><span class="subtitle">Reminder Jatuh <br>Tempo Penjualan</span>
                            </a>
                        </li>
                        
                    </ul>
                </li>

                <li class="list-sidebar">
                    <a href="#stock-management" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-warehouse-icon lucide-warehouse"><path d="M18 21V10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v11"/><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8a2 2 0 0 1 1.132-1.803l7.95-3.974a2 2 0 0 1 1.837 0l7.948 3.974A2 2 0 0 1 22 8z"/><path d="M6 13h12"/><path d="M6 17h12"/></svg>
                        <span class="ml-3 side-menu-title">Manajemen Stok</span>
                        <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                        <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                    </a>
                    <ul id="stock-management" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="list-subtitle">
                            <a href="#">
                                <i class="las la-minus"></i><span class="subtitle">Penerimaan Barang<br>Material Masuk</span>
                            </a>
                        </li>
                        <li class="list-subtitle">
                            <a href="#">
                                <i class="las la-minus"></i><span class="subtitle">Penyimpanan Stok<br>Barang</span>
                            </a>
                        </li>
                        <li class="list-subtitle">
                            <a href="#">
                                <i class="las la-minus"></i><span class="subtitle">Manajemen Palet</span>
                            </a>
                        </li>
                        
                        
                    </ul>
                </li>


                <li class="list-sidebar">
                    <a href="#production" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package-search-icon lucide-package-search"><path d="M21 10V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14"/><path d="m7.5 4.27 9 5.15"/><polyline points="3.29 7 12 12 20.71 7"/><line x1="12" x2="12" y1="22" y2="12"/><circle cx="18.5" cy="15.5" r="2.5"/><path d="M20.27 17.27 22 19"/></svg>
                        <span class="ml-3 side-menu-title">Produksi & Operasional</span>
                        <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                        <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                    </a>
                    <ul id="production" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="list-subtitle">
                            <a href="#">
                                <i class="las la-minus"></i><span class="subtitle">Job Order</span>
                            </a>
                        </li>
                        <li class="list-subtitle">
                            <a href="#">
                                <i class="las la-minus"></i><span class="subtitle">Surat Perintah Kerja</span>
                            </a>
                        </li>
                        <li class="list-subtitle">
                            <a href="#">
                                <i class="las la-minus"></i><span class="subtitle">Hasil Potongan</span>
                            </a>
                        </li>
                        <li class="list-subtitle">
                            <a href="#">
                                <i class="las la-minus"></i><span class="subtitle">Update Stok Potongan<br>Jasa Keluar</span>
                            </a>
                        </li>
                        
                    </ul>
                </li>

                <li class="list-sidebar">
                    <a href="#surat-jalan-penjualan" class="collapsed" data-toggle="collapse" aria-expanded="false">
                       <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-truck-icon lucide-truck"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>
                        <span class="ml-3 side-menu-title">Distribusi</span>
                        <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                        <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                    </a>
                    <ul id="surat-jalan-penjualan" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="list-subtitle">
                            <a href="#">
                                <i class="las la-minus"></i><span class="subtitle">Surat Jalan <br>Penjualan</span>
                            </a>
                        </li>
                        
                    </ul>
                </li>


                <li class="list-sidebar">
                    <a href="#transaksi-penjualan" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-weight-icon lucide-weight"><circle cx="12" cy="5" r="3"/><path d="M6.5 8a2 2 0 0 0-1.905 1.46L2.1 18.5A2 2 0 0 0 4 21h16a2 2 0 0 0 1.925-2.54L19.4 9.5A2 2 0 0 0 17.48 8Z"/></svg>
                        <span class="ml-3 side-menu-title">Transaksi Penjualan</span>
                        <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                        <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                    </a>
                    <ul id="transaksi-penjualan" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="list-subtitle">
                            <a href="#">
                                <i class="las la-minus"></i><span class="subtitle">Sales Order</span>
                            </a>
                        </li>
                        <li class="list-subtitle">
                            <a href="#">
                                <i class="las la-minus"></i><span class="subtitle">Booking Order</span>
                            </a>
                        </li>
                        <li class="list-subtitle">
                            <a href="#">
                                <i class="las la-minus"></i><span class="subtitle">Invoice Penjualan</span>
                            </a>
                        </li>
                        <li class="list-subtitle">
                            <a href="#">
                                <i class="las la-minus"></i><span class="subtitle">Bukti Kas Masuk</span>
                            </a>
                        </li>
                        
                    </ul>
                </li>


                <li class="list-sidebar">
                    <a href="#settingan" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-settings-icon lucide-settings"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
                        <span class="ml-3 side-menu-title">Settingan</span>
                        <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                        <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                    </a>
                    <ul id="settingan" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="list-subtitle">
                            <a href="{{ url('karyawan') }}">
                                <i class="las la-minus"></i><span class="subtitle">Manajemen Data<br>Karyawan</span>
                            </a>
                        </li>
                        <li class="list-subtitle">
                            <a href="{{ url('vendors') }}">
                                <i class="las la-minus"></i><span class="subtitle">Manajemen Data<br>Vendor</span>
                            </a>
                        </li>
                        <li class="list-subtitle">
                            <a href="{{ url('customer') }}">
                                <i class="las la-minus"></i><span class="subtitle">Manajemen Data<br>Customer</span>
                            </a>
                        </li>
                        <li class="list-subtitle">
                            <a href="#">
                                <i class="las la-minus"></i><span class="subtitle">Manajemen Role<br>Hak Akses</span>
                            </a>
                        </li>

                        <li class="list-subtitle">
                            <a href="{{ url('branch') }}">
                                <i class="las la-minus"></i><span class="subtitle">Branch Data</span>
                            </a>
                        </li>

                        <li class="list-subtitle">
                            <a href="{{ url('tax_setting') }}">
                                <i class="las la-minus"></i><span class="subtitle">Tax Setting</span>
                            </a>
                        </li>
                        <li class="list-subtitle">
                            <a href="{{ url('mills') }}">
                                <i class="las la-minus"></i><span class="subtitle">Mills Data</span>
                            </a>
                        </li>
                        <li class="list-subtitle">
                            <a href="{{ url('warehouse') }}">
                                <i class="las la-minus"></i><span class="subtitle">Warehouse Data</span>
                            </a>
                        </li>
                        <li class="list-subtitle">
                            <a href="{{ url('user') }}">
                                <i class="las la-minus"></i><span class="subtitle">User Management</span>
                            </a>
                        </li>
                        
                    </ul>
                </li>


                <li class="list-sidebar">
                    <a href="#customer-management" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-user-icon lucide-square-user"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="12" cy="10" r="3"/><path d="M7 21v-2a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2"/></svg>
                        <span class="ml-3 side-menu-title">Manajemen Customer</span>
                        <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                        <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                    </a>
                    <ul id="customer-management" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="list-subtitle">
                            <a href="#">
                                <i class="las la-minus"></i><span class="subtitle">Customer Per<br>Marketing</span>
                            </a>
                        </li>
                        <li class="list-subtitle">
                            <a href="#">
                                <i class="las la-minus"></i><span class="subtitle">Customer By<br>Grade</span>
                            </a>
                        </li>
                        <li class="list-subtitle">
                            <a href="#">
                                <i class="las la-minus"></i><span class="subtitle">Map Lokasi<br>Customer</span>
                            </a>
                        </li>
                        
                        
                        
                    </ul>
                </li>

                <li class="list-sidebar">
                    <a href="#marketing-activity" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-store-icon lucide-store"><path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7"/><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4"/><path d="M2 7h20"/><path d="M22 7v3a2 2 0 0 1-2 2a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 16 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 12 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 8 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 4 12a2 2 0 0 1-2-2V7"/></svg>
                        <span class="ml-3 side-menu-title">Aktivitas Marketing</span>
                        <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                        <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                    </a>
                    <ul id="marketing-activity" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="list-subtitle">
                            <a href="#">
                                <i class="las la-minus"></i><span class="subtitle">To Do List /<br>Deal</span>
                            </a>
                        </li>
                        <li class="list-subtitle">
                            <a href="#">
                                <i class="las la-minus"></i><span class="subtitle">Task / Tugas Marketing</span>
                            </a>
                        </li>
                        <li class="list-subtitle">
                            <a href="#">
                                <i class="las la-minus"></i><span class="subtitle">History Aktivitas<br>Marketing</span>
                            </a>
                        </li>
                        <li class="list-subtitle">
                            <a href="#">
                                <i class="las la-minus"></i><span class="subtitle">Bidding Customer<br>(Customer yang sedang<br> dikejar)</span>
                            </a>
                        </li>
                        
                        
                        
                    </ul>
                </li>

                 <li class="list-sidebar">
                    <a href="#communication" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-phone-call-icon lucide-phone-call"><path d="M13 2a9 9 0 0 1 9 9"/><path d="M13 6a5 5 0 0 1 5 5"/><path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"/></svg>
                        <span class="ml-3 side-menu-title">Komunikasi</span>
                        <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                        <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                    </a>
                    <ul id="communication" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="list-subtitle">
                            <a href="#">
                                <i class="las la-minus"></i><span class="subtitle">Broadcast Email</span>
                            </a>
                        </li>
                        <li class="list-subtitle">
                            <a href="#">
                                <i class="las la-minus"></i><span class="subtitle">Broadcast Whatsapp</span>
                            </a>
                        </li>
                    </ul>
                </li>
                





            </ul>
        </nav>

        <div class="pt-5 pb-2" style="margin-top:150px;"></div>
    </div>
</div>
