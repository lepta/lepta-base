<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
<style type='text/css'>
body
{
	font-family: Arial;
	font-size: 14px;
}
a {
    color: blue;
    text-decoration: none;
    font-size: 14px;
}
a:hover
{
	text-decoration: underline;
}
</style>
</head>
<body>
	<div>
        <a href='<?php echo site_url('index/content')?>'>Контент</a> |
        <a href='<?php echo site_url('index/meta')?>'>Мета Теги</a> |
        <a href='<?php echo site_url('index/reviews')?>'>Отзывы</a> |
        <a href='<?php echo site_url('orders/index/all')?>'>Заказы</a> |
        <a href='<?php echo site_url('drugstores')?>'>Аптеки</a> |
        <a href='<?php echo site_url('index/faq')?>'>Faq</a>
	</div>
	<div style="margin-top: 20px">
        <a href='<?php echo site_url('drugstores')?>'>Аптеки</a> |
        <a href='<?php echo site_url('drugstores/brands')?>'>Сети аптек</a> |
		<a href='<?php echo site_url('drugstores/cities')?>'>Города</a> |
		<a href='<?php echo site_url('drugstores/regions')?>'>Регионы</a> |
	</div>
    <div>
		<?php echo $output; ?>
    </div>
</body>
</html>
