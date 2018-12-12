<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File extends CI_Controller {

    public function __construct()
	{
		parent::__construct();

		if(!$this->ion_auth->logged_in()) {
			redirect('auth/login','refresh');
		}
    }
    
    public function download($id) {
        $this->load->helper('download');
        $this->load->model('file_model');
        $file = $this->file_model->getFileData($id);
        $fileLoc = ".".$file->filepath.$file->filename;
        force_download($fileLoc,NULL);
    }
}