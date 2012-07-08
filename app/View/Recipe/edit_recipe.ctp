<div id="recipe">
<h1><span class="editTitle"><?php echo $recipe['Recipe']['name']?></span><span class="recipeType">[ <span class="editType"><?php echo $recipe['RecipeType']['name']?></span> ]</span></h1>

<p><?php echo $this->Form->input('ingredient_quantity',array('div'=>false,'label'=>false,'size'=>2,'value'=>1)); ?> <?php echo $this->Form->input('ingredient_name',array('div'=>false,'label'=>false)); ?> <?php echo $this->Form->button('Add',array('div'=>false,'label'=>false,'onClick'=>'add_ingredient()')); ?></p>
<table width="90%" id="ingredient_table">
	<tr>
	</tr>
	<?php foreach ($recipe['Ingredient'] as $ingredient): ?>
	<tr>
		<td width="5%" id="ingredient_<?php echo $ingredient['id'] ?>"><?php echo $this->Html->image('delete.png')?></td>
		<td width="5%"><?php echo $ingredient['quantity']?></td>
		<td width="60%"><?php echo $ingredient['name'] ?></td>
		<td align="right"><?php echo $this->Html->link('Add To List','#',array('onClick'=>'add_grocery_list("' . $ingredient['name'] . '")'))?> | <?php echo $this->Html->link('Remove','/recipe/remove_ingredient/' . $ingredient['id'] . '/' . $recipe['Recipe']['id'])?></td>
	</tr>
	<?php endforeach;?>
</table>
</div>
<div id="instructions">
	<div></div>
	<?php foreach($recipe['RecipeInstruction'] as $instruction): ?>
		<div class="recipe_instruction">
			<p><?php echo $instruction['text'] ?></p>
			<p style="float:right" class="delete_instruction"><?php echo $this->Html->image('/img/delete_spacer.png',array('url'=>'/recipe/delete_instruction/' . $instruction['id'] . '/' . $recipe['Recipe']['id'])) ?></p>
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

	check_ingredients();
});

function update_value(field,value){
	$.post('<?php echo $this->Html->url('/',true) ?>recipe/update_recipe/' + recipeId,
			{field: field, value: value});
}

function add_ingredient(){
	var quantity = $('#ingredient_quantity').val();
	var name = $('#ingredient_name').val();

	

	$.post('<?php echo $this->Html->url('/',true) ?>recipe/add_ingredient/',
			{id: recipeId, quantity: quantity, name: name}, function(data){
				response = jQuery.parseJSON(data);

				//add to table
				$('#ingredient_table tr:last').after('<tr><td id="ingredient_' + response.id + '"><img src="<?php echo $this->Html->url('/',true)?>img/delete.png" /></td>' + 
						'<td>' + quantity + '</td>' + 
						'<td>' + name + '</td></tr>');

				//also check all ingredients again
				check_ingredients();
			});
}

function add_instruction(){
	var text = $('#recipe_instruction').val();
	var position = $('#instructions div').size();
	
	$('#recipe_instruction').val('');
	$('#recipe_instruction').focus();
	
	$.post('<?php echo $this->Html->url('/',true) ?>recipe/add_instruction/',
			{id: recipeId, text:text, position:position}, function(data){
				response = jQuery.parseJSON(data);

				//add to the bottom of the recipe instruction area
				$('#instructions div:last').after('<div class="recipe_instruction"><p>' + response.text + '</p>' + 
						'<p style="float:right" class="delete_instruction"><a href="/recipe/delete_instruction/' + response.id + '/' + response.recipe + '"><img src="/img/delete_spacer.png" /></a></p></div>');
							
				
			});	
}

function check_ingredients(){
	//get all of the ingredients we do have
	$.post('<?php echo $this->Html->url('/',true)?>recipe/check_ingredients/' + recipeId, {},
	function(data){
		response = jQuery.parseJSON(data);

		for(var i = 0; i < response.ingredients.length; i ++)
		{
			$('#ingredient_' + response.ingredients[i]).html('<img src="<?php echo $this->Html->url('/',true)?>img/check.png" />');
		}
	});
}

function add_grocery_list(ingredient){

	$.post('<?php echo $this->Html->url('/',true)?>pantry/add_to_list/', {"name": ingredient });
}
</script>