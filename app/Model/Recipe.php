<?php 
class Recipe extends AppModel{
	var $name = 'Recipe';
	var $useTable = 'recipe';
	var $belongsTo = array('RecipeType'=>array('className'=>'RecipeType','foreignKey'=>'type_id'));
	var $hasMany = array('Ingredient'=>array('className'=>'Ingredient','foreignKey'=>'recipe_id'));
}
?>