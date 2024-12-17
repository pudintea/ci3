<?php if ( ! defined('__PUDINTEA__')) exit('No direct script access allowed');

class Template {
    
    protected $CI; // Deklarasi properti CI
    var $template_data = array();

    function set($name, $value) {
        $this->template_data[$name] = $value;
    }

    function load($template = '', $view = '', $view_data = array(), $return = FALSE) {
        $this->CI =& get_instance();
        
        // Gabungkan $view_data ke $template_data
        $this->template_data = array_merge($this->template_data, $view_data);

        $this->set('pdn_konten', $this->CI->load->view($view, $view_data, TRUE));
        return $this->CI->load->view($template, $this->template_data, $return);
    }

    function pdn_load($template = '', $view = '', $view2 = '', $view_data = array(), $return = FALSE) {
        $this->CI =& get_instance();

        // Gabungkan $view_data ke $template_data
        $this->template_data = array_merge($this->template_data, $view_data);

        $this->set('pdn_konten', $this->CI->load->view($view, $view_data, TRUE));
        $this->set('pdn_kode', $this->CI->load->view($view2, $view_data, TRUE));
        return $this->CI->load->view($template, $this->template_data, $return);
    }
}

/*
* Menampilkan 2 view konten ke template
*$this->load->library(array('template')); load library template
*$this->template->pdn_load('tema','konten1','kontendata'); menampilkan file konten1.php dan kontendata.php yang ada di folder view dan ditampilkan kedalam file template utama (2 pemanggilan konten)
*$this->template->load('tema','konten1'); menampilkan file konten1.php yang ada di folder view dan ditampilkan kedalam file template utama (1 pemanggilan konten)
*
* TEMPLATE HTML (Tampilkan)
* isset($konten) ? $konten : '';
* isset($kode) ? $kode : '';
*
* https://t.me/pudin_ira
* https://instagram.com/pudin.ira
/* End of file Template.php */
/* Location: ./system/application/libraries/Template.php */
