<!-- Main content -->
<?php 
if (isset($branch)) {
    echo form_open("cms/branch/save/".$branch->id, ["id" => "form-info"]);
} else {
    echo form_open("cms/branch/save", ["id" => "form-info"]);
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
                    <div id="msg">
                    <?php $this->load->view("cms/layout/message_box") ?>
                    </div>
                    <div class="form-group">
                        <label for="inputName">Name (*)</label>
                        <input type="text" id="inputName" class="form-control" name="name" value="<?= isset($branch) ? $branch->name : "" ?>">
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">Address (*)</label>
                        <textarea id="inputAddress" class="form-control" rows="4" name="address"><?= isset($branch) ? $branch->address : "" ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="inputNumberOfTables">Number of tables (*)</label>
                        <input type="number" id="inputNumberOfTables" class="form-control" name="tablesNum" value="<?= isset($branch) ? $branch->tables_num : "" ?>">
                    </div>
                    <div class="form-group">
                        <label for="inputManagers">Manager</label>
                        <select id="inputManagers" class="form-control custom-select" name="manager">
                            <option selected disabled>Select a manager</option>
                            <?php foreach ($managers_list as $manager) { ?>
                                <option value="<?= $manager->id?>" <?= isset($branch) && $branch->manager == $manager->id ? "selected" : "" ?>><?= $manager->email.' - '.$manager->name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <input type="submit" value="Save" class="btn btn-primary">
                    <a href="<?= site_url("cms/branch") ?>" class="btn btn-secondary">Cancel</a>
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
    $.post("<?= site_url("cms/branch/check-form") ?>", $(this).serialize(), function(response) {
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