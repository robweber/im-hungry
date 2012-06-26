<h1>Pantry Locations</h1>
<table width="50%">
<?php foreach($p_locations as $location): ?>
<tr>
	<td width="50%" class="edit" id="location_<?php echo $location['PantryLocation']['id']?>"><?php echo $location['PantryLocation']['name']?></td>
	<td><?php echo $this->Html->link('Delete','/ajax/delete_location/' . $location['PantryLocation']['id'])?></td>
</tr>
<?php endforeach; ?>
<tr>
	<td class="edit" id="location_new">Add Location</td>
</tr>
</table>
<h1>Recipe Types</h1>
<table width="50%">
<?php foreach($r_types as $type): ?>
<tr>
	<td width="50%" class="edit" id="type_<?php echo $type['RecipeType']['id']?>"><?php echo $type['RecipeType']['name']?></td>
	<td><?php echo $this->Html->link('Delete','/ajax/delete_type/' . $type['RecipeType']['id'])?></td>
</tr>
<?php endforeach; ?>
<tr>
	<td class="edit" id="type_new">Add Location</td>
</tr>
</table>

<script type="text/javascript">
$(document).ready(function(){
	$('.edit').editable('/ajax/save_table', {
		indicator: 'Saving...',
		submit: 'OK',
		cancel: 'Cancel',
		loadtype:'POST',
		tooltp: 'Click to edit',
		callback: function(value,settings){
			
			if($(this).attr('id') == 'location_new' || $(this).attr('id') == 'type_new')
			{
				//reload the page (taking the easy way out)
				window.location.reload();
			}
		}
	});
});
</script>