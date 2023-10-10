<!DOCTYPE html>
<html class="no-js"	> 
<head>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"> </script>
	
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
	
    
    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


    <!-- Footable CSS-->
    <link rel="stylesheet" href="FooTable-3/compiled/footable.bootstrap.min.css">
    <link rel="stylesheet" href="FooTable-3/compiled/footable.bootstrap.css">

    <link rel="stylesheet" href="FooTable-3/compiled/footable.sorting.css">
    <link rel="stylesheet" href="FooTable-3/compiled/footable.filtering.css">

    <!-- Footable JS -->
    <script src="FooTable-3/compiled/footable.min.js"></script>
   
  
 
 <link rel="icon" href="softflow-logo.png">
 <link rel="stylesheet" href="../style.css">

	<title>Auto Generator</title>
	
	<script type="text/javascript">
   jQuery(function($){
	   $('.table').footable();
   });

		function date_time(id)
		{
		        date = new Date;
		        year = date.getFullYear();
		        month = date.getMonth();
		        months = new Array('January', 'February', 'March', 'April', 'May', 'June', 'Jully', 'August', 'September', 'October', 'November', 'December');
		        d = date.getDate();
		        day = date.getDay();
		        days = new Array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
		        h = date.getHours();
		        if(h<10)
		        {
		                h = "0"+h;
		        }
		        m = date.getMinutes();
		        if(m<10)
		        {
		                m = "0"+m;
		        }
		        s = date.getSeconds();
		        if(s<10)
		        {
		                s = "0"+s;
		        }
		        result = ''+days[day]+' '+months[month]+' '+d+' '+year+' '+h+':'+m+':'+s;
		        document.getElementById(id).innerHTML = result;
		        setTimeout('date_time("'+id+'");','1000');
		        return true;
		}

function xenable_disable_loader(xrun) {
                 var xloadingdiv = document.getElementById('loadingdiv');

                 if (xrun == 1) {
                     xloadingdiv.style.display = "block";
                 }
                 else {
                     xloadingdiv.style.display = "none";
                 }
             }

	</script>


<style>
.input-group-btn:last-child>.btn, .input-group-btn:last-child>.btn-group 
{
    z-index: 2;
    margin: 10px 0 0 0px;
}

.dropdown-toggle::after {
    display: none;
   
}

.pagination
{
	border:none;
}

.form-group.required .control-label:after 
{
content:"*" ;
color:red;
margin-left: 4px;
}
</style>

</head>

<body style="margin:0 0; padding:0 0;background-color:#E9EFF1">

	

