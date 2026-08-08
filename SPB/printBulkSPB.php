<?php
session_start();
include("../Connection/connect.php");
date_default_timezone_set('Etc/GMT-8');

if(empty($_POST['chkRow'])) {
    die("<h2 style='text-align:center;font-family:sans-serif;margin-top:50px;'>Tidak ada SPB yang dipilih.</h2>");
}

$spb_list = $_POST['chkRow'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Bulk Print SPB</title>
    <meta charset="utf-8">
    <script src="../js/jquery-1.6.4.min.js" type="text/javascript"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background: #f4f7f6; 
            padding: 30px; 
            color: #333;
        }
        .print-btn-container { 
            text-align: right; 
            margin-bottom: 30px; 
        }
        .print-btn { 
            background: #fff; 
            border: 2px solid #1a252f; 
            color: #1a252f; 
            padding: 12px 25px; 
            font-weight: bold; 
            font-size: 16px; 
            cursor: pointer; 
            border-radius: 8px;
            transition: all 0.3s;
        }
        .print-btn:hover { 
            background: #1a252f; 
            color: #fff; 
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .print-btn i {
            margin-right: 8px;
        }
        
        .spb-container { 
            background: #fff; 
            margin-bottom: 25px; 
            border: 2px solid #cbd5e1; 
            border-radius: 8px; 
            overflow: hidden; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: all 0.3s;
        }
        .spb-header { 
            background: #f8fafc; 
            padding: 15px 25px; 
            border-bottom: 2px solid #cbd5e1;
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            cursor: pointer; 
            font-size: 20px; 
            font-weight: bold;
        }
        .spb-header:hover {
            background: #f1f5f9;
        }
        .spb-header-left { display: flex; align-items: center; }
        .spb-header-right { display: flex; align-items: center; }
        .spb-number { margin-right: 20px; }
        
        .icon-trash { 
            color: #ef4444; 
            cursor: pointer; 
            font-size: 24px; 
            text-decoration: none; 
            border: none; 
            background: none; 
            padding: 0;
            transition: color 0.3s;
        }
        .icon-trash:hover {
            color: #dc2626;
        }
        .icon-chevron { 
            font-size: 20px; 
            transition: transform 0.3s; 
            color: #64748b;
        }
        .collapsed .icon-chevron { transform: rotate(-90deg); }
        .spb-body { padding: 30px; display: block; }
        
        /* The specific SPB Print CSS overrides */
        .spb-body table { font-size: 13px; }
        
        @media print {
            body { background: #fff; padding: 0; }
            .print-btn-container { display: none; }
            .spb-container { border: none; box-shadow: none; margin-bottom: 0; border-radius:0; page-break-after: always; }
            .spb-header { display: none; } /* Hide the headers when printing */
            .spb-body { padding: 0; padding-top:20px; display: block !important; } /* Force display on print */
        }
    </style>
</head>
<body>

<div class="print-btn-container">
    <button class="print-btn" onclick="window.print()"><i class="fas fa-print"></i> PRINT ALL</button>
</div>

<?php
foreach($spb_list as $nomor_spb) {
    // Get Header
    $query_getHeader="	SELECT	* FROM POSPO007
                        WHERE	POPRCTNM='".mysql_real_escape_string($nomor_spb)."'
                        ";
    $res_getHeader=mysql_query($query_getHeader);
    $row_getHeader=mysql_fetch_array($res_getHeader);
    if(!$row_getHeader) continue;
    
    $hash_id = md5($nomor_spb);
?>
<div class="spb-container" id="spb-<?php echo $hash_id; ?>">
    <div class="spb-header" onclick="toggleSpb('<?php echo $hash_id; ?>')">
        <div class="spb-header-left">
            <div class="spb-number"><?php echo htmlspecialchars($nomor_spb); ?></div>
            <button class="icon-trash" onclick="removeSpb(event, '<?php echo $hash_id; ?>')" title="Remove SPB"><i class="fas fa-trash-alt"></i></button>
        </div>
        <div class="spb-header-right">
            <div class="icon-chevron"><i class="fas fa-chevron-down"></i></div>
        </div>
    </div>
    <div class="spb-body" id="body-<?php echo $hash_id; ?>">
        <!-- BEGIN ORIGINAL SPB DESIGN -->
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
                	<?php echo $row_getHeader['MET_Store_ID'];?>
                </td>
            	<td>
                	<?php echo date('d-M-Y', strtotime($row_getHeader['DOCDATE']));?>
                </td>
            	<td>
                	<?php echo date('d-M-Y', strtotime($row_getHeader['Vendor_Document_Date']));?>
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
                    <?php echo $row_getHeader['VENDNAME'];?>
                </td>
                <td>
                    <?php echo $row_getHeader['LOCNCODE'];?>
                </td>
                <td>
                    <?php echo $row_getHeader['POPRCTNM'];?>
                </td>
                <td>
                    <?php echo $row_getHeader['VNDDOCNM'];?>
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
            <?php
			$no=0;
			$jum_qty=0;
            $query_getDetail="	SELECT * FROM POSPO008
								WHERE POPRCTNM='".mysql_real_escape_string($nomor_spb)."'
							";
			$res_getDetail=mysql_query($query_getDetail);
			while($row_getDetail=mysql_fetch_array($res_getDetail))
			{
				$no+=1;
				$jum_qty+=$row_getDetail['QTYRCVOA'];
			?>
        	<tr>
            	<td>
                	<?php echo $no;?>
                </td>
            	<td>
                	<?php echo $row_getDetail['ITEMDESC'];?>
                </td>
            	<td style="text-align:left;">
                	<?php echo number_format($row_getDetail['QTYRCVOA']);?>
                </td>
            	<td style="text-align:left;">
                	<?php echo $row_getDetail['UOFM'];?>
                </td>
            	<td style="text-align:left;">
                	<?php echo $row_getDetail['PONUMBER'];?>
                </td>
            </tr>
            <?php
			}
			?>
            <tr>
            	<td colspan="2" style="text-align:center;">
                	Total
                </td>
            	<td colspan="3" style="text-align:left;">
                	<?php echo $jum_qty;?>
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
                	User ID: <?php echo $row_getHeader['PTDUSRID'];?>
                </td>
            </tr>
            <tr style="text-align:left;">
            	<td>
                	
                </td>
                <td colspan="2">
                	Print Date: <?php echo date("d/m/Y");?>
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
        <!-- END ORIGINAL SPB DESIGN -->
    </div>
</div>
<?php } ?>

<script>
function toggleSpb(id) {
    var body = document.getElementById('body-' + id);
    var header = document.querySelector('#spb-' + id + ' .spb-header');
    if (body.style.display === 'none') {
        body.style.display = 'block';
        header.classList.remove('collapsed');
    } else {
        body.style.display = 'none';
        header.classList.add('collapsed');
    }
}

function removeSpb(event, id) {
    event.stopPropagation(); // Prevent the toggle from triggering
    if(confirm('Apakah Anda yakin ingin menghapus SPB ini dari daftar cetak?')) {
        var el = document.getElementById('spb-' + id);
        el.parentNode.removeChild(el);
    }
}
</script>
</body>
</html>
