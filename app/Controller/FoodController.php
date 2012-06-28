<?php

class FoodController extends AppController {
	var $uses = array('FoodItem','PantryLocation','Recipe','RecipeType','Ingredient');
	
	function index(){
		//get a list of recipes
		$allRecipes = $this->Recipe->find('all',array('order'=>array('RecipeType.name','Recipe.name')));
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
		$sqlQ = $this->Ingredient->query('select recipe_id, ingredients.name from ingredients inner join food_item on food_item.name = ingredients.name where food_item.quantity >= ingredients.quantity order by recipe_id');
		
		$recipeList = array();
		$ingredientTotals = array();
		
		foreach($sqlQ as $response){
			//check if this key already exists
			if(array_key_exists($response['ingredients']['recipe_id'],$ingredientTotals))
			{
				//simply add to the total
				$ingredientTotals[$response['ingredients']['recipe_id']] = $ingredientTotals[$response['ingredients']['recipe_id']] + 1;
			}
			else
			{
				$recipeList[] = $response['ingredients']['recipe_id'];
				$ingredientTotals[$response['ingredients']['recipe_id']] = 1;
			}
		}

		//if we are filtering on type
		$searchConditions = array('OR'=>array('Recipe.id'=>$recipeList));
		if(isset($this->data['Filter']) && $this->data['Filter']['type'] != "")
		{
			$searchConditions[] = array('Recipe.type_id'=>$this->data['Filter']['type']);
		}
		
		$allRecipes = $this->Recipe->find('all',array('conditions'=>$searchConditions));
		$result = array();
		//go through the recipes and make sure the ingredients we have match the totals we need
		for($i = 0; $i < count($allRecipes); $i ++)
		{
			$ingredient_total = count($allRecipes[$i]['Ingredient']);
			
			if($ingredient_total <= $ingredientTotals[$allRecipes[$i]['Recipe']['id']])
			{
				//add this recipe to the result
				$result[] = $allRecipes[$i];
			}
		}
		
		$this->set('allRecipes',$result);
		
		//throw in a list of the types for filtering
		$r_types = $this->RecipeType->find('list',array('fields'=>array('RecipeType.id','RecipeType.name'),'order'=>array('RecipeType.name desc')));
		$this->set('r_types',$r_types);
	}
}

?>