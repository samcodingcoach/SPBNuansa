<?php
session_start();
include('../StructureIndex/head-library.php');
include('../Connection/validateSession.php');
include("../Connection/connect.php");
date_default_timezone_set('Etc/GMT-8');

if(empty($_POST['chkRow'])) {
    echo '<div class="box round first fullpage" style="padding:20px;"><h2>Tidak ada SPB yang dipilih.</h2><br><a href="DaftarSPB.php" style="color:blue; text-decoration:underline;">&laquo; Kembali ke Daftar SPB</a></div>';
    exit;
}

$spb_list = $_POST['chkRow'];
?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<style>
    .print-btn-container { 
        display: flex;
        justify-content: space-between;
        align-items: center;
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
    
    
    
    @media print {
        body { background: #fff; padding: 0; }
        .box { border: none !important; box-shadow: none !important; }
        h2.title-page, .print-btn-container, .box-header { display: none !important; }
        .spb-container { border: none; box-shadow: none; margin-bottom: 0; border-radius:0; page-break-after: always; }
        .spb-header { display: none; } /* Hide the headers when printing */
        .spb-body { padding: 0; padding-top:20px; display: block !important; } /* Force display on print */
    }
    
    #page-loader {
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(255, 255, 255, 0.95);
        z-index: 9999;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        font-size: 22px;
        font-weight: bold;
        color: #1a252f;
    }
    .spinner {
        border: 8px solid #f3f3f3;
        border-top: 8px solid #1a252f;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        animation: spin 1s linear infinite;
        margin-bottom: 20px;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<div id="page-loader">
    <div class="spinner"></div>
    <div>Memuat Data SPB... Harap Tunggu</div>
</div>

<div id="main-content" style="display:none;">
<div class="box round first fullpage" style="padding:20px;">
    <h2 class="title-page">Preview Bulk Print SPB</h2>
    <div class="block">

        <div class="print-btn-container">
            <a href="javascript:history.back()" style="color:#333; text-decoration:none; font-weight:bold; font-size:16px;">
                <img src="icon/back.png" alt="Back" style="vertical-align:middle; width:24px; height:24px; margin-right:8px;" onerror="this.src='../lib-img/back.png'"> Kembali
            </a>
            <button class="print-btn" onclick="window.print()"><i class="fas fa-print"></i> PRINT ALL (<?php echo count($spb_list); ?>)</button>
        </div>

        <?php
        $index = 0;
        foreach($spb_list as $nomor_spb) {
            // Get Header
            $query_getHeader="	SELECT	* FROM POSPO007
                                WHERE	POPRCTNM='".mysql_real_escape_string($nomor_spb)."'
                                ";
            $res_getHeader=mysql_query($query_getHeader);
            $row_getHeader=mysql_fetch_array($res_getHeader);
            if(!$row_getHeader) continue;
            
            $hash_id = md5($nomor_spb);
            $is_first = ($index === 0);
            $header_class = "spb-header" . ($is_first ? "" : " collapsed");
            $body_style = $is_first ? "display: block;" : "display: none;";
            $index++;
        ?>
        <div class="spb-container" id="spb-<?php echo $hash_id; ?>">
            <div class="<?php echo $header_class; ?>" onclick="toggleSpb('<?php echo $hash_id; ?>')">
                <div class="spb-header-left">
                    <div class="spb-number"><?php echo htmlspecialchars($nomor_spb); ?></div>
                    <button class="icon-trash" onclick="removeSpb(event, '<?php echo $hash_id; ?>', '<?php echo htmlspecialchars($nomor_spb); ?>')" title="Remove SPB"><i class="fas fa-trash-alt"></i></button>
                </div>
                <div class="spb-header-right">
                    <div class="icon-chevron"><i class="fas fa-chevron-down"></i></div>
                </div>
            </div>
            <div class="spb-body" id="body-<?php echo $hash_id; ?>" style="<?php echo $body_style; ?>">
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

    </div>
</div>

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

function removeSpb(event, id, spbNum) {
    event.stopPropagation(); // Prevent the toggle from triggering
    if(confirm('Apakah Anda yakin ingin menghapus SPB ini dari daftar cetak?')) {
        var el = document.getElementById('spb-' + id);
        el.parentNode.removeChild(el);
        
        var selected = JSON.parse(sessionStorage.getItem('selectedSPB')) || [];
        var index = selected.indexOf(spbNum);
        if (index !== -1) {
            selected.splice(index, 1);
            sessionStorage.setItem('selectedSPB', JSON.stringify(selected));
        }
        
        var count = document.querySelectorAll('.spb-container').length;
        var btn = document.querySelector('.print-btn');
        if (btn) {
            btn.innerHTML = '<i class="fas fa-print"></i> PRINT ALL (' + count + ')';
        }
        
        if (count === 0) {
            history.back();
        }
    }
}

window.onload = function() {
    $('#page-loader').fadeOut('fast', function() {
        $('#main-content').fadeIn('fast');
    });
};
</script>
</div>
