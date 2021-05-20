<main id="main">
    <div class="container d-flex h-100">
        <div class="justify-content-center align-self-center">
            <?php echo form_open("signin/signin", ["id" => "form-info"]); ?>
            <h1 class="page-title t-white font-weight-bold">
                Edit your account settings
            </h1>
            <div id="msg" class="mt-5"> <?php $this->load->view("homepage/layout/message_box") ?> </div>
            <?php $this->load->view("homepage/layout/avatar_box", [
                "name" => "avatar",
                "image_link" => isset($staff) && $staff->avatar ? base_url("resources/users/".$staff->id."/".$staff->avatar) : base_url("resources/no-avatar.png"),
            ]) ?>
            <div class="input-group mt-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="bi bi-phone"></i></span>
                </div>
                <input type="text" name="phone" class="form-control" placeholder="Your phone">
            </div>
            <div class="input-group mt-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="bi bi-inbox"></i></span>
                </div>
                <input type="email" name="email" class="form-control" placeholder="Your email">
            </div>
            <div class="input-group mt-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                </div>
                <input type="text" name="name" class="form-control" placeholder="Your name">
            </div>
            <div class="input-group mt-3">
            <?php foreach (gender_array() as $value => $title) { ?>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="radioGender<?= $value ?>" name="gender" value="<?= $value ?>" class="custom-control-input">
                    <label class="custom-control-label t-white" for="radioGender<?= $value ?>"><?= $title ?></label>
                </div>
            <?php } ?>
            </div>
            <div class="input-group mt-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                </div>
                <input type="date" name="birthday" class="form-control" placeholder="Your birthday">
            </div>
            <div class="input-group mt-3">
                <textarea class="form-control" rows="3" name="address" placeholder="Your address"></textarea>
            </div>
            
            <div class="mt-5">
                <button class="btn btn-danger" href="#">Save information</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</main>

