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
            <p class="price"><?= number_format($menu->price) ?>đ</p>
            <div class="rating mt-3">
                <span class="fas fa-star checked"></span>
                <span class="fas fa-star checked"></span>
                <span class="fas fa-star checked"></span>
                <span class="fas fa-star"></span>
                <span class="fas fa-star"></span>
            </div>
        </div>
        <p class="mt-5"><?= $menu->description ?></p>
        <?php $this->load->view('homepage/menu_comments') ?>
    </div>
</main>

