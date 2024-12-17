<?php
defined('__PUDINTEA__') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	protected $data;
	function __construct()
	{
		parent::__construct();
		$this->data = [];
		date_default_timezone_set('Asia/Jakarta');
	}

	public function author()	{return 'Pudin Saepudin';}
	public function MainModel()	{return 'Welcome_Models';}
	public function contact()	{return 'pudin.alazhar@gmail.com';}
	public function ClassNama()	{return 'welcome';}

	public function index()
	{
		$this->data['pdn_title'] 		= 'Dashboard';
		$this->data[$this->ClassNama()] = 'active';
		echo "HALLO WORLD";
	}
}