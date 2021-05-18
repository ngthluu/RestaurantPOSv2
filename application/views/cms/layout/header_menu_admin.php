<li class="nav-item <?= $this->uri->segment(2) == "branch" ? "menu-open" : "" ?>">
    <a href="<?= site_url("cms/branch"); ?>" class="nav-link">
        <i class="nav-icon fas fa-map-marker-alt"></i>
        <p>
            Branch
        </p>
    </a>
</li>
<li class="nav-item <?= $this->uri->segment(2) == "staffs" ? "menu-open" : "" ?>">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-user"></i>
        <p>
            Staffs
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="<?= site_url("cms/staffs?type=manager"); ?>" class="nav-link <?= isset($type) && $type == "manager" ? "active" : "" ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Managers</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= site_url("cms/staffs?type=chef"); ?>" class="nav-link <?= isset($type) && $type == "chef" ? "active" : "" ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Chefs</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= site_url("cms/staffs?type=waiter"); ?>" class="nav-link <?= isset($type) && $type == "waiter" ? "active" : "" ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Waiters</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item <?= $this->uri->segment(2) == "menu" ? "menu-open" : "" ?>">
    <a href="<?= site_url("cms/menu"); ?>" class="nav-link">
        <i class="nav-icon fas fa-utensils"></i>
        <p>
            Menu
        </p>
    </a>
</li>
<li class="nav-item <?= $this->uri->segment(2) == "orders" ? "menu-open" : "" ?>">
    <a href="<?= site_url("cms/orders"); ?>" class="nav-link">
        <i class="nav-icon fas fa-file-alt"></i>
        <p>
            Orders
            <span class="right badge badge-info">2</span>
        </p>
    </a>
</li>
<li class="nav-item <?= $this->uri->segment(2) == "customers" ? "menu-open" : "" ?>">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-users"></i>
        <p>
            Customers
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="<?= site_url("cms/customers"); ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Customers list</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= site_url("cms/customers?locked=true"); ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Customers list (locked)</p>
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