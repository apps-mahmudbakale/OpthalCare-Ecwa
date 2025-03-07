@php
    $configData = Helper::appClasses();
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <!-- ! Hide app brand if navbar-full -->
    @if (!isset($navbarFull))
        <div class="app-brand demo">
            <a href="{{ url('/') }}" class="app-brand-link">
                <span class="app-brand-logo demo">
                    <img src="{{ !empty(app(App\Settings\SystemSettings::class)->logo) ? asset('storage/system/' . app(App\Settings\SystemSettings::class)->logo) : asset('assets/img/logo.png') }}"
                        style="width: 130%; height:120%;">
                </span>
                <span
                    class="app-brand-text demo menu-text fw-bold">{{ app(App\Settings\SystemSettings::class)->clinic_name ?: 'Clinic' }}</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
                <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
            </a>
        </div>
    @endif


    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        <li class="menu-item  {{ request()->is('app/dashboard') ? 'active' : '' }}">
            <a href="{{ route('app.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-apps"></i>
                <div>Dashboard</div>
            </a>
        </li>
        @can('read-users')
            <li class="menu-item {{ request()->is('app/users/') ? 'open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-lock"></i>
                    <div>Authentication</div>
                </a>


                <ul class="menu-sub">
                    <li class="menu-item {{ request()->is('app/users') ? 'active' : '' }}">
                        <a href="{{ route('app.users.index') }}" class="menu-link">
                            <div>Users</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is('app/roles') ? 'active' : '' }}">
                        <a href="{{ route('app.roles.index') }}" class="menu-link">
                            <div>Roles</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endcan
        <li class="menu-item ">
            <a href="{{ route('app.patients.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div>Patients</div>
            </a>
        </li>
        @can('read-appointments')
            <li class="menu-item ">
                <a href="{{ route('app.appointments.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-calendar"></i>
                    <div>Appointments</div>
                </a>
            </li>
        @endcan
        @can('waiting-list')
            <li class="menu-item ">
                <a href="{{ route('app.wait-list.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-clock"></i>
                    <div>Waiting List</div>
                </a>
            </li>
        @endcan

        <li class="menu-item ">
            <a href="{{ route('app.pharmacy.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-prescription"></i>
                <div>Pharmacy</div>
            </a>
        </li>

        <li class="menu-item ">
            <a href="{{ route('app.lab.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-vaccine"></i>
                <div>Laboratory</div>
            </a>
        </li>
        <li class="menu-item ">
            <a href="{{ route('app.radiology.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-photo"></i>
                <div>Radiology</div>
            </a>
        </li>
        {{-- <li class="menu-item ">
            <a href="{{ route('app.consumables.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-pills"></i>
                <div>Consumables</div>
            </a>
        </li> --}}
        <li class="menu-item ">
            <a href="{{ route('app.admissions.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-bed"></i>
                <div>Admissions</div>
            </a>
        </li>
        <li class="menu-item ">
            <a href="{{ route('app.procedures.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-medical-cross"></i>
                <div>Procedures</div>
            </a>
        </li>
        <li class="menu-item ">
            <a href="{{ route('app.billing.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-report-money"></i>
                <div>Billing</div>
            </a>
        </li>
        <li class="menu-item ">
            <a href="{{ route('app.reports.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-report"></i>
                <div>Reports</div>
            </a>
        </li>
        <li class="menu-item ">
            <a href="{{ route('app.messages.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-messages"></i>
                <div>Messages</div>
            </a>
        </li>
        <li class="menu-item ">
            <a href="{{ route('app.settings.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-adjustments"></i>
                <div>Settings</div>
            </a>
        </li>
    </ul>

</aside>
