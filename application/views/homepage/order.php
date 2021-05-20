<main id="main" class="d-flex flex-column justify-content-start menu-list">
    <div class="container">
        <h1 class="page-title t-white font-weight-bold mt-3">
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
                    "
                data-id="<?= $menu->id ?>"
                > 
                    <div>
                        <h3><?= $menu->name ?></h3>
                        <p class="price"><?= number_format($menu->price) ?>đ</p>
                    </div>
                    <p><?= word_limiter($menu->description, 50) ?></p>
                    <div class="d-flex justify-content-end">
                        <button class="btn-minus btn btn-danger mr-2"><i class="bi bi-dash"></i></button>
                        <input type="number" class="quantity mr-2 text-center" value="1">
                        <button class="btn-plus btn btn-danger mr-2"><i class="bi bi-plus"></i></button>
                        <button class="btn-add-cart btn btn-danger"><i class="bi bi-cart-plus"></i></button>
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

<script>
document.addEventListener("DOMContentLoaded", function (event) {
    $('.btn-minus').on('click', function(e) {
        let input = $(this).closest('.menu-box').find('.quantity');
        let quantity = parseInt(input.val());
        if (quantity > 1) input.val(quantity - 1);
    });

    $('.btn-plus').on('click', function(e) {
        let input = $(this).closest('.menu-box').find('.quantity');
        let quantity = parseInt(input.val());
        input.val(quantity + 1);
    });

    $('.btn-add-cart').on('click', function(e) {
        let menu = $(this).closest('.menu-box');
        let menuId = menu.attr('data-id');

        let input = menu.find('.quantity');
        let menuQuantity = parseInt(input.val());
        console.log([menuId, menuQuantity]);
    });
});
</script>
