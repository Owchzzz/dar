<?php

class MY_Model extends CI_Model {

    protected $guarded = true; // Change to false if you want the model to not have any thing
    protected $table = ''; // Required parameter

    public function __construct()
    {
        parent::__construct();
        // Do nothing
        if($this->guarded && ! $this->ion_auth->logged_in()) {
            die('Unable to execute query. you must be logged in');
        }
        $this->user = $this->ion_auth->user()->row()->id or die();
    }

    public function struct($array,$data) {
        $final = [];
        foreach($array as $key => $item) {
            $final[$key] = $data[$key];
        }
        return $final;
    }

    public function create($data) {
        $this->db->insert($this->table, $data);
        $data = $this->single($this->db->insert_id());

        if(method_exists($this,'postCreate')) {
            $this->postCreate($data);
        }

        return $data;
    }

    public function update($id,$data) {
        $this->db->where('id',$id)
                    ->set($data)
                    ->update($this->table);
        return $this->db->affected_rows();
    }
    
    public function get() {
        return $this->db->order_by('id','desc')->get($this->table)->result_array();
    }

    public function where($data) {
        return $this->db->where($data)->get($this->table)->result_array();
    }

    public function single($id) {
        $data = ['id'=>$id];
        return $this->db->where($data)->get($this->table)->row();
    }

    public function delete($id) {
        return $this->db->delete($this->table,array('id'=>$id));
    }

    public function getUser() {
        return $this->user;
    }

    public function getUserFolder() {
        if(!is_dir('uploads')) {
            mkdir('./uploads', 0777, true);
        }
        if (!is_dir('uploads/'.$this->user)) {
            mkdir('./uploads/'.$this->user, 0777, true);
        }
        if(!is_dir('uploads/'.$this->user.'/files')) {
            mkdir('./uploads/'.$this->user.'/files', 0777, true);
        }
        return "/uploads/{$this->user}/files/";
    }

    public function getFile($id) {
        if($id) {
            return $this->db->where('id',$id)->where('is_temp',0)->get('files')->row();
        }

        return false;
    }
}