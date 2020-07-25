<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

    <div class="sidebar-content">
        <!--- Sidemenu -->
        <div id="sidebar-menu" class="slimscroll-menu">
            <ul class="metismenu" id="menu-bar">
                <li class="menu-title">Navigation</li>

                <li>
                    <a href="{{ route('dashboard') }}">
                        <i data-feather="home"></i>
                        <span> Dashboard</span>
                    </a>
                </li>

                @if(\Illuminate\Support\Facades\Cookie::get('user_role') == 'super_admin')
                    {{-- super admin protected routes here --}}
                    @include('partials.menus_items.store_admin')
                    @include('partials.menus_items.super_admin')
                @endif

                @if(\Illuminate\Support\Facades\Cookie::get('user_role') == 'store_admin')
                    {{--super admin protected routes here--}}
                    @include('partials.menus_items.store_admin')
                @endif

                @if(\Illuminate\Support\Facades\Cookie::get('user_role') == 'store_assistant')
                    {{-- super admin protected routes here --}}
                    @include('partials.menus_items.store_assistant')
                @endif

                <li>
                    <a href="{{ route('setting') }}">
                        <i class="uil  uil-cog"></i>
                        <span> Settings </span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
