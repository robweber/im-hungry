<h1>Pantry Locations</h1>
<table width="50%">
<?php foreach($p_locations as $location): ?>
<tr>
	<td width="50%" class="edit" id="location_<?php echo $location['PantryLocation']['id']?>"><?php echo $location['PantryLocation']['name']?></td>
	<td><?php echo $this->Html->link('Delete','/admin/delete_location/' . $location['PantryLocation']['id'])?></td>
</tr>
<?php endforeach; ?>
<tr>
	<td class="edit" id="location_new">Add Location</td>
</tr>
</table>

<h1></h1>
<h1>Recipe Types</h1>
<table width="50%">
<?php foreach($r_types as $type): ?>
<tr>
	<td width="50%" class="edit" id="type_<?php echo $type['RecipeType']['id']?>"><?php echo $type['RecipeType']['name']?></td>
	<td><?php echo $this->Html->link('Delete','/admin/delete_type/' . $type['RecipeType']['id'])?></td>
</tr>
<?php endforeach; ?>
<tr>
	<td class="edit" id="type_new">Add Location</td>
</tr>
</table>

<h1></h1>
<h1>Measurement Types</h1>
<table width="50%">
<?php foreach($m_types as $type): ?>
<tr>
	<td width="50%" class="edit" id="measure_<?php echo $type['MeasurementType']['id']?>"><?php echo $type['MeasurementType']['label']?></td>
	<td><?php echo $this->Html->link('Delete','/admin/delete_measure/' . $type['MeasurementType']['id'])?></td>
</tr>
<?php endforeach; ?>
<tr>
	<td class="edit" id="measure_new">Add Measurement</td>
</tr>
</table>

<h1></h1>
<h1>Measurement Conversions</h1>
<table width="90%">
<?php foreach($m_conversions as $conv): ?>
<tr>
	<td width="33%"><?php echo $conv['MeasurementConversion']['input_quantity']?> <?php echo $m_types_list[$conv['MeasurementConversion']['input_measurement_id']]?></td>
	<td width="15%">Equals</td>
	<td width="33%"><?php echo $conv['MeasurementConversion']['output_quantity']?> <?php echo $m_types_list[$conv['MeasurementConversion']['output_measurement_id']]?></td>
</tr>
<?php endforeach; ?>
<?php echo $this->Form->create('MeasurementConversion',array('url'=>'/admin/add_conversion')) ?>
<tr>
	<td><p><?php echo $this->Form->input('input_quantity',array('div'=>false,'label'=>false,'size'=>5)) ?> <?php echo $this->Form->select('input_measurement_id',$m_types_list,array('div'=>false,'label'=>false)) ?></p></td>
	<td><p>Equals</p></td>
	<td><?php echo $this->Form->input('output_quantity',array('div'=>false,'label'=>false,'size'=>5)) ?> <?php echo $this->Form->select('output_measurement_id',$m_types_list,array('div'=>false,'label'=>false)) ?> 
	<?php echo $this->Form->submit('Create',array('div'=>false)) ?></td>
</tr>
<?php echo $this->Form->end() ?>
</table>
<script type="text/javascript">
$(document).ready(function(){
	$('.edit').editable('<?php echo $this->Html->url('/',true) ?>admin/save_table', {
		indicator: 'Saving...',
		submit: 'OK',
		cancel: 'Cancel',
		loadtype:'POST',
		tooltp: 'Click to edit',
		callback: function(value,settings){
			
			if($(this).attr('id') == 'location_new' || $(this).attr('id') == 'type_new' || $(this).attr('id') == 'measure_new')
			{
				//reload the page (taking the easy way out)
				window.location.reload();
			}
		}
	});
});
</script>
