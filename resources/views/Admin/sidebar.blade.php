<style>
    .accordion-flush .accordion-item .accordion-button:hover {
        background-color: #6ef3ac65;
    }

    .submenu .menu-item {
        width: 14rem !important;
    }

</style>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        @if(!empty(Auth::guard('user')->user()))
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            @endif
            <span class="app-brand-logo demo">
                {{-- <img src="{{asset('/public/logo.png')}}" height="50"> --}}
                <h4>Atomic Gateway</h4>
            </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        @if(!empty(Auth::guard('user')->user()))
        @if(Auth::guard('user')->user()->role == 'admin')
        <li class="menu-item {{$active == 'dashboard' ? 'active': ''}}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>
        <li class="menu-item {{$active == 'warehouse_manager' ? 'active': ''}}">
            <a href="{{route('wareHouManag_list')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Company</div>
            </a>
        </li>
        <li class="menu-item {{$active == 'payout' ? 'active': ''}}">
            <a href="{{ route('order_list') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">PayOut</div>
            </a>
        </li>
        <li class="menu-item {{$active == 'comission' ? 'active': ''}}">
            <a href="{{route('wareHouManag_list')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Comission</div>
            </a>
        </li>
        <li class="menu-item {{$active == 'comission' ? 'active': ''}}">
            <a href="{{route('wareHouManag_list')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Settelment</div>
            </a>
        </li>

        @endif

        @if(Auth::guard('user')->user()->role == 'warehousemanager' || Auth::guard('user')->user()->role == 'admin')
        @if(Auth::guard('user')->user()->role == 'warehousemanager')
        <li class="menu-item {{$active == 'dashboard' ? 'active': ''}}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>
        @endif

        <li class="menu-item {{$active == 'bank' ? 'active': ''}}">
            <a href="{{ route('bank_list') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Bank</div>
            </a>
        </li>
        <li class="menu-item">
            <div class="accordion accordion-flush mt-1" id="accordionFlushExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="true" aria-controls="flush-collapseOne">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>Transection
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse {{($active == 'new_request') || ($active == 'approved_request') || ($active == 'reject_request') ? 'show': ''}}" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <ul class="menu-inner py-1 submenu">
                                <li class="menu-item {{$active == 'new_request' ? 'active': ''}}">
                                    <a href="{{ route('categoryList',['type'=>'new']) }}" class="menu-link mx-0">
                                        <i class="menu-icon tf-icons bx bx-home-circle"></i>
                                        <div data-i18n="Analytics">New Request</div>
                                    </a>
                                </li>
                                <li class="menu-item {{$active == 'approved_request' ? 'active': ''}}">
                                    <a href="{{ route('categoryList',['type'=>'approved']) }}" class="menu-link mx-0">
                                        <i class="menu-icon tf-icons bx bx-home-circle"></i>
                                        <div data-i18n="Analytics">Approved Request</div>
                                    </a>
                                </li>
                                <li class="menu-item {{$active == 'reject_request' ? 'active': ''}}">
                                    <a href="{{ route('categoryList',['type'=>'reject']) }}" class="menu-link mx-0">
                                        <i class="menu-icon tf-icons bx bx-home-circle"></i>
                                        <div data-i18n="Analytics">Reject Request</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </li>






        <li class="menu-item {{$active == 'report' ? 'active': ''}}">
            <a href="{{ route('order_list') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Report</div>
            </a>
        </li>

        @endif
        @endif
    </ul>
</aside>
