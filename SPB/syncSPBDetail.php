<?
	include("../Connection/connect_mssql.php");

	date_default_timezone_set('Etc/GMT-8');

	//$date=date("Y-m-d");
	//$date="2013-09-20";
	$date=$_POST['txtDate'];
	//$end="2013-09-28";
	//$end=date("Y-m-d", strtotime("+1 days"));
	$end=$_POST['txtDateNow'];

	$baris_getHeader=0;

	$query_getHeader="	SELECT
						B.POPRCTNM, B.PONUMBER,
						B.ITEMNMBR, B.ITEMDESC, B.UOFM, B.QTYRCVOA,
						B.QTYONPO, B.LOCNCODE, B.DEX_ROW_ID
						FROM POSPO007 A, POSPO008 B, IV40700 C
						WHERE A.POPRCTNM=B.POPRCTNM
						AND A.LOCNCODE=C.LOCNCODE
						--AND (C.CITY='Banjarmasin' OR C.CITY='Tanjung' OR C.CITY='Martapura')
						--AND ((A.CREATDDT between '".$date."' and '".$end."') OR (A.MODIFDT between '".$date."' and '".$end."'))
						AND ((A.CREATDDT >='".$date."') OR (A.MODIFDT >='".$date."'))
						and A.DOCDATE>='2013-07-01'
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
		echo "REPLACE INTO `POSPO008` (`POPRCTNM`, `PONUMBER`, `ITEMNMBR`, `ITEMDESC`, `UOFM`, `QTYRCVOA`, `QTYONPO`, `LOCNCODE`, `DEX_ROW_ID`) VALUES ('".$row_getHeader['POPRCTNM']."', '".$row_getHeader['PONUMBER']."', '".$row_getHeader['ITEMNMBR']."', '".str_replace("'","''",$row_getHeader['ITEMDESC'])."', '".$row_getHeader['UOFM']."', '".$row_getHeader['QTYRCVOA']."', '".$row_getHeader['QTYONPO']."', '".$row_getHeader['LOCNCODE']."', '".$row_getHeader['DEX_ROW_ID']."');^#

			";
		
		
	}

?>