<?php

class Fields extends CI_Migration {
    public function __construct() {
		parent::__construct();
		$this->load->dbforge();

    }
    
    public function up() {

        $this->dbforge->add_field(array(
            'id' => array(
				'type'           => 'MEDIUMINT',
				'constraint'     => '8',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			),
			'survey_for' => array(
				'type'       => 'VARCHAR',
				'constraint' => '500',
			),
			'lot_no' => array(
				'type'       => 'VARCHAR',
				'constraint' => '100',
			)
        ));
        $this->dbforge->addkey('id');
        $this->dbforge->create_table('fields');
    }

}