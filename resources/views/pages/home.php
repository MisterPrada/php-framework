<?php ob_start(); ?>
    <div id="app">
        Home Page
        <br>
        <test-component></test-component>
    </div>
<?php $content = ob_get_clean(); ?>

<?php ob_start(); ?>
    <script src="/js/home.js"></script>
<?php $scripts = ob_get_clean(); ?>

<?php require __VIEWS__ . "/layouts/main.php";?>