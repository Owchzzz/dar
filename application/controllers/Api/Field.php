<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Field extends MY_ApiController {

	public function __construct() {
		parent::__construct();
		$this->load->model('field_model');
	}


	public function create()
	{
		$data = (array) $_POST;
		return $this->field_model->create($data);
	}
	
	public function get() {
		$data = $this->field_model->get();
		return $this->response($data);
	}

	public function test() {
		$this->response(['test'=>true]);
	}
    
}
