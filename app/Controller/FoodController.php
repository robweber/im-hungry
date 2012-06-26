<?php

class FoodController extends AppController {
	var $uses = array('FoodItem','PantryLocation','Recipe');
	
	function index(){
		
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
	
	function add_recipe(){
		
	}
}

?>