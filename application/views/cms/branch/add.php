<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">General</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="inputName">Name (*)</label>
                        <input type="text" id="inputName" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputDescription">Address (*)</label>
                        <textarea id="inputDescription" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="inputClientCompany">Number of tables (*)</label>
                        <input type="text" id="inputClientCompany" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputStatus">Manager (*)</label>
                        <select id="inputStatus" class="form-control custom-select">
                            <option selected disabled>Select one</option>
                            <?php foreach ($managers_list as $manager) { ?>
                                <option value="<?= $manager->id?>"><?= $manager->email.' - '.$manager->name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <input type="submit" value="Add Branch" class="btn btn-success">
                    <a href="<?= site_url("cms/branch") ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</section>
<!-- /.content -->