<?php echo $this->Form->create('FoodItem',array('url'=>'/food/addFood'))?>
<p align="right"><b>New Food: </b> <?php echo $this->Form->input('name',array('label'=>false,'div'=>false)) ?> <?php echo $this->Form->select('location_id',$p_locations,array('div'=>false,'label'=>false,'empty'=>false))?> <?php echo $this->Form->submit('Add',array('div'=>false))?></p>
<?php echo $this->Form->end(); ?>

<?php
	$pantryLocation = null; 
	foreach($pantry as $item):

	if($pantryLocation == null || $item['PantryLocation']['name'] != $pantryLocation):
		$pantryLocation = $item['PantryLocation']['name'];
?>
<h1><?php echo $pantryLocation ?></h1>
<?php 
	endif;
?>
<p><?php echo $item['FoodItem']['name']?></p>
<?php endforeach?>
