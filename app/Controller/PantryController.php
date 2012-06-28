<?php

class PantryController extends AppController {
	var $uses = array('FoodItem','PantryLocation','Recipe','RecipeType','Ingredient');
	
	function index(){
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
	
	function inventory(){
		//get list of locations
		$p_locations = $this->PantryLocation->find('list',array('fields'=>array('id','name'),'order'=>array('PantryLocation.name')));
		$this->set('p_locations',$p_locations);
		
		//get all the foods currently in the pantry
		$pantry = $this->FoodItem->find('all',array('order'=>array('PantryLocation.name','FoodItem.name')));
		$this->set('pantry',$pantry);
	}
	
	function add_food(){
		$this->FoodItem->save($this->data['FoodItem']);
		
		$this->redirect(array('controller'=>'Pantry','action'=>'inventory'));
	}
	
	function delete_item($id){
		$this->FoodItem->delete($id);
		
		$this->redirect(array('controller'=>'Pantry','action'=>'inventory'));
	}
	
	//Ajax functions
	
	function search_food(){
		$this->layout = '';
		
		$q = 'no data';
		if(isset($this->params['url']['term']))
		{
			$q = $this->params['url']['term'];
		}
		
		//get the food items
		$items = $this->FoodItem->find('list',array('fields'=>array('FoodItem.name'),'conditions'=>'FoodItem.name LIKE "' . $q . '%"'));
		
		$this->set('output',array_values($items));
		$this->render('ajax');
	}
	
	function update_item($id, $quantity){
		$this->layout = '';
		
		//amount can't be less than 0
		if($quantity < 0)
		{
			$quantity = 0;
		}
		
		$this->FoodItem->create();
		$this->FoodItem->id = $id;
		$this->FoodItem->set('quantity',$quantity);
		$this->FoodItem->save();
		
		$this->set('output',array('id'=>$id,'quantity'=>$quantity));
	}
	
	function move_item($id, $pantry){
		$this->layout = '';
		
		$this->FoodItem->id = $id;
		$this->FoodItem->set("location_id",$pantry);
		$this->FoodItem->save();
		
		$this->set("output",array("id"=>$id,"location"=>$pantry));
		
		$this->render('update_item');
	}
}

?>