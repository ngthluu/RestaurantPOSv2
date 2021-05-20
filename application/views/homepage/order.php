<main id="main" class="d-flex flex-column justify-content-start menu-list">
    <div class="container">
        <h1 class="page-title t-white font-weight-bold">
            Our menu
        </h1>
        <?php if (!empty($menu_list)) { ?>
        <div class="row gy-4">
        <?php foreach ($menu_list as $menu) { ?>
            <div class="col-md-6 mb-3">
                <div class="menu-box d-flex flex-column justify-content-between"
                style="
                background:url(<?= $menu->image ? base_url("resources/menu/".$menu->id."/".$menu->image) : base_url("resources/no-image.jpg") ?>);
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
                box-shadow: inset 0 0 0 2000px rgba(0, 0, 0, 0.5);
                "> 
                    <div>
                        <h3><?= $menu->name ?></h3>
                        <p class="price"><?= number_format($menu->price) ?>đ</p>
                    </div>
                    <p><?= word_limiter($menu->description, 30) ?></p>
                    <div class="d-flex justify-content-end">
                        <input type="number" class="mr-2 text-center" value="0">
                        <button class="btn btn-danger"><i class="bi bi-cart"></i></button>
                    </div>
                </div>
            </div>
        <?php } ?>
        </div>
        <?php } else { ?>
        <div class="t-yellow mt-3">The menu is currently empty.</div> 
        <?php } ?>
    </div>
</main>

