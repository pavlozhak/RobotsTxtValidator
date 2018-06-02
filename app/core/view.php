<?php
namespace View;

class View
{
	public function render($template = 'default_template', $data = null)
	{
		if(is_array($data))
		{
			// transform the elements of the array into variables
			extract($data);
		}
		
		include_once 'app/views/'.$template.'.php';
	}
}