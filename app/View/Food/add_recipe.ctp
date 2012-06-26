<h1 class="editTitle">Recipe Name</h1>
<table width="90%">
	<tr>
		<td width="5%"><p>0</p></td>
		<td><p>Ingredient</p></td>
	</tr>
</table>

<script type="text/javascript">
$(document).ready(function(){
	$('.editTitle').editable(function(value,settings){
		return value
	},{
		submit: 'OK'
	});
});
</script>