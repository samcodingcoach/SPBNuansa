<?
session_start();
include('../StructureIndex/head-library.php');
include('../Connection/validateSession.php');

	include("../Connection/connect.php");
	
	if($_SESSION['restricted_nuansa1']=="%")
	{
		$restricted="%";
	}
	else
	{
		$restricted=$_SESSION['restricted_nuansa1'];
	}
	
	if(!isset($_REQUEST['status']))
	{
		$status="%";
	}
	else
	{
		$status=$_REQUEST['status'];
	}
	
	if(!isset($_REQUEST['site']))
	{
		$site="%";
	}
	else
	{
		$site=$_REQUEST['site'];
	}
	
	if(!isset($_REQUEST['supplier'])&&$_SESSION['restricted_nuansa1']=="%")
	{
		$supplier="%";
	}
	else if(!isset($_REQUEST['supplier'])&&$_SESSION['restricted_nuansa1']!="%")
	{
		$supplier=trim($_SESSION['restricted_nuansa1']);
	}
	else
	{
		$supplier=$_REQUEST['supplier'];
	}
	
	if(!isset($_REQUEST['tanggal']))
	{
		$date=date("d-m-Y", mktime(date("H"),date("i"),date("s"),date("m")-1,date("d"),date("Y")));
		$tanggal=date("Y-m-d", mktime(date("H"),date("i"),date("s"),date("m")-1,date("d"),date("Y")));
	}
	else
	{
		$date=$_REQUEST['tanggal'];
		$tanggal_1=explode("-",$_REQUEST['tanggal']);
		$tanggal=$tanggal_1[2]."-".$tanggal_1[1]."-".$tanggal_1[0];
	}
	
	if(!isset($_REQUEST['tanggal2']))
	{
		$date2=date("d-m-Y");
		$tanggal2=date("Y-m-d");
	}
	else
	{
		$date2=$_REQUEST['tanggal2'];
		$tanggal_1=explode("-",$_REQUEST['tanggal2']);
		$tanggal2=$tanggal_1[2]."-".$tanggal_1[1]."-".$tanggal_1[0];
	}
	
	if(!isset($_REQUEST['searchNo']))
	{
		$searchNo="";
	}
	else
	{
		$searchNo=$_REQUEST['searchNo'];
	}
	
	if(!isset($_REQUEST['page']))
	{
		$page=1;
	}
	else
	{
		$page=$_REQUEST['page'];
	}
	$limit = 50;
	$offset = ($page - 1) * $limit;
