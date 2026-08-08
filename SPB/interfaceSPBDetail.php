<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<? 
	date_default_timezone_set('Etc/GMT+0');
	include('../StructureIndex/head-library.php');
?>
<script src="../js/jquery.form.js"></script>
<script>
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
	
	function clickSync()
	{
		
			function showResponse(responseText, statusText, xhr, $form)  { 
				/*if(responseText.trim()=="OK!")
				{
					alert("OK!");
					//window.location="../StructureIndex/index.php";
				}
				else
				{
					alert("Error!");
				}*/
				//alert('status: ' + statusText + '\n\nresponseText: \n' + responseText + '\n\nThe output div should have already been updated with the responseText.'); 
			} 
			var options = { 
				//target:        '#divMessage',   // target element(s) to be updated with server response 
				//beforeSubmit:  showRequest,  // pre-submit callback 
				success:       showResponse,  // post-submit callback 
		 
				// other available options: 
				url:       'http://nuansaelektronik.com/Nuansa1/SPB/insertSPBDetail.php'        // override for form's 'action' attribute 
				//url:       'insertPODetail - 2.php?id='+a        // override for form's 'action' attribute 
				//type:      type        // 'get' or 'post', override for form's 'method' attribute 
				//dataType:  null        // 'xml', 'script', or 'json' (expected server response type) 
				//clearForm: true        // clear all form fields after successful submit 
				//resetForm: true        // reset the form after successful submit 
		 
				// $.ajax options can be used here too, for example: 
				//timeout:   3000 
			}; 
			$('#frmSyncPOHeader').ajaxSubmit(options); 
		
		
	}
	
	function getContent()
	{
		function showResponse(responseText, statusText, xhr, $form)  { 
			//document.getElementById("divContent").innerHTML=responseText.trim();
			var explode=responseText.trim().split('|');
			document.getElementById("txtQuery").value=explode[1];
			document.getElementById("txtTotalRow").value=explode[0];
			//document.getElementById("divContent").innerHTML=responseText.trim();
			//alert(responseText.trim());
			//document.getElementById("divQuery").innerHTML=responseText.trim();
			
			var query=explode[1];
			var total_row=explode[0];
			
			var loop=Math.ceil(total_row/100);
			
			var query_explode=query.split('^');
			
			$(document.getElementById("divQuery")).append("<input type='text' name='txtTotalQuery' id='txtTotalQuery' value='"+loop+"' />");
			for(var a=1;a<=loop;a++)
			{
				$(document.getElementById("divQuery")).append("<input type='text' name='txtQuery"+a+"' id='txtQuery"+a+"' />");
			}
			
			for(var a=1;a<=loop-1;a++)
			{
				var temp="";
				for(var b=(a-1)*100;b<a*100;b++)
				{
					temp+=query_explode[b];
				}
				if(a!=1)
				{
					document.getElementById("txtQuery"+a).value=temp.substring(1).trim()+"#";
				}
				else
				{
					document.getElementById("txtQuery"+a).value=temp.trim()+"#";
				}
				//$(document.getElementById("divQuery")).append("<input type='text' name='txtQuery"+a+"' id='txtQuery"+a+"' value='"+temp+"' />");
				//alert(temp);
				//echo "<input type='text' name='txtQuery".$a."' id='txtQuery".$a."' value='".$temp."' />";
			}
			
			temp="";
			for(var b=(loop-1)*100;b<total_row;b++)
			{
				temp+=query_explode[b];
			}
			document.getElementById("txtQuery"+loop).value=temp.substring(1).trim()+"#";
			//echo "<input type='text' name='txtQuery".$loop."' id='txtQuery".$loop."' value='".$temp."' />";
			
			
			clickSync();
			//alert('status: ' + statusText + '\n\nresponseText: \n' + responseText + '\n\nThe output div should have already been updated with the responseText.'); 
		} 
		var options = { 
			//target:        '#divMessage',   // target element(s) to be updated with server response 
			//beforeSubmit:  showRequest,  // pre-submit callback 
			success:       showResponse,  // post-submit callback 
	 
			// other available options: 
			url:       'syncSPBDetail.php'         // override for form's 'action' attribute 
			//type:      type        // 'get' or 'post', override for form's 'method' attribute 
			//dataType:  null        // 'xml', 'script', or 'json' (expected server response type) 
			//clearForm: true        // clear all form fields after successful submit 
			//resetForm: true        // reset the form after successful submit 
	 
			// $.ajax options can be used here too, for example: 
			//timeout:   3000 
		}; 
		$('#frmSyncPOHeader').ajaxSubmit(options); 
		
	}
	
	$(document).ready(function () {
		getContent();
		
		//getDateSync();
	});
	
</script>
<body>
<form name="frmSyncPOHeader" id="frmSyncPOHeader" method="post" enctype="multipart/form-data">
	<div id="divContent" style="display:nones;">
	<? 
		if(file_get_contents("http://nuansaelektronik.com/Nuansa1/SPB/readDateSync.php?file=SPBDetail"))
		{
			$a = file_get_contents("http://nuansaelektronik.com/Nuansa1/SPB/readDateSync.php?file=SPBDetail");
			
			//echo ($a);
		}
		else
		{
			$a="2013-09-01";
		}
	?>
    </div>
    <div id="divQuery" style="display:nones;">
	<? 
		
	?>
    </div>
    <input type='text' name='txtQuery' id='txtQuery' value="" />
    <input type='text' name='txtTotalRow' id='txtTotalRow' value="" />
    <input type='text' name='txtDate' id='txtDate' value="<? echo $a;?>" />
    <!--<input type='text' name='txtDateNow' id='txtDateNow' value="<? echo date("Y-m-d H:i:s");?>" />-->
	<!--<input type='text' name='txtDateNow' id='txtDateNow' value="<? echo date("Y-m-d H:i:s", mktime(date("H")-15,date("i"),date("s"),date("m"),date("d"),date("Y")));?>" />-->
    <input type='text' name='txtDateSyncLast' id='txtDateSyncLast' value="<? echo date("Y-m-d H:i:s", mktime(date("H"),date("i")-10,date("s"),date("m"),date("d"),date("Y")));?>" />
    <!--<input type='text' name='txtDateNow' id='txtDateNow' value="<? echo date("Y-m-d H:i:s");?>" />-->
    <input type='text' name='txtDateNow' id='txtDateNow' value="<? echo date("Y-m-d");?>" />
    <input type="button" value="Sync" id="btnSync" name="btnSync" onclick="clickSync();" />
</form>
</body>
</html>