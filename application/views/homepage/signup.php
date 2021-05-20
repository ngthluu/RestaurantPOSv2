<main id="main">
    <div class="container d-flex h-100">
        <div class="justify-content-center align-self-center">
        <?php echo form_open("signup/save", ["id" => "form-info"]); ?>
            <h1 class="page-title t-white font-weight-bold">
                Sign up to <?= PROJECT_SHORTCUT ?>
            </h1>
            <h3 class="t-yellow mt-3">
                Fast, convenient & delicious.
            </h3>
            <div id="msg" class="mt-5"> <?php $this->load->view("homepage/layout/message_box") ?> </div>
            <div class="input-group mt-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="bi bi-phone"></i></span>
                </div>
                <input type="text" class="form-control" name="phone" placeholder="Your phone">
            </div>
            <div class="input-group mt-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="bi bi-key"></i></span>
                </div>
                <input type="password" class="form-control" name="password"  placeholder="Your password">
            </div>
            <div class="input-group mt-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="bi bi-key"></i></span>
                </div>
                <input type="password" class="form-control" name="repassword"  placeholder="Re type your password">
            </div>
            <div class="input-group mt-3">
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" name="privacy" id="privacyPolicy">
                    <label class="custom-control-label t-white" for="privacyPolicy">
                        I accept the <a href="<?= site_url("privacy-policy") ?>">Privacy and Policy.</a>
                    </label>
                </div>
            </div>
            <div class="mt-5">
                <button class="btn btn-danger" href="#">Sign up</button>
            </div>
            <div class="mt-3">
                <div class="t-white">Already have an account ?</div>
                <a href="<?= site_url("signin") ?>" class="t-red">Sign in here</a>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</main>

<script>
document.addEventListener("DOMContentLoaded", function (event) {

$("#form-info").submit(function(e) {
    e.preventDefault();
    $.post("<?= site_url("signup/check-form") ?>", $(this).serialize(), function(response) {
        if (response == "ok") {
            $("#form-info").off("submit").submit();
        } else {
            $("html, body").animate({ scrollTop: 0 }, "fast");
            $("#msg").html(response);
        }
    });
});

});

</script>