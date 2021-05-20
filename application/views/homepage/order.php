<main id="main">
    <div class="container d-flex h-100">
        <div class="justify-content-center align-self-center">
            <h1 class="page-title t-white font-weight-bold">
                Order
            </h1>
            <h3 class="t-yellow mt-3">
                Fast, convenient & delicious.
            </h3>
            <?php if (is_logged_in()) { ?>
            <div class="t-white mt-3">
                Scan QR Code and have a delicious meal.
            </div>
            <?php } else { ?>
            <div class="t-white mt-3">
                Create account, scan QR Code and have a delicious meal.
            </div>
            <div class="mt-5">
                <a href="<?= site_url("signup") ?>" class="btn btn-danger" href="#">Sign up here > </a>
            </div>
            <div class="mt-3">
                <div class="t-white">Already have account ?</div>
                <a href="<?= site_url("signin") ?>" class="t-red">Sign in here</a>
            </div>
            <?php } ?>
        </div>
    </div>
</main>

