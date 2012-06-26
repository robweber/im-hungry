<?php
	$this->Html->script('jquery-ui-1.8.21.custom.min',false); 
?>

<?php echo $this->Form->create('FoodItem',array('url'=>'/food/addFood'))?>
<p align="right"><b>New Food: </b> <?php echo $this->Form->input('name',array('label'=>false,'div'=>false)) ?> <?php echo $this->Form->select('location_id',$p_locations,array('div'=>false,'label'=>false,'empty'=>false))?> <?php echo $this->Form->submit('Add',array('div'=>false))?></p>
<?php echo $this->Form->end(); ?>

<?php
	$pantryLocation = null; 
	$js_names = array();
	foreach($pantry as $item):

	if($pantryLocation == null || $item['PantryLocation']['name'] != $pantryLocation):
		$pantryLocation = $item['PantryLocation']['name'];
		$js_names[] = "#pantry_" . $item['PantryLocation']['id']; 
?>
</ul>

<h1><?php echo $pantryLocation ?></h1>
<ul id="pantry_<?php echo $item['PantryLocation']['id'] ?>" class="pantry_group">

<?php endif; ?>
	<li id="item_<?php echo $item['FoodItem']['id'] ?>" class="food_item"><p class="quantity" id="quantity_<?php echo $item['FoodItem']['id'] ?>"><?php echo $item['FoodItem']['quantity']?></p>
	<p class="food_name"><?php echo $item['FoodItem']['name']?></p>
	<p><?php echo $this->Html->image('add.png',array('onClick'=>'updateItem(' . $item['FoodItem']['id'] . ',1)','class'=>'image_anchor')); ?> <?php echo $this->Html->image('subtract.png',array('onClick'=>'updateItem(' . $item['FoodItem']['id'] . ',-1)','class'=>'image_anchor')); ?></p>
	</li>
	<?php endforeach?>
	
</ul>

<script type="text/javascript">

$(function(){
	$('<?php echo implode(",",$js_names) ?>').sortable({
		connectWith: ".pantry_group",
		remove: function(event,ui){
			var item = $(ui.item).attr("id");
			var pantry = $(ui.item).parent("ul").attr("id");

			item = item.substring(5);
			pantry = pantry.substring(7);
	
			//send ajax request
			$.ajax('/ajax/move_item/' + item + "/" + pantry);
		}
	}).disableSelection();
});

function updateItem(id, amount){
	var current = $('#quantity_' + id).html();
	current = parseInt(current) + amount;

	if(current < 0)
	{
		current = 0;
	}
	
	//update the number right away - we assume this succeeds
	$('#quantity_' + id).html(current);
	
	//send the request
	$.ajax('/ajax/update_item/' + id + '/' + current);
	
	
}
</script>