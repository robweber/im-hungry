<?php

class RecipeController extends AppController {
	var $uses = array('FoodItem','PantryLocation','Recipe','RecipeType','Ingredient');
	
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
		
		$this->set('output',"Success");
		$this->render('ajax');
	}
}