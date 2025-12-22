<aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="{{ route('admin.dashboard') }}" class="text-nowrap logo-img">
            <img src="../assets/images/logos/dark-logo.svg" width="180" alt="">
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
          </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="init"><div class="simplebar-wrapper selected" style="margin: 0px -24px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask selected"><div class="simplebar-offset selected" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper selected" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden scroll;"><div class="simplebar-content selected" style="padding: 0px 24px;">
          <ul id="sidebarnav" class="in">
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Home</span>
            </li>
            <li class="sidebar-item selected">
              <a class="sidebar-link active" href="{{ route('admin.dashboard') }}" aria-expanded="false">
                <span>
                  <i class="ti ti-layout-dashboard"></i>
                </span>
                <span class="hide-menu">Dashboard</span>
              </a>
            </li>
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">MANAGEMENT</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('admin.products.index') }}" aria-expanded="false">
                <span>
                  <i class="ti ti-box-multiple"></i>
                </span>
                <span class="hide-menu">Products</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('admin.categories.index') }}" aria-expanded="false">
                <span>
                  <i class="ti ti-tags"></i>
                </span>
                <span class="hide-menu">Categories</span>
              </a>
            </li>
          </ul>
          
            
          
        </div>
      </div>
    </div>
  </div>
  <div class="simplebar-placeholder" style="width: auto; height: 888px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 93px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>