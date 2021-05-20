
<main id="main" class="d-flex flex-column justify-content-start menu-list">
    <div class="container">
        <h1 class="page-title t-white font-weight-bold mt-3">
            <?php if (isset($_SESSION["cart"]) && !empty($_SESSION["cart"]->details)) { ?>
            <a href="<?= site_url("order/index/".$_SESSION["cart"]->branch."/".$_SESSION["cart"]->table) ?>" class="t-white"><i class="bi bi-arrow-left"></i></a> 
            <?php } ?>
            Your order
        </h1>
        <?php if (isset($_SESSION["cart"]) && !empty($_SESSION["cart"]->details)) { ?>
        <?php echo form_open("checkout/waiting", ["id" => "form-info"]); ?>
        <div class="row">
            <div class="col-md-8">
            <?php 
            $total_quantity = 0;
            $total_price = 0;
            foreach ($_SESSION["cart"]->details as $menuObj) { 
                $menu = $this->M_Menu->get($menuObj->id);
                $menuQuantity = $menuObj->quantity;
                
                $total_quantity += $menuQuantity;
                $total_price += $menuQuantity * $menu->price;
            ?>
                <div class="container">
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
                            <p class="price"><?= number_format($menu->price) ?>đ x <span class="quantity"><?= $menuQuantity ?></span></p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="price align-self-center item-total"><?= number_format($menu->price * $menuQuantity) ?>đ</p>
                            <div class="d-flex justify-content-end">
                                <button class="btn-minus btn btn-danger mr-2"><i class="bi bi-dash"></i></button>
                                <button class="btn-plus btn btn-danger mr-2"><i class="bi bi-plus"></i></button>
                                <button class="btn-remove btn btn-danger"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            </div>
            <div class="col-md-4">
                <div class="checkoutinfo-box d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between">
                            <strong class="t-red">Total Item(s): </strong>
                            <strong class="total-quantity"><?= $total_quantity ?></strong>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <strong class="t-red">Total Price: </strong>
                            <strong class="total-price"><?= number_format($total_price) ?>đ</strong>
                        </div>
                        <div class="mt-2">
                            <strong class="t-red">Note: </strong>
                            <textarea class="form-control mt-2" rows="3" name="note" placeholder="Your note"></textarea>
                        </div>
                    </div>
                    <div>
                        <hr>
                        <button type="submit" class="btn btn-danger btn-block">Pay this order</button>
                    </div>
                </div>
            </div>
        </div>
        <?= form_close() ?>
        <?php } else { ?>
        <div class="t-yellow mt-3">Your order is currently empty.</div> 
        <?php } ?>
    </div>
</main>

<?php if (isset($_SESSION["cart"]) && !empty($_SESSION["cart"]->details)) { ?>
<script>

var total_quantity = <?= $total_quantity ?>;
var total_price = <?= $total_price ?>;

document.addEventListener("DOMContentLoaded", function (event) {

    function updateQuantity(target, delta) {
        let menu = target.closest('.menu-box');
        let menuId = menu.attr('data-id');

        let input = menu.find('.quantity');
        let menuQuantity = parseInt(input.html());

        let itemTotal = menu.find('.item-total');

        let data = {
            menuId: menuId,
            menuQuantity: menuQuantity + delta
        }

        if (data.menuQuantity <= 0) return;

        $.post('<?= site_url("order/update-cart") ?>', data, function(response) {
            if (response.status == "ok") {
                item_total_price = response.menuPrice * response.menuQuantityNew;
                total_quantity += response.menuQuantityNew - response.menuQuantityOld;
                total_price += response.menuPrice * (response.menuQuantityNew - response.menuQuantityOld);
                input.html(response.menuQuantityNew);
                itemTotal.html(`${item_total_price.toLocaleString('en-US')}đ`);
                $('.total-price').html(`${total_price.toLocaleString('en-US')}đ`);
                $('.total-quantity').html(total_quantity);
            } else {
                toastr.error(response.message);
            }
        }, 'json');
    }

    $('.btn-minus').on('click', function(e) {
        updateQuantity($(this), -1);
    });

    $('.btn-plus').on('click', function(e) {
        updateQuantity($(this), 1);
    });

    $('.btn-remove').on('click', function(e) {
        let menu = $(this).closest('.menu-box');
        let menuId = menu.attr('data-id');

        let data = {
            menuId: menuId
        }

        $.post('<?= site_url("order/remove-cart") ?>', data, function(response) {
            if (response == "ok") {
                location.reload();
            } else {
                toastr.error(response);
            }
        });
    });
});
</script>
<?php } ?>