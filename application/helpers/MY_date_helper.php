<?php 
//Lay ngay tu dang int
//$time: int - thoi gian muon hien thi ngay
//$full_time: cho biet co lay ca gio phut giay hay khong
function get_date($time, $fulltime = true)
{
	$format = '%d-%m-%Y';
	if($fulltime)
	{
		$format = $format.' - %h:%i:%s';
	}
	$date = mdate($format, $time);
	return $date; 
}