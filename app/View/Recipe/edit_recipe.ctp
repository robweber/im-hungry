<div id="recipe">
<?php
	$this->Html->script('jquery-ui-1.8.21.custom.min',false); 
	echo $this->Html->css('jquery-ui-1.8.21.custom');
?>

<h1><span class="editTitle"><?php echo $recipe['Recipe']['name']?></span><span class="recipeType">[ <span class="editType"><?php echo $recipe['RecipeType']['name']?></span> ]</span></h1>

<p><?php echo $this->Form->input('ingredient_quantity',array('div'=>false,'label'=>false,'size'=>2,'value'=>1)); ?> <?php echo $this->Form->input('ingredient_name',array('div'=>false,'label'=>false)); ?> <?php echo $this->Form->button('Add',array('div'=>false,'label'=>false,'onClick'=>'add_ingredient()')); ?></p>
<table width="90%" id="ingredient_table">
	<tr>
	</tr>
	<?php foreach ($recipe['Ingredient'] as $ingredient): ?>
	<tr>
		<td width="5%"><?php echo $ingredient['quantity']?></td>
		<td><?php echo $ingredient['name'] ?>
	</tr>
	<?php endforeach;?>
</table>
</div>
<div id="instructions">
	<?php foreach($recipe['RecipeInstruction'] as $instruction): ?>
		<div class="recipe_instruction">
			<p><?php echo $instruction['text'] ?></p>
		</div>
	<?php endforeach;?>
</div>

<?php echo $this->Form->textarea('recipe_instruction',array('rows'=>10,'cols'=>100))?><?php echo $this->Form->button('Add',array('onClick'=>'add_instruction()'))?>

<script type="text/javascript">
var recipeId = <?php echo $recipe['Recipe']['id'] ?>;

$(document).ready(function(){
	$('.editTitle').editable(function(value,settings){
		update_value('name',value);
		
		return value},{
		submit: 'OK',
		style: 'display:inline'
	});

	$('.editType').editable(function(value,settings){
		update_value('type_id',value);
		
		//turn the id into the type name
		value = settings.data[value];
		
		return value;
		},{
		data: <?php echo $this->Js->object($recipeTypes) ?>,
		type: 'select',
		style: 'display:inline'
	});

	$('#ingredient_name').autocomplete({
			source: '<?php echo $this->Html->url('/',true) ?>pantry/search_food',
			delay:1,
			autoFocus: true
		});
	
});

function update_value(field,value){
	$.post('<?php echo $this->Html->url('/',true) ?>recipe/update_recipe/' + recipeId,
			{field: field, value: value});
}

function add_ingredient(){
	var quantity = $('#ingredient_quantity').val();
	var name = $('#ingredient_name').val();

	//add to table
	$('#ingredient_table tr:last').after('<tr><td>' + quantity + '</td>' + 
			'<td>' + name + '</td></tr>');

	$.post('<?php echo $this->Html->url('/',true) ?>recipe/add_ingredient/',
			{id: recipeId, quantity: quantity, name: name});
}

function add_instruction(){
	var text = $('#recipe_instruction').val();

	//add to the bottom of the recipe instruction area
	$('#instructions .recipe_instruction:last').after('<div class="recipe_instruction">' + text + '</div>');
}
</script>