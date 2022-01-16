<?php
/**
 * @var string $lang
 * @var string $content
 * @var string $scripts
 */
?>
<!doctype html>
<html lang="<?= $lang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    <?= $content ?>
</body>

<script src="/js/app.js"></script>
<?= $scripts ?>
</html>