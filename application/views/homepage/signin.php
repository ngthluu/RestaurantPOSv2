<main id="main" class="d-flex flex-column justify-content-center">
    <div class="container col-auto">
        <?php echo form_open("signin/signin", ["id" => "form-info"]); ?>
        <h1 class="page-title t-white font-weight-bold">
            Sign in to <?= PROJECT_SHORTCUT ?>
        </h1>
        <h3 class="t-yellow mt-3">
            Fast, convenient & delicious.
        </h3>
        <div id="msg" class="mt-5"> <?php $this->load->view("homepage/layout/message_box") ?> </div>
        <div class="input-group mt-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="bi bi-phone"></i></span>
            </div>
            <input type="text" name="phone" class="form-control" placeholder="Your phone">
        </div>
        <div class="input-group mt-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="bi bi-key"></i></span>
            </div>
            <input type="password" name="password" class="form-control" placeholder="Your password">
        </div>
        <div class="mt-5">
            <button class="btn btn-danger" href="#">Sign in</button>
        </div>
        <div class="mt-3">
            <div class="t-white">Not have an account ?</div>
            <a href="<?= site_url("signup") ?>" class="t-red">Sign up here</a>
        </div>
        <?php echo form_close(); ?>
    </div>
</main>

