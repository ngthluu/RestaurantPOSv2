<main id="main" class="d-flex flex-column justify-content-center">
    <div class="container col-auto mt-5 mb-5">
        <?php echo form_open_multipart("settings/save", ["id" => "form-info"]); ?>
        <h1 class="page-title t-white font-weight-bold">
            Edit your account settings
        </h1>
        <div id="msg" class="mt-5"> <?php $this->load->view("homepage/layout/message_box") ?> </div>
        <?php $this->load->view("homepage/layout/avatar_box", [
            "name" => "avatar",
            "image_link" => $customer->avatar ? base_url("resources/customers/".$customer->id."/".$customer->avatar) : base_url("resources/no-avatar.png"),
        ]) ?>
        <div class="input-group mt-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="bi bi-phone"></i></span>
            </div>
            <input type="text" name="phone" class="form-control" placeholder="Your phone" value="<?= $customer->phone ?>">
        </div>
        <div class="input-group mt-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="bi bi-inbox"></i></span>
            </div>
            <input type="email" name="email" class="form-control" placeholder="Your email" value="<?= $customer->email ?>">
        </div>
        <div class="input-group mt-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
            </div>
            <input type="text" name="name" class="form-control" placeholder="Your name" value="<?= $customer->name ?>">
        </div>
        <div class="input-group mt-3">
        <?php foreach (gender_array() as $value => $title) { ?>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="radioGender<?= $value ?>" name="gender" value="<?= $value ?>" class="custom-control-input" <?= $customer->gender == $value ? "checked" : "" ?>>
                <label class="custom-control-label t-white" for="radioGender<?= $value ?>"><?= $title ?></label>
            </div>
        <?php } ?>
        </div>
        <div class="input-group mt-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="bi bi-calendar"></i></span>
            </div>
            <input type="date" name="birthday" class="form-control" placeholder="Your birthday" value="<?= $customer->birthday ?>">
        </div>
        <div class="input-group mt-3">
            <textarea class="form-control" rows="3" name="address" placeholder="Your address"><?= $customer->address ?></textarea>
        </div>
        
        <div class="mt-5">
            <button class="btn btn-danger" href="#">Save information</button>
        </div>
        <?php echo form_close(); ?>
    </div>
</main>

<script>
document.addEventListener("DOMContentLoaded", function (event) {

$("#form-info").submit(function(e) {
    e.preventDefault();
    $.post("<?= site_url("settings/check-form") ?>", $(this).serialize(), function(response) {
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
