<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Form Value
 *
 * Grabs a value from the POST array for the specified field so you can
 * re-populate an input field or textarea.  If Form Validation
 * is active it retrieves the info from the validation class
 *
 * @access	public
 * @param	string
 * @return	mixed
 */
if ( ! function_exists('set_value'))
{
	function set_value($field = '', $default = '')
	{
		if ( ! isset($_POST[$field]))
		{
			return $default;
		}

		return form_prep($_POST[$field], $field);
	}
}

/* End of file form_helper.php */
/* Location: ./system/helpers/form_helper.php */