<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">


    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route(Auth::user()->hasRole('admin') ? 'admin.dashboard' : (Auth::user()->hasRole('driver') ? 'driver.dashboard' : 'customer.dashboard')) }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Logistics</div>
    </a>

    <hr class="sidebar-divider my-0">


    <li class="nav-item">
        <a class="nav-link" href="{{ route(Auth::user()->hasRole('admin') ? 'admin.dashboard' : (Auth::user()->hasRole('driver') ? 'driver.dashboard' : 'customer.dashboard')) }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    @can('manage users')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('users.index') }}">
            <i class="fas fa-users"></i>
            <span>User Management</span>
        </a>
    </li>
    @endcan

    @can('manage roles')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseConfigurations" aria-expanded="true" aria-controls="collapseConfigurations">
            <i class="fas fa-cogs"></i>
            <span>Configurations</span>
        </a>
        <div id="collapseConfigurations" class="collapse" aria-labelledby="headingConfigurations" data-parent="#accordionSidebar">
            <div class=" py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('roles.index') }}">
                    <i class="fas fa-user-shield"></i> Roles
                </a>
                <a class="collapse-item" href="{{ route('permissions.index') }}">
                    <i class="fas fa-key"></i> Permissions
                </a>
            </div>
        </div>
    </li>
    @endcan


    @role('super-admin')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCompanies" aria-expanded="true" aria-controls="collapseCompanies">
            <i class="fas fa-building"></i>
            <span>Companies</span>
        </a>
        <div id="collapseCompanies" class="collapse" aria-labelledby="headingCompanies" data-parent="#accordionSidebar">
            <div class="py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('super-admin.add') }}">
                    <i class="fas fa-plus-circle"></i> Add Company
                </a>
                <a class="collapse-item" href="{{ route('super-admin.companies') }}">
                    <i class="fas fa-list"></i> View Companies
                </a>
            </div>
        </div>
    </li>
    @endrole



    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTrips" aria-expanded="true" aria-controls="collapseTrips">
            <i class="fas fa-car"></i>
            <span>Trips</span>
        </a>
        <div id="collapseTrips" class="collapse" aria-labelledby="headingTrips" data-parent="#accordionSidebar">
            <div class="py-2 collapse-inner rounded">
                @role('customer')
                <a class="collapse-item" href="{{ route('customer.book') }}">
                    <i class="fas fa-plus"></i> Book Trip
                </a>
                <a class="collapse-item" href="{{ route('view.trip') }}">
                    <i class="fas fa-eye"></i> View Trips
                </a>
                @endrole

                @role('admin')
                <a class="collapse-item" href="{{ route('manageTrips') }}">
                    <i class="fas fa-edit"></i> Manage Trips
                </a>
                <a class="collapse-item" href="{{ route('admin.allTrips') }}">
                    <i class="fas fa-eye"></i> All Trips
                </a>
                <a class="collapse-item" href="{{ route('vehicles.create') }}">
                    <i class="fas fa-car"></i> Add Vehicle
                </a>
                <a class="collapse-item" href="{{ route('vehicles.all') }}">
                    <i class="fas fa-warehouse"></i> All Vehicles
                </a>
                @endrole

                @role('driver')
                <a class="collapse-item" href="{{ route('viewTrip') }}">
                    <i class="fas fa-cogs"></i> Manage Trip
                </a>
                <a class="collapse-item" href="{{ route('index') }}">
                    <i class="fas fa-road"></i> My Trips
                </a>
                @endrole

            </div>
        </div>
    </li>

    @role('admin')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReports" aria-expanded="true" aria-controls="collapseReports">
            <i class="fas fa-chart-line"></i>
            <span>Reports</span>
        </a>
        <div id="collapseReports" class="collapse" aria-labelledby="headingReports" data-parent="#accordionSidebar">
            <div class=" py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('reports.successful') }}">
                    <i class="fas fa-check-circle"></i> Successful Trips
                </a>
                <a class="collapse-item" href="{{ route('reports.unsuccessful') }}">
                    <i class="fas fa-times-circle"></i> Unsuccessful Trips
                </a>
                <a class="collapse-item" href="{{ route('driver.report') }}">
                    <i class="fas fa-truck"></i> Driver Reports
                </a>
            </div>
        </div>
    </li>
    @endrole



    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>

