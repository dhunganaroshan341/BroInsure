<header class="top-header">
    <nav class="navbar navbar-expand align-items-center gap-4">
        <div class="btn-toggle">
            <a href="javascript:;" id="sidebarTogger"><i class="material-icons-outlined">menu</i></a>
        </div>
        <div class="search-bar flex-grow-1">

        </div>
        @php
            $notificationlist = getNotification();
        @endphp
        <ul class="navbar-nav gap-1 nav-right-links align-items-center">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative notificationA"
                    data-bs-auto-close="outside" data-bs-toggle="dropdown" href="javascript:;"><i
                        class="material-icons-outlined">notifications</i>

                    <span class="badge-notify"
                        data-output="{{ isset($notificationlist[0]->unseen_count) ? $notificationlist[0]->unseen_count : '' }}"
                        id="notificationCounter">{{ isset($notificationlist[0]->unseen_count) ? $notificationlist[0]->unseen_count : '0' }}</span>
                </a>
                <div class="dropdown-menu dropdown-notify dropdown-menu-end shadow">
                    <div class="px-3 py-1 d-flex align-items-center justify-content-between border-bottom">
                        <h5 class="notiy-title mb-0">Notifications</h5>
                        <a href="{{ route('notification.index') }}">
                            <h5 class="notiy-title mb-0">View All</h5>
                        </a>

                    </div>
                    <div class="notify-list ps">
                        @foreach ($notificationlist as $notification)
                            <div>
                                <a class="dropdown-item border-bottom py-2 {{ $notification->is_seen != 'Y' ? 'notificationAnkor unseenNotifictaion' : '' }}"
                                    data-id="{{ $notification->id }}"
                                    href="{{ $notification->redirect_url != null ? $notification->redirect_url : '#' }}">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="">
                                            <i class="fas fa-exclamation-circle"></i>
                                        </div>
                                        <div class="">
                                            <h5 class="notify-title">{{ $notification->type }}</h5>
                                            <p class="mb-0 notify-desc-custom">{{ $notification->message }}.
                                            </p>
                                            <p class="mb-0 notify-time">{{ $notification->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        {{-- <div class="notify-close position-absolute end-0 me-3">
                                <i class="fas fa-eye fa-sm"></i>
                            </div> --}}
                                    </div>
                                </a>
                            </div>
                        @endforeach
                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                        </div>
                        <div class="ps__rail-y" style="top: 0px; right: 0px;">
                            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a href="javascrpt:;" class="dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">
                    <img src="{{ asset('admin/assets/images/profile.png') }}" class="rounded-circle p-1 border"
                        width="45" height="45" alt="">
                </a>
                <div class="dropdown-menu dropdown-user dropdown-menu-end shadow">
                    <a class="dropdown-item  gap-2 py-2" href="javascript:;">
                        <div class="text-center">
                            <img src="{{ asset('admin/assets/images/profile.png') }}"
                                class="rounded-circle p-1 shadow mb-3" width="90" height="90" alt="">
                            <h5 class="user-name mb-0 fw-bold">Hello, {{ getUserDetail()->full_name }}</h5>
                        </div>
                    </a>
                    <hr class="dropdown-divider">
                    {{-- <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
              class="material-icons-outlined">person_outline</i>Profile</a>
          <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
              class="material-icons-outlined">local_bar</i>Setting</a>
          <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
              class="material-icons-outlined">dashboard</i>Dashboard</a>
          <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
              class="material-icons-outlined">account_balance</i>Earning</a>
          <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
              class="material-icons-outlined">cloud_download</i>Downloads</a>
          <hr class="dropdown-divider"> --}}
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('logout') }}"><i
                            class="material-icons-outlined">power_settings_new</i>Logout</a>
                </div>
            </li>
        </ul>

    </nav>
</header>
