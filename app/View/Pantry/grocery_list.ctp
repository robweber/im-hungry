<?php foreach($allItems as $item): ?>
<h2>
<?php if(isset($item['FoodItem']['name'])){
	echo $item['FoodItem']['name'];
}
else 
{
	echo $item['GroceryList']['name'];
}
?>
</h2>
<?php endforeach;?>
