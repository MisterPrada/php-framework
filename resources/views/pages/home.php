<?php ob_start(); ?>
    <div class="flex-center position-ref full-height">
        <div class="top-right links">
            <span>
                Приветствуем вас, Алексей
            </span>

            <a href="/">Главная</a>

            <a href="/">Выйти</a>
        </div>

        <div class="content">
            <div class="title m-b-md">
                Mister&Prada
            </div>
        </div>
    </div>
<?php $content = ob_get_clean(); ?>

<?php require __VIEWS__ . "/layouts/main.php";?>

