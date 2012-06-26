<?php

class AdminController extends AppController {
	var $uses = array('PantryLocation','RecipeType');
	
	function index(){
		
		//get some items we need for this page
		$p_locations = $this->PantryLocation->find('all',array('order'=>array('PantryLocation.name')));
		$this->set("p_locations",$p_locations);
		
		$r_types = $this->RecipeType->find('all',array('order'=>array('RecipeType.name')));
		$this->set('r_types',$r_types);
		
	}
}

?>