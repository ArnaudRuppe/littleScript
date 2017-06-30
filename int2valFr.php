<?php 

/*
 * @param value - the value you want to convert to string
 * @return string
*/
function int2val100($value){
	// In french, this is the basic and unique number we need to create all the other number

	$basicNumber = array(
		"0" => "",
		"1" => "un" ,
		"2" => "deux",
		"3" => "trois",
		"4" => "quatre",
		"5" => "cinq",
		"6" => "six",
		"7" => "sept",
		"8" => "huit",
		"9" => "neuf",
		"10" => "dix",
		"11" => "onze",
		"12" => "douze",
		"13" => "treize",
		"14" => "quatorze",
		"15" => "quinze",
		"16" => "seize",
		"17" => "dix-sept",
		"18" => "dix-huit",
		"19" => "dix-neuf"
	);

	$dozen = array(
		"1"=>"dix",
		"2"=>"vingt",
		"3"=>"trente",
		"4"=>"quarante",
		"5"=>"cinquante",
		"6"=>"soixante",
		"8"=>"quatre-vingt"
	);
	if(substr($value, 0,1) == "0"){
		$value = substr($value, 1);
	}
	if(array_key_exists($value, $basicNumber)){
		return $basicNumber[$value];
	}
	$unit = $value % 10 ;
	if($value <70 || ($value<90 && $value > 79)){
		$res = $dozen[substr($value, 0,1)];
		if ($unit == 1) {
			return $res.=" et un" ;
		}
		elseif($unit != 0){
			return $res.="-".$basicNumber[$unit];
		}
		else{
			return $res ;
		}
	}
	elseif($value<80){
		//Case 70 to 79
		$res = $dozen["6"] ;
		if($unit == 1){
			return $res." et ".$basicNumber["1".$unit];
		}
		else{
			return $res."-".$basicNumber["1".$unit];
		}
	}
	else{
		//Case 90 to 99
		$res = $basicNumber["4"]."-".$dozen["2"] ;
		return $res."-".$basicNumber["1".$unit];
	}
}
function int2val1000($value){
	$basicNumber = array(
		"0" => "",
		"1" => "" ,
		"2" => "deux",
		"3" => "trois",
		"4" => "quatre",
		"5" => "cinq",
		"6" => "six",
		"7" => "sept",
		"8" => "huit",
		"9" => "neuf"
	);
	$hundred = substr($value, 0,1);
	if($hundred == 0){
		return " ".int2val100(substr($value, 1));
	}
	else{
		return $basicNumber[$hundred]." cent ".int2val100(substr($value, 1));
	}
}
function int2valMil($value){
	// we don't take the 3 last digit
	$milPart = substr($value, 0,-3);	
	if($milPart == 1){
		$res = "mille";
	}
	else{
		if($milPart < 100 && $milPart != 1){
			$res = int2val100($milPart);
		}
		if($milPart < 1000){
			$res = int2val1000($milPart);
		}
		$res.=" mille ";
	}	
	//We treat the last 3 digits
	$lastDigits = substr($value, -3) ;
	if($lastDigits == 0){
		return $res ;
	}
	else{
		$res.= int2val1000($lastDigits);
		return $res ;
	}
	
}
function int2valRest($value){
	//We returieve the value over the milion
	$valueOMil = substr($value,0, -6);
	echo $valueOMil;
	$res = int2valFr($valueOMil);
	$res .=" milion";
	//We retrieve the valune under the milion
	$valueUMil = substr($value, -6);
	if($valueUMil != 0){
		$res .= " ".int2valMil($valueUMil);
	}
	return $res ;
}
function int2valFr($value){
	if($value < 100){
		return int2val100($value);
	}
	if($value < 1000){
		return int2val1000($value);
	}
	if($value < 1000000){
		return int2valMil($value);
	}
	return int2valRest($value);
}
//This file is used to have the function int2val for php in french
