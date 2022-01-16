<?php

use DynamicFields\Fields\FieldOptions;
use DynamicFields\Fields\TextField;

?>

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

<?php
    // Fields Test
    $textField = new TextField('test_field', 'Test Field!');
    $textField->addAttribute('placeholder', 'This is placehoder');
    $textField->addAttribute('style', 'border: 2px solid black; padding: 0.5em; font-size: 16px;');

    $textFieldOptions = new FieldOptions('test');

    ob_start();

    $textField->renderDom($textFieldOptions);

    print ob_get_clean();
?>

<?php ob_start(); ?>
<script>
    console.log('footer include scripts')
</script>
<?php $scripts = ob_get_clean(); ?>

<?php require __VIEWS__ . "/layouts/main.php";?>

