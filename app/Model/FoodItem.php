<?php 
class FoodItem extends AppModel{
	var $name = 'FoodItem';
	var $useTable = 'food_item';
	var $belongsTo = array('PantryLocation'=>array('className'=>'PantryLocation','foreignKey'=>'location_id'));
}
?>