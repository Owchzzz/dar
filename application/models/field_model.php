<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Field_model extends MY_Model {

    public function get($page = 0, $items = 0) {
        return $this->db
                    ->order_by('id','desc')
                    ->get('fields')
                    ->result_array();
    }

    public function create($form) {
        $form['creator_id'] = $this->user;
        return $this->db->insert('fields',$form);
    }



}