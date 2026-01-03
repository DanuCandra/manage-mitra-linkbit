  <div id="main-wrapper">
      <!-- Sidebar Start -->
      <aside class="left-sidebar with-vertical">
          <div><!-- ---------------------------------- -->
              <!-- Start Vertical Layout Sidebar -->
              <!-- ---------------------------------- -->
              <div class="brand-logo d-flex align-items-center justify-content-between">
                  <a href="{{ url('') }}" class="text-nowrap logo-img">
                      <img src="{{ url('') }}/assets/images/logos/logo-linkbit.png" class="dark-logo mt-3"
                          alt="Logo-Dark" width="80%" />
                      <img src="{{ url('') }}/assets/images/logos/logo-linkbit.png" class="light-logo mt-3"
                          alt="Logo-light" width="80%" />
                  </a>
                  <a href="javascript:void(0)"
                      class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
                      <i class="ti ti-x"></i>
                  </a>
              </div>

              <nav class="sidebar-nav scroll-sidebar" data-simplebar>
                  <ul id="sidebarnav">
                      <!-- ---------------------------------- -->
                      <!-- Home -->
                      <!-- ---------------------------------- -->
                      <li class="nav-small-cap">
                          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                          <span class="hide-menu">Home</span>
                      </li>
                      <!-- ---------------------------------- -->
                      <!-- Dashboard -->
                      <!-- ---------------------------------- -->
                      {{-- ============================================ --}}
                      {{-- MENU UNTUK ADMIN --}}
                      {{-- ============================================ --}}
                      @if (Auth::check() && Auth::user()->role === 'admin')
                          {{-- Dashboard --}}
                          <li class="sidebar-item">
                              <a href="{{ url('/admin-dashboard') }}"
                                  class="sidebar-link waves-effect {{ Request::is('admin-dashboard') ? 'active' : '' }}">
                                  <span><i class="ti ti-aperture"></i></span>
                                  <span class="hide-menu">Dashboard</span>
                              </a>
                          </li>

                          {{-- Manage Users --}}
                          <li class="sidebar-item">
                              <a href="{{ url('/manage-users') }}"
                                  class="sidebar-link waves-effect {{ Request::is('manage-users*') ? 'active' : '' }}">
                                  <span><i class="ti ti-users"></i></span>
                                  <span class="hide-menu">Manage Users</span>
                              </a>
                          </li>

                          {{-- Bandwidth Management --}}
                          <li class="sidebar-item">
                              <a href="{{ url('/manage-bandwidth') }}"
                                  class="sidebar-link waves-effect {{ Request::is('manage-bandwidth*') ? 'active' : '' }}">
                                  <span><i class="ti ti-network"></i></span>
                                  <span class="hide-menu">Bandwidth Management</span>
                              </a>
                          </li>

                          {{-- MENU KEUANGAN & PEMBAYARAN --}}
                          <li class="nav-small-cap">
                              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                              <span class="hide-menu">Keuangan</span>
                          </li>

                          {{-- Account Bank --}}
                          <li class="sidebar-item">
                              <a href="{{ url('/admin/account-bank') }}"
                                  class="sidebar-link waves-effect {{ Request::is('admin/account-bank*') ? 'active' : '' }}">
                                  <span><i class="ti ti-building-bank"></i></span>
                                  <span class="hide-menu">Account Bank</span>
                              </a>
                          </li>

                          {{-- Tagihan --}}
                          <li class="sidebar-item">
                              <a href="{{ url('/admin/tagihan') }}"
                                  class="sidebar-link waves-effect {{ Request::is('admin/tagihan*') ? 'active' : '' }}">
                                  <span><i class="ti ti-file-invoice"></i></span>
                                  <span class="hide-menu">Kelola Tagihan</span>
                              </a>
                          </li>

                          {{-- Verifikasi Pembayaran --}}
                          <li class="sidebar-item">
                              <a href="{{ url('/admin/pembayaran') }}"
                                  class="sidebar-link waves-effect {{ Request::is('admin/pembayaran*') ? 'active' : '' }}">
                                  <span><i class="ti ti-receipt"></i></span>
                                  <span class="hide-menu">Verifikasi Pembayaran</span>
                                  @php
                                      $pendingCount = \App\Models\Pembayaran::pending()->count();
                                  @endphp
                                  @if ($pendingCount > 0)
                                      <span class="badge bg-danger rounded-pill ms-auto">{{ $pendingCount }}</span>
                                  @endif
                              </a>
                          </li>

                          {{-- Laporan Keuangan --}}
                          <li class="sidebar-item">
                              <a href="{{ url('/admin/laporan-keuangan') }}"
                                  class="sidebar-link waves-effect {{ Request::is('admin/laporan-keuangan*') ? 'active' : '' }}">
                                  <span><i class="ti ti-report-money"></i></span>
                                  <span class="hide-menu">Laporan Keuangan</span>
                              </a>
                          </li>
                      @endif

                      {{-- ============================================ --}}
                      {{-- MENU UNTUK MITRA --}}
                      {{-- ============================================ --}}
                      @if (Auth::check() && Auth::user()->role === 'mitra')
                          {{-- Dashboard --}}
                          <li class="sidebar-item">
                              <a href="{{ url('/mitra-dashboard') }}"
                                  class="sidebar-link waves-effect {{ Request::is('mitra-dashboard') ? 'active' : '' }}">
                                  <i class="ti ti-dashboard"></i>
                                  <span class="hide-menu">Dashboard</span>
                              </a>
                          </li>

                          {{-- MENU DATA MITRA --}}
                          <li class="nav-small-cap">
                              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                              <span class="hide-menu">Data Mitra</span>
                          </li>

                          {{-- Profil Mitra --}}
                          <li class="sidebar-item">
                              <a href="{{ url('/profile/add-profile') }}"
                                  class="sidebar-link waves-effect {{ Request::is('profile/*') ? 'active' : '' }}">
                                  <i class="ti ti-user-circle"></i>
                                  <span class="hide-menu">Profil Mitra</span>
                              </a>
                          </li>

                          {{-- Dokumen --}}
                          <li class="sidebar-item">
                              <a href="{{ url('/dokumen/manage-dokumen') }}"
                                  class="sidebar-link waves-effect {{ Request::is('dokumen/*') ? 'active' : '' }}">
                                  <i class="ti ti-file-text"></i>
                                  <span class="hide-menu">Dokumen</span>
                              </a>
                          </li>

                          {{-- MENU PRODUK & PELANGGAN --}}
                          <li class="nav-small-cap">
                              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                              <span class="hide-menu">Produk & Pelanggan</span>
                          </li>

                          {{-- Produk --}}
                          <li class="sidebar-item">
                              <a href="{{ url('/produk/manage-produk') }}"
                                  class="sidebar-link waves-effect {{ Request::is('produk/*') ? 'active' : '' }}">
                                  <i class="ti ti-box"></i>
                                  <span class="hide-menu">Produk</span>
                              </a>
                          </li>

                          {{-- Pelanggan --}}
                          <li class="sidebar-item">
                              <a href="{{ url('/pelanggan/manage') }}"
                                  class="sidebar-link waves-effect {{ Request::is('pelanggan/*') ? 'active' : '' }}">
                                  <i class="ti ti-users"></i>
                                  <span class="hide-menu">Pelanggan</span>
                              </a>
                          </li>

                          {{-- MENU PEMBAYARAN --}}
                          <li class="nav-small-cap">
                              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                              <span class="hide-menu">Pembayaran</span>
                          </li>

                          {{-- Tagihan Saya --}}
                          <li class="sidebar-item">
                              <a href="{{ url('/mitra/tagihan') }}"
                                  class="sidebar-link waves-effect {{ Request::is('mitra/tagihan*') ? 'active' : '' }}">
                                  <i class="ti ti-file-invoice"></i>
                                  <span class="hide-menu">Tagihan Saya</span>
                                  @php
                                      $mitra = Auth::user()->mitra;
                                      $unpaidCount = $mitra ? $mitra->tagihanAktif()->count() : 0;
                                  @endphp
                                  @if ($unpaidCount > 0)
                                      <span class="badge bg-danger rounded-pill ms-auto">{{ $unpaidCount }}</span>
                                  @endif
                              </a>
                          </li>

                          {{-- Bayar Tagihan --}}
                          <li class="sidebar-item">
                              <a href="{{ url('/mitra/pembayaran') }}"
                                  class="sidebar-link waves-effect {{ Request::is('mitra/pembayaran*') ? 'active' : '' }}">
                                  <i class="ti ti-credit-card"></i>
                                  <span class="hide-menu">Bayar Tagihan</span>
                              </a>
                          </li>

                          {{-- Riwayat Pembayaran --}}
                          <li class="sidebar-item">
                              <a href="{{ url('/mitra/riwayat-pembayaran') }}"
                                  class="sidebar-link waves-effect {{ Request::is('mitra/riwayat-pembayaran*') ? 'active' : '' }}">
                                  <i class="ti ti-history"></i>
                                  <span class="hide-menu">Riwayat Pembayaran</span>
                              </a>
                          </li>
                      @endif




                  </ul>
              </nav>

              <div class="fixed-profile p-3 mx-4 mb-2 bg-secondary-subtle rounded mt-3">
                  <div class="hstack gap-3">
                      <div class="john-img">
                          <img src="{{ Auth::user()->profile_photo ? asset('storage/profile-foto/' . Auth::user()->profile_photo) : asset('assets/images/profile/user-1.jpg') }}"
                              alt="Profile Photo" class="rounded-circle" width="40" height="40"
                              style="object-fit: cover; width: 40px; height: 40px;" />
                      </div>
                      <div class="john-title">
                          <h6 class="mb-0 fs-4 fw-semibold">{{ Auth::user()->name }}</h6>
                          <span class="fs-2">{{ Auth::user()->role }}</span>
                      </div>
                      <a href="{{ url('/logout') }}" class="border-0 bg-transparent text-primary ms-auto"
                          tabindex="0" type="button" aria-label="logout" data-bs-toggle="tooltip"
                          data-bs-placement="top" data-bs-title="logout">
                          <i class="ti ti-power fs-6"></i>
                      </a>
                  </div>
              </div>

              <!-- ---------------------------------- -->
              <!-- Start Vertical Layout Sidebar -->
              <!-- ---------------------------------- -->
          </div>
      </aside>
