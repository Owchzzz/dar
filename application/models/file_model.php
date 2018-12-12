<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File_model extends MY_Model {

    public function getFileData($id) {
        return $this->db->where('id',$id)->where('is_temp',0)->get('files')->row();
    }
}