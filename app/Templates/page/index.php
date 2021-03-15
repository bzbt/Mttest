<?php
$title = 'Upload CSV file';
require __DIR__.'/../header.php';
?>
    <div class="row">
        <div class="col-8 mx-auto">
            <p>Max file size: <?= ini_get('upload_max_filesize'); ?></p>

            <form enctype="multipart/form-data" action="/report" method="POST">
                <div class="form-group">
                    <input type="hidden" name="token" value="<?= $token; ?>"/>
                    <input class="form-control-file" type="file" name="calls"/>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Proceed</button>
                </div>
            </form>
        </div>
    </div>
<?php
require __DIR__.'/../footer.php';
