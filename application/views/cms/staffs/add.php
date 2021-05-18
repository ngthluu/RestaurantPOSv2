<!-- Main content -->
<?php 
if (isset($staff)) {
    echo form_open_multipart("cms/staffs/save/".$staff->id."?type=".$type, array("id" => "form-info"));
} else {
    echo form_open_multipart("cms/staffs/save?type=".$type, array("id" => "form-info"));
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
                        "title" => "Avatar (*)",
                        "name" => "avatar",
                        "image_link" => isset($staff) && $staff->avatar ? base_url("resources/users/".$staff->id."/".$staff->avatar) : base_url("resources/no-avatar.png"),
                    )) ?>
                    <div class="form-group">
                        <label for="inputEmail">Email</label>
                        <input readonly type="text" id="inputEmail" class="form-control" name="email" value="<?= isset($staff) ? $staff->email : "" ?>">
                    </div>
                    <div class="form-group">
                        <label for="inputName">Name (*)</label>
                        <input type="text" id="inputName" class="form-control" name="name" value="<?= isset($staff) ? $staff->name : "" ?>">
                    </div>
                    <div class="form-group">
                        <label for="inputPhone">Phone (*)</label>
                        <input type="text" id="inputPhone" class="form-control" name="phone" value="<?= isset($staff) ? $staff->phone : "" ?>">
                    </div>
                    <div class="form-group">
                        <label for="inputIdc">Identity Card (*)</label>
                        <input type="number" id="inputIdc" class="form-control" name="idc" value="<?= isset($staff) ? $staff->idc : "" ?>">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputGender">Gender (*)</label>
                                <select id="inputGender" class="form-control custom-select" name="gender">
                                    <option selected disabled>Select a gender</option>
                                    <?php foreach (gender_array() as $num => $title) { ?>
                                    <option value="<?= $num ?>" <?= isset($staff) && $staff->gender == $num ? "selected" : "" ?>><?= $title ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputBirthday">Birthday (*)</label>
                                <input type="date" id="inputBirthday" class="form-control" name="birthday" value="<?= isset($staff) ? $staff->birthday : "" ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputBranch">Branch (*)</label>
                        <select id="inputBranch" class="form-control custom-select" name="branch">
                            <option selected disabled>Select a branch</option>
                            <?php foreach ($branch_list as $branch) { ?>
                                <option value="<?= $branch->id?>" <?= isset($staff) && $staff->branch == $branch->id ? "selected" : "" ?>><?= $branch->name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <input type="submit" value="Save" class="btn btn-primary">
                    <a href="<?= site_url("cms/staffs?type=".$type) ?>" class="btn btn-secondary">Cancel</a>
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
    $.post("<?= site_url("cms/staffs/check-form?type=".$type) ?>", $(this).serialize(), function(response) {
        if (response == "ok") {
            $("#form-info").off("submit").submit();
        } else {
            $("#msg").html(response);
        }
    });
});


});

</script>