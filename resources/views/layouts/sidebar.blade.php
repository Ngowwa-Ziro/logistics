
<div class="sidebar p-3">
    <a href="{{ route('dashboard') }}" class="d-block p-2">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>


    <a href="{{ route('users.index') }}" class="d-block p-2">
        <i class="fas fa-users"></i> User Management
    </a>


    <div class="menu">
        <a href="#" class="menu-toggle d-block p-2">
            <i class="fas fa-cogs"></i> Configurations ▾
        </a>
        <div class="submenu pl-3">
            <a href="{{ route('roles.index') }}" class="d-block p-2">
                <i class="fas fa-user-shield"></i> Roles
            </a>
            <a href="{{ route('permissions.index') }}" class="d-block p-2">
                <i class="fas fa-key"></i> Permissions
            </a>
        </div>
    </div>

    <div class="menu">
        <a href="#" class="menu-toggle">
            <i class="fas fa-car"></i> Trips ▾
        </a>
        <div class="submenu">
            <a href="{{ route('trips.index') }}" class="pl-3">
                <i class="fas fa-eye"></i> View Trips
            </a>
            <a href="{{ route('trips.book') }}" class="pl-3">
                <i class="fas fa-plus"></i> Book Trip
            </a>
        </div>
    </div>

    <div class="flex-grow"></div>
</div>

<script>
    document.querySelectorAll('.menu-toggle').forEach(item => {
        item.addEventListener('click', function() {
            this.nextElementSibling.classList.toggle('active');
        });
    });
</script>

<style>
    .sidebar {
        width: 250px;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    }
    .submenu {
        display: none;
    }
    .submenu.active {
        display: block;
    }
    a {
        color: #333;
        text-decoration: none;
        display: block;
    }
    a:hover {
        background: #f8f9fa;
        border-radius: 5px;
    }
</style>


