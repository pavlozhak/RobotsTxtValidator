<?php
namespace Model;

class Model
{
	public function get_data()
	{
	}

	public function getVarFromPost($name)
    {
        if(empty($name))
        {
            return false;
        }
        else
        {
            if(empty($_POST[$name]))
            {
                return false;
            }
            else
            {
                return $_POST[$name];
            }
        }
    }

    public function getVarFromGet($name)
    {
        if(empty($name))
        {
            return false;
        }
        else
        {
            if(empty($_GET[$name]))
            {
                return false;
            }
            else
            {
                return $_GET[$name];
            }
        }
    }
}