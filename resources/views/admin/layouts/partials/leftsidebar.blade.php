<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Main</li>
                <li>
                    <a href="{{ url('admin/dashboard') }}" class="waves-effect">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class=" @if(strpos(Request::path(), 'customers') != false) mm-active @endif ">
                    <a href="{{ url('admin/customers') }}" class="waves-effect">
                        <i class="mdi mdi-account-tie-outline"></i>
                        <span>Customer</span>
                    </a>
                </li>
                
                <li class=" @if(strpos(Request::path(), 'user-record') != false) mm-active @endif ">
                    <a href="{{ url('admin/user-record/stocks') }}" class="waves-effect">
                        <i class="ion ion-md-alarm"></i>
                        <span>User Record</span>
                    </a>
                </li>
                <li class=" @if(strpos(Request::path(), 'schedule') != false) mm-active @endif ">
                    <a href="{{ url('admin/schedule') }}" class="waves-effect">
                        <i class="mdi mdi-calendar-check"></i>
                        <span>Schedule</span>
                    </a>
                </li>
                <li class="menu-title">ETC</li>
                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="mdi mdi-chat-processing-outline"></i>
                        <span>SMS</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="mdi mdi-email-outline"></i>
                        <span>E-mail</span>
                    </a>
                </li>
                
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ion ion-md-settings"></i>
                        <span>Setting</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="javascript: void(0);">Setting</a></li>
                        @if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->level==3)
                        <li class=" @if(strpos(Request::path(), 'users') != false) mm-active @endif "><a href="{{ route('admin.users') }}">Admin</a></li>
                        @endif
                    </ul>
                </li>
                
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->