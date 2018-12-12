<?php
/**
 * API Controller Class extends all API routes
 *
 * Hi seph :) hi mel :)
 * Crave - Custom.
 */
class MY_ApiController extends CI_Controller {

    protected $model = false;
    
    /**
     * Constructor function
     * 
     * returns json error if no authentication is found on the requesting user
     */
    public function __construct()
    {
        parent::__construct();
        header('Content-Type: application/json');    
        $this->guarded = true;
        $this->logged = true;
        if($this->guarded && ! $this->ion_auth->logged_in()) {
            die(json_encode(['err'=>'authentication','message'=>'user needs to be logged in']));
        }

        if($this->model)
            $this->load->model($this->model);

        $this->m = &$this->{$this->model};
    }

    public static function response($model) {
        echo json_encode($model);
    }

    public function create()
	{
		$data = (array) $_POST;
        $resp = $this->{$this->model}->create($data);
        $this->response($resp);
	}

    public function get() {
		$data = $this->{$this->model}->get();
		return $this->response($data);
    }
    
    public function single($id) {
        $data = $this->{$this->model}->single($id);
        return $this->response($data);
    }

    public function file($id) {
        return $this->response($this->m->getFile($id));
    }
}
