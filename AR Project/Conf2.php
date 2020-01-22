<!DOCTYPE html>
<html>
<head>
	<title>Audit Confirmations</title>
    <style type="text/css">
      div {width:800px;}
      p.boilerplate {font-family:"Arial"; font-size:16px; text-align:justified;}
      table.bordered {border-style:solid; padding:10px}
      td.address {font-family:"Arial"; font-size:16px; text-align:left;}
      td.title {font-family:"Arial"; font-size:16px; text-align:left;}     
      td.letterhead {font-family:"Arial"; font-size:20px; text-align:center;}
      td.signature {font-family:"Freestyle Script"; font-size:40px; text-align:left;}
      td.signedunderlined {font-family:"Freestyle Script"; font-size:30px; text-align:left; border-bottom-style:solid; border-bottom-width:2px;}
      td.standard {font-family:"Arial"; font-size:16px; text-align:left;}
      td.underlined {font-family:"Arial"; font-size:16px; text-align:left; border-bottom-style:solid; border-bottom-width:2px;}
    </style>

</head>
<body>

<?php

$servername = "pcluster31";
$username = "jamesalo_Exodar898";
$password = "NanoKangarooNano12";
$dbname = "jamesalo_ARProject"; 

/*$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ARProject";*/


$conn = new mysqli($servername,$username,$password,$dbname);

if ($conn->connect_error){
	die ("Connection Failed: " . $conn->connect_error);
}

$value = $_GET["number"];

$result = $conn->query("SELECT * FROM tad WHERE `number`='".$value."'");
$row = $result->fetch_assoc();

echo 

"<div id=\"letters\">
	<table class=\"bordered\">
		<tr><td><a name=\"&x\">" .$row["number"] ."</td><td colspan=\"2\">&nbsp;</td></tr>
		<tr><td colspan=\"3\" class=\"letterhead\">Charles Cabinets</td></tr>
		<tr><td colspan=\"3\" class=\"letterhead\">San Luis Obispo, CA</td></tr>
		<tr><td colspan=\"3\">&nbsp;</td></tr>
		<tr><td colspan=\"3\">&nbsp;</td></tr>
		<tr><td colspan=\"3\" class=\"address\">" .$row["Name"] ."</a></td></tr>
		<tr><td colspan=\"3\" class=\"address\">" .$row["Address 1"] ."</td></tr>
		<tr><td colspan=\"3\" class=\"address\">".$row["City"] .", " .$row["State"] .", " .$row["Zip"] ."</td></tr>
		<tr><td colspan=\"3\">&nbsp;</td></tr>
		<tr><td colspan=\"3\">&nbsp;</td></tr>
		<tr><td colspan=\"3\">
			<p class=\"boilerplate\">
				Our auditors, DC & H, LLP, are making their regular audit of our financial statements. Part of this audit
				includes direct verification of customer balances.
			</p>
			<p class=\"boilerplate\">
				PLEASE EXAMINE THE DATA BELOW CAREFULLY AND EITHER CONFIRM ITS ACCURACY OR REPORT ANY DIFFERENCES DIRECTLY TO OUR AUDITORS
				USING THE ENCLOSED REPLY ENVELOPE.
			</p>
			<p class=\"boilerplate\">
				This is not a request for payment. Please do not send your remittance to our auditors.
			</p>
			<p class=\"boilerplate\">
				Your prompt attention to this request will be appreciated.
			</p>          
		</td></tr>
		<tr><td colspan=\"3\">&nbsp;</td></tr>
		<tr><td colspan=\"3\"class=\"signature\">Pat Miller</td></tr>
		<tr><td colspan=\"3\" class=\"title\">Pat Miller, Controller</td></tr>
		<tr><td colspan=\"3\">&nbsp;</td></tr>
		<tr><td colspan=\"3\">&nbsp;</td></tr>
		<tr><td colspan=\"3\" class=\"standard\">The balance due Charles Cabinets as of December 31, 20xx is " .$row["Book Balance"] .".</td></tr>
		<tr><td colspan=\"3\">&nbsp;</td></tr>
		<tr><td colspan=\"3\" class=\"standard\">The balance is correct except as noted below:</td></tr>
		<tr><td colspan=\"3\">&nbsp;</td></tr>
		<tr><td colspan=\"3\" class=\"underlined\"> According to our records, our balance is: " .$row["2nd Bal"] ."</td></tr>
		<tr><td colspan=\"3\">&nbsp;</td></tr>
		<tr><td class=\"underlined\" width=150px>Date: 1/15/20xx</td><td class=\"signedunderlined\" width=400px>By:" .$row["Signature"] ."</td><td class=\"underlined\">Title: President</td></tr>
		<tr><td colspan=\"3\">&nbsp;</td></tr>       
	</table>
</div>";

?>

</body>
</html>