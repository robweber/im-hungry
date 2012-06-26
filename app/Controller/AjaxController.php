<?php

class AjaxController extends AppController {
	var $uses = array('PantryLocation','FoodItem','RecipeType');
	var $layout = '';
	var $helpers = array('Js');
	
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
}

?>