<?php

		//http://localhost/conn_grid.php?coid=0001&conm=COMPANY%20NAME&yr=18&userid=0&server=JARVIS\SQLEXPRESS&db=trans&user=sallu&pwd=dbamvt48&mnno=5001&fval=&ffill=&fid=&cfg=&uptb_nm=misc_purc&upfil_nm=qty&upft_nm=uid&upft_val=11&cnm=&cnnid=

		$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		#print_r($actual_link);

		$xcoid = $_GET["coid"];
		$xconm = $_GET["conm"];
		$xyear = $_GET["yr"];
		$xuserid = $_GET["userid"];
		$xserver = $_GET["server"];
		$ser = explode('\\',$xserver); 
		$actual = $ser[0].'\\\\'.$ser[1];
		$xdatabase = $_GET["db"];
		$xuser = $_GET["user"];
		$xpassword = $_GET["pwd"];
		$xmenu_no = $_GET["mnno"];
		$continue_entry;
		$uptb_nm ;
		$upfil_nm;
		$upft_nm;
		$upft_val;
		$val;
		$user_nm;
		$save_updatequery = null;
		$fillf	;
		$vchno;
		$vchnm;
		#echo $_GET['uptb_nm'];

		if($_GET['cnm']){
			$xserver = $_GET['cnm'];
			$xserver .= '\\';
			$xserver .= $_GET['server'];
		}
		if($_GET['cfg']){
			$continue_entry = $_GET['cfg'];
		}
		if($_GET["uptb_nm"]){
			$uptb_nm = $_GET['uptb_nm'];
			$upfil_nm = $_GET['upfil_nm'];
			$upft_nm = $_GET['upft_nm'];
			$upft_val = $_GET['upft_val'];

			$uptb_nm = filenameConversion($uptb_nm);

						$save_updatequery = "update ".$uptb_nm." set [".$upfil_nm."] = '1' where ".$upft_nm." = ".$upft_val;
			#echo $save_updatequery;
		}



		if($_GET["ffill"]){	
			$fillfg = 1;
			$xfield_value = $_GET["fval"];
			$xfield_value = explode(",",$xfield_value);
			$count = count($xfield_value);
			$xfield_fill = $_GET["ffill"]; 
			$xfield_fill = explode(",", $xfield_fill);

			for($i=0 ; $i<$count; $i++){
				for($j=$i; $j>=0; $j++){
					$val[$xfield_fill[$i]] = $xfield_value[$j];
					break;
				}
			}
			#print_r($val);
		}


		
		/*$xcoid = '0001';
		$xconm = 'COMPANY NAME';
		$xyear = '19';
		$xuserid = '1';
		$xserver = 'JARVIS\SQLEXPRESS01';
		$xdatabase = 'alldata';
		$xuser = 'sallu';
		$xpassword = 'dbamvt48';
		$xmenu_no = '5003'; 
		$xfield_fill = 'party_nm';
		$xfield_value = "250";*/
		$connection;
		$number_fields;
		$xfetch_id;
		$update_flag;
		$isForm;

			#--------------- Connection query ------------#

			$connection = odbc_connect("Driver={SQL Server};Server=$xserver;Database=$xdatabase;", $xuser, $xpassword);
			if($connection){
				#echo "established";

				if($_GET["fid"]){
					$xfetch_id = $_GET["fid"];
					$update_flag =1;
					viewForm();
				}
				else{
					fetchData();
				}
			}

			#------------  function to perform all the data operations and form generation ---------- #

			function fetchData()
			{
				
				#--------- declaring globals to use in the function -------#

				global $xcoid;
				global $connection;
				global $xmenu_no;
				global $xuid;
				global $xmnu_nm;
				global $xfile_nm;
				global $xfield_fill;
				global $xfield_value;
				global $xyear;
				global $val;
				global $fillfg;
				global $user_nm;
				global $count;


				#----------  fetching data from entry_mst ------------------#

				$sql = "select * from entry_mst where mnu_no = ".$xmenu_no;
				$result = odbc_exec($connection, $sql);
				#print_r($sql);
				$a = odbc_fetch_array($result);
				#echo($a['fil_nm']);

				if($a['fil_nm']){
				$a['fil_nm']= filenameConversion($a['fil_nm']);
				$sql = "select * from ".$a['fil_nm'];
				}
				else{
				$sql = "select ".$a['query'] ;
				}
				#echo($sql);
				$result_2 = odbc_exec( $connection,$sql);	


				if($_GET["cnnid"]){
					$_GET['cnnid'] = strtoupper($_GET['cnnid']);
					$lastsql = "select max(vch_no)+1 from ".$a['fil_nm']." where vch_no1 = '".$_GET['cnnid']."'";
					#print_r($lastsql);
					$latestval = odbc_exec( $connection,$lastsql);
					$latestval = odbc_fetch_array($latestval);
					$latestval = array_values($latestval)[0];
				}

				//$b = odbc_fetch_array($result_2);
			//	print_r($b);


				#print_r($a);
				
				#----------- Fetching important data from the entry_mst and saving them in variables -----#

				$xuid = $a['uid'];
				$xmnu_nm = $a['mnu_nm'];
				$xfile_nm = $a['fil_nm'];
				$isForm = $a['isform']; 
				$isreport = $a['isreport'] ;	


				#------------ Fetching username from user_mst using userid provided in userid field -------------#
				global $xuserid;
				#print_r($xuserid);
				$user_sql = "select usr_nm from usr_mast where id = ".$xuserid;
				#error_reporting(0);
				$usr_r = @odbc_exec( $connection, $user_sql);
				if($usr_r){
					$user_nm = odbc_fetch_array($usr_r);
				}



				#----------- Conversion of fil_nm into the desired file name by replacing #fil and #yr -------#

				$xfile_nm = filenameConversion($xfile_nm);

				
				#echo $xfield_fill;
				#echo $xfile_nm;

				#------------ fetching data from field_mst to create the form using uid of entry_mst---------#
				
				$sql = "select * from field_mst where entry_uid =".$xuid." order by fldno";
				$result = odbc_exec( $connection, $sql);
				$number_fields = odbc_num_rows($result);

				$sql = "select * from field_mst where entry_uid =".$xuid." order by fldno";
				$xvar = odbc_exec( $connection, $sql);
				


	?>

<div class="header1 " style="background:#009688; position:static;top:0;height:3em;	" >

			<div class="row" style="width:100%; display:block; ">
			 	<div style="padding: 0.4em 0 0 2em; font-weight:bold;font-family: 'Roboto',sans-serif;position:absolute; ">
				<?php global $xconm; echo $xconm; ?>  	
				</div>
				
				<div id="date_time" style="padding:2.5em 0 0 0 ;float: right;font-weight:bold;font-family: 'Roboto',sans-serif;font-size:0.7em;" >
				</div>
				     <span id="username">
					 <?php echo $user_nm['usr_nm']; ?>
					</span>

					 
					<script type="text/javascript">window.onload = date_time('date_time');</script>
					 
				 
			</div>
		</div>

<div class="container-fluid">

<div id="loadingdiv" style="  width: 100%; height: 100%;top: 0;left: 0;position: fixed;display: flex;background-color: rgba(255,255,255,0.7) ;z-index: 99;text-align: center;">
                    <div style="z-index: 100;display:flex;justify-content:center;align-items:center;margin-top:18em">
                        <div><img src="806.gif"></div>
                    </div>
                </div>

<script>
xenable_disable_loader(1);
</script>





	<div style="color: #565555; font-family:sans-serif;font-size:1.3em;margin: 14px 0 0 0; font-weight:bold;font-family: 'Roboto',sans-serif;">	<?php global $xmnu_nm; echo $xmnu_nm; ?> </div>
</div>

		<div class="container-fluid" style="margin-top:1em;box-shadow:5px 15px 20px 5px grey; padding:0 0;background-color: mintcream;width: 98%  ">


		<!--/*----------------------   header1 for the form  ----------------*/-->
		
	
	
			
				
		
	<?php

				#------------- Creating form -----------#
				date_default_timezone_set("Asia/Calcutta");
				$now = new DateTime();
				$now = $now->format('Y-m-d');    // MySQL datetime format
				#echo $now;
				echo "<form method ='post' class ='form-inline' id='myForm' action = '' enctype='multipart/form-data'>";
				echo "<div class='container-fluid' style=' margin: 0 0'>";
				$ac_fl = null;
				$ac_val = null;
				echo "<div class='row' style='padding: 0 0em 0 0em;margin-top:14px;width:100%;'>";
				
				if($isForm)
				{	

				while($a = odbc_fetch_array($result)){
					#print_r($a);
					if($fillfg){
						foreach ($val as $key => $value) {
							if($key == $a['fld_nm']){
									$ac_val = $value;
								$ac_fl = $key;
							}
						}
					}
					
					$acv = $a['isnline'];

					if($a['isreq']==TRUE)
					{
						$required = "required";
					}
					else{
						$required = NULL ;
					}
					

			/*		if($a['isnline']==1)
				{
					echo "</div>" ;
				}
			*/


					#echo $ac_val;
				/*	$cls1= "col-lg-12" ;
					$cls2= "col" ;
					$cls3 ="row" ;
					if($a['isnline'] == 1) 
					{ 
					$varo = $cls1 ; 
					$varo2 = $cls3;
					} 
					else 
					{
						$varo = $cls2 ;
						$varo2  = NULL ;
					}
				*/
				
				//echo "<div class='".$varo." ". $varo2 ."' >" ;
				
				
									
				

				
				if($a['disp_typ'] == 4)
						{
								if($ac_fl == $a['fld_nm'])
								{								
									echo "<input style='margin-top:0;background: transparent; border:none;border-bottom: 1.5px solid #A9A9A9; display: none;'   name='".$a['fld_nm']."' id = '".$a['fld_nm']."' placeholder = '".$a['head_nm']."' value='".$ac_val."'>";				 
								
								}	
						}

					else
						{
							echo "<div class='col' >" ;
							
							echo "<div style='float:left; id ='input_label'> <label class='float-left' style=' font-family:arial;font-weight:bold;'for = '".$a['fld_nm']."''>".$a['head_nm'].":</label> </div> ";
							echo "<br><br><div id = 'input_field' style='col float:left;' >";
						
					# ----------------------- Direct Display ----------------------- #

						if($ac_fl == $a['fld_nm'] && $a['iscombo'] == 0 && $a['fld_type'] != 6 && $a['fld_type'] != 3){
							echo "<input class = 'col' style='margin-top:-1em;background: transparent; border:none;border-bottom: 1.5px solid #A9A9A9 ;' type='text' name='".$a['fld_nm']."' id = '".$a['fld_nm']."' placeholder = '".$a['head_nm']."' value='".$ac_val."' readonly>";
	
						}
	
						

					#------------- Numeric field ------------- #

	                						
							elseif($a['fld_type'] == 0){
								if($a['ischkbox'] == 1){
									echo "<input type='checkbox' id = '".$a['fld_nm']."' name='".$a['fld_nm']."' value='1'>";
								}
							elseif($a['iscombo'] == 1){

								$first4char = substr($a['combo_fil'], 0, 4); #this is for #fill
								$last3char = substr($a['combo_fil'], -3); #this is for #yr 

								if(strcmp($first4char,'#fil') == 0){
									if($last3char == '#yr'){
										$a['combo_fil'] = str_replace('#fil', 'z', $a['combo_fil']);
										$a['combo_fil'] = str_replace('#yr','',$a['combo_fil']);
										$a['combo_fil'] .= $xcoid;
										$a['combo_fil'] .= '_';
										$a['combo_fil'] .= $xyear;
									}
									else{
										$a['combo_fil'] = str_replace('#fil', 'z', $a['combo_fil']);
										$a['combo_fil'] .= '_';
										$a['combo_fil'] .= $xcoid;
									}
								}

								#echo $a['combo_fil'];
								$combofil_sql_where = '';
								if($a['combofiltfld'] != ''){
									$combofil_sql_where = " where ".$a['combofiltfld']."=".$a['combofiltval']." ";	
								}

								$combofil_sql = "select * from ".$a['combo_fil']." ".$combofil_sql_where." order by ".$a['combonm']." ";
								$defaultValue= '';
								$combo_result = odbc_exec( $connection, $combofil_sql);
								if($ac_fl == $a['fld_nm']){

									while($combofil_a = odbc_fetch_array($combo_result)){
										if($ac_val == $combofil_a[$a['comboid']]){
											
											$defaultValue = $combofil_a[$a['combonm']]." || ".$combofil_a[$a['comboid']];
												echo "<input class = 'col' list = '".$a['fldno']."' value = '".$defaultValue."' name='".$a['fld_nm']."' readonly>";
										}
									}


								}
								else{
									echo "<input class = 'col' style='margin-top:-1em;background: transparent; border:none;border-bottom: 1.5px solid #A9A9A9;'  list = '".$a['fldno']."'  name='".$a['fld_nm']."' ".$required.">";
								}	
								$combo_result = odbc_exec( $connection, $combofil_sql);	
								echo "<datalist id = '".$a['fldno']."''>";
								echo "<option> </option>";
								
								while($combofil_a = odbc_fetch_array($combo_result)){
									#print_r($combofil_a);
									echo "<option value='".$combofil_a[$a['combonm']]." || ".$combofil_a[$a['comboid']]."'>".$combofil_a[$a['combonm']]. "</option>";
								}
								echo "</datalist>";
	
							}elseif ($a['disp_typ'] == 1) {
								if($a['fld_nm'] == 'rate'){

									echo "<input class = 'col' style='margin-top:-1em;background: transparent; border:none;border-bottom: 1.5px solid #A9A9A9 ;' type='int' name='".$a['fld_nm']."' placeholder = '".$a['head_nm']."' id = '".$a['fld_nm']."' onkeypress='return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57' onchange = 'freight(this.value)'  ".$required." >";

								}
								elseif($a['fld_nm'] == 'rp_rt'){

									echo "<input class = 'col' style='margin-top:-1em;background: transparent; border:none;border-bottom: 1.5px solid #A9A9A9 ;' type='int' name='".$a['fld_nm']."' placeholder = '".$a['head_nm']."' id = '".$a['fld_nm']."' onkeypress='return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57' onchange = 'rpamount(this.value)'  ".$required." >";

								}
								elseif($a['fld_nm'] == 'handchgrt'){

									echo "<input class = 'col' style='margin-top:-1em;background: transparent; border:none;border-bottom: 1.5px solid #A9A9A9 ;' type='int' name='".$a['fld_nm']."' placeholder = '".$a['head_nm']."' id = '".$a['fld_nm']."' onkeypress='return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57' onchange = 'handchgamount(this.value)'  ".$required." >";

								}
								elseif($a['fld_nm'] == 'sur_per'){

									echo "<input class = 'col' style='margin-top:-1em;background: transparent; border:none;border-bottom: 1.5px solid #A9A9A9 ;' type='int' name='".$a['fld_nm']."' placeholder = '".$a['head_nm']."' id = '".$a['fld_nm']."' onkeypress='return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57' onchange = 'suramt(this.value)'  ".$required." >";

								}
								elseif($a['fld_nm'] == 'rafterrt'){

									echo "<input class = 'col' style='margin-top:-1em;background: transparent; border:none;border-bottom: 1.5px solid #A9A9A9 ;' type='int' name='".$a['fld_nm']."' placeholder = '".$a['head_nm']."' id = '".$a['fld_nm']."' onkeypress='return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57' onchange = 'rafteramount(this.value)'  ".$required." >";

								}
								elseif($a['fld_nm'] == 'gutkhart'){

									echo "<input class = 'col' style='margin-top:-1em;background: transparent; border:none;border-bottom: 1.5px solid #A9A9A9 ;' type='int' name='".$a['fld_nm']."' placeholder = '".$a['head_nm']."' id = '".$a['fld_nm']."' onkeypress='return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57' onchange = 'gutkhaamount(this.value)'  ".$required." >";

								}
								else{
									echo "<input class = 'col' style='margin-top:-1em;background: transparent; border:none;border-bottom: 1.5px solid #A9A9A9 ;' type='int' name='".$a['fld_nm']."' placeholder = '".$a['head_nm']."' id = '".$a['fld_nm']."' onkeypress='return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57' ".$required." >";
								}
							}elseif ($a['disp_typ'] == 3) {
								echo "<textarea class = 'col' style='margin-top:-1em;background: transparent; border:none;border-bottom: 1.5px solid #A9A9A9 ;' type='int' name='".$a['fld_nm']."' id = '".$a['fld_nm']."' style='height:15px' onkeypress='return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57' placeholder = ".$a['head_nm']. " ".$required." ></textarea>";	
							}
							
						}


							#-------------- String field -------------------#

							elseif ($a['fld_type'] == 1) {
								if ($a['disp_typ'] == 1) 
								{
									if($a['fld_nm']=='vch_no1'){
										if($_GET['cnnid']){
											echo "<input class = 'col' style='margin-top:-1em;background: transparent; border:none;border-bottom: 1.5px solid #A9A9A9 ;' type='text' placeholder = '".$a['head_nm']."' name= '".$a['fld_nm']."' id = '".$a['fld_nm']."' ".$required." value ='".$_GET['cnnid']."' readonly>";
										}
										else{
											echo "<input class = 'col' onchange='mainInfo(this.value)' style='margin-top:-1em;background: transparent; border:none;border-bottom: 1.5px solid #A9A9A9 ;' type='text' placeholder = '".$a['head_nm']."' name= '".$a['fld_nm']."' id = '".$a['fld_nm']."' ".$required.">";
										}
									}
									elseif($a['fld_nm']=='vch_no'){
										if($_GET['cnnid']){
											echo "<input class = 'col' style='margin-top:-1em;background: transparent; border:none;border-bottom: 1.5px solid #A9A9A9 ;' type='text' placeholder = '".$a['head_nm']."' name= '".$a['fld_nm']."' id = '".$a['fld_nm']."' ".$required." value ='".$latestval."' readonly>";
										}
										else{
											echo "<input class = 'col' onchange='mainInfo(this.value)' style='margin-top:-1em;background: transparent; border:none;border-bottom: 1.5px solid #A9A9A9 ;' type='text' placeholder = '".$a['head_nm']."' name= '".$a['fld_nm']."' id = '".$a['fld_nm']."' ".$required.">";
										}
									}else{
								 		echo "<input class = 'col' style='margin-top:-1em;background: transparent; border:none;border-bottom: 1.5px solid #A9A9A9 ;' type='text' placeholder = '".$a['head_nm']."' name= '".$a['fld_nm']."' id = '".$a['fld_nm']."' ".$required.">";
								 	}
								}elseif ($a['disp_typ'] == 3) {
									echo "<textarea class = 'col' style='margin-top:-1em;background: transparent; border:none;border-bottom: 1.5px solid #A9A9A9 ;' type='text' name='".$a['fld_nm']."' style='height:15px' id = '".$a['fld_nm']."'  placeholder = '".$a['head_nm']."' ".$required."></textarea>";
								}
							}

							#--------------- Date Field -------------------#	

							elseif ($a['fld_type'] == 3) {
									echo "<input class = 'col' style='margin-top:-1em;background: transparent; border:none;border-bottom: 1.5px solid #A9A9A9 ;' type = 'date' value='".$now."' name = '".$a['fld_nm']."' ".$required.">";
							}

							#---------------- Rating Field --------------#

							elseif ($a['fld_type'] == 6) {

								echo "<ul class='rate-area' >";
									if ($a['disp_typ'] == 1){
										echo "<input type='radio' id='".$a['fld_nm']."5' name='".$a['fld_nm']."' value='5' /><label for='".$a['fld_nm']."5' title='Amazing'>5 stars</label>";
						  				echo "<input type='radio' id='".$a['fld_nm']."4' name='".$a['fld_nm']."' value='4' /><label for='".$a['fld_nm']."4' title='Good'>4 stars</label>";
						  				echo "<input type='radio' id='".$a['fld_nm']."3' name='".$a['fld_nm']."' value='3' /><label for='".$a['fld_nm']."3' title='average'>3 stars</label>";
						  				echo "<input type='radio' id='".$a['fld_nm']."2' name='".$a['fld_nm']."' value='2' /><label for='".$a['fld_nm']."2' title='Not Good'>2 stars</label>";	
						  				echo "<input type='radio' id='".$a['fld_nm']."1' name='".$a['fld_nm']."' value='1' /><label for='".$a['fld_nm']."1' title='Bad'>1 star</label>";
										echo "<input type='radio' id='".$a['fld_nm']."0' name='".$a['fld_nm']."' value='0' style='display:none;' checked/><label for='".$a['fld_nm']."0' title='not selected' style='display:none;'>0 star</label>";
									}
									if ($a['disp_typ'] == 2){
										if($ac_val == 5){
											echo "<input type='radio' id='".$a['fld_nm']."".$ac_val."' name='".$a['fld_nm']."' value='".$ac_val."' checked /><label for='".$a['fld_nm']."".$ac_val."' >".$ac_val." stars</label>";
										}
						  				else{
						  					echo "<input type='radio' id='".$a['fld_nm']."5' name='".$a['fld_nm']."' value='5' /><label for='".$a['fld_nm']."5' title='Amazing'>5 stars</label>";
						  				}
						  				if($ac_val == 4){
											echo "<input type='radio' id='".$a['fld_nm']."".$ac_val."' name='".$a['fld_nm']."' value='".$ac_val."' checked /><label for='".$a['fld_nm']."".$ac_val."' >".$ac_val." stars</label>";
										}else{
						  					echo "<input type='radio' id='".$a['fld_nm']."4' name='".$a['fld_nm']."' value='4' /><label for='".$a['fld_nm']."4' title='Good'>4 stars</label>";
						  				}
						  				if($ac_val == 3){
											echo "<input type='radio' id='".$a['fld_nm']."".$ac_val."' name='".$a['fld_nm']."' value='".$ac_val."' checked /><label for='".$a['fld_nm']."".$ac_val."' >".$ac_val." stars</label>";
										}else{
						  					echo "<input type='radio' id='".$a['fld_nm']."3' name='".$a['fld_nm']."' value='3' /><label for='".$a['fld_nm']."3' title='average'>3 stars</label>";
						  				}
						  				if($ac_val == 2){
											echo "<input type='radio' id='".$a['fld_nm']."".$ac_val."' name='".$a['fld_nm']."' value='".$ac_val."' checked /><label for='".$a['fld_nm']."".$ac_val."' >".$ac_val." stars</label>";
										}else{
						  					echo "<input type='radio' id='".$a['fld_nm']."2' name='".$a['fld_nm']."' value='2' /><label for='".$a['fld_nm']."2' title='Not Good'>2 stars</label>";	
						  				}
						  				if($ac_val == 1){
											echo "<input type='radio' id='".$a['fld_nm']."".$ac_val."' name='".$a['fld_nm']."' value='".$ac_val."' checked /><label for='".$a['fld_nm']."".$ac_val."' >".$ac_val." stars</label>";
										}else{
						  					echo "<input type='radio' id='".$a['fld_nm']."1' name='".$a['fld_nm']."' value='1' /><label for='".$a['fld_nm']."1' title='Bad'>1 star</label>";
					  					}
					  				}

					  													
								echo "</ul>";
							}

							elseif($a['fld_type'] == 7){
								echo "<input class = 'col' style='margin-top:-1em;background: transparent; border:none;border-bottom: 1.5px solid #A9A9A9 ;' type='file' name='".$a['fld_nm']."' id='fileToUpload' accept='image/*' ".$required." >";
							
							}
							echo "</div>" ;  // div with id ='input_fields'
							echo "</div>";

						}

						/*else{
							echo "<input type='number' name=".$a['fld_nm']." placeholder = ".$a['head_nm'].">";
						}*/

						

				
					if($acv == 1)
					{
						echo "</div> " ;
						echo "<div class='row' style='padding-left: 0em;margin-top:14px;width:100%'>";

						
					}
				
				
					
					
				}
				echo "</div>"; //row end
				echo "<hr>";
				echo "<div class = 'submit'>";
				echo "<button style='border:none;background:teal;padding: 3px 15px;border-radius:5%;color:white' class='btn0' type='submit' name='submit'>SUBMIT</button>";
				echo "</div>";
				
				 // row ends
				//echo "</div>";
				 //div near col end
				

		
		echo "</div>"; // container ends
		echo "</form>";
		}
		else
		{
			/* here  
			global $xmenu_no ;
			$a = odbc_fetch_array($result);
			$xmenu_no = $_GET['mnno'];

			$sql = "select * from entry_mst where mnu_no=".$xmenu_no ;
			$result3 = odbc_exec($connection,$sql);
			$a3 = odbc_fetch_array($result3);


			$sql = " select * from field_mst where entry_uid=".$a3['uid'];
			$result4 = odbc_exec($connection,$sql);
			$a4 = odbc_fetch_array($result4);
			*/
			
			
			echo "<table style='margin-left:2em' class='table table-responsive footable footable-filtering footable-filtering-right footable-paging footable-paging-center ' data-sorting='true' data-filtering='true' width='100%'>";
			echo "<thead>";
			
			
			//print_r($xvar) ;
			
			while($afild_mast = odbc_fetch_array($result))
			{			
					if($afild_mast['disp_typ'] == 4)
					{
						$visibi = "false";
					}
					else
					{
						$visibi = "true" ;
					}

					
					echo "<th style=' padding-left:3em;' data-visible='".$visibi."'>".$afild_mast['head_nm'] ;
		  			echo " </th> ";			
					
			 }			 
			echo " </thead>" ;
			
			echo "<tbody>" ; 
			//print_r($result_2);

		/*	while($b = odbc_fetch_array($result_2))
			{ 	
				print_r($b);
				echo "<br><br>" ;
			}

				echo "<hr>";
			while ($new_var = odbc_fetch_array($xvar) )
			{		

				print_r($new_var['fld_nm']);
				echo "<br><br>";
			}
		*/	



			$ct=0;
			$ct2=0;
			$i=0;
			while($b = odbc_fetch_array($result_2))
			{ 	
				echo "<tr>" ;
										
				while ($new_var = odbc_fetch_array($xvar) )
				{	
				$arr1[$i] = $new_var['fld_nm'] ;
				$i++; 

				}

				for($j=0;$j<=$i;$j++)
				{
					echo "<td style=' padding-left:3em;'>";
					echo $b[$arr1[$j]];
				//	echo "hi";	
					echo "</td>" ;
					
				}

				
				echo "</tr>" ;
			
	
			}
			
					
			
			if(!$isreport)
			{
				echo "<tfoot>";
					echo "<tr class='footable-editing'>";
						echo "<td colspan='6'>" ;
			
						echo "<button data-toggle='modal' data-target='$' type='button' class='btn btn-primary footable-show'>" ;
							echo "<span class='fooicon fooicon-pencil' aria-hidden='true' style='margin-right:5px;'></span>" ;
								echo "Edit rows" ;
						echo "</button>";
			
						echo "<button class='btn btn-primary footable-add' style='margin-left:5px;' data-target='#editor-modal' data-toggle='modal' type='button' >";
							echo "New row";
						echo "</button>" ; 
						echo "</td>" ;
					echo "</tr>";
				echo "</tfoot>";
		

			}
			
			echo "</tbody> " ;


			echo "</table> " ;


			echo "<div class='modal fade' id='editor-modal' tabindex='-1' role='dialog' aria-labelledby='editor-title'> ";
				
				echo "<div class='modal-dialog' role='document' style='background-color:white;'> ";
					echo "<form class='modal-content form-horizontal' id='editor'> ";
						echo "<div class='modal-header'> ";
							echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>×</span></button> ";
							echo "<h4 class='modal-title' id='editor-title'>Add Row</h4>";
						echo "</div>";
						echo "<div class='modal-body'>"; 
						
							echo "<input type='number' id='id' name='id' class='hidden'/>";
							
						
						

							while ($a = odbc_fetch_array($result))
							{
								
							echo " <div class='form-group required'>";
								echo "<label for='firstName' class='col-sm-4 control-label'>First Name</label>";
								echo"<div class='col-sm-4'>";
									echo "<input type='text' class='form-control' id='firstName' name='firstName' placeholder='First Name' required>";
								echo "		</div>";
							echo " </div>";
							}

						echo"</div>";
										
						echo "<div class='modal-footer'>";
							echo "	  <button type='submit' class='btn btn-primary'>Save changes</button>";
							echo "	  <button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>";
						echo "</div>";
					echo "</form>";
				echo "</div>";

			echo "</div>";
		}
			
				
			
			}


			//echo "</div>" ;
			
			
	?>

	
