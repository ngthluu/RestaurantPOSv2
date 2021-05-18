<div class="form-group">
    <label><?= $title ?></label>
    <div class="clear"></div>
    <label>
        <?php if (!(isset($view) && $view)) { ?>
        <input type="file" onchange="previewAvatar(event)" name="<?= $name ?>-file" style="display:none"/>
        <?php } ?>
        <img src="<?= $image_link ?>" alt="Choose avatar" style="max-height:100px" id="<?= $name?>-image" name="<?= $name?>-image"/>
    </label>
</div>

<?php if (!(isset($view) && $view)) { ?>
<script>
function previewAvatar(event) {
    var output = document.getElementById('<?= $name ?>-image');
    output.src = URL.createObjectURL(event.target.files[0]);
};
</script>
<?php } ?>