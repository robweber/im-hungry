<?php

class AjaxController extends AppController {
	var $uses = array('PantryLocation');
	var $layout = '';
	
	function save_location(){
		$id = $this->data['id'];
		$name = $this->data['value'];

		$this->PantryLocation->create();
		$this->PantryLocation->set('name',$name);
		
		if($id != 'location_new'){
			$this->PantryLocation->id = substr($id,9);
		}
		
		$this->PantryLocation->save();
		
		$this->set('name',$name);
	}
}

?>