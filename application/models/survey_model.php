<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survey_model extends MY_Model {
    protected $table="surveys";
    // public function get($page = 0, $items = 0) {
    //     return $this->db
    //                 ->order_by('id','desc')
    //                 ->get('fields')
    //                 ->result_array();
    // }

    // public function create($form) {
    //     $form['creator_id'] = $this->user;
    //     return $this->db->insert('fields',$form);
    // }

    private function createLog() {
        $data = array(
            'created_at' => date('Y-m-d'),
            'status_code' => 0,
        );

        $this->db->insert('logs',$data);
        return $this->db->insert_id();
    }
    public function postCreate($record) {
        $cf_status = $this->db->get('cf_status_codes')->result();
        $survey_status = $this->db->get('survey_status_codes')->result();

        foreach($cf_status as $cf) {
            $logId = $this->createLog();

            $data = array(
                'survey_id' => $record->id,
                'cf_id' => $cf->id,
                'log_id' => $logId
            );
            $this->db->insert('cf_records',$data);
            
        }

        foreach($survey_status as $surv) {
            $logId = $this->createLog();

            $data = array(
                'survey_id' => $record->id,
                'survey_status_id' => $surv->id,
                'log_id' => $logId
            );
            $this->db->insert('survey_records',$data);
        }
    }

    public function getCfRecords($id) {
        // $cf_records = $this->db->where('survey_id',$id)->get('cf_records')->result_array();
        $cf_records = $this->db->select('cf_records.*, cf_status_codes.value as cf_status_value, cf_status_codes.code as cf_status_code')
                ->from('cf_records')
                ->join('cf_status_codes','cf_status_codes.id = cf_records.cf_id')
                ->join('logs','logs.id = cf_records.log_id')
                
                ->where('survey_id',$id)
                ->get()
                ->result_array();

        // Generate Logs for that CF status
        foreach($cf_records as $key => $record) {
            $cf_records[$key]['logs'] = $this->db
                ->select('log_records.*,users.id as uid,users.first_name,users.last_name')
                ->from('log_records')
                ->join('users','users.id = log_records.user_id')
                ->where('log_id',$record['log_id'])
                ->get()
                ->result_array();
        }

        return $cf_records;
    }

    // public function getLogs($log_id) {
    //     return $this->db->where('cf_records')
    // } 

    public function updateCfRecord($id, $data) {
        $this->db->where('id',$id)
            ->set($data)
            ->update('cf_records');
        return $this->db->affected_rows();
    }

    public function updateSurveyRecord($id, $data) {
        $this->db->where('id',$id)
            ->set($data)
            ->update('survey_records');
        return $this->db->affected_rows();
    }

    public function getSurveyRecords($id) {
        // $records = $this->db->where('survey_id',$id)->get('survey_records')->result_array();
        $records = $this->db
                    ->select('survey_records.*, survey_status_codes.value as survey_status_value, survey_status_codes.code as survey_status_code')
                    ->from('survey_records')
                    ->join('survey_status_codes','survey_status_codes.id = survey_records.survey_status_id')
                    ->join('logs','logs.id = survey_records.log_id') 
                    ->where('survey_id',$id)
                    ->get()
                    ->result_array();

        // Generate Logs for that CF status
        foreach($records as $key => $record) {
            $records[$key]['logs'] = $this->db
                ->select('log_records.*,users.id as uid,users.first_name,users.last_name')
                ->from('log_records')
                ->join('users','users.id = log_records.user_id')
                ->where('log_id',$record['log_id'])
                ->get()
                ->result_array();
        }
        return $records;
    }

    public function submitComment($data) {
        $files = explode(",",$data['files']);

        $data['files'] = json_encode($files);
        log_message('error',print_r($files,1));
        foreach($files as $file) {
            $this->db->set('is_temp',0);
            $this->db->where('id',$file);
            $this->db->update('files');
        }

        $data['user_id'] = $this->user;
        $this->db->set('created_at','NOW()',FALSE);
        $this->db->insert('log_records',$data);

        $id = $this->db->insert_id();
        return $this->db->where('id',$id)->get('log_records')->row();
    }

    public function getCommentor($user_id) {
        return $this->db->select('first_name,last_name,id')->where('id',$user_id)->get('users')->row();
    }

    public function uploadFile($temp,$logId) {
        $data = [
            'log_id' => $logId,
            'is_temp' => 1,
            'filename' => $temp['file_name'],
            'filepath' => $this->getUserFolder(),
            'user_id' => $this->user,
        ];
        $this->db->insert('files',$data);
        return $this->db->insert_id();
    }
}