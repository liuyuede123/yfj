<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CCH
 */

/**
* Returns variable or default value
* @access	public
* @param	mixed
* @return	mixed
*/
if(!function_exists('my_echo'))
{
	function my_echo(&$variable, $default_echo = '')
	{
		if(isset($variable) and $variable != '') return $variable;
		else return $default_echo;
	}
}

if( ! function_exists('get_video_category'))
{
	function get_video_category()
	{
		$CI =& get_instance();
		return $CI->db->query("select id,name from {$CI->db->dbprefix('video_category')}")->result_array();
	}
}

if(!function_exists('my_states'))
{
	function my_states(&$states, $default_states = '')
	{
		if(isset($states) AND $states != ''){

			switch ($states) {
				case 1:
					$new_states = '99积分兑换'; 
					break;
				case 2:
					$new_states = '688积分兑换'; 
					break;
				case 3:
					$new_states = '1288积分兑换'; 
					break;
				case 4:
					$new_states = '5888积分兑换'; 
					break;
				case 5:
					$new_states = '51888积分兑换'; 
					break;
				
				default:
					$new_states = '';
					break;
			}
			return $new_states;

		}else{

			return $default_states;
		} 
	}
}