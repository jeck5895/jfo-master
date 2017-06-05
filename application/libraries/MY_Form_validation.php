<?php
/** application/libraries/MY_Form_validation **/ 
class MY_Form_validation extends CI_Form_validation 
{
     public $CI;
	/**
		Source:
		http://stackoverflow.com/questions/32665715/codeigniter-unable-to-access-an-error-message-corresponding-to-your-field-name
	*/
	function run($module = '', $group = '')
    {
       (is_object($module)) AND $this->CI = &$module;
        return parent::run($group);
    }
}