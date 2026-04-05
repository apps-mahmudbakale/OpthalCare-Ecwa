@php
$configData = Helper::appClasses();
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

  @if (!isset($navbarFull))
  <div class="app-brand demo">
    <a href="{{ url('/') }}" class="app-brand-link">
                <span class="app-brand-logo demo">
                    <img src="{{ !empty(app(App\Settings\SystemSettings::class)->logo) ? asset('storage/system/' . app(App\Settings\SystemSettings::class)->logo) : asset('assets/img/logo.png') }}"
                         style="width: 130%; height:120%;">
                </span>
      <span class="app-brand-text demo menu-text fw-bold">{{ app(App\Settings\SystemSettings::class)->clinic_name ?: 'Clinic' }}</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
      <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
    </a>
  </div>
  @endif

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">

    <li class="menu-item {{ request()->is('app/dashboard*') ? 'active' : '' }}">
      <a href="{{ route('app.dashboard') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-apps"></i>
        <div>Dashboard</div>
      </a>
    </li>

    @can('read-users')
    <li class="menu-item {{ request()->is('app/users*') || request()->is('app/roles*') ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-lock"></i>
        <div>Authentication</div>
      </a>

      <ul class="menu-sub">
        <li class="menu-item {{ request()->is('app/users*') ? 'active' : '' }}">
          <a href="{{ route('app.users.index') }}" class="menu-link">
            <div>Users</div>
          </a>
        </li>
        <li class="menu-item {{ request()->is('app/roles*') ? 'active' : '' }}">
          <a href="{{ route('app.roles.index') }}" class="menu-link">
            <div>Roles</div>
          </a>
        </li>
      </ul>
    </li>
    @endcan
    @can('read-patients')
    <li class="menu-item {{ request()->is('app/patients*') ? 'active' : '' }}">
      <a href="{{ route('app.patients.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-users"></i>
        <div>Patients</div>
      </a>
    </li>
    @endcan

    {{-- @can('read-appointments')
    <li class="menu-item {{ request()->is('app/appointments*') ? 'active' : '' }}">
      <a href="{{ route('app.appointments.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-calendar"></i>
        <div>Appointments</div>
      </a>
    </li>
    @endcan --}}

    @can('waiting-list')
    <li class="menu-item {{ request()->is('app/wait-list*') ? 'active' : '' }}">
      <a href="{{ route('app.wait-list.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-clock"></i>
        <div>Waiting List</div>
      </a>
    </li>
    @endcan
    @can('read-pharmacy')
    <li class="menu-item {{ request()->is('app/pharmacy*') ? 'active' : '' }}">
      <a href="{{ route('app.pharmacy.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-prescription"></i>
        <div>Pharmacy</div>
      </a>
    </li>
  @endcan
    @can('read-laboratory')
    <li class="menu-item {{ request()->is('app/lab*') ? 'active' : '' }}">
      <a href="{{ route('app.lab.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-vaccine"></i>
        <div>Laboratory</div>
      </a>
    </li>
@endcan
    @can('read-radiology')
    <li class="menu-item {{ request()->is('app/radiology*') ? 'active' : '' }}">
      <a href="{{ route('app.radiology.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-photo"></i>
        <div>Investigations</div>
      </a>
    </li>
@endcan
    <!-- @can('read-opticals')
    <li class="menu-item {{ request()->is('app/opticals*') ? 'active' : '' }}">
      <a href="{{ route('app.opticals.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-eyeglass"></i>
        <div>Opticals</div>
      </a>
    </li>
@endcan -->
@can('read-admission')
    <li class="menu-item {{ request()->is('app/admissions*') ? 'active' : '' }}">
      <a href="{{ route('app.admissions.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-bed"></i>
        <div>Admissions</div>
      </a>
    </li>
@endcan
    @can('read-procedures')
    <li class="menu-item {{ request()->is('app/procedures*') ? 'active' : '' }}">
      <a href="{{ route('app.procedures.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-medical-cross"></i>
        <div>Procedures</div>
      </a>
    </li>
    @endcan
    @can('read-antenatal')
    <li class="menu-item {{ request()->is('app/antenatal*') ? 'active' : '' }}">
      <a href="{{ route('app.antenatals.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-heart-plus"></i>
        <div>Antenatal</div>
      </a>
    </li>
    @endcan
@can('read-billing')
    <li class="menu-item {{ request()->is('app/billing*') ? 'active' : '' }}">
      <a href="{{ route('app.billing.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-report-money"></i>
        <div>Billing</div>
      </a>
    </li>
@endcan
    @can('read-hmo-management')
    <li class="menu-item {{ request()->is('app/hmo*') ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-building-hospital"></i>
        <div>HMO Management</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->is('app/hmo/billing*') ? 'active' : '' }}">
          <a href="{{ route('app.hmo.billing') }}" class="menu-link">
            <div>HMO Billing</div>
          </a>
        </li>
        <li class="menu-item {{ request()->is('app/hmo/finance*') ? 'active' : '' }}">
          <a href="{{ route('app.hmo.finance') }}" class="menu-link">
            <div>Wallets & Finance</div>
          </a>
        </li>
      </ul>
    </li>
    @endcan
    @can('read-report')
    <li class="menu-item {{ request()->is('app/reports*') || request()->is('app/report/hmo*') ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-report"></i>
        <div>Reports</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->is('app/reports*') ? 'active' : '' }}">
          <a href="{{ route('app.reports.index') }}" class="menu-link">
            <div>General Reports</div>
          </a>
        </li>
        <li class="menu-item {{ request()->is('app/report/hmo*') ? 'active' : '' }}">
          <a href="{{ route('app.reports.hmo') }}" class="menu-link">
            <div>HMO Analytics</div>
          </a>
        </li>
      </ul>
    </li>
    @endcan
@can('read-settings')
    <li class="menu-item {{ request()->is('app/settings*') ? 'active' : '' }}">
      <a href="{{ route('app.settings.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-adjustments"></i>
        <div>Settings</div>
      </a>
    </li>
@endcan
  </ul>

</aside>

<!-- Add this JavaScript at the bottom of your layout file -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Initialize menu toggles
    const menuToggles = document.querySelectorAll('.menu-toggle');

    menuToggles.forEach(toggle => {
      toggle.addEventListener('click', function(e) {
        e.preventDefault();
        const parent = this.closest('.menu-item');
        parent.classList.toggle('open');
      });
    });

    // Mobile menu toggle
    const mobileToggle = document.getElementById('mobile');
    if (mobileToggle) {
      mobileToggle.addEventListener('click', function() {
        document.documentElement.classList.toggle('layout-menu-expanded');
      });
    }

    // Close menu on overlay click
    const overlay = document.querySelector('.layout-overlay');
    if (overlay) {
      overlay.addEventListener('click', function() {
        document.documentElement.classList.remove('layout-menu-expanded');
      });
    }

    // Close menu on close toggle click
    const closeToggle = document.querySelector('.layout-menu-toggle.menu-link');
    if (closeToggle) {
      closeToggle.addEventListener('click', function() {
        document.documentElement.classList.remove('layout-menu-expanded');
      });
    }
  });
</script>
