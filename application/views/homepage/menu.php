<main id="main" class="d-flex flex-column justify-content-center" 
    style="
        background:url(<?= $menu->image ? base_url("resources/menu/".$menu->id."/".$menu->image) : base_url("resources/no-image.jpg") ?>);
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    ">
    <div class="container menu-view">
        <div>
            <h1 class="page-title t-white font-weight-bold mt-3">
                <?= $menu->name ?>
            </h1>
            <div class="rating mt-3">
                <?php $menu_rating_point = $this->M_Menu->get_rating_point($menu->id);?>
                <span class="fas fa-star <?= $menu_rating_point >= 1 ? "checked" : "" ?>"></span>
                <span class="fas fa-star <?= $menu_rating_point >= 2 ? "checked" : "" ?>"></span>
                <span class="fas fa-star <?= $menu_rating_point >= 3 ? "checked" : "" ?>"></span>
                <span class="fas fa-star <?= $menu_rating_point >= 4 ? "checked" : "" ?>"></span>
                <span class="fas fa-star <?= $menu_rating_point >= 5 ? "checked" : "" ?>"></span>
                <span class="ml-2">(<?= round($menu_rating_point, 2) ?>/5)</span>
            </div>
            <p class="price mt-3"><?= number_format($menu->price) ?>đ</p>
        </div>
        <p class="mt-5"><?= $menu->description ?></p>
        <?php $this->load->view('homepage/menu_comments', ["menu_id" => $menu->id]) ?>
    </div>
</main>

