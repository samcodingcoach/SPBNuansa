<?
	include("../Connection/connect_mssql.php");

	date_default_timezone_set('Etc/GMT-8');

	//$date=date("Y-m-d");
	//$date="2013-09-15";
	$date=$_POST['txtDate'];
	//$end="2013-09-30";
	//$end=date("Y-m-d", strtotime("+1 days"));
	$end=$_POST['txtDateNow'];

	$baris_getHeader=0;
	
	//and (B.CITY='Banjarmasin' OR B.CITY='Tanjung' OR B.CITY='Martapura')
	$query_getHeader="	SELECT
						A.POPRCTNM, A.DOCDATE, A.VNDDOCNM,
						A.Vendor_Document_Date, A.VENDORID,
						A.VENDNAME, A.MET_Store_ID, A.LOCNCODE,
						A.PTDUSRID, A.CREATDDT, A.MODIFDT, A.DEX_ROW_ID
						FROM POSPO007 A, IV40700 B
						where A.LOCNCODE=B.LOCNCODE
						--and ((a.CREATDDT between '".$date."' and '".$end."') OR (a.MODIFDT between '".$date."' and '".$end."'))
						AND ((a.CREATDDT >='".$date."') OR (a.MODIFDT >='".$date."'))
						and a.DOCDATE>='2013-07-01'
						";
	$res_getHeader=mssql_query($query_getHeader);
	$totalrow_getHeader=mssql_num_rows($res_getHeader);
	
	//echo $query_getHeader;
	
	$query="";
	echo $totalrow_getHeader."|";
	
	//echo "<input type='text' name='txtTotalRowHeader' id='txtTotalRowHeader' value='".$totalrow_getHeader."' />";
	while($row_getHeader=mssql_fetch_array($res_getHeader))
	{
		$baris_getHeader+=1;
		echo "REPLACE INTO `POSPO007` (`POPRCTNM`, `DOCDATE`, `VNDDOCNM`, `Vendor_Document_Date`, `VENDORID`, `VENDNAME`, `MET_Store_ID`, `LOCNCODE`, `PTDUSRID`, `CREATDDT`, `MODIFDT`, `DEX_ROW_ID`) VALUES ('".$row_getHeader['POPRCTNM']."', '".$row_getHeader['DOCDATE']."', '".$row_getHeader['VNDDOCNM']."', '".$row_getHeader['Vendor_Document_Date']."', '".$row_getHeader['VENDORID']."', '".$row_getHeader['VENDNAME']."', '".$row_getHeader['MET_Store_ID']."', '".$row_getHeader['LOCNCODE']."', '".$row_getHeader['PTDUSRID']."', '".$row_getHeader['CREATDDT']."', '".$row_getHeader['MODIFDT']."', '".$row_getHeader['DEX_ROW_ID']."');^#

			";
		
			
			//$query.="('".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['PONUMBER']."');";
			
			
			

		

		
	}


	//echo "<input type='text' name='txtQuery' id='txtQuery' value='".$query."' />";
	/*echo $totalrow_getHeader."|";
	echo $query;
	*/

?>