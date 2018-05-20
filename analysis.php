<?php
$draw=0;
$error="";

if ( !empty($_FILES['myfile']['name']) )
{

	setcookie('ghabli',$_FILES['myfile']['name']);

	$draw=0;

	if  ( $file = fopen($_FILES['myfile']["tmp_name"],"r") ) {}
		else $error .= " نتوانستیم فایل را باز کنیم ";


	$file_ext=explode('.',$_FILES['myfile']['name']);

	if ($file_ext[1]!="txt") {
		$error  .=  " پسوند فایل مجاز نیست ! <hr>";
	}
	else {

		$file_lines = array();
		$color = "black";
		$line_number=0;




// read line of file START ---------------------------------------
		while (! feof ($file))
		{
  /*	$content = fgetc($file);
  $number_of_alphabets_character = $content;*/
  $file_lines[$line_number] =  fgets($file);
  $line_number++;
}
}
// read line of file END ---------------------------------------

if (!is_numeric($file_lines[0][0])) $error .= " لطفا خط اول فایل را چک کنید !<br>و دقیقا مانند مثال گفته شده عمل کنید<hr>در خط اول فایل بجای نوشتن تعداد حروف الفبا و اسم آن ها نوشته اید : <br><br><pre>".$file_lines[0]."</pre><br><hr>";

// line 1 analysis START ---------------------------------------
$number_of_alphabets_character = $file_lines[0][0];

if($number_of_alphabets_character==0) $error .= " تعداد حروف الفبا صفر هست . صرفا برای تست سیستم آمده اید ؟ <hr>";

$alphabets  = array() ;


for ($i=1 ; $i<=($number_of_alphabets_character * 2) ; $i++)
{
	if($file_lines[0][$i] == ' ') continue;
	else
		array_push($alphabets, $file_lines[0][$i]);

}


// line 1 analysis END ---------------------------------------



// line 2 analysis START ---------------------------------------
$number_of_states = $file_lines[1][0];

if($number_of_states==0) $error .= " تعداد state ها صفر هست . صرفا برای تست سیستم آمده اید ؟ <hr>";



$states = array();
$states_situation = array();

for ($i=1 ; $i<=(strlen($file_lines[1])-2) ; $i++)
{
	switch ($file_lines[1][$i]) {
		case ' ':
		continue;
		break;
		case '-':
		if( $file_lines[1][($i+2)]!="+" ){
			array_push($states, $file_lines[1][($i+2)]);
			array_push($states_situation, 'start');
			$i+=3;
		}
		else {
			array_push($states, $file_lines[1][($i+4)]);
			array_push($states_situation, 'start-final');
			$i+=5;


		}
		break;
		
		case '+':
		if( $file_lines[1][($i+2)]!="-" ){
			array_push($states, $file_lines[1][($i+2)]);			
			array_push($states_situation, 'final');
			$i+=3;
		}
		else {
			array_push($states, $file_lines[1][($i+4)]);
			array_push($states_situation, 'start-final');
			$i+=5;
		}	
		break;
		
		
		default:  
		array_push($states, $file_lines[1][$i]);
		array_push($states_situation, 'normal');				
		break;
	}

}

// line 2 analysis END ---------------------------------------


// line 3 to end analysis START ------------------------------------
$state_arrow = array();
for ( $j=2 ; $j<$line_number ; $j++){
	$a = $file_lines[$j][0];
	$b = $file_lines[$j][4];
	$value = $file_lines[$j][2];
	$state_arrow [$a][$b] = $value;

}
// line 3 to end analysis END ---------------------------------------

fclose($file);

// =======================================================================================================
// =======================================================================================================
// ========================================= END OF READING FILE =========================================
// =======================================================================================================
// =========================================== www. FARIDFR .ir ==========================================
// =======================================================================================================
// ========================================== BEHINE SAZI START ==========================================
// =======================================================================================================
// =======================================================================================================



// halate dastresi pazir : 

$i=0;
foreach ($states_situation as $ss ) {
	if( strpos ($ss , 'start') !== false )
	{
		$start = $states[$i];
	}
	$i++;
}

/*$start = $states [ array_search('start', $states_situation,true) ];
*/

$new_array = array();
array_push($new_array, $start);

function find ($input){
	global $alphabets , $new_array , $state_arrow;

	foreach ($alphabets as $char) {


		if(!in_array($state_arrow [$input][$char], $new_array)) {
			
			array_push($new_array, $state_arrow [$input][$char]);
			find ($state_arrow [$input][$char]);


		}

	}

}	

find ($start);

// echo " <pre> ";
// print_r($new_array);
// echo "</pre><hr>";


function stkzadan ($st1 , $st2){
	global $states,$states_situation;

	$st1 = array_search($st1, $states,true);
	$st2 = array_search($st2, $states,true);
	$count_of_true = 0 ;


	if( $states_situation[$st1] == 'final' || $states_situation[$st1] == 'start-final' ){$count_of_true++;}
	if( $states_situation[$st2] == 'final' || $states_situation[$st2] == 'start-final' ){$count_of_true++;}

	if( $count_of_true==1){
		return 'stk';
	}

}

$streaked = array();

for($i=0;$i<count($new_array) ; $i++){
	for($j=0;$j<count($new_array) ; $j++){
		$streaked [$new_array [$i]][$new_array [$j]] = 0;
	}
}

for ($i=0 ; $i<count($new_array) ; $i++){
	for($j=($i) ; $j<count($new_array) ; $j++) {


		if(stkzadan ( $new_array [$i] , $new_array [$j] ) == 'stk' ){

			$streaked [$new_array [$i]][$new_array [$j]] = 1;
			$streaked [$new_array [$j]][$new_array [$i]] = 1;


		}
		else {
			$streaked [$new_array [$i]][$new_array [$j]] = 0;
			$streaked [$new_array [$j]][$new_array [$i]] = 0;
		}

	}
}


/*echo " <pre> ";
print_r($streaked);
echo "</pre><hr>";

*/

$stk2 = array();
$unfinished = array();
$final_chars = array();

for($i=0;$i<count($new_array) ; $i++){
	for($j=0;$j<count($new_array) ; $j++){
		$stk2 [$new_array [$i]][$new_array [$j]] = 0;
	}
}





function findstk ($in1,$in2){

	global $alphabets , $new_array , $state_arrow , $stk2 , $streaked , $unfinished , $final_chars , $states;

	$key=0;

	foreach ($alphabets as $char) {

		$koja1 = $state_arrow [$in1][$char];
		$koja2 = $state_arrow [$in2][$char];


		if ( $streaked [$koja1][$koja2] == 1 &&  $koja1 != $koja2) {

			$key=1;
			break;

		}
		
		
	}
	return $key;

}

function counter () {
	global $alphabets , $new_array , $state_arrow , $stk2 , $streaked , $unfinished , $final_chars , $states;

	$i=0;

	for ($i=0 ; $i<count($new_array) ; $i++){
		for($j=($i)  ; $j<count($new_array) ; $j++) {

			if($streaked[$new_array[$i]][$new_array[$j]] == 0){
				$i++;
			}
		}
	}

	return $i;

}

/*echo counter();*/

$biroon = 0;

while ($biroon!=1){

	$count = counter();
	$temp = $count;

	for ($i=0 ; $i<count($new_array) ; $i++){

		for($j=($i+1) ; $i<$j && $j<count($new_array) ; $j++) {

			if( $streaked [$new_array [$i]][$new_array [$j]] != 1 ) {
				
				$key = findstk($new_array [$i],$new_array [$j]);
				if ( $key == 1){
					$streaked[$new_array [$i]][$new_array [$j]] = 1 ;
					$streaked[$new_array [$j]][$new_array [$i]] = 1 ;
					$count = $count-1;
				}
			}


		}

	}

	if($count==$temp){

		$biroon = 1;
	}

}



for ($i=0 ; $i<count($new_array) ; $i++){
	for($j=($i+1) ; $j<count($new_array) ; $j++) {	
		if( $streaked [$new_array [$i]][$new_array [$j]] == 0 ) {
			array_push($unfinished,$new_array[$i]."-".$new_array[$j]);				
			
		}


	}
}


/*	for ($i=0 ; $i<count($new_array) ; $i++){
		for($j=($i+1) ; $j<count($new_array) ; $j++) {

				if( $streaked [$new_array [$i]][$new_array [$j]] != 1 ) {
				findstk ($new_array [$i],$new_array [$j]);

			}
			
	}
}
*/

/*
	echo   "<pre>";
	print_r($unfinished);
	echo "</pre>";*/

	$groups = array ();

	if(count($unfinished)>0)
	{	
		$exploded = explode("-",$unfinished[0]);


		$groups[0] = $exploded[0];
		$groups[0].= $exploded[1];


		for ( $i=1; $i<count($unfinished) ; $i++)
		{

			$exploded = explode("-",$unfinished[$i]);

			for ($j=0 ; $j<count($groups) ; $j++)
			{
				$ok = 1;

				if (strpos ($groups[$j],$exploded[0]) !== false && strpos ($groups[$j],$exploded[1]) !== false)
				{
					$ok = 0;
					continue;
				}

				else if ( strpos ($groups[$j],$exploded[0]) !== false )
				{
					$ok = 0;
					$groups[$j].= $exploded[1];
				}

				else if ( strpos ($groups[$j],$exploded[1]) !== false )
				{
					$ok = 0;
					$groups[$j].= $exploded[0];
				}

			}
			if ($ok==1) {

				$str = $exploded[0].$exploded[1];
				array_push($groups , $str);
			}


		}
	}
	$nahaee = array();

	foreach ($groups as $gr) {
		// echo "<br>".$gr."<br>";
		array_push($nahaee,$gr);
	}


	foreach ($new_array as $state){
		$bood=0;
		foreach ($groups as $gr) {
			if(strpos ($gr,$state) !== false)
				$bood =1;
		}
		if($bood==0){
			array_push($nahaee,$state);
		}

	}


	/*echo"<pre>";
	print_r($nahaee);
	echo"</pre>";*/

	$arrows = array();

	foreach ($nahaee as $state) {

		foreach ($alphabets as $char)
		{

			$peyda =0 ;

			foreach ($nahaee as $na)
			{
				if(strpos ($na,$state_arrow[$state[0]][$char]) !==false )
				{
					$peyda = 1;
					$arrows[$state][$char] = $na;
				}
			}
			


		}
		
	}

/*	echo " <pre > ";
print_r($arrows);*/

$final_states = array();
$i=0;
foreach ($states_situation as $ss) {
	if($ss == "final" || $ss == "start-final"){

		array_push($final_states, $states[$i]);

	}
	$i++;
}



foreach ($nahaee as $search ) {
	if( strpos ($search , $start) !== false )
	{
		$final_start = $search;
	}
}


$i=0;
$final_final = array();

foreach ($nahaee as $search ) {

	foreach ($final_states as $fs) {
		if( strpos ($search , $fs) !== false )
		{
			$final_final [$i] = 1;
		}
		else $final_final [$i] =0;

	}
	$i++;
}



$myFile=fopen("txt/".$_FILES['myfile']['name'],"w") or exit("فایل برای ثبت خروجی نمی تواند باز شود ! ");


$output_line1 = $number_of_alphabets_character." ";
foreach ($alphabets as $char) {
	if(end($alphabets) !== $char){ $output_line1 .= $char." ";}
	else  $output_line1 .= $char;
}

	////////////////////////////////

$output_line2 = count($nahaee)." ";
$i=0;

foreach ($nahaee as $na) {

	$pishvand = "";

	if ($final_final[$i] == 1)   $pishvand = "+";
	if ($final_start==$na)       $pishvand = "-";
	if ($final_final[$i]==1 && $final_start==$na) $pishvand = "- +";

	if (end($nahaee) !== $na){


		if($pishvand!=""){
			$output_line2 .= $pishvand." ".$na." ";
		}
		else {
			$output_line2 .= $na." ";
		}

	}
	else{

		if($pishvand!=""){
			$output_line2 .= $pishvand." ".$na;
		}
		else {
			$output_line2 .= $na;
		}
	} 


	$i++;
}

fwrite($myFile,$output_line1."\r\n");  
fwrite($myFile,$output_line2."\r\n");

	////////////////////////////////


foreach ($nahaee as $state) {

	foreach ($alphabets as $char) {
		$output_line = $state." ".$arrows[$state][$char]." ".$char;											
		fwrite($myFile,$output_line."\r\n");					

	} }
	
	////////////////////////////////



	fclose($myFile);

	$draw=1;
}

?>