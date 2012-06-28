<?php 
class GroceryList extends AppModel{
	var $name = 'GroceryList';
	var $useTable = 'grocery_list';
	var $belongsTo = array('FoodItem'=>array('className'=>'FoodItem','foreignKey'=>'food_id'));
}
?>