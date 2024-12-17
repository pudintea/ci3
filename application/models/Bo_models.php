<?php  if ( ! defined('__PUDINTEA__')) exit('No direct script access allowed');
/**
*
* Author:  Pudin Saepudin
* 		   pudin.alazhar@gmail.com
*
*/

class Bo_Models extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
	}

	/* nama database */
	//protected 
	private $_dtable 	= 'users';
	private $_dtable_id = 'id_users';
	
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

    function db_get_where($data_array){
		$this->_result = $this->db->get_where($this->_dtable, $data_array)->row_array();
		if ($this->_result) {
            return $this->_result;
        }
	}

    function update_token($data, $where)
    {
        $this->db->where($where);
        $this->_result = $this->db->update($this->_dtable, $data);

        if ($this->_result) {
            return $this->_result;
        }
    }

}