<script>
xenable_disable_loader(0);
</script>
	</div>
	
			
	<?php

			#--------------------- View Form -------------------------#

			function viewForm(){



				#--------- declaring globals to use in the function -------#

				global $xcoid;
				global $connection;
				global $xmenu_no;
				global $xuid;
				global $xmnu_nm;
				global $xfile_nm;
				global $xfield_fill;
				global $xfield_value;
				global $xyear;
				global $xfetch_id;

				#echo "hello";

				#----------  fetching data from entry_mst ------------------#

				$sql = "select * from entry_mst where mnu_no = ".$xmenu_no;
				$result = odbc_exec( $connection, $sql);
				//print_r($sql);
				$a = odbc_fetch_array($result);

				
				#print_r($a);
				#----------- Fetching important data from the entry_mst and saving them in variables -----#

				$xuid = $a['uid'];
				$xmnu_nm = $a['mnu_nm'];
				$xfile_nm = $a['fil_nm']; 

				#----------- Conversion of fil_nm into the desired file name by replacing #fil and #yr -------#
				//print_r("file name1 ".$xfile_nm );
				$xfile_nm = filenameConversion($xfile_nm);
				//print_r ("file name ". $xfile_nm );


				$Finalfetch_sql = "select * from ".$xfile_nm." where uid =".$xfetch_id;
				//print_r($Finalfetch_sql);
				$view_result1 = odbc_exec( $connection, $Finalfetch_sql);
				$view_result = odbc_fetch_array($view_result1);
				#print_r($view_result);

				#------------ fetching data from field_mst to create the form using uid of entry_mst---------#
				
				$sql = "select * from field_mst where entry_uid =".$xuid." order by fldno";
				$result = odbc_exec( $connection, $sql);


				#------------ Fetching username from user_mst using userid provided in userid field -------------#
				/*global $xuserid;
				$user_sql = "select usr_nm from abc_mst where id = ".$xuserid;
				$result = @odbc_exec( $connection, $user_sql);
				*/
	?>

		<!--/*----------------------   header1 for the form  ----------------*/-->
			<div class = "contain">
			<div class="container-fluid">
	
		    	<h2 class="header1" align="center"><?php global $xconm; echo $xconm; ?></br>
		    	    		<?php global $xmnu_nm; echo $xmnu_nm; ?>
		    	</h2>

			<?php

				#------------- Creating form -----------#

				echo "<form method = 'post' class = 'form-inline' id='myForm'> ";
				#print_r($view_result);
				foreach ($view_result as $key => $value) {
					
					while($a = odbc_fetch_array($result))
					{

							

							echo "<div class = 'row'> <div>";
							echo "<div id = 'input_label'> <label for = '".$a['fld_nm']."'>".$a['head_nm']."</label> </div> </div>";

							
							#------------- Numeric field ------------- #

								echo "<div id = 'input_field'>";
								
								if($a['fld_type'] == 0){
									if($a['ischkbox'] == 1){
										if($value){
											echo "<input type='checkbox' id = '".$a['fld_nm']."' name='".$a['fld_nm']."' value='".$value."' checked>";
										}else{
											echo "<input type='checkbox' id = '".$a['fld_nm']."' name='".$a['fld_nm']."' value='".$value."'>";
										}
									}elseif($a['iscombo'] == 1){

										
										$defaultValue;
										$first4char = substr($a['combo_fil'], 0, 4); #this is for #fill
										$last3char = substr($a['combo_fil'], -3); #this is for #yr

										if(strcmp($first4char,'#fil') == 0){
											if($last3char == '#yr'){
												$a['combo_fil'] = str_replace('#fil', 'z', $a['combo_fil']);
												$a['combo_fil'] = str_replace('#yr','',$a['combo_fil']);
												$a['combo_fil'] .= $xcoid;
												$a['combo_fil'] .= '_';
												$a['combo_fil'] .= $xyear;
											}
											else{
												$a['combo_fil'] = str_replace('#fil', 'z', $a['combo_fil']);
												$a['combo_fil'] .= '_';
												$a['combo_fil'] .= $xcoid;
											}
										}

										#echo $a['combo_fil'];
										$combofil_sql_where = '';
										if($a['combofiltfld'] != ''){
											$combofil_sql_where = " where ".$a['combofiltfld']."=".$a['combofiltval']." ";	
										}

										$combofil_sql = "select * from ".$a['combo_fil']." ".$combofil_sql_where." order by ".$a['combonm']." ";

									
										$combo_result = odbc_exec( $connection, $combofil_sql);
										$combo_result1 = $combo_result;
										while($combofil_a = odbc_fetch_array($combo_result)){
											if($value == $combofil_a[$a['comboid']]){
												
												$defaultValue = $combofil_a[$a['combonm']]." || ".$combofil_a[$a['comboid']];
												
											}
										}

										if($defaultValue){
											echo "<input list = '".$a['fldno']."' value = '".$defaultValue."' name='".$a['fld_nm']."'>";
										}else{
											echo "<input list = '".$a['fldno']."'  name='".$a['fld_nm']."'>";
										}	
											echo "<datalist id = ".$a['fldno']." ";
											echo "<option> </option>";
											$combo_result1 = odbc_exec( $connection, $combofil_sql);
											while($combo_fil1 = odbc_fetch_array($combo_result1)){
												#print_r($combo_fil1);
												echo "<option value='".$combo_fil1[$a['combonm']]." || ".$combo_fil1[$a['comboid']]."'>".$combo_fil1[$a['combonm']]. "</option>";
											
											}
											echo "</datalist>";
										$defaultValue = null;
									}else{
										echo "<input type='int' name=".$a['fld_nm']." placeholder = ".$a['head_nm']." id = ".$a['fld_nm']." onkeypress='return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57' value=".$value.">";
									}
									
								}

								#-------------- String field -------------------#

								elseif ($a['fld_type'] == 1) {
									if ($a['disp_typ'] == 1) {
										echo "<input type='text' name='".$a['fld_nm']."' id = '".$a['fld_nm']."' placeholder = '".$a['head_nm']."' value='".$value."'>";
										
										#echo "<input type='text' placeholder = ".$a['head_nm']." name=".$a['fld_nm']." id = ".$a['fld_nm']." value=".$value.">";
									}elseif ($a['disp_typ'] == 3) {
										echo "<textarea type='text' name='".$a['fld_nm']."' style='height:6px' id = '".$a['fld_nm']."'  placeholder = '".$a['head_nm']."' >".$value."</textarea>";
									}
								}

								#--------------- Date Field -------------------#	

								elseif ($a['fld_type'] == 3) {
									echo "<input type = 'date' value='".$value."' name = '".$a['fld_nm']."'>";
								}

								#---------------- Rating Field --------------#

								elseif ($a['fld_type'] == 6) {
									echo "<ul class='rate-area'>";
										if($value == 5){
						  					echo "<input type='radio' id='".$a['fld_nm']."5' name='".$a['fld_nm']."' value='5' checked /><label for='".$a['fld_nm']."5' title='Amazing' >5 stars</label>";
						  				}else{
						  					echo "<input type='radio' id='".$a['fld_nm']."5' name='".$a['fld_nm']."' value='5' /><label for='".$a['fld_nm']."5' title='Amazing'>5 stars</label>";
						  				}
						  				if($value == 4){
						  					echo "<input type='radio' id='".$a['fld_nm']."4' name='".$a['fld_nm']."' value='4' checked /><label for='".$a['fld_nm']."4' title='Good' selected>4 stars</label>";	
						  				}else{
						  					echo "<input type='radio' id='".$a['fld_nm']."4' name='".$a['fld_nm']."' value='4' /><label for='".$a['fld_nm']."4' title='Good'>4 stars</label>";
						  				}
						  				if($value == 3){	
						  					echo "<input type='radio' id='".$a['fld_nm']."3' name='".$a['fld_nm']."' value='3' checked /><label for='".$a['fld_nm']."3' title='average' selected>3 stars</label>";	
						  				}else{
						  					echo "<input type='radio' id='".$a['fld_nm']."3' name='".$a['fld_nm']."' value='3' /><label for='".$a['fld_nm']."3' title='average'>3 stars</label>";
						  				}
						  				if($value == 2){	
						  					echo "<input type='radio'  id='".$a['fld_nm']."2' name='".$a['fld_nm']."' value='2' checked /><label for='".$a['fld_nm']."2' title='Not Good' >2 stars</label>";	
						  				}else{
						  					echo "<input type='radio' id='".$a['fld_nm']."2' name='".$a['fld_nm']."' value='2' /><label for='".$a['fld_nm']."2' title='Not Good'>2 stars</label>";	
						  				}
						  				if($value == 1){
						  					
						  					echo "<input type='radio' id='".$a['fld_nm']."1' name='".$a['fld_nm']."' value='1' checked /><label for='".$a['fld_nm']."1' title='Bad' selected>1 star</label>";	
						  				}else{
						  					echo "<input type='radio' id='".$a['fld_nm']."1' name='".$a['fld_nm']."' value='1' /><label for='".$a['fld_nm']."1' title='Bad'>1 star</label>";
										}
									echo "</ul>";
								}
								elseif ($a['fld_type'] == 7) {
									echo "<input type='file' name='".$a['fld_nm']."' id='fileToUpload' accept='image/*'><img src=data:image/jpg;base64,".$value."></input>";

								}
							echo "</div></div>";

					break;
					}#end of while

				}#end of foreach	
				
				echo "</div>";
				echo "<hr>";
				echo "<div class = 'submit'>";
					echo "<input type='submit' value='Submit' id = 'send'  name='submit' />";
				
			echo "</form>";
			
			}

			?>
