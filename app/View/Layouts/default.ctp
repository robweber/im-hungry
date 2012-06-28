<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		I'm Hungry
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('main');
		echo $this->Html->css('jquery-ui-1.8.21.custom');
		
		echo $this->Html->script('jquery');
		echo $this->Html->script('jquery.jeditable'); 
		echo $this->Html->script('jquery-ui-1.8.21.custom.min'); 
		
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		
	?>
</head>
<body>
	<div id="top_header" align="center">
		<div class="center_box">
			<div id="top_nav">
				<ul>
					<li><?php echo $this->Html->link("I'm Hungry",'/') ?></li>
					<li><?php echo $this->Html->link('Recipes','/recipe/') ?></li>
					<li><?php echo $this->Html->link('Pantry','/pantry/inventory') ?></li>
					<li><?php echo $this->Html->image('settings_cog.png',array('class'=>'settings','url'=>array('controller'=>'admin','action'=>'index'))) ?></li>
				</ul>
			</div>
			<div id="search">
				<?php echo $this->Form->create('Search',array('url'=>'/recipe/search'))?>
					<p>Search: <?php echo $this->Form->input('q',array('div'=>false,'label'=>false,'size'=>30))?></p>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
	<div id="content" align="center">
		<div class="center_box">
		<?php echo $this->Session->flash(); ?>

		<?php echo $this->fetch('content'); ?>
		</div>
	</div>
	<div id="footer" align="center">
		<div class="center_box">
			<p align="center">I'm Hungry. Written by Rob Weber. <a href="https://github.com/robweber/im-hungry/">https://github.com/robweber/im-hungry/</a></p>
		</div>
	</div>
	<?php //echo $this->element('sql_dump'); ?>
<script type="text/javascript">
$(document).ready(function(){
	$('#SearchQ').autocomplete({
		source: '<?php echo $this->Html->url('/',true) ?>recipe/search',
		delay:1,
		autoFocus: true
	});
});
</script>
</body>
</html>
