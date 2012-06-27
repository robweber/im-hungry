<?php

class FoodController extends AppController {
	var $uses = array('FoodItem','PantryLocation','Recipe','RecipeType','Ingredient');
	
	function index(){
		//get a list of recipes
		$allRecipes = $this->Recipe->find('all',array('order'=>array('Recipe.name')));
		$this->set("recipes",$allRecipes);
		
	}
	
	function pantry(){
		//get list of locations
		$p_locations = $this->PantryLocation->find('list',array('fields'=>array('id','name'),'order'=>array('PantryLocation.name')));
		$this->set('p_locations',$p_locations);
		
		//get all the foods currently in the pantry
		$pantry = $this->FoodItem->find('all',array('order'=>array('PantryLocation.name','FoodItem.name')));
		$this->set('pantry',$pantry);
	}
	
	function addFood(){
		$this->FoodItem->save($this->data['FoodItem']);
		
		$this->redirect(array('controller'=>'Food','action'=>'pantry'));
	}
	
	function edit_recipe($id = null){

		//create a new recipe
		if($id == null)
		{
			$this->Recipe->create();
			$this->Recipe->set('name','New Recipe');
			$this->Recipe->save();
			
			$id = $this->Recipe->id;
		}
		
		$recipe = $this->Recipe->find('first',array('conditions'=>array('Recipe.id'=>$id)));
		$this->set('recipe',$recipe);
		
		//get a list of all recipe types
		$allTypes = $this->RecipeType->find('list',array('fields'=>array('RecipeType.id','RecipeType.name'),'order'=>'RecipeType.name'));
		$this->set('recipeTypes',$allTypes);
		
	}
	
	function hungry(){
		//get any ingredients that we have on hand that match our recipies
		$allIngredients = $this->Ingredient->query('select recipe_id, ingredients.name from ingredients inner join food_item on food_item.name = ingredients.name where food_item.quantity >= ingredients.quantity order by recipe_id');

	}
}

?>