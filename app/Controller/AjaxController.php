<?php

class AjaxController extends AppController {
	var $uses = array('PantryLocation','FoodItem','RecipeType','Recipe','Ingredient');
	var $layout = '';
	
	function beforeRender(){
		Controller::disableCache(); 
	}
	
	function save_table(){
		$id = $this->data['id'];
		$name = $this->data['value'];

		//figure out what we're saving
		if(strpos($id,"location") === 0)
		{
			$this->PantryLocation->create();
			$this->PantryLocation->set('name',$name);
			
			if($id != 'location_new'){
				$this->PantryLocation->id = substr($id,9);
			}
			
			$this->PantryLocation->save();
		}
		else
		{
			$this->RecipeType->create();
			$this->RecipeType->set('name',$name);
			
			if($id != 'type_new'){
				$this->RecipeType->id = substr($id,5);
			}
			
			$this->RecipeType->save();
		}
		
		$this->set('name',$name);
	}
	
	function update_item($id, $quantity){
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
		$this->FoodItem->id = $id;
		$this->FoodItem->set("location_id",$pantry);
		$this->FoodItem->save();
		
		$this->set("output",array("id"=>$id,"location"=>$pantry));
		
		$this->render('update_item');
	}
	
	function delete_location($id){
		//check if any items use this location
		$totalItems = $this->FoodItem->find('count',array('conditions'=>array('FoodItem.location_id'=>$id)));
		
		if($totalItems > 0)
		{
			$this->Session->setFlash("Food items still in this location, can't delete it","error_message");	
		}
		else
		{
			$this->PantryLocation->delete($id);
		}
		
		$this->redirect("/admin");
	}
	
	function delete_type($id){
		$this->redirect("/admin");
	}
	
	function search_food(){
		$q = 'no data';
		if(isset($this->params['url']['term']))
		{
			$q = $this->params['url']['term'];
		}
		
		//get the food items
		$items = $this->FoodItem->find('list',array('fields'=>array('FoodItem.name'),'conditions'=>'FoodItem.name LIKE "' . $q . '%"'));
		
		$this->set('output',array_values($items));
		$this->render('update_item');
	}
	
	function update_recipe($id){
		$field = $this->data['field'];
		$value = $this->data['value'];
		
		$this->Recipe->id = $id;
		$this->Recipe->set($field,$value);
		$this->Recipe->save();
		
		$this->set('output',"Success");
		$this->render('update_item');
	}
	
	function add_ingredient(){
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
		$this->render('update_item');
	}
}

?>