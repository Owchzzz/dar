<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survey extends MY_ApiController {

	protected $model = "survey_model"; // Declare model
	
	public function cfRecords($id) {
		$records = $this->{$this->model}->getCfRecords($id);
		return $this->response($records);
	}

	public function surveyRecords($id) {
		$records =  $this->{$this->model}->getSurveyRecords($id);
		return $this->response($records);
	}

	public function updatecf() {
		$data = (array) $_POST;
		$id = $data['id'];
		unset($data['id']);
		$resp = $this->{$this->model}->updateCfRecord($id,$data);
		return $this->response($resp);
	}

	public function updatesurvey() {
		$data = (array) $_POST;
		$id = $data['id'];
		unset($data['id']);
		$resp = $this->{$this->model}->updateSurveyRecord($id,$data);
		return $this->response($resp);
	}

	public function submitComment() {
		$data = (array) $_POST;
		$comment = $this->{$this->model}->submitComment($data);
		return $this->response($comment);
	}

	public function getTempFileId() {

	}

	public function tempFileUpload($logId) {

		$config['upload_path'] = '.'.$this->m->getUserFolder();
		$config['allowed_types'] = "*";

		$this->load->library('upload',$config);
		if($this->upload->do_upload('file')) {
			$data = $this->upload->data();
			$fileID = $this->m->uploadFile($data, $logId);
			return $this->response(['id' => $fileID]);
		} else {
			
		}
	}
	public function getCommentor($id) {
		$user = $this->{$this->model}->getCommentor($id);
		return $this->response($user);
	}
}
