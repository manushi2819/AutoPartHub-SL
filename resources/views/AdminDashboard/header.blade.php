<div class="navbar-header">
  <div class="row align-items-center justify-content-between">
    <div class="col-auto">
      <div class="d-flex flex-wrap align-items-center gap-4">
        <button type="button" class="sidebar-toggle">
          <iconify-icon icon="heroicons:bars-3-solid" class="icon text-2xl non-active"></iconify-icon>
          <iconify-icon icon="iconoir:arrow-right" class="icon text-2xl active"></iconify-icon>
        </button>
        <button type="button" class="sidebar-mobile-toggle">
          <iconify-icon icon="heroicons:bars-3-solid" class="icon"></iconify-icon>
        </button>
      </div>
    </div>
    <div class="col-auto">
      <div class="d-flex flex-wrap align-items-center gap-3">
        <button type="button" data-theme-toggle class="w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center"></button>
 


        <div class="dropdown">
          <button class="d-flex justify-content-center align-items-center rounded-circle" type="button" data-bs-toggle="dropdown">
            <img src="{{ asset('user1.png') }}" alt="image" class="w-40-px h-40-px object-fit-cover rounded-circle"
            style="border: 2px solid #dee2e6;">
          </button>
         <div class="dropdown-menu to-top dropdown-menu-sm">
         <!-- User info -->
        <div class="py-12 px-16 radius-8 bg-primary-50 mb-16 d-flex align-items-center justify-content-between gap-2">
            <div>
                <h6 style="font-size:13px !important"
                    class="text-lg text-primary-light fw-semibold mb-2">
                    Role:
                    @if(session('is_super_admin'))
                        Super Admin
                    @else
                        Admin User
                    @endif
                </h6>

                <h6 style="font-size:13px !important"
                    class="text-lg text-primary-light fw-semibold mb-2 mt-4">
                    Name:
                    @if(session('is_super_admin'))
                        Kasthuri Dhananjaya
                    @else
                        {{ session('name') }}
                    @endif
                </h6>
            </div>

            <button type="button"
                    class="hover-text-danger"
                    data-bs-dismiss="dropdown">
                <iconify-icon icon="radix-icons:cross-1"
                              class="icon text-xl">
                </iconify-icon>
            </button>

        </div>
          <!-- Dropdown links -->
          <ul class="to-top-list">
             <!-- <li>
                  <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-primary d-flex align-items-center gap-3"
                    href="">
                      <iconify-icon icon="solar:user-linear" class="icon text-xl"></iconify-icon> My Profile
                  </a>
              </li>-->
              <li>
                  <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                      @csrf
                      <button type="submit" class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-danger d-flex align-items-center gap-3 border-0 bg-transparent">
                          <iconify-icon icon="lucide:power" class="icon text-xl"></iconify-icon> Log Out
                      </button>
                  </form>
              </li>
          </ul>
      </div>

        </div><!-- Profile dropdown end -->
      </div>
    </div>
  </div>
</div> 