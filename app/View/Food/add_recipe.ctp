<h1 class="editTitle">New Recipe</h1>
<table width="90%">
	<tr>
		<td width="5%"><p>0</p></td>
		<td><p>Ingredient</p></td>
	</tr>
</table>

<script type="text/javascript">
var recipeId = <?php echo $recipeId ?>;

$(document).ready(function(){
	$('.editTitle').editable('<?php echo $this->Html->url('/',true) ?>ajax/update_recipe/' . recipeId,{
		submit: 'OK'
	});
});
</script>