<?
	include("../Connection/connect.php");

	date_default_timezone_set('Etc/GMT-8');

	$file=$_REQUEST['file'];
	
	$myFile = $file.".txt";
	$fh = fopen($myFile, 'r');
	$theData = fread($fh, filesize($myFile));
	fclose($fh);
	//echo $myFile;
	echo $theData;

?>