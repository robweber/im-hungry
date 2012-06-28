<?php

class AdminController extends AppController {
	var $uses = array('PantryLocation','RecipeType','FoodItem');
	
	function index(){
		
		//get some items we need for this page
		$p_locations = $this->PantryLocation->find('all',array('order'=>array('PantryLocation.name')));
		$this->set("p_locations",$p_locations);
		
		$r_types = $this->RecipeType->find('all',array('order'=>array('RecipeType.name')));
		$this->set('r_types',$r_types);
		
	}
	
	function save_table(){
		$this->layout = '';
		
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