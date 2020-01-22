<!DOCTYPE html>
<html>
<head>
	<title>PO</title>
	<style type="text/css">
      div {width:800px;}
      p.boilerplate {font-family:"Arial"; font-size:16px; text-align:justified;}
      table.bordered {border-style:solid; padding:10px}
      td.address {font-family:"Arial"; font-size:16px; text-align:left;}
      td.letterhead {font-family:"Arial"; font-size:20px; text-align:center;}
      td.signature {font-family:"Freestyle Script"; font-size:40px; text-align:left;}
      td.title {font-family:"Arial"; font-size:16px; text-align:left;}     
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

$balance = ltrim($row["Book Balance"], '-');
$balance = ltrim($balance, '$');
$balance = str_replace(",", "", $balance);
$balance = floatval($balance);


echo
"<table class=\"bordered\">
    <tbody>
        <tr>
        	<td colspan=\"3\" class=\"letterhead\">Purchase Order " .$row["PO#"] ."</td>
        </tr>
        <tr>
        	<td>&nbsp;</td><td><a name=\"&amp;x\">&nbsp;</a></td><td>&nbsp;</td>
        </tr>
        <tr>
        	<td><p class=\"boilerplate\">12/01/xx</p></td><td colspan=\"2\">&nbsp;</td>
        </tr>
        <tr>
        	<td colspan=\"3\">&nbsp;</td>
        </tr>
        <tr>
        	<td colspan=\"3\">&nbsp;</td>
        </tr>
        <tr>
        	<td class=\"address\">Vendor:</td><td>&nbsp;</td><td class=\"address\">Ship/Bill to:</td>
        </tr>
        <tr>
        	<td class=\"address\">Charles Cabinets</td><td>&nbsp;</td><td class=\"address\">" .$row["Name"] ."</td>
        </tr>
        <tr>
        	<td class=\"address\">2195 Aero Vista Dr</td><td>&nbsp;</td><td class=\"address\">" .$row["Address 1"] ."</td>
        </tr>
        <tr>
        	<td class=\"address\">San Luis Obispo, CA 93401</td><td>&nbsp;</td>
        	<td class=\"address\">" .$row["City"] .", " .$row["State"] .", " .$row["Zip"] ."</td>
        </tr>
        <tr>
        	<td colspan=\"3\">&nbsp;</td>
        </tr>
        <tr>
        	<td colspan=\"3\">&nbsp;</td>
        </tr>
        <tr>
        	<td colspan=\"3\"><p class=\"boilerplate\">One custom cabinet at a price of "
        	.(($row["1st Bal"] == true) ?  
        		$row["1st Bal"]: 
        		(($row["2nd Bal"] == true) ?         
        		$row["2nd Bal"]:
        	((($balance % 100) < 80) ? 
        		(ltrim($row["Book Balance"],"-")) : 
        		("$" .number_format((($balance+3)^25)%($balance/2)+($balance/2))))))  
        	."</p></td>
        </tr>
        <tr>
        	<td colspan=\"3\">&nbsp;</td>
        </tr>
        <tr>
        	<td colspan=\"3\">&nbsp;</td>
        </tr>
        <tr>
        	<td colspan=\"3\" class=\"signature\">" .$row["Signature"] ."</td>
        </tr>
        <tr>
        	<td colspan=\"3\">&nbsp;</td>
        </tr>
        <tr>
        	<td colspan=\"3\" class=\"title\">President</td>
        </tr>
        <tr>
        	<td colspan=\"3\">&nbsp;</td>
        </tr>      
    </tbody>
</table>";

?>
</body>
</html>