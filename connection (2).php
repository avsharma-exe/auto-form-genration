<!DOCTYPE html>
<html>
<head>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<style type="text/css">
		
		ul{
			background-color: aliceblue;
			padding: inherit;
		}
		.contain{
			background-color: #6AD2FD;
		}

			.form-inline {
			  display: flex;
			  flex-flow: row wrap;
			  align-items: center;
			}

		.form-inline label {
  			margin: 5px 10px 5px 10px;
		}

		/*submit*/
		.submit {
		    text-align: center;
		    padding: 10px;
		}

		input {

		    background-color: #639bf5;

		}

		/* Style the input fields */
		.form-inline input, select, textarea, ul {
		  vertical-align: middle;
		  margin: 10px 10px 10px 10px;
		  padding: 10px;
		  background-color: #9cdbf6;
		  border: 2px solid #ddd;
		}
		
		.header {

		    text-align: center;
		    background: #1abc9c;
		    color: white;
		    font-size: 30px;

		}
		.sub-header {

		    text-align: center;
		    background: #1abc9c;
		    color: white;
		    font-size: 30px;

		}
		
		

		.rate-area {
		  float: left;
		  border-style: none;
		}

		.rate-area:not(:checked) > input {
		  position: absolute;
		  top: -9999px;
		  clip: rect(0,0,0,0);
		}

		.rate-area:not(:checked) > label {
		  float: right;
		  width: 1em;
		  padding: 0 .1em;
		  overflow: hidden;
		  white-space: nowrap;
		  cursor: pointer;
		  font-size: 10px;
		  line-height: 1.2;
		  color: white;
		  text-shadow: 1px 1px #bbb;
		}

		.rate-area:not(:checked) > label:before { content: '★ '; }

		.rate-area > input:checked ~ label {
		  color: gold;
		  text-shadow: 1px 1px #c60;
		  
		}

		.rate-area:not(:checked) > label:hover, .rate-area:not(:checked) > label:hover ~ label { color: gold; }

		.rate-area > input:checked + label:hover, .rate-area > input:checked + label:hover ~ label, .rate-area > input:checked ~ label:hover, .rate-area > input:checked ~ label:hover ~ label, .rate-area > label:hover ~ input:checked ~ label {
		  color: gold;
		  text-shadow: 1px 1px goldenrod;
		}

		.rate-area > label:active {
		  position: relative;
		  top: 2px;
		  left: 2px;
		}

		
	</style>
	<title>Auto Generator</title>
