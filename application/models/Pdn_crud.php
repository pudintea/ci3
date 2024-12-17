<?php defined('__PUDINTEA__') OR exit('No direct script access allowed');

class Pdn_crud extends CI_Model
{
	function __construct(){
		parent::__construct();
	}

	/**
     * return _retval
     *
     * @var Boolean
     **/
    private $_retval = NULL;

    /**
     * return _result
     *
     * @var Boolean
     **/
    private $_result = FALSE;

    /**
     * return _retarr
     *
     * @var Array
     **/
    private $_retarr = array();
	
    /**
     * SAVE
     * $this->Pdn-crud->save($nama_tb, $save_data)
    **/

    function save($nama_tb='', $save_data='')
    {
        $this->_result = $this->db->insert($nama_tb, $save_data);

        if ($this->_result) {
            return $this->_result;
        }
    }
	
    /**
     * EDIT
     * $this->Pdn-crud->edit($_id, $nama_id, $nama_tb)
    **/
	
	function edit($_id ='', $nama_id ='', $nama_tb='')
	{
		if (empty($_id) || empty($nama_id) || empty($nama_tb)) {
            return false;
        }

		$this->db->where($nama_id, $_id);
		$this->_result = $this->db->get($nama_tb)->row();
		
		if ($this->_result) {
            return $this->_result;
        }
	}
	
	/**
     * UPDATE
     * $this->Pdn_crud->update($_id, $nama_id, $nama_tb, $update_data)
    **/

    function update($_id ='', $nama_id ='', $nama_tb='', $update_data='')
    {
        if (empty($_id) || empty($nama_id) || empty($nama_tb) || empty($update_data)) {
            return false;
        }

        $this->db->where($nama_id, $_id);
        $this->_result = $this->db->update($nama_tb, $update_data);

        if ($this->_result) {
            return $this->_result;
        }
    }


    /**
     * DELETE
     * $this->Pdn_crud->delete($_id, $nama_id,$nama_tb)
    **/
	
	function delete($_id='', $nama_id='',$nama_tb='')
    {
        if (empty($_id) || empty($nama_id) || empty($nama_tb)) {
            return false;
        }

        $this->db->where($nama_id, $_id);
        $this->_result = $this->db->delete($nama_tb);

        if ($this->_result) {
            return $this->_result;
        }
    }
	
}

// Pudin Saepudin , Application/models/Pdn_crud.php 