</script>

<script>
	let cnn = [];
	function mainInfo(id) {
	    
	    console.log(id);
	   
	    		location.replace("http://localhost/conn_grid.php?coid=0001&conm=COMPANY%20NAME&yr=18&userid=0&server=<?php echo($actual); ?>&db=trans&user=sallu&pwd=dbamvt48&mnno=5001&fval=&ffill=&fid=&cfg=&uptb_nm=misc_purc&upfil_nm=qty&upft_nm=uid&upft_val=11&cnm=&cnnid="+id);
	}
	function freight(id) {
               
        var first_number = document.getElementById("weight").value;
        var result = id * first_number;

        document.getElementById("frt").value = result;
    }

    function rpamount(id){

    	var first_number = document.getElementById("weight").value;
        var result = id * first_number;

        document.getElementById("rp_amt").value = result;	
    }
    
    function handchgamount(id) {
    	var first_number = document.getElementById("weight").value;
        var result = id * first_number;

        document.getElementById("handchgamt").value = result;	
    }

    function suramt(id) {
    	var first_number = document.getElementById("weight").value;
        var result = (first_number/100)*id;

        document.getElementById("sur_amt").value = result;	
    }

    function rafteramount(id) {
    	var first_number = document.getElementById("rafter").value;
        var result = id * first_number;

        document.getElementById("rafteramt").value = result;	
    }

    function gutkhaamount(id) {
    	var first_number = document.getElementById("gutkha").value;
        var result = id * first_number;

        document.getElementById("gutkhaamt").value = result;	
    }
