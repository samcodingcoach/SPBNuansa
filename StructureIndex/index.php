<?
session_start();
	include("../Connection/connect.php");
	
	if(!isset($_REQUEST['err']))
	{
		$err="";
	}
	else
	{
		$err=$_REQUEST['err'];
	}
	
	//include("../StructureIndex/validateSession.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<? include('../StructureIndex/head-library.php');?>

<script src="../js/jquery.form.js"></script>

<script type="text/javascript">
	$(document).ready(function () {
		setupTinyMCE();
		setupProgressbar('progress-bar');
		setDatePicker('date-picker');
		setupDialogBox('dialog', 'opener');
		//$('input[type="checkbox"]').fancybutton();
		//$('input[type="radio"]').fancybutton();
		var txtUsername = document.getElementById("txtUsername");
		if(txtUsername) {
			txtUsername.focus();
		}
	});
</script>
<!-- /TinyMCE -->

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
	
	function doLogin()
	{
		function showResponse(responseText, statusText, xhr, $form)  { 
			if(responseText.trim()=="OK!")
			{
				//alert(responseText.trim());
				window.location="../StructureIndex/index.php";
			}
			else
			{
				alert(responseText.trim());
			}
			//alert('status: ' + statusText + '\n\nresponseText: \n' + responseText + '\n\nThe output div should have already been updated with the responseText.'); 
		} 
		var options = { 
			//target:        '#divMessage',   // target element(s) to be updated with server response 
			//beforeSubmit:  showRequest,  // pre-submit callback 
			success:       showResponse,  // post-submit callback 
	 
			// other available options: 
			url:       '../Connection/doLogin.php'         // override for form's 'action' attribute 
			//type:      type        // 'get' or 'post', override for form's 'method' attribute 
			//dataType:  null        // 'xml', 'script', or 'json' (expected server response type) 
			//clearForm: true        // clear all form fields after successful submit 
			//resetForm: true        // reset the form after successful submit 
	 
			// $.ajax options can be used here too, for example: 
			//timeout:   3000 
		}; 
		$('#frmLogin').ajaxSubmit(options); 
		
		/*
		if(document.getElementById("txtUsername").value=="")
		{
			alert("Silahkan Masukkan Username");
			document.getElementById("txtUsername").focus();
		}
		else if(document.getElementById("txtPassword").value=="")
		{
			alert("Silahkan Masukkan Password");
			document.getElementById("txtPassword").focus();
		}
		else
		{
			document.forms['frmLogin'].action = "../Connection/doLogin.php";
			document.forms['frmLogin'].submit();
		}
		*/
	}
	
	function pressUsername(e)
	{
		if(e==13)
		{
			doLogin();
		}
	}
	
</script>

<style type="text/css">
	#progress-bar
	{
		width: 400px;
	}
</style>
</head>

<body>
    <div class="container_12">
    	<div class="grid_12 header-repeat">
        	<? include('../StructureIndex/header.php');?>
        </div>
        <div class="clear">
        </div>
        <div class="grid_12">
		<?
        if(isset($_SESSION['username_nuansa1']))
        {
        	include('../StructureIndex/header-menu.php');
        }
        ?>
        </div>
        <div class="clear">
        </div>
        <!--<div class="grid_12">-->
        <div class="grid_12 gridContent">  <!--hyroki add line-->
            <?
			if(!isset($_SESSION['username_nuansa1']))
			{
			?>
            <div class="box round first fullpage" style="padding:20px;">
                <div style="width:40%;">
                <h2>
                    LOGIN
                </h2>
                <div class="block ">
                    <form name="frmLogin" id="frmLogin" method="post">
                        <table class="form">
                            <tr>
                                <td>
                                    <label>
                                        Username
                                    </label>
                                </td>
                                <td>
                                    <input type="text" id="txtUsername" name="txtUsername" class="error" onkeypress="pressUsername(event.keyCode)" />
                                    <span class="error">This is a required field.</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>
                                        Password
                                    </label>
                                </td>
                                <td>
                                    <input type="password" id="txtPassword" name="txtPassword" onkeypress="pressUsername(event.keyCode)" class="error" />
                                    <span class="error">This is a required field.</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="button" name="btnLogin" id="btnLogin" value="LOGIN" onclick="doLogin();" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-size:12px; font-weight:bold; text-align:center; color:#F00;">
                                    <? echo $err;?>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                </div>
            </div>
            <?
			}
			else
			{
			?>
            <iframe id="iframeContent" src="contentIndex.php" width="100%" height="500">WELCOME!!!</iframe>
            <?
			}
			?>
        </div>
        <div class="clear">
        </div>
    </div>
    <div class="clear">
    </div>
    <div id="site_info">
        <? include('../StructureIndex/footer.php');?>
    </div>
    
    <!--tambahan yy-->
    <!--div style="margin : 10px;">
        <p style="font-size:14px; font-weight:bold;"> Yth Vendor / Supplier, minta diisikan email Perusahaan pada gform (melengkapi data kami), untuk nantinya Nuansa mengirimkan PO sebagai pengganti web PO ini. </p>             
    </div>
    
    <div style="margin : 10px;">
        <a style="font-size:16px; font-weight:bold; color:blue;" href="https://forms.gle/RZoHs3w6PZgpLKJa8" target="_blank">
          (Klik) Tampilkan Google Form ...
        </a>    
    </div-->
    <!--eof tambahan yy-->
   
</body>
</html>
