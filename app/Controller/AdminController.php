<?php

class AdminController extends AppController {
	var $uses = array('PantryLocation','RecipeType','FoodItem','MeasurementType');
	
	function index(){
		
		//get some items we need for this page
		$p_locations = $this->PantryLocation->find('all',array('order'=>array('PantryLocation.name')));
		$this->set("p_locations",$p_locations);
		
		$r_types = $this->RecipeType->find('all',array('order'=>array('RecipeType.name')));
		$this->set('r_types',$r_types);
		
		$m_types = $this->MeasurementType->find('all',array('order'=>array("MeasurementType.label")));
		$this->set('m_types',$m_types);
		
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
		else if(strpos($id,"type") === 0)
		{
			$this->RecipeType->create();
			$this->RecipeType->set('name',$name);
			
			if($id != 'type_new'){
				$this->RecipeType->id = substr($id,5);
			}
			
			$this->RecipeType->save();
		}
		else {
			$this->MeasurementType->create();
			$this->MeasurementType->set('label',$name);
			
			if($id != 'measure_new'){
				$this->MeasurementType->id = substr($id,5);
			}
			
			$this->MeasurementType->save();
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
	
	function delete_measure($id){
		//check if any items use this location
		$totalItems = $this->FoodItem->find('count',array('conditions'=>array('FoodItem.measurement_id'=>$id)));
		
		if($totalItems > 0)
		{
			$this->Session->setFlash("Food items still assigned to this type, can't delete it","error_message");	
		}
		else
		{
			$this->MeasurementType->delete($id);
		}
		
		$this->redirect("/admin");
	}
}

?>