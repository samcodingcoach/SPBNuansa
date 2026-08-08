<?
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Surat Penerimaan Barang</title>
</head>
<script src="../js/jquery-1.6.4.min.js" type="text/javascript"></script>
<script>
	function clickPrint(PONumber)
	{
		var cetakSPB= window.open('printSPB.php?nomor_spb='+PONumber+'&mode=print','cetakSPB','menubar=no,status=no,scrollbars=yes,top=100%,left=100');
	}
	
	$(document).ready(function () {
		if(document.getElementById("txtMode").value=="print")
		{
			window.print();
		}
	});
	
</script>
<?
	include("../Connection/connect.php");

	date_default_timezone_set('Etc/GMT-8');

	if(!isset($_REQUEST['mode']))
	{
		$mode="preview";
	}
	else
	{
		$mode=$_REQUEST['mode'];
	}

	if(!isset($_REQUEST['nomor_spb']))
	{
		$nomor_spb="SF/POR/1309/00052";
	}
	else
	{
		$nomor_spb=$_REQUEST['nomor_spb'];
	}
	
	$query_getHeader="	SELECT	* FROM POSPO007
						WHERE	POPRCTNM='".$nomor_spb."'
						";
	$res_getHeader=mysql_query($query_getHeader);
	//echo $query_getHeader;
	$row_getHeader=mysql_fetch_array($res_getHeader);
?>
<body bgcolor="#FFFFFF">
	<div style="width:100%;">
    	<input type="text" style="display:none;" id="txtMode" name="txtMode" value="<? echo $mode;?>" />
		<?
        if($mode=="preview")
		{
		?>
        <input type="button" id="btnPrint" name="btnPrint" onclick="clickPrint('<? echo $row_getHeader['POPRCTNM'];?>');" value="Print" />
        <?
		}
		?>
        <table style="width:100%;">
            <tr>
                <td rowspan="6">
                    <img src="../lib-img/Nuansa.jpg" width="200" height="75" />
                </td>
                <td rowspan="2" style="font-weight:bold; font-size:16px;">
                    SURAT PENERIMAAN BARANG (WEBSITE)
                </td>
                <td>
                    Cabang:
                </td>
                <td>
                    TANGGAL PB:
                </td>
                <td>
                    Tanggal SJ Supplier:
                </td>
            </tr>
            <tr>
            	<td>
                	<? echo $row_getHeader['MET_Store_ID'];?>
                </td>
            	<td>
                	<? echo date('d-M-Y', strtotime($row_getHeader['DOCDATE']));?>
                </td>
            	<td>
                	<? echo date('d-M-Y', strtotime($row_getHeader['Vendor_Document_Date']));?>
                </td>
            </tr>
            <tr>
                <td>
                    Diterima Dari
                </td>
                <td>
                    Gudang:
                </td>
                <td>
                    No. PB:
                </td>
                <td>
                    No. SJ Supplier:
                </td>
            </tr>
            <tr>
                <td>
                    <? echo $row_getHeader['VENDNAME'];?>
                </td>
                <td>
                    <? echo $row_getHeader['LOCNCODE'];?>
                </td>
                <td>
                    <? echo $row_getHeader['POPRCTNM'];?>
                </td>
                <td>
                    <? echo $row_getHeader['VNDDOCNM'];?>
                </td>
            </tr>
        </table>
        <br />
        <table style="width:100%;">
        	<tr style="">
            	<td style="text-align:left;">
                	No.
                </td>
            	<td>
                	ITEMDESC
                </td>
            	<td>
                	QTY Rcv
                </td>
            	<td style="text-align:left;">
                	UOFM
                </td>
            	<td style="text-align:left;">
                	PO Number
                </td>
            </tr>
            <?
			$no=0;
			$jum_qty=0;
            $query_getDetail="	SELECT * FROM POSPO008
								WHERE POPRCTNM='".$nomor_spb."'
							";
			$res_getDetail=mysql_query($query_getDetail);
			while($row_getDetail=mysql_fetch_array($res_getDetail))
			{
				$no+=1;
				$jum_qty+=$row_getDetail['QTYRCVOA'];
			?>
        	<tr>
            	<td>
                	<? echo $no;?>
                </td>
            	<td>
                	<? echo $row_getDetail['ITEMDESC'];?>
                </td>
            	<td style="text-align:left;">
                	<? echo number_format($row_getDetail['QTYRCVOA']);?>
                </td>
            	<td style="text-align:left;">
                	<? echo $row_getDetail['UOFM'];?>
                </td>
            	<td style="text-align:left;">
                	<? echo $row_getDetail['PONUMBER'];?>
                </td>
            </tr>
            <?
			}
			?>
            <tr>
            	<td colspan="2" style="text-align:center;">
                	Total
                </td>
            	<td colspan="3" style="text-align:left;">
                	<? echo $jum_qty;?>
                </td>
            </tr>
        </table>
        <br />
        <table style="width:100%;">
        	<tr style="vertical-align:top;">
            	<td colspan="2" style="width:60%;">
                	Keterangan: -
                </td>
            </tr>
            <tr>
            	<td>
                	
                </td>
            	<td style="font-weight:bold;">
                	Dokumen Wajib dibawa pada saat Tagihan
                </td>
            </tr>
            <tr style="text-align:left;">
            	<td>
                	
                </td>
                <td colspan="2">
                	User ID: <? echo $row_getHeader['PTDUSRID'];?>
                </td>
            </tr>
            <tr style="text-align:left;">
            	<td>
                	
                </td>
                <td colspan="2">
                	Print Date: <? echo date("d/m/Y");?>
                </td>
            </tr>
            <tr style="text-align:left;">
            	<td>
                	Disiapkan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Disetujui &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Diantar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Diterima
                </td>
            	<td>
                	Lbr. 1 - Lampiran Tagihan
                    <br />Lbr. 2 - Arsip Purchase
                    <br />Lbr. 3 - Arsip Cab / Setempat
                </td>
            </tr>
        </table>
        <br />
    </div>
</body>
</html>