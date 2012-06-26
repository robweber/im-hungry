<?php 
class Recipe extends AppModel{
	var $name = 'Recipe';
	var $useTable = 'recipe';
	var $belongsTo = array('RecipeType'=>array('className'=>'RecipeType','foreignKey'=>'type_id'));
}
?>