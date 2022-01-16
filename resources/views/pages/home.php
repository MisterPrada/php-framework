<?php ob_start(); ?>
    <div class="flex-center position-ref full-height">
        <div class="top-right links">
            <span>
                Приветствуем вас, Алексей
            </span>

            <a href="/">Главная</a>

            <a href="/">Выйти</a>
        </div>

        <div id="app" class="content">
            <div class="title m-b-md">
                Mister&Prada
<!--                <test-component></test-component>-->
            </div>
        </div>
    </div>
<?php $content = ob_get_clean(); ?>

<?php ob_start(); ?>
<script>
    console.log('footer include scripts')
</script>
<?php $scripts = ob_get_clean(); ?>

<?php require __VIEWS__ . "/layouts/main.php";?>

