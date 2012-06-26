<?php
	$this->Html->script('jquery.jeditable',false); 
?>
<h1>Pantry Locations</h1>
<table width="50%">
<?php foreach($p_locations as $location): ?>
<tr>
	<td width="50%" class="edit" id="location_<?php echo $location['PantryLocation']['id']?>"><?php echo $location['PantryLocation']['name']?></td>
	<td>Delete</td>
</tr>
<?php endforeach; ?>
<tr>
	<td class="edit" id="location_new">Add Location</td>
</tr>
</table>
<h1></h1>

<script type="text/javascript">
$(document).ready(function(){
	$('.edit').editable('/ajax/save_location', {
		indicator: 'Saving...',
		submit: 'OK',
		cancel: 'Cancel',
		loadtype:'POST',
		tooltp: 'Click to edit',
		callback: function(value,settings){
			
			if($(this).attr('id') == 'location_new')
			{
				//reload the page (taking the easy way out)
				window.location.reload();
			}
		}
	});
});
</script>