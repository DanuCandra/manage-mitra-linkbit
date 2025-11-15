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
                      @if (Auth::check() && Auth::user()->role === 'admin')
                          <li class="sidebar-item">
                              <a href="{{ url('/admin-dashboard') }}"
                                  class="sidebar-link waves-effect {{ Request::is('admin-dashboard') ? 'active' : '' }}">
                                  <span><i class="ti ti-aperture"></i></span>
                                  <span class="hide-menu">Dashboard</span>
                              </a>
                          </li>

                          <li class="sidebar-item">
                              <a href="{{ url('/manage-users') }}"
                                  class="sidebar-link waves-effect {{ Request::is('manage-users*') ? 'active' : '' }}">
                                  <span><i class="ti ti-users"></i></span>
                                  <span class="hide-menu">Manage Users</span>
                              </a>
                          </li>
                      @endif

                      @if (Auth::check() && Auth::user()->role === 'mitra')
                          <li class="sidebar-item">
                              <a href="{{ url('/mitra-dashboard') }}"
                                  class="sidebar-link waves-effect {{ Request::is('mitra-dashboard') ? 'active' : '' }}">
                                  <i class="ti ti-aperture"></i>
                                  <span class="hide-menu">Dashboard</span>
                              </a>
                          </li>
                          <li class="sidebar-item">
                              <a href="{{ url('/profile/add-profile') }}"
                                  class="sidebar-link waves-effect {{ Request::is('profile/*') ? 'active' : '' }}">
                                  <i class="ti ti-aperture"></i>
                                  <span class="hide-menu">Profil Mitra</span>
                              </a>
                          </li>
                      @endif




                  </ul>
              </nav>

              <div class="fixed-profile p-3 mx-4 mb-2 bg-secondary-subtle rounded mt-3">
                  <div class="hstack gap-3">
                      <div class="john-img">
                          <img src="{{ url('') }}/assets/images/profile/user-1.jpg" class="rounded-circle"
                              width="40" height="40" alt="modernize-img" />
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
