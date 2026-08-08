<?
	include("../Connection/connect.php");

	date_default_timezone_set('Etc/GMT-8');
	
	
	$flag=0;

	$query_file="";
	$query_file1="";
	$total=$_POST['txtTotalRow'];
	$query1=str_replace("\\","",$_POST['txtQuery']);
	
	$query=explode("^#",$query1);
	//$id=$_REQUEST['id'];
	/*
	$query_file1="";
	$query_file="";

	$query=str_replace("\\","",$_POST['txtQuery']);
	//$query1=str_replace("\\","",$_POST['txtQuery'.$id]);
	//$total=$_POST['txtTotalRow'];
	//$id=$_REQUEST['id'];
	
	$res_insertDetail=mysql_query($query);
	if(!$res_insertDetail)
	{
		$flag=1;
		$query_file1.=$query;
		$myFile2 = "queryPODetail-Failed-".date("d-m-Y H-i-s").".txt";
		$fh1 = fopen($myFile2, 'w') or die("can't open file");
		$stringData2 = $query_file1;
		fwrite($fh1, $stringData2);
		fclose($fh1);
	}
	else
	{
		$query_file.=$query;
		$myFile1 = "queryPODetail.txt";
		$fh = fopen($myFile1, 'w') or die("can't open file");
		$stringData1 = $query_file;
		fwrite($fh, $stringData1);
		fclose($fh);
	}
	*/
	
	
	
	
	for($a=0;$a<$total;$a++)
	{
		$res_insertDetail=mysql_query($query[$a]);
		if(!$res_insertDetail)
		{
			$flag=1;
			$query_file1.=$query[$a];
			$myFile2 = "querySPBHeader-Failed-".date("d-m-Y H-i-s").".txt";
			$fh1 = fopen($myFile2, 'w') or die("can't open file");
			$stringData2 = $query_file1;
			fwrite($fh1, $stringData2);
			fclose($fh1);
		}
		else
		{
			$query_file.=$query[$a];
			$myFile1 = "querySPBHeader.txt";
			$fh = fopen($myFile1, 'w') or die("can't open file");
			$stringData1 = $query_file;
			fwrite($fh, $stringData1);
			fclose($fh);
		}
	}
	
	
	if($flag==0)
	{
		$myFile = "SPBHeader.txt";
		$fh = fopen($myFile, 'w') or die("can't open file");
		$stringData = $_POST['txtDateNow'];
		fwrite($fh, $stringData);
		fclose($fh);
	}







//=================================================================
	/*include("../Connection/connect.php");

	date_default_timezone_set('Etc/GMT-8');


	$id=$_REQUEST['id'];
	$flag=0;
	//$loop=$_POST['txtTotalQuery'];
	
	
		$query=$_POST['txtQuery'.$id];
		$res_insertDetail=mysql_query($query);
		
		if(!$res_insertDetail)
		{
			$flag=1;
		}
	
	//echo $query;
	
	
	
	
	
	if($flag==0)
	{
		$myFile = "PODetail.txt";
		$fh = fopen($myFile, 'w') or die("can't open file");
		$stringData = date("Y-m-d");
		fwrite($fh, $stringData);
		fclose($fh);
		
		$myFile1 = "queryPODetail.txt";
		$fh = fopen($myFile1, 'w') or die("can't open file");
		$stringData1 = $query;
		fwrite($fh, $stringData1);
		fclose($fh);
		
	}*/

?>