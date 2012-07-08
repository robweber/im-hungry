<?php

class RecipeController extends AppController {
	var $uses = array('FoodItem','PantryLocation','Recipe','RecipeType','Ingredient','RecipeInstruction');
	
	function index(){
		//get a list of recipes
		$allRecipes = $this->Recipe->find('all',array('order'=>array('RecipeType.name','Recipe.name')));
		$this->set("recipes",$allRecipes);
		
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
	
	function delete_instruction($id,$recipe){
		$this->RecipeInstruction->delete($id);
		
		$this->redirect('/recipe/edit_recipe/' . $recipe);
	}
	
	function search(){
		//check if we are POSTing from form
		if(isset($this->data['Search']['q']))
		{
			$q = trim($this->data['Search']['q']);

			//check if we are doing a recipe or a food item
			if(strrpos($q,'-') !== false){
				//get the food item that matches
				$itemName = substr($q,0,strrpos($q,'-') -1);

				$matches = $this->FoodItem->find('first',array('conditions'=>array('FoodItem.name LIKE "' . $itemName . '"')));

				$this->redirect('/pantry/inventory/' . $matches['FoodItem']['id'] );
			}
			else
			{
			
				//get any recipes that match
				$matches = $this->Recipe->find('all',array('conditions'=>array('Recipe.name LIKE "%' . $q . '"')));
			
				if(count($matches) == 1)
				{
					//we can just go right to this item
					$this->redirect('/recipe/edit_recipe/' . $matches[0]['Recipe']['id']);
				}
				else
				{
					$this->set('recipes',$matches);
					$this->render('index');
				}
			}
		}
		else
		{
			$this->layout = '';
			//we are autocompleteing (GET)
			$q =  $this->params['url']['term'];
			$result = array();

			//first get the recipes
			$matches = $this->Recipe->find('list',array('fields'=>array('Recipe.name'),'conditions'=>'Recipe.name LIKE "' . $q . '%"'));

			//set the category
			foreach(array_values($matches) as $value)
			{
				$result[] = array('label'=>$value,'category'=>'Recipe');
			}

			//now get the pantry items
			$matches = $this->FoodItem->find('list',array('fields'=>array('FoodItem.quantity','FoodItem.name'),'conditions'=>'FoodItem.name LIKE "' . $q . '%" '));
			foreach(array_keys($matches) as $value){
				$result[] = array('label'=>$matches[$value] . ' - ' . $value,'category'=>'Pantry');
			}

			//sort the results
			asort($result);

			$this->set('output',$result);
			$this->render('ajax');
		}
	}
	
	function remove_ingredient($id,$recipe){
		$this->Ingredient->delete($id);
		
		$this->redirect('/recipe/edit_recipe/' . $recipe);
	}
	
	//Ajax functions
	
	function update_recipe($id){
		$this->layout = '';
		
		$field = $this->data['field'];
		$value = $this->data['value'];
		
		$this->Recipe->id = $id;
		$this->Recipe->set($field,$value);
		$this->Recipe->save();
		
		$this->set('output',"Success");
		$this->render('ajax');
	}
	
	function add_ingredient(){
		$this->layout = '';
		
		$id = $this->data['id'];
		$quantity = $this->data['quantity'];
		$name = $this->data['name'];
		
		//add the ingredient
		$this->Ingredient->create();
		$this->Ingredient->set('recipe_id',$id);
		$this->Ingredient->set('quantity',$quantity);
		$this->Ingredient->set('name',$name);
		$this->Ingredient->save();
		
		$this->set('output',array('id'=>$this->Ingredient->id,'recipe_id'=>$id,'quantity'=>$quantity,'name'=>$name));
		$this->render('ajax');
	}
	
	function add_instruction(){
		$this->layout = '';
		
		$id = $this->data['id'];
		$text = $this->data['text'];
		$position = $this->data['position'];
		
		$this->RecipeInstruction->create();
		$this->RecipeInstruction->set('recipe_id',$id);
		$this->RecipeInstruction->set('text',$text);
		$this->RecipeInstruction->set('position',$position);
		$this->RecipeInstruction->save();
		
		$this->set('output',array("id"=>$this->RecipeInstruction->id,"recipe"=>$id,'position'=>$position,'text'=>$text));
		$this->render('ajax');
	}
	
	function check_ingredients($recipe_id){
		$this->layout = '';
		
		//get all the ingredients we do have for this recipe
		$allIngredients = $this->Ingredient->query('select ingredients.id from ingredients inner join food_item on ingredients.name = food_item.name where ingredients.recipe_id = ' . $recipe_id . ' and food_item.quantity >= ingredients.quantity');
		$result = array();
		
		foreach ($allIngredients as $ingredient){
			$result[] = $ingredient['ingredients']['id'];	
		}
		
		$this->set('output',array('ingredients'=>$result));
		$this->render('ajax');
	}

}
