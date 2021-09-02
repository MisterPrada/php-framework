<?php ob_start(); ?>
    <div>
        <h1>Hi, <?= $name ?></h1>

        <div>
            <p>
                Content with you <a href="<?= route('user') ?>">User</a>
            </p>
        </div>
    </div>
<?php $content = ob_get_clean(); ?>

<?php require "layouts/main.php";?>