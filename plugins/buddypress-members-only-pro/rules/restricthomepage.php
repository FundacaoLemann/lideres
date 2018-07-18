<?php
if (!defined('ABSPATH'))
{
	exit;
}

function restrictHomePageToGuestHavePermisssion()
{
	if (is_front_page ())
	{
		if (is_user_logged_in () == false) 
		{
			$m_bprestricthomepage = get_option ( 'bprestricthomepage');
			if ($m_bprestricthomepage == 'yes')
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		else 
		{
			return true;
		}
	}
	else 
	{
		return false;
	}
}