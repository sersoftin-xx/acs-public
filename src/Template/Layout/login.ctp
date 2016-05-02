<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <title>ACS Panel — <?= $this->fetch('title') ?> </title>
    <?= $this->Html->css('bootstrap.min.css') ?>
    <?= $this->fetch('css') ?>
</head>
<body>
<?= $this->fetch('content') ?>

<?= $this->Html->script('jquery.min.js') ?>
<?= $this->Html->script('bootstrap.min.js') ?>
</body>
</html>