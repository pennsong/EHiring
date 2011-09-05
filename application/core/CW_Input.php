<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CW_Input extends CI_Input {
	/**
	* Fetch an item from the POST array
	*
	* @access	public
	* @param	string
	* @param	bool
	* @return	string
	*/
	function post($index = NULL, $xss_clean = FALSE)
	{
		// Check if a field has been provided
		if ($index === NULL AND ! empty($_POST))
		{
			$post = array();

			// Loop through the full _POST array and return it
			foreach (array_keys($_POST) as $key)
			{
				$post[$key] = $this->_fetch_from_array($_POST, $key, $xss_clean);
			}
			return $post;
		}
		$tmpStr = $this->_fetch_from_array($_POST, $index, $xss_clean);
		if ($tmpStr == '')
		{
			return null;
		}
		else
		{
			return $tmpStr;
		}
	}
}
// END Input class