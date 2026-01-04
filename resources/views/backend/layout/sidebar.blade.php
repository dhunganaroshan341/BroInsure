@php
    $userinfo = getUserDetail();
    $menulist = getSideMenu();
    $path = Request::path();
@endphp
<aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div class="logo-icon">
            <img src="{{ asset('admin/assets/images/igi-logo.png') }}" class="logo-img" alt="" style="width:70%">
        </div>
        {{-- <div class="logo-name flex-grow-1">
            <h5 class="mb-0">Insurance</h5>
        </div> --}}
        <div class="sidebar-close">
            <span class="material-icons-outlined">close</span>
        </div>
    </div>
    <div class="sidebar-nav">

        <ul class="metismenu" id="sidenav">
            @foreach ($menulist as $li)
                        @php
                            $submenulist = getSideSubMenu($li->id);

                        @endphp
                        @if (count($submenulist) > 0)
                                @php
                                    $html = '';
                                    $isactive = '';

                                    foreach ($submenulist as $key => $subli) {

                                        $menuname = $subli->modulename;
                                        $url = $subli->url;
                                        $icon = $subli->icon;
                                        if ($path == 'admin/' . $url) {
                                            $isactive = 'mm-active';
                                        } else {
                                            $isactive = '';
                                        }
                                        $html .= '<li class="' . $isactive . '"><a href="' . url('/admin/' . $url) . '"><i class="fas fa-arrow-right fa-sm"></i>' . $menuname . '</a>
                                                                                                                </li>';
                                    }
                                @endphp
                                <li class="{{$isactive}}">
                                    <a href="javascript:;" class="has-arrow">
                                        <div class="parent-icon"><i class="{{ $li->icon}} fa-lg"></i>
                                        </div>
                                        <div class="menu-title">{{ $li->modulename }}</div>
                                    </a>
                                    <ul>
                                        {{-- <li><a href="index.html"><i class="material-icons-outlined"></i>Analysis</a>
                                        </li> --}}
                                        @php
                                            echo $html;
                                        @endphp
                                    </ul>
                                </li>

                        @else
                                @php
                                    if ($path == 'admin/' . $li->url) {
                                        $active = 'mm-active';
                                    } else {
                                        $active = '';
                                    }

                                @endphp
                                {{-- <li class="menu-label">UI Elements</li> --}}
                                <li class="{{$active}}">
                                    <a href="{{ url('/admin/' . $li->url) }}">
                                        <div class="parent-icon"><i class="{{ $li->icon}} fa-lg"></i>
                                        </div>
                                        <div class="menu-title">{{ $li->modulename }}</div>
                                    </a>
                                </li>
                        @endif
            @endforeach
        </ul>
        <!--end navigation-->
    </div>
</aside>