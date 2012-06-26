<?php

class AdminController extends AppController {
	var $uses = array('PantryLocation');
	
	function index(){
		
		//get some items we need for this page
		$p_locations = $this->PantryLocation->find('all',array('order'=>array('PantryLocation.name')));
		$this->set("p_locations",$p_locations);
		
	}
}

?>