<?php

namespace org;

class Filter 
{	
	
	/*
	参数过滤
	*/
	public static function filterWords($str)
    { 
        return html_in($str);
    }
	

}
