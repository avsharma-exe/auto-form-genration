<!DOCTYPE html>
<html>
<head>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<style type="text/css">
		
		.contain{
			background-color: #D3D3D3;
		}

			.form-inline {
			  display: flex;
			  flex-flow: row wrap;
			  align-items: center;
			}

		.form-inline label {
  			margin: 5px 10px 5px 0;
		}

		/*submit*/
		.submit {
		    text-align: center;
		}

		/* Style the input fields */
		.form-inline input {
		  vertical-align: middle;
		  margin: 5px 10px 5px 0;
		  padding: 10px;
		  background-color: #fff;
		  border: 1px solid #ddd;
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
		  font-size: 400%;
		  line-height: 1.2;
		  color: lightgrey;
		  text-shadow: 1px 1px #bbb;
		}

		.abc{
			background-color: aqua;
		}
		.rate-area:not(:checked) > label:before { content: '★ '; }

		.rate-area > input:checked ~ label {
		  color: gold;
		  text-shadow: 1px 1px #c60;
		  font-size: 450% !important;
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

		@media (max-width: 800px) {
		.form-inline input {
		margin: 10px 0;
		}
	</style>
	<title>Auto Generator</title>
</head>
<body>


	<?php

		//http://localhost/connection.php?coid=0001&conm=COMPANY NAME&year=19&userid=0&server=JARVIS\SQLEXPRESS01&database=alldata&user=sallu&password=dbamvt48&menuno=5005&field_value=ayush&field_fill=&field_value=

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
			echo "bhai bhai";	
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
						echo "<label for = ".$a['fld_nm'].">".$a['head_nm']."</label> </div>";

						#------------- Numeric field ------------- #

						echo "<div>";
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

								$combofil_sql = "select * from ".$a['combo_fil']." order by nm";
								$combo_result = odbc_exec( $connection, $combofil_sql);
								
								echo "<select name=".$a['fld_nm'].">";

									while($combofil_a = odbc_fetch_array($combo_result)){
										echo "<option value='' selected> </option>";
										echo "<option value=".$combofil_a['id'].">".$combofil_a['nm']."</option>";
									}
								echo "<select name=".$a['fld_nm'].">";
	
							}elseif ($a['disp_typ'] == 1) {
								echo "<input type='int' name=".$a['fld_nm']." placeholder = ".$a['head_nm']." id = ".$a['fld_nm']." onkeypress='return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57' >";
							}elseif ($a['disp_typ'] == 2) {
								echo "<input type='int' name=".$a['fld_nm']." placeholder = ".$a['head_nm']." id = ".$a['fld_nm']." onkeypress='return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode == 46 || event.charCode >= 48 && event.charCode <= 57' >";
							}elseif ($a['disp_typ'] == 3) {
								echo "<textarea type='int' name=".$a['fld_nm']." id = ".$a['fld_nm']." style='height:200px' onkeypress='return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57' placeholder = ".$a['head_nm']."></textarea>";	
							}elseif($a['disp_typ'] == 4){
								if($xfield_fill == $a['fld_nm']){
									"<input type='hidden' name=".$a['fld_nm']." id = ".$a['fld_nm']." placeholder = ".$a['head_nm']." value=".$xfield_value.">";
								}
							}
							
						}

						#-------------- String field -------------------#

						elseif ($a['fld_type'] == 1) {
							if ($a['disp_typ'] == 1) {
								echo "<input type='text' placeholder = ".$a['head_nm']." name=".$a['fld_nm']." id = ".$a['fld_nm']." >";
							}elseif ($a['disp_typ'] == 3) {
								echo "<textarea type='text' name=".$a['fld_nm']." style='height:200px' id = ".$a['fld_nm']."  placeholder = ".$a['head_nm']."></textarea>";
							}elseif ($a['disp_typ'] == 3) {

							}

							
						}

						#--------------- Date Field -------------------#	

						elseif ($a['fld_type'] == 3) {
							echo "<input type='date' id = ".$a['fld_nm']." name='date' >" ;
							
						}

						#---------------- Rating Field --------------#

						elseif ($a['fld_type'] == 6) {
							echo "<ul class='rate-area'>";
				  				echo "<input type='radio' id='5-star' name='rating' value='5' /><label for='5-star' title='Amazing'>5 stars</label>";
				  				echo "<input type='radio' id='4-star' name='rating' value='4' /><label for='4-star' title='Good'>4 stars</label>";
				  				echo "<input type='radio' id='3-star' name='rating' value='3' /><label for='3-star' title='average'>3 stars</label>";
				  				echo "<input type='radio' id='2-star' name='rating' value='2' /><label for='2-star' title='Not Good'>2 stars</label>";	
				  				echo "<input type='radio' id='1-star' name='rating' value='1' /><label for='1-star' title='Bad'>1 star</label>";
							echo "</ul>";
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
							if($count > $x)
								$insertsql .= "'".$value."'";
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
							if($count > $x)
								$insertsql .= "'".$value."'";
							$x++;
	    					if($count > $x)
	    						$insertsql .= ",";

						}
					$insertsql .= ")";
					#echo $insertsql;
				}

				# -- - ------------- execute insert command using odbc connection ---------------#

				$abc = odbc_exec( $connection, $insertsql);

			}

			#---------------- closing the connection --------------------#

			odbc_close($connection);
	?>
</body>

</html>

