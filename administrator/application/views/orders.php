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
		<a href='<?php echo $baseurl ?>/all'>Все</a> | 
		<a href='<?php echo $baseurl ?>/leptaden.com.ua'>Лептаден</a> | 
	</div>
	<div style="margin-top: 20px">
		<a href='<?php echo $siteurl ?>/delivered_unpaid'>Доставлен, не оплачен</a> | 
		<a href='<?php echo $siteurl ?>/delivered_paid'>Доставлен, оплачен</a> | 
		<a href='<?php echo $siteurl ?>/new'>Новый заказ</a> | 
		<a href='<?php echo $siteurl ?>/undelivered_paid'>Оплачен, не доставлен</a> | 
		<a href='<?php echo $siteurl ?>/confirmed'>Подтверждён, выполняется</a> | 
	</div>
	<div style='height:20px;'></div>  
    <div>
		<?php echo $output; ?>
    </div>
</body>
</html>
