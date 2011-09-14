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
// ------------------------------------------------------------------------

/**
 * Form Declaration
 *
 * Creates the opening portion of the form.
 *
 * @access	public
 * @param	string	the URI segments of the form destination
 * @param	array	a key/value pair of attributes
 * @param	array	a key/value pair hidden data
 * @return	string
 */
if ( ! function_exists('form_open'))
{
	function form_open($action = '', $attributes = '', $hidden = array())
	{
		$CI =& get_instance();

		if ($attributes == '')
		{
			$attributes = 'method="post"';
		}

		// If an action is not a full URL then turn it into one
		if ($action && strpos($action, '://') === FALSE)
		{
			$action = $CI->config->site_url($action);
		}

		$form = '<form action="'.$action.'"';

		$form .= _attributes_to_string($attributes, TRUE);

		$form .= '>';

		// CSRF
		if ($CI->config->item('csrf_protection') === TRUE)
		{
			$hidden[$CI->security->get_csrf_token_name()] = $CI->security->get_csrf_hash();
		}

		if (is_array($hidden) AND count($hidden) > 0)
		{
			$form .= sprintf("\n<div class=\"hidden\">%s</div>", form_hidden($hidden));
		}

		return $form;
	}
}

/* End of file form_helper.php */
/* Location: ./system/helpers/form_helper.php */