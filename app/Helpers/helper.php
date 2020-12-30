<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of helpers
 *
 */

function setActive($path, $active = 'active') 
{
    return call_user_func_array('Request::is', (array)$path) ? $active : '';
}

function setShow($path, $show = 'show') 
{
    return call_user_func_array('Request::is', (array)$path) ? $show : '';
}

function setSubmenu($path, $submenu = 'submenu') 
{
    return call_user_func_array('Request::is', (array)$path) ? $submenu : '';
}

function rupiah($angka)
{	
	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	return $hasil_rupiah;
}

function formatDate($array) 
{
    $string = date('Y-m-d', strtotime($array));
    return $string;
}

if (! function_exists('num_row')) {
	function num_row($page, $limit) {
		if (is_null($page)) {
			$page = 1;
		}

		$num = ($page * $limit) - ($limit - 1);
		return $num;
	}
}

function objectToArray ($object) {
    if(!is_object($object) && !is_array($object)){
    	return $object;
    }
    return array_map('objectToArray', (array) $object);
}

function dateBetween($dateStart, $dateEnd)
{
    $startTimeStamp = strtotime($dateStart);
    $endTimeStamp = strtotime($dateEnd);

    $timeDiff = abs($endTimeStamp - $startTimeStamp);

    $numberDays = $timeDiff/86400;  // 86400 seconds in one day
    
    // and you might want to convert to integer
    $numberDays = intval($numberDays);
    return $numberDays;
}
