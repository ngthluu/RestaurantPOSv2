<li class="nav-item <?= $this->uri->segment(2) == "orders" ? "menu-open" : "" ?>">
    <a href="<?= site_url("cms/orders"); ?>" class="nav-link">
        <i class="nav-icon fas fa-file-alt"></i>
        <p>
            Orders
        </p>
    </a>
</li>
<li class="nav-item <?= $this->uri->segment(2) == "statistics" ? "menu-open" : "" ?>">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-chart-pie"></i>
        <p>
            Statistics
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="<?= site_url("cms/statistics/salary"); ?>" class="nav-link <?= $this->uri->segment(2) == "statistics" && $this->uri->segment(3) == "salary" ? "active" : "" ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Salary</p>
            </a>
        </li>
    </ul>
</li>