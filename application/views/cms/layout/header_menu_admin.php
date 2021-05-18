<li class="nav-item">
    <a href="<?= site_url("cms/branch"); ?>" class="nav-link">
        <i class="nav-icon fas fa-map-marker-alt"></i>
        <p>
            Branch
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-user"></i>
        <p>
            Staffs
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="<?= site_url("cms/staffs?type=manager"); ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Managers</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= site_url("cms/staffs?type=chef"); ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Chefs</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= site_url("cms/staffs?type=waiter"); ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Waiters</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item">
    <a href="<?= site_url("cms/menu"); ?>" class="nav-link">
        <i class="nav-icon fas fa-utensils"></i>
        <p>
            Menu
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= site_url("cms/orders"); ?>" class="nav-link">
        <i class="nav-icon fas fa-file-alt"></i>
        <p>
            Orders
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-users"></i>
        <p>
            Users
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="<?= site_url("cms/users"); ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Users list</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= site_url("cms/users?locked=true"); ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Users list (locked)</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-chart-pie"></i>
        <p>
            Statistics
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="<?= site_url("cms/revenue"); ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Revenue</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= site_url("cms/salary"); ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Salary</p>
            </a>
        </li>
    </ul>
</li>