?>

	<script language="javascript" src="../lib Calendar/calendar.js"></script>
    <script language="javascript" src="../lib Calendar/datetimepicker.js"></script>
    <script src="../js/JS-GlobalFunction.js" type="text/javascript"></script>
    <script src="../js/JS-GlobalFunction1.js" type="text/javascript"></script>
    <script type="text/javascript">
        function ajaxRequest(){
		 var activexmodes=["Msxml2.XMLHTTP", "Microsoft.XMLHTTP"] //activeX versions to check for in IE
		 if (window.ActiveXObject){ //Test for support for ActiveXObject in IE first (as XMLHttpRequest in IE7 is broken)
		  for (var i=0; i<activexmodes.length; i++){
		   try{
			return new ActiveXObject(activexmodes[i])
		   }
		   catch(e){
			//suppress error
		   }
		  }
		 }
		 else if (window.XMLHttpRequest) // if Mozilla, Safari etc
		  return new XMLHttpRequest()
		 else
		  return false
		}
		
		
		var searchTimer = null;
		function onSearchNoKeyUp() {
			clearTimeout(searchTimer);
			searchTimer = setTimeout(function() {
				clickView();
			}, 1500);
		}

		function clickView()
		{
			var searchParam = document.getElementById("txtSearchNo") ? document.getElementById("txtSearchNo").value : "";
			window.location="DaftarSPB.php?supplier="+document.getElementById("lstSupplier").value+"&tanggal="+document.getElementById("txtTgl").value+"&tanggal2="+document.getElementById("txtTgl2").value+"&site="+document.getElementById("lstSite").value+"&searchNo="+searchParam;
		}
		
		function clickPONumber(PONumber)
		{
			var printPO= window.open('printPO.php?nomor_po='+PONumber,'printPO','menubar=no,status=no,scrollbars=yes,top=100%,left=100');
		}
		
		function clickDetail(PONumber)
		{
			window.location="printSPB.php?nomor_spb="+PONumber;
		}
		
		function clickPrint(PONumber)
		{
			var cetakSPB= window.open('printSPB.php?nomor_spb='+PONumber+'&mode=print','cetakSPB','menubar=no,status=no,scrollbars=yes,top=100%,left=100');
		}
		
		function clickCancelledPO()
		{
			var popy= window.open('formCancelledPO.php','popup_form','menubar=no,status=no,top=100%,left=100');
		}
		
		function clickReportSelected()
		{
			var frm = document.forms[0];
            var selectedSPB = JSON.parse(sessionStorage.getItem('selectedSPB')) || [];
            if(selectedSPB.length < 2) {
                alert("Minimal 2 data harus dipilih.");
                return;
            }
            
            var btnReport = document.getElementById("btnViewReport");
            if (btnReport) {
                btnReport.disabled = true;
                btnReport.style.cursor = "wait";
                var dots = 0;
                setInterval(function() {
                    dots = (dots + 1) % 4;
                    var text = "⏳ Loading";
                    for(var j=0; j<dots; j++) text += ".";
                    btnReport.value = text;
                }, 400);
            }
            document.body.style.cursor = "wait";

            $("input[name='chkRow[]']").prop('disabled', true);
            $.each(selectedSPB, function(i, val) {
                $('<input>').attr({ type: 'hidden', name: 'chkRow[]', value: val }).appendTo(frm);
            });
			frm.action = "printBulkSPB.php";
			frm.method = "POST";
			frm.target = "_self";
			frm.submit();
		}
		
		$(document).ready(function () {
            var txtSearchNo = document.getElementById('txtSearchNo');
            if(txtSearchNo && txtSearchNo.value !== '') {
                txtSearchNo.focus();
                var val = txtSearchNo.value;
                txtSearchNo.value = '';
                txtSearchNo.value = val;
            }
            <?php if(!isset($_REQUEST['supplier']) && !isset($_REQUEST['page']) && !isset($_REQUEST['searchNo'])) { ?>
                sessionStorage.removeItem('selectedSPB');
            <?php } ?>
            var selectedSPB = JSON.parse(sessionStorage.getItem('selectedSPB')) || [];

			function updateReportButton() {
				var checkedCount = selectedSPB.length;
				if (checkedCount >= 2 && checkedCount <= 30) {
					$("#btnViewReport").val("View Report Selected (" + checkedCount + ")");
					$("#btnViewReport").show();
				} else {
					$("#btnViewReport").hide();
				}
			}
            
            function updateCheckboxState() {
                $("input[name='chkRow[]']").each(function() {
                    if (selectedSPB.indexOf(this.value) !== -1) {
                        $(this).prop('checked', true);
                    }
                });
                updateReportButton();
            }

			$("#chkAll").click(function () {
                var isChecked = this.checked;
				$("input[name='chkRow[]']").each(function () {
                    $(this).prop('checked', isChecked);
                    var val = this.value;
                    if (isChecked) {
                        if (selectedSPB.indexOf(val) === -1) selectedSPB.push(val);
                    } else {
                        var index = selectedSPB.indexOf(val);
                        if (index !== -1) selectedSPB.splice(index, 1);
                    }
                });
                
                if (selectedSPB.length > 30) {
                    alert("Maksimal 30 data yang dapat dipilih!");
                    // Tidak membatalkan centang all agar tidak rumit, tapi validasi saat submit akan mencegah > 30
                }
                sessionStorage.setItem('selectedSPB', JSON.stringify(selectedSPB));
				updateReportButton();
			});
			
			$("input[name='chkRow[]']").change(function () {
                var val = this.value;
                if (this.checked) {
                    if (selectedSPB.indexOf(val) === -1) selectedSPB.push(val);
                } else {
                    var index = selectedSPB.indexOf(val);
                    if (index !== -1) selectedSPB.splice(index, 1);
                }
                
                if (selectedSPB.length > 30) {
                    alert("Maksimal 30 data yang dapat dipilih!");
                    $(this).prop('checked', false);
                    selectedSPB.pop();
                }
                sessionStorage.setItem('selectedSPB', JSON.stringify(selectedSPB));
				updateReportButton();
			});
			
            updateCheckboxState();
			
			//document.getElementById("txtKodeBarang").focus();
            /*setupTinyMCE();
            setupProgressbar('progress-bar');
            setDatePicker('date-picker');
            setupDialogBox('dialog', 'opener');
            $('input[type="checkbox"]').fancybutton();
            $('input[type="radio"]').fancybutton();*/
        });
    </script>
    <!-- /TinyMCE -->
    <style type="text/css">
        #progress-bar
        {
            width: 400px;
        }
    </style>
    <div class="box round first fullpage" style="padding:20px;">
        <h2>
            Daftar SPB
        </h2>
        <div class="block ">
            <form>
                <table class="form">
                    <tr>
                        <td style="width:5%;" class="col1">
                            <label>
                                Site
                            </label>
                        </td>
                        <td class="col2">
                            <!--<select name="lstSupplier" id="lstSupplier" <? if($_SESSION['restricted_nuansa1']!="%"){?> disabled="disabled"<? }?>>-->
                            <select name="lstSite" id="lstSite">
                            <?
                            //if($_SESSION['restricted_nuansa1']=="%"){
							?>
                            	<option <? if($supplier=="%"){?> selected="selected"<? }?> value="%">All</option>
                            <?
                            //}
							?>
                           	<?
                            $query_getSite="select distinct LOCNCODE from POSPO007";
							$res_getSite = mysql_query($query_getSite);
							//echo $query_getDetail;
							while($row_getSite=mysql_fetch_array($res_getSite))
							{
							?>
                                <option <? if($site==$row_getSite['LOCNCODE']){?> selected="selected"<? }?> value="<? echo $row_getSite['LOCNCODE'];?>"><? echo $row_getSite['LOCNCODE'];?></option>
                            <?
							}
							?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:5%;" class="col1">
                            <label>
                                Supplier
                            </label>
                        </td>
                        <td class="col2">
                            <select name="lstSupplier" id="lstSupplier" <? if($_SESSION['restricted_nuansa1']!="%"){?> disabled="disabled"<? }?>>
                            <?
                            if($_SESSION['restricted_nuansa1']=="%")
							{
							?>
                            	<option <? if($supplier=="%"){?> selected="selected"<? }?> value="%">All</option>
                            <?
                            }
							?>
                           	<?
                            $query_getSupplier="select * from MS_VENDOR order by VENDNAME";
							$res_getSupplier = mysql_query($query_getSupplier);
							//echo $query_getDetail;
							while($row_getSupplier=mysql_fetch_array($res_getSupplier))
							{
							?>
                                <option <? if($supplier==$row_getSupplier['VENDORID']){?> selected="selected"<? }?> value="<? echo $row_getSupplier['VENDORID'];?>"><? echo $row_getSupplier['VENDNAME'];?></option>
                            <?
							}
							?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:5%;" class="col1">
                            <label>
                                Tanggal (d-m-y)
                            </label>
                        </td>
                        <td class="col2">
                            <input id="txtTgl" type="text" size="20" name="txtTgl" value="<? echo $date;?>" readonly="readOnly"><a onclick="callCalendarDMY('txtTgl');" style="display:nones; cursor:pointer;" ><img width="16" height="16" border="0" alt="Pick a date" src="../lib Calendar/cal.gif"></a>
                             - 
                            <input id="txtTgl2" type="text" size="20" name="txtTgl2" value="<? echo $date2;?>" readonly="readOnly"><a onclick="callCalendarDMY('txtTgl2');" style="display:nones; cursor:pointer;" ><img width="16" height="16" border="0" alt="Pick a date" src="../lib Calendar/cal.gif"></a>
                        </td>
                    </tr>
                    <tr>
                        <td class="col1"></td>
                        <td class="col2" style="padding-top: 10px;">
                            <input type="button" value="Search" name="btnView" id="btnView" onclick="clickView();">
                            <input type="button" value="View Report Selected (0)" name="btnViewReport" id="btnViewReport" style="display:none;" onclick="clickReportSelected();">
                        </td>
                    </tr>
                </table>
                <?php
                $filter_search = "";
                if($searchNo != "") {
                    $filter_search = " AND a.POPRCTNM like '%".mysql_real_escape_string($searchNo)."' ";
                }
                $query_count="select count(*) as total from POSPO007 a
                                where	a.LOCNCODE like '".$site."'
                                AND		a.VENDORID like '".$supplier."'
                                AND		(a.DocDate between '".$tanggal."' and '".$tanggal2."')
                                $filter_search
                ";
                $res_count = mysql_query($query_count);
                $row_count = mysql_fetch_array($res_count);
                $total_records = $row_count['total'];
                $total_pages = ceil($total_records / $limit);
                if ($total_pages == 0) $total_pages = 1;
                ?>
                
                <?php if ($total_records > 0 || $searchNo != "") { ?>
                <div style="text-align: right; margin-bottom: 5px;">
                    <label style="font-weight:bold;">Search No SPB : </label>
                    <input type="text" id="txtSearchNo" name="txtSearchNo" maxlength="5" style="width: 120px; padding: 2px;" placeholder="5 Digit Akhir" value="<?php echo htmlspecialchars($searchNo); ?>" onkeyup="onSearchNoKeyUp();">
                </div>
                <?php } ?>
                
                <div style="overflow:auto;">
                <?php
                if ($total_records == 0) {
                    $bulan_indo = array(1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
                    $tgl1 = date('d', strtotime($tanggal)) . ' ' . $bulan_indo[(int)date('m', strtotime($tanggal))] . ' ' . date('Y', strtotime($tanggal));
                    $tgl2 = date('d', strtotime($tanggal2)) . ' ' . $bulan_indo[(int)date('m', strtotime($tanggal2))] . ' ' . date('Y', strtotime($tanggal2));
                    echo "<div style='text-align:center; padding:40px; font-weight:bold; font-size:16px;'>Data tidak ditemukan pada tanggal $tgl1 - $tgl2</div>";
                } else {
                ?>
                <table class="myTable" style="width:100%;">
                    <thead height="23" style="background-color:#2E5E79; color:#FFF;">
                        <tr>
                            <th style="width:3%;">
                                <input type="checkbox" id="chkAll" />
                            </th>
                            <th style="width:3%;">
                                No.
                            </th>
                            <th style="width:7%;">
                                Tgl PB
                            </th>
                            <th style="width:10%;">
                                No PB
                            </th>
                            <th style="width:7%;">
                                Gudang
                            </th>
                            <th style="width:20%;">
                                Supplier
                            </th>
                            <th style="width:10%;">
                                No SJ Supplier
                            </th>
                            <th style="width:7%;">
                                Tgl SJ Supplier
                            </th>
                            <th style="width:5%;">
                                
                            </th>
                        </tr>
                    </thead>
                    <tbody id="DetailBarang">
                    <?
					$no=$offset;
                    $query_getDetail="select * from POSPO007 a
									where	a.LOCNCODE like '".$site."'
									AND		a.VENDORID like '".$supplier."'
									AND		(a.DocDate between '".$tanggal."' and '".$tanggal2."')
                                    $filter_search
									Order By DOCDATE desc
									LIMIT $offset, $limit
					";
					$res_getDetail = mysql_query($query_getDetail);
					//echo $query_getDetail;
					while($row_getDetail=mysql_fetch_array($res_getDetail))
					{
						$no+=1;
					?>
                        <tr style="text-align:center;">
                        	<td>
                            	<input type="checkbox" name="chkRow[]" value="<? echo $row_getDetail['POPRCTNM'];?>" />
                            </td>
                        	<td>
                            	<? echo $no;?>
                            </td>
                        	<td>
                            	<? echo date('d-M-Y', strtotime($row_getDetail['DOCDATE']));?>
                            </td>
                        	<td>
								<? echo $row_getDetail['POPRCTNM'];?>
                            </td>
                        	<td>
                            	<? echo $row_getDetail['LOCNCODE'];?>
                            </td>
                        	<td>
                            	<? echo $row_getDetail['VENDNAME'];?>
                            </td>
                        	<td>
                            	<? echo $row_getDetail['VNDDOCNM'];?>
                            </td>
                        	<td>
                            	<? echo date('d-M-Y', strtotime($row_getDetail['Vendor_Document_Date']));?>
                            </td>
                        	<td>
                            	<a style="cursor:pointer;" onclick="clickDetail('<? echo trim($row_getDetail['POPRCTNM']);?>');">Detail</a>
                                ||
                                <a style="cursor:pointer;" onclick="clickPrint('<? echo trim($row_getDetail['POPRCTNM']);?>');">Print</a>
                            </td>
                        </tr>
                    <?
					}
					?>
                    </tbody>
                </table>
                <?php } ?>
                </div>
                <?php if ($total_records > 0) { ?>
                <div style="margin-top: 10px; text-align: right; padding-right: 20px;">
                    <?php
                    $queryString = "&supplier=".urlencode($supplier)."&tanggal=$date&tanggal2=$date2&site=".urlencode($site);
                    echo "Total Data: $total_records | Page $page of $total_pages &nbsp;&nbsp;&nbsp;";
                    if($page > 1) {
                        echo "<a href='DaftarSPB.php?page=1".$queryString."' style='text-decoration:none;'>&laquo; First</a> | ";
                        echo "<a href='DaftarSPB.php?page=".($page-1).$queryString."' style='text-decoration:none;'>&lsaquo; Prev</a> | ";
                    }
                    if($page < $total_pages) {
                        echo "<a href='DaftarSPB.php?page=".($page+1).$queryString."' style='text-decoration:none;'>Next &rsaquo;</a> | ";
                        echo "<a href='DaftarSPB.php?page=".$total_pages.$queryString."' style='text-decoration:none;'>Last &raquo;</a>";
                    }
                    ?>
                </div>
                <?php } ?>
            </form>
        </div>
    </div>