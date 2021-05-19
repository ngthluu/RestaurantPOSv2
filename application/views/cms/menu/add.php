<!-- Main content -->
<?php 
if (isset($menu)) {
    echo form_open_multipart("cms/menu/save/".$menu->id."", array("id" => "form-info"));
} else {
    echo form_open_multipart("cms/menu/save", array("id" => "form-info"));
}
?>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">General</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="msg"> <?php $this->load->view("cms/layout/message_box") ?> </div>
                    <?php $this->load->view("cms/layout/avatar_box", array(
                        "title" => "Image",
                        "name" => "image",
                        "image_link" => isset($menu) && $menu->image ? base_url("resources/menu/".$menu->id."/".$menu->image) : base_url("resources/no-image.jpg"),
                    )) ?>
                    <div class="form-group">
                        <label for="inputName">Name (*)</label>
                        <input type="text" id="inputName" class="form-control" name="name" value="<?= isset($menu) ? $menu->name : "" ?>">
                    </div>
                    <div class="form-group">
                        <label for="inputPrice">Price (*)</label>
                        <input type="number" id="inputPrice" class="form-control" name="price" value="<?= isset($menu) ? $menu->price : "" ?>">
                    </div>
                    <div class="form-group">
                        <label for="inputDescription">Description</label>
                        <textarea id="inputDescription" class="form-control" rows="4" name="description"><?= isset($menu) ? $menu->description : "" ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="inputBranch">Branch</label>
                        <select id="inputBranch" class="form-control custom-select" name="branch">
                            <option selected disabled>Select a branch</option>
                            <?php foreach ($branch_list as $branch) { ?>
                                <option value="<?= $branch->id?>" <?= isset($menu) && $menu->branch == $branch->id ? "selected" : "" ?>><?= $branch->name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <input type="submit" value="Save" class="btn btn-primary">
                    <a href="<?= site_url("cms/menu") ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</section>
<?php echo form_close(); ?>
<!-- /.content -->

<script>
document.addEventListener("DOMContentLoaded", function (event) {

$("#form-info").submit(function(e) {
    e.preventDefault();
    $.post("<?= site_url("cms/menu/check-form") ?>", $(this).serialize(), function(response) {
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