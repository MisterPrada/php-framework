<?php ob_start(); ?>
<div>
    Пользователь: <?= $userName ?><br>
    Администратор: <?= $name ?><br>
    uuid: <?= uniqid() ?>
</div>
<?php $content = ob_get_clean(); ?>

<?php require __VIEWS__ . "/layouts/main.php";?>

