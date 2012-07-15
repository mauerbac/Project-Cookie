<?php
header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
//Twilio Response and logging
//�2012 Matt Auerbach
//Written for Will Ginseberg- Project Cookie


//Initialize all variables
$SmsSid = '';
$AccountSid = '';
$From = '';
$To = '';
$Body = '';
$FromCity = '';
$FromState = '';
$FromZip = '';
$FromCountry = '';
$ToCity = '';
$ToState = '';
$ToZip = '';
$ToCountry = '';

//Populate variables(if they exist)
isset($_POST['SmsSid'])?$SmsSid = $_POST['SmsSid']:$SmsSid = '';
isset($_POST['AccountSid'])?$AccountSid = $_POST['AccountSid']:$AccountSid = '';
isset($_POST['From'])?$From = $_POST['From']:$From = '';
isset($_POST['To'])?$To = $_POST['To']:$To = '';
isset($_POST['Body'])?$Body = $_POST['Body']:$Body = '';
isset($_POST['FromCity'])?$FromCity = $_POST['FromCity']:$FromCity = '';
isset($_POST['FromState'])?$FromState = $_POST['FromState']:$FromState = '';
isset($_POST['FromZip'])?$FromZip = $_POST['FromZip']:$FromZip = '';
isset($_POST['FromCountry'])?$FromCountry = $_POST['FromCountry']:$FromCountry = '';
isset($_POST['ToCity'])?$ToCity = $_POST['ToCity']:$ToCity = '';
isset($_POST['ToState'])?$ToState = $_POST['ToState']:$ToState = '';
isset($_POST['ToZip'])?$ToZip = $_POST['ToZip']:$ToZip = '';
isset($_POST['ToCountry'])?$ToCountry = $_POST['ToCountry']:$ToCountry = '';



$link = mysql_connect("xxxx", "xxxx", "xxxx");
	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}
	$db_selected = mysql_select_db("projectcookie");
	if (!$db_selected) {
		die ('Can\'t use foo : ' . mysql_error());
	}


$currentnumber=$_POST['From'];
$currentmessage=$_POST['Body'];

$search = strtolower($_POST['Body']);

	
	$array = explode(" ", $search);
	$firstWord= $array[0];
	$secondItem=(int)$array[1];
	$thirdItem=(int)$array[2];
	$fourthItem=(int)$array[3];
	$fifthItem=(int)$array[4];
	
	if($currentnumber=="123456789"){
		$name= "Joe Smoe";
	}else if($currentnumber=="987654321"){
		$name="Jill Smoe";
	}else{
		$name="Unauthorized Number";
	}

	if($firstWord=="items"){
	$sql = "INSERT INTO items (`time`,`name`,`item1`,`item2`,`item3`,`item4`) VALUES (NOW(),'".$name."','".$secondItem."','".$thirdItem."','".$fourthItem."','".$fifthItem."')"; 
	mysql_query($sql);
	$output= "You've entered: ".$secondItem." Rolls of Dough, ".$thirdItem." Tubs of Dough, and ".$fourthItem." Oreo Boxes.";	
	$sql = "INSERT INTO maininfo (`numbers`,`message`) VALUES ('".$currentnumber."','".$currentmessage."')"; 
	mysql_query($sql);
	finals($output);
	
	}else if($firstWord=="clockin"){
	//$name = str_ireplace('clockin ', '', $search);
	$sql = "INSERT INTO clockin (`time`,`name`) VALUES (NOW(),'".$name."')"; 
	mysql_query($sql);
	$output= "Thanks for clocking in ".$name.".";
	$sql = "INSERT INTO maininfo (`numbers`,`message`) VALUES ('".$currentnumber."','".$currentmessage."')"; 
	mysql_query($sql);	
	finals($output);
	
	}else if($firstWord=="clockout"){
	//$name = str_ireplace('clockout ', '', $search);
	$sql = "INSERT INTO clockout (`time`,`name`) VALUES (NOW(),'".$name."')"; 
	mysql_query($sql);
	$output= "Thanks for clocking out ".$name.".";	
	finals($output);
	

	$sql = "INSERT INTO maininfo (`numbers`,`message`) VALUES ('".$currentnumber."','".$currentmessage."')"; 
	mysql_query($sql);

	}else{
	$output= "Invaild Command! Enter \"items\" then each # followed by a space, \"clockin\" or \"clockout\"";
	$sql = "INSERT INTO maininfo (`numbers`,`message`) VALUES ('".$currentnumber."','".$currentmessage."')"; 
	mysql_query($sql);	
	finals($output);
	}


	
function finals($response){

$finals=str_ireplace('&','&amp;',"<Response> \n <Sms> \n ".$response."\n</Sms> \n</Response>");

 echo $finals;
}
	
?>