</head>
<body>


	<?php

		//http://localhost/connection.php?coid=0001&conm=COMPANY NAME&year=19&userid=0&server=JARVIS\SQLEXPRESS&database=alldata&user=sallu&password=dbamvt48&menuno=5010&field_value=ayush&field_fill=

		$xcoid = $_GET["coid"];
		$xconm = $_GET["conm"];
		$xyear = $_GET["year"];
		$xuserid = $_GET["userid"];
		$xserver = $_GET["server"];
		$xdatabase = $_GET["database"];
		$xuser = $_GET["user"];
		$xpassword = $_GET["password"];
		$xmenu_no = $_GET["menuno"];
		
		if($_GET["field_fill"]){
			#echo "bhai bhai";	
			$xfield_value = $_GET["field_value"];
			$xfield_fill = $_GET["field_fill"]; 
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

			#--------------- Connection query ------------#

			$connection = odbc_connect("Driver={SQL Server};Server=$xserver;Database=$xdatabase;", $xuser, $xpassword);
			if($connection){
				#echo "established";
				fetchData();
			}

			#=--------------  function to perform all the data operations and form generation ---------- #

			function fetchData(){
				
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

				$first4char = substr($xfile_nm, 0, 4); #this is for #fill
				$last3char = substr($xfile_nm, -3); #this is for #yr

				if(strcmp($first4char,'#fil') == 0){
					if($last3char == '#yr'){
						$xfile_nm = str_replace('#fil', 'z', $xfile_nm);
						$xfile_nm = str_replace('#yr','',$xfile_nm);
						$xfile_nm .= $xcoid;
						$xfile_nm .= '_';
						$xfile_nm .= $xyear;
					}
					else{
						$xfile_nm = str_replace('#fil', 'z', $xfile_nm);
						$xfile_nm .= '_';
						$xfile_nm .= $xcoid;
					}
				}
				#echo $xfield_fill;
				#echo $xfile_nm;

				#------------ fetching data from field_mst to create the form using uid of entry_mst---------#
				
				$sql = "select * from field_mst where entry_uid =".$xuid." order by fldno";
				$result = odbc_exec( $connection, $sql);
				$number_fields = odbc_num_rows($result);
	?>

		<!--/*----------------------   header for the form  ----------------*/-->
			<div class = "contain">
			<div class="container">
	
		    	<h2 class="header" align="center"><?php global $xconm; echo $xconm; ?></br>
		    	    		<?php global $xmnu_nm; echo $xmnu_nm; ?>
		    	</h2>

	<?php

				#------------- Creating form -----------#

				echo "<form method = 'post' class = 'form-inline'>";
				while($a = odbc_fetch_array($result)){
					#print_r($a);
					echo "<div class='row'> <div>";
						if($a['disp_typ'] == 4){
							if($xfield_fill == $a['fld_nm']){
								"<input type='hidden' name=".$a['fld_nm']." id = ".$a['fld_nm']." placeholder = ".$a['head_nm']." value=".$xfield_value.">";
							}
						}else{
							echo "<div id = 'input_label'> <label for = ".$a['fld_nm'].">".$a['head_nm']."</label> </div>  </div>";
						
						#------------- Numeric field ------------- #

							echo "<div id = 'input_field'>";
							if($a['fld_type'] == 0){
								if($a['ischkbox'] == 1){
									echo "<input type='checkbox' id = ".$a['fld_nm']." name=".$a['fld_nm']." value='1'>";
								}elseif($a['iscombo'] == 1){

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

									#print_r($combofil_sql);
									$combo_result = odbc_exec( $connection, $combofil_sql);

									echo "<input list = ".$a['fldno']."  name=".$a['fld_nm'].">";
										echo "<datalist id = ".$a['fldno']." ";
										echo "<option> </option>";
										while($combofil_a = odbc_fetch_array($combo_result)){
											#print_r($combofil_a);
											echo "<option value='".$combofil_a[$a['combonm']]." || ".$combofil_a[$a['comboid']]."'>".$combofil_a[$a['combonm']]. "</option>";
										}
										echo "</datalist>";
		
								}elseif ($a['disp_typ'] == 1) {
									echo "<input type='int' name=".$a['fld_nm']." placeholder = ".$a['head_nm']." id = ".$a['fld_nm']." onkeypress='return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57' >";
								}elseif ($a['disp_typ'] == 2) {
									if($xfield_fill == $a['fld_nm']){
										echo "<input type = 'int' name=".$a['fld_nm']."  value='".$xfield_value."' readonly>";
									}
								}elseif ($a['disp_typ'] == 3) {
									echo "<textarea type='int' name=".$a['fld_nm']." id = ".$a['fld_nm']." style='height:200px' onkeypress='return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57' placeholder = ".$a['head_nm']."></textarea>";	
								}
								
							}

							#-------------- String field -------------------#

							elseif ($a['fld_type'] == 1) {
								if ($a['disp_typ'] == 1) {
									echo "<input type='text' placeholder = ".$a['head_nm']." name=".$a['fld_nm']." id = ".$a['fld_nm']." >";
								}elseif($a['disp_typ'] == 2){
									if($xfield_fill == $a['fld_nm']){
										echo "<input type='text' name=".$a['fld_nm']." id = ".$a['fld_nm']." placeholder = ".$a['head_nm']." value=".$xfield_value." readonly>";
									}
								}elseif ($a['disp_typ'] == 3) {
									echo "<textarea type='text' name=".$a['fld_nm']." style='height:200px' id = ".$a['fld_nm']."  placeholder = ".$a['head_nm']."></textarea>";
								}
							}

							#--------------- Date Field -------------------#	

							elseif ($a['fld_type'] == 3) {
								#if(){echo "<input type='date' id = ".$a['fld_nm']." name=".$a['fld_nm']." >" ;}
								if ($a['disp_typ'] == 1) {
									$tdate = date("m/d/Y");
									#echo  $date;
									#echo $a['fld_nm'];
									echo "<input type='date' name=".$a['fld_nm']." id = ".$a['fld_nm']." value = ".$tdate." >";
								}elseif($a['disp_typ'] == 2){
									if($xfield_fill == $a['fld_nm']){
										echo "<input type='date' name=".$a['fld_nm']." id = ".$a['fld_nm']." value=".$xfield_value." readonly>";
									}
								}
							}

							#---------------- Rating Field --------------#

							elseif ($a['fld_type'] == 6) {
								echo "<ul class='rate-area'>";
					  				echo "<input type='radio' id='".$a['fld_nm']."5' name=".$a['fld_nm']." value='5' /><label for='".$a['fld_nm']."5' title='Amazing'>5 stars</label>";
					  				echo "<input type='radio' id='".$a['fld_nm']."4' name=".$a['fld_nm']." value='4' /><label for='".$a['fld_nm']."4' title='Good'>4 stars</label>";
					  				echo "<input type='radio' id='".$a['fld_nm']."3' name=".$a['fld_nm']." value='3' /><label for='".$a['fld_nm']."3' title='average'>3 stars</label>";
					  				echo "<input type='radio' id='".$a['fld_nm']."2' name=".$a['fld_nm']." value='2' /><label for='".$a['fld_nm']."2' title='Not Good'>2 stars</label>";	
					  				echo "<input type='radio' id='".$a['fld_nm']."1' name=".$a['fld_nm']." value='1' /><label for='".$a['fld_nm']."1' title='Bad'>1 star</label>";
								echo "</ul>";
							}
						}

						/*else{
							echo "<input type='number' name=".$a['fld_nm']." placeholder = ".$a['head_nm'].">";
						}*/
						echo "</div>";
					echo "</div>";
				}
				echo "</div>";
				echo "<hr>";
				echo "<div class = 'submit'>";
					echo "<input type='submit' value='Submit' name='submit' />";
				echo "</div>";
			echo "</form>";
			}

	?>
			</div>
	<?php

			#--------------- Funcion to check weather data is submited --------------#

			if(isset($_POST['submit']))
			{
			   insert();
			} 

			#----------------- Function to insert data and create insert query -----------#

			function insert(){
				global $xuserid;
				global $xfile_nm;
				global $connection;


				if ($xuserid >= 1){

				
					$ipadd = $_SERVER['REMOTE_ADDR'];
					$hostname = gethostname();
					$count = count($_POST);
					date_default_timezone_set("Asia/Calcutta");
					//$timestamp = date('r');

					$timestamp = date("d/m/Y");
					$timestamp .= "_".date("h:i:sa"); 

					#------------- creating insert query if userid = 1 ------------#

					$insertsql = "insert into ".$xfile_nm." (";
						$x = 1;
						foreach ($_POST  as $key => $value) {
							if($count > $x)
	    						$insertsql .= $key;
	    					$x++;
	    					if($count > $x)
	    						$insertsql .= ",";
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

						}
					$insertsql .= ")";
					echo $insertsql;
				}

				# -- - ------------- execute insert command using odbc connection ---------------#

				$abc = odbc_exec( $connection, $insertsql);

			}

			#---------------- closing the connection --------------------#

			odbc_close($connection);
	?>
</body>

</html>