</script>

		<?php
			



			#--------------- Funcion to check weather data is submited --------------#
			
			if(isset($_POST['submit']))
			{
				#print_r($_POST);
				global $update_flag;
				if($update_flag){
					update();
				}else{
					insert();
				}
			} 


			#--------------------- File Name Conversion Function ----------------------#

			function filenameConversion($nameString){
				#echo "hello";
				global $xyear;
				global $xcoid;
				$first3char = substr($nameString, 0, 3);
				$last2char = substr($nameString, -2);
				$first4char = substr($nameString, 0, 4); #this is for #fill
				$last3char = substr($nameString, -3); #this is for #yr
				if(strcmp($first3char,'fil') == 0){
					if($last2char == 'yr'){
						$nameString = str_replace('fil_', '', $nameString);
						$nameString = str_replace('yr','',$nameString);
						$nameString .= $xcoid;
						$nameString .= '_';
						$nameString .= $xyear;
					}
					else{
						$nameString = str_replace('fil_', '', $nameString);
						$nameString .= '_';
						$nameString .= $xcoid;
					}
				}
				if(strcmp($first4char,'#fil') == 0){
					if($last3char == '#yr'){
						$nameString = str_replace('#fil', 'z', $nameString);
						$nameString = str_replace('#yr','',$nameString);
						$nameString .= $xcoid;
						$nameString .= '_';
						$nameString .= $xyear;
					}
					else{
						$nameString = str_replace('#fil', 'z', $nameString);
						$nameString .= '_';
						$nameString .= $xcoid;
					}
				}
				return($nameString);
			}

			#----------------- Function to insert data and create insert query -----------#

			function insert(){

				global $xuserid;
				global $xfile_nm;
				global $connection;
				global $continue_entry;
				global $save_updatequery;
				global $actual_link;
				$filefg = null;
				#print_r($_POST);
				#print_r( $_FILES); 
				$i=0;
				if($_FILES){
					$filefg = 1;
					foreach ($_FILES as $key => $value) {
						$name[$key] = base64_encode(file_get_contents($_FILES[$key]['tmp_name']));			
					}
				}


				#echo"<img src=data:image/jpg;base64,".$name['to_party'].">";
				#print_r($name);

				/*$i=0;
				$finalimagefile;
				foreach ($key1 as $key => $value) {
				
					$finalimagefile[$i] = base64_encode($value['tmp_name']);

				}
				$count1 = count($finalimagefile);
				print_r($finalimagefile);
				#echo base64_encode();

				$i = 1;
				$image_query = "insert into ".$xfile_nm." (";
				foreach ($name as $key => $value) {
					$image_query .= $value;

					if($i < $count1)
						$image_query .= ",";

				}
				$image_query .= ") values ( ";
				$i = 1;
				$count1 = count($finalimagefile);
				foreach ($finalimagefile as $key => $value) {
					$image_query .= base64_encode($value);
					if($i < $count1)
						$image_query .= ",";
				}

				$image_query .= ")" ;

				echo $image_query;

				

				

				odbc_exec( $connection, $image_query) ;
				*/
				/*foreach ($_FILES as $key => $value) {
					$key1 = $_FILES[$key];
				}

				print_r($key1);
				$img = file_get_contents($key1['tmp_name']);
				$data = base64_encode($img); 
				echo $data;
				$image_query = "update misc_purc set [pd_image] = '".$data."' where uid = 12";
				odbc_exec( $connection, $image_query) ;
				$select_query  = "select pd_image from misc_purc where uid = 12";
				$RES = odbc_exec( $connection, $select_query) ;
				$ABBBB = odbc_fetch_array($RES);
				#print_r($ABBBB);
				header("Content-type: image/gif");
				#$data = "/9j/4AAQSkZJRgABAQEAYABgAAD........";
				$ABBBB = base64_decode($ABBBB);
				#echo "<img src='data:image/png;base64," . $ABBBB . "' />";
				#echo "<img src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAJCAIAAACExCpEAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAASSURBVChTY5DutMGDRqZ0pw0A4ZNOwQNf'>";

*/

				if ($xuserid >= 1){

				
					$ipadd = $_SERVER['REMOTE_ADDR'];
					$hostname = gethostname();
					$count = count($_POST);
					date_default_timezone_set("Asia/Calcutta");
					//$timestamp = date('r');

					$timestamp = date("Y/m/d");
					$timestamp .= " ".date("h:i:sa"); 

					#------------- creating insert query if userid = 1 ------------#

					$insertsql = "insert into ".$xfile_nm." (";
						$x = 1;
						foreach ($_POST  as $key => $value) {
							if($count > $x)
	    						$insertsql .= $key;
	    					$x++;
	    					if($count > $x)
	    						$insertsql .= ",";
	    					if($filefg){
	    						foreach ($name as $k => $v) {
	    							$insertsql .= ",".$k;
	    						}
	    					}
						}
						$insertsql .= ", entered_on, hostname, ipadd) values ( ";

						$x = 1;
						
						foreach ($_POST  as $key => $value) {
							if($count > $x){
								if (strpos($value, ' || ') !== false){
									$value = substr($value, strpos($value, "|| ") + 3);
									#echo $value;
								}
								$insertsql .= "'".$value."'";

							}
							$x++;
	    					if($count > $x)
	    						$insertsql .= ",";
	    				}
						#$insertsql = substr_replace($insertsql ,"",-1);
	    					if($filefg){
	    						foreach ($name as $k => $v) {
	    							$insertsql .= ",".$v; 
	    						}
	    					}						
					$insertsql .= ",'".$timestamp."', '".$hostname."', '".$ipadd."' )";
					#echo $insertsql;

				}

				#----------------- creating insert query if userid != 1  --------------#

				else{
					$count = count($_POST);
					$insertsql = "insert into ".$xfile_nm." (";
						$x = 1;
						foreach ($_POST  as $key => $value) {
							if($count > $x)
	    						$insertsql .= $key;
	    					$x++;
	    					if($count > $x)
	    						$insertsql .= ",";
						}
						if($filefg){
	    						foreach ($name as $k => $v) {
	    							$insertsql .= ",".$k;
	    						}
	    					}
						$insertsql .= ") values ( ";

						$x = 1;
						
						foreach ($_POST  as $key => $value) {
							if($count > $x){
								if (strpos($value, ' || ') !== false){
									$value = substr($value, strpos($value, "|| ") + 3);
									#echo $value;
								}
								$insertsql .= "'".$value."'";
							}
							$x++;
	    					if($count > $x)
	    						$insertsql .= ",";
	    					
	    					#echo $insertsql;
						}
						#$insertsql = substr_replace($insertsql ,"",-1);
						if($filefg){
	    						foreach ($name as $k => $v) {
	    							$insertsql .= ",'".$v."'"; 
	    						}
	    				}
					$insertsql .= ")";
					#echo $insertsql;
				}
				
				# -- - ------------- execute insert command using odbc connection ---------------#
				$err_chk = odbc_exec( $connection, $insertsql) ;
				$exec_run = 1;
				

				if(odbc_error()){
					#echo odbc_errormsg($connection)."\n".$insertsql;
					$exec_run = 0;
				}

				if($exec_run == 1){
					#echo $continue_entry;
						if($continue_entry){
							echo "<script>document.getElementById('myForm').reset();</script>";
						}
					else{
							if($save_updatequery){
								#echo "hi";
								#echo $save_updatequery;
								odbc_exec( $connection, $save_updatequery) ;
							}
							?>
							<script type="text/javascript">
								close();
							</script>
							<?php
						}
			
				}
				

			}

			#------------------------------- Function to form update query and update table -----------------#


			function update(){

				global $xuserid;
				global $xfile_nm;
				global $connection;
				global $xfetch_id;
				global $userid;
				$update_sql = '';
				#echo $xuserid;
				$count = count($_POST);


				if($_FILES){
					$filefg = 1;
					foreach ($_FILES as $key => $value) {
						$name[$key] = base64_encode(file_get_contents($_FILES[$key]['tmp_name']));			
					}
				}


				if ($xuserid >= 1){

				
					$ipadd = $_SERVER['REMOTE_ADDR'];
					$hostname = gethostname();
					$count = count($_POST);
					date_default_timezone_set("Asia/Calcutta");
					//$timestamp = date('r');

					$timestamp = date("Y/m/d");
					$timestamp .= " ".date("h:i:sa"); 


						$update_sql = "update ".$xfile_nm." set ";
						$x = 1;
						foreach ($_POST  as $key => $value) {
									if($count > $x){
										if($value == null){
											$count--;
											continue;
										}
										if (strpos($value, ' || ') !== false){
											$value = substr($value, strpos($value, "|| ") + 3);
											#echo $value;
										}

										$update_sql .= "[".$key."] = '".$value."'";

										if($count == $x + 1){
											
											$update_sql .= ", [entered_on] = '".$timestamp."', [hostname] = '".$hostname."', [ipadd] = '".$ipadd."'";

										}

									}
									$x++;
			    					if($count > $x)
			    						$update_sql .= ",";

						}
				}else{
						$update_sql = "update ".$xfile_nm." set ";
						$x = 1;
						foreach ($_POST  as $key => $value) {
							if($count > $x){
								if($value == null){
									$x++;
									continue;
								}
								if (strpos($value, ' || ') !== false){
									$value = substr($value, strpos($value, "|| ") + 3);
									#echo $value;
								}

								$update_sql .= "[".$key."] = '".$value."'";
							}
							$x++;
	    					if($count > $x)
	    						$update_sql .= ",";
					}
				}
				if($filefg){
					foreach ($name as $key => $value) {
						$update_sql .= ",[".$key."] = '".$value."'";
					}
				}

						$update_sql .= " where [uid] ='".$xfetch_id."'";
				
				#echo $update_sql;
				



				odbc_exec( $connection, $update_sql);
				$err_chk = odbc_exec( $connection, $update_sql) ;
				$exec_run = 1;
				

				if(odbc_error()){
					echo odbc_errormsg($connection)."\n".$update_sql;
					$exec_run = 0;
				}

				if($exec_run == 1){
					#echo $continue_entry;
						if($continue_entry){
							echo "<script>document.getElementById('myForm').reset();</script>";
						}else{
							if($save_updatequery){
								#echo "hi";
								odbc_exec( $connection, $save_updatequery) ;
							}
							?>
							<script type="text/javascript">
								close();
							</script>
							<?php
						}
			
				}

			}
			
			#---------------- closing the connection --------------------#
			odbc_close($connection);
	?>


		</div>




</body>






</html>

