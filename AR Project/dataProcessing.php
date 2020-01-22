<!DOCTYPE html>

<html>
<head>
	<title>AR Sample</title>
	<link rel="StyleSheet" type="text/css" title="universalStyle" href="StyleSheet.css">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:900|Work+Sans:300" rel="stylesheet">
	<script src="jstat.js"></script>
	
</head>
<body>

<script>

	// function formats numbers with "$" and adds thousands seperators
	function format(num) {
		return "$"
		+ num.toLocaleString().split(".")[0]
	    + "."
	    + num.toFixed(2).split(".")[1];
	} 

	let confCounter = 0;
	let confTranslater1 = 0;
	let confTranslater2 = 0;
</script>

<?php


// Receives sampleSize and studentID from form submission on index.php page
$sampleSize = $_POST['sampleSize'];
$studentID = $_POST['studentID'];
if ($sampleSize > 1000){
	$sampleSize = 1000;
}

$min = 1;
$max = 1000;
$samples = array();
$bookBalance = array();
$correctAuditList = array();

// Creates the correct number of primary keys with no duplicates
for($i = 1; $i <= $sampleSize; $i++){
	array_push ($samples, rand($min,$max));
}

$uniqueArray = array_unique($samples);
while (sizeof($uniqueArray) < $sampleSize){
	array_push ($uniqueArray, rand($min,$max));
	$uniqueArray = array_unique($uniqueArray);
}
sort($uniqueArray);

// Connects to database to get data associated with each primary key

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

// Creates array containing all values for the sample
$resultsArray = array();

foreach ($uniqueArray as &$value) {
$result = $conn->query("SELECT * FROM tad WHERE `number`='".$value."'");
$row = $result->fetch_assoc();
$rowArray = array();
array_push($rowArray,$row["number"]);
array_push($rowArray,$row["Name"]);
array_push($rowArray,$row["Address 1"]);
array_push($rowArray,$row["City"]);
array_push($rowArray,$row["State"]);
array_push($rowArray,$row["Zip"]);
array_push($rowArray,ltrim($row["Book Balance"],'-'));
array_push($rowArray,$row["Signature"]);
if($row["number"] % 100 < 50 && $row["number"] % 10 == 5){
	array_push($rowArray,"");
	array_push($rowArray,"");
} else {
	array_push($rowArray,ltrim($row["1st Bal"],'-'));
	array_push($rowArray,ltrim($row["2nd Bal"],'-'));
}
array_push($rowArray,$row["PO#"]);
array_push($rowArray,$row["Inv#"]);

array_push($resultsArray,$rowArray);

array_push ($bookBalance, $row["Book Balance"]);
}

//strips "$" and "," from strings, then converts to floats for calculation of starting sample statistics
for ($i = 0; $i <sizeof($bookBalance);$i++){
	$bookBalance[$i] = ltrim($bookBalance[$i], '-');
	$bookBalance[$i] = ltrim($bookBalance[$i], '$');
	$bookBalance[$i] = str_replace(",", "", $bookBalance[$i]);
	$bookBalance[$i] = floatval($bookBalance[$i]);
}

mysqli_close($conn);


// Adds the standard deviation function to PHP
if (!function_exists('stats_standard_deviation')) {
    /**
     * This user-land implementation follows the implementation quite strictly;
     * it does not attempt to improve the code or algorithm in any way. It will
     * raise a warning if you have fewer than 2 values in your array, just like
     * the extension does (although as an E_USER_WARNING, not E_WARNING).
     * 
     * @param array $a 
     * @param bool $sample [optional] Defaults to false
     * @return float|bool The standard deviation or false on error.
     */
    function stats_standard_deviation(array $a, $sample = false) {
        $n = count($a);
        if ($n === 0) {
            trigger_error("The array has zero elements", E_USER_WARNING);
            return false;
        }
        if ($sample && $n === 1) {
            trigger_error("The array has only 1 element", E_USER_WARNING);
            return false;
        }
        $mean = array_sum($a) / $n;
        $carry = 0.0;
        foreach ($a as $val) {
            $d = ((double) $val) - $mean;
            $carry += $d * $d;
        };
        if ($sample) {
           --$n;
        }
        return sqrt($carry / $n);
    }
}

?>
<!-- Link to Instructions -->
<button type="button" 
		id="instructions" 
		onClick="window.open('instructions.php');">Instructions!</button>
<!-- Table for starting Sample Statistics -->
<ul>
	<li>Sum of Sample Balances: 
		<script type="text/javascript">
			let sampleTotal = <?php echo array_sum($bookBalance); ?>;
			document.write(format(sampleTotal));
		</script>
	</li>
	<li>Average Sample Balance:
		<script type="text/javascript"> 
			let averageSample = <?php echo round(array_sum($bookBalance)/sizeof($bookBalance),2); ?>;
			document.write(format(averageSample));
		</script>		
	</li>
	<li>Std. Dev of the Sample Balances:  
		<script type="text/javascript">
			let stdSample = <?php echo round(stats_standard_deviation($bookBalance),2); ?>;
			document.write(format(stdSample));		
		</script>
	</li>
</ul>
<br>

<?php 

// creates table for data
echo
"<table>
	<tr>
		<th>Number</th>
		<th>Name</th>
		<th>Address</th>		
		<th>City</th>
		<th>State</th>
		<th>Zip</th>
		<th>Book Balance</th>
		<th>Signature</th>
		<th><button onclick=\"revealer1()\">1st Balance</th>  
		<th><button onclick=\"revealer2()\">2nd Balance</th>
		<th>PO #</th>
		<th>Bill of Lading</th>
		<th>Inv #</th>
		<th>Audited Bal</th>
	</tr>";

// Fills Data Table
$confNumber = 5;
$confChecker = false;
for($i =0;$i <sizeof($resultsArray);$i++){
	echo "<tr>";
	echo "<td>" .$resultsArray[$i][0] ."</td>";
	echo "<td>" .$resultsArray[$i][1] ."</td>";
	echo "<td>" .$resultsArray[$i][2] ."</td>";
	echo "<td>" .$resultsArray[$i][3] ."</td>";
	echo "<td>" .$resultsArray[$i][4] ."</td>";
	echo "<td>" .$resultsArray[$i][5] ."</td>";
	echo "<td>" .$resultsArray[$i][6] ."</td>";
	echo "<td>" .$resultsArray[$i][7] ."</td>";

	// Creates confirmations for the first five entries which contain confirmations
	// Checks to see if a customer sent a 1st confirmation, then reports it
	// If there is not a first confirmation, the code looks for a 2nd confirmation, then reports it
	// If no confirmation is found, then confNumber is increased by 1 to indicate that the program
	// needs to search for an additional customers confirmations. This process repeats until
	// five confirmations have been found, at which point the program stops looking for additional 
	// confirmations.

	if ($i < $confNumber 
		&& $resultsArray[$i][8] != null){
		echo
			"<td id = conf" .$i .">
				<form 
					id = confForm" .$i ."
					action=\"Conf1.php\" 
					target=\"_blank\" 
					method=\"get\">
				<input type=\"text\" 
					name=\"number\" 
					value=" .$resultsArray[$i][0] 
					." style=\"display:none\">
				<input type=\"text\" 
					id=\"Bal" .$i ."\" 
					value=" .$resultsArray[$i][8] 
					." style=\"display:none\">
				<input type=\"button\" 
					value=\"CONF\"
					onclick=\"confComplete(" .$i .",'" .$resultsArray[$i][8] ."',1)\">
				</form>
			</td>";
	} else {
		echo "<td><p class=\"hide1\">" .$resultsArray[$i][8] ."</p></td>";
		$confChecker = true;
	}

	if ($i < $confNumber 
		&& $resultsArray[$i][9] != null 
		&& $resultsArray[$i][8] == null){
		echo
			"<td id = conf" .$i .">
				<form 
					id = confForm" .$i ."
					action=\"Conf2.php\" 
					target=\"_blank\" 
					method=\"get\">
				<input type=\"text\" 
					name=\"number\" 
					value=" .$resultsArray[$i][0] 
					." style=\"display:none\">
				<input type=\"text\" 
					id=\"Bal" .$i ."\" 
					value=" .$resultsArray[$i][9] 
					." style=\"display:none\">
				<input type=\"button\" 
					value=\"CONF\"
					onclick=\"confComplete(" .$i .",'" .$resultsArray[$i][9] ."',2)\">
				</form>
			</td>";
	} else {	
		echo "<td><p class=\"hide2\">" .$resultsArray[$i][9] ."</p></td>";
		if ($confChecker == true) {
			$confNumber += 1;
		}
	}
	$confChecker = false; 


	// Adds the buttons for Purchase Order, Bill of Lading, and Invoice #

	echo "<td>" 
			."<form action=\"PO.php\" 
				target=\"_blank\" 
				method=\"get\">
			<input type=\"text\" 
				name=\"number\" 
				value=" .$resultsArray[$i][0] 
				." style=\"display:none\">
			<input type=\"submit\" 
				value=\"PO\">
			</form>" 
		."</td>";
	echo "<td>" 
			."<form action=\"BOL.php\" 
				target=\"_blank\" 
				method=\"get\">
			<input type=\"text\" 
				name=\"number\" 
				value=" .$resultsArray[$i][0] 
				." style=\"display:none\">
			<input type=\"submit\" 
				value=\"BOL\">
			</form>" 
		."</td>";
	echo "<td>" 
			."<form action=\"INV.php\" 
				target=\"_blank\" 
				method=\"get\">
			<input type=\"text\" 
				name=\"number\" 
				value=" .$resultsArray[$i][0] 
				." style=\"display:none\">
			<input type=\"submit\" 
				value=\"INV\">
			</form>" 
		."</td>";

	// stores correct audited Balance for verification against user input

	$correctAudit = 0;
	$calcBalance = floatval(str_replace(",","",ltrim(ltrim($resultsArray[$i][6], '-'),'$')));
	if ($resultsArray[$i][8] == true){
		$correctAudit = $resultsArray[$i][8];
	} else if ($resultsArray[$i][9] == true){
		$correctAudit = $resultsArray[$i][9];
	} else if ($resultsArray[$i][0] % 10 == 5){
		if (($resultsArray[$i][0] % 100) < 50){
		$correctAudit = 0;
		} else {
		$correctAudit = $resultsArray[$i][6];
		}
	} else if (($calcBalance % 100) < 80){
		$correctAudit = $resultsArray[$i][6];
	} else {
		$correctAudit = number_format((
			($calcBalance+3)^25)
			%($calcBalance/2)
			+($calcBalance/2));
	}

	array_push($correctAuditList, floatval(str_replace(",","",ltrim(ltrim($correctAudit, '-'),'$'))));

	// adds in input box for user's audited amounts

	echo "<td><input type=\"text\" id=\"audit" .$i ."\"></td>";
	echo "</tr>";
}

?>

<!-- Closes Sample Table -->

	<tr>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		<th>Final</th>
		<th>Submission</th>
		<th><button type="text" id="auditComplete" onClick='finalAudit()'>Final Audit</button></th>
	</tr>
</table>

<!-- Adds table for final audited amounts -->
<br>
<ul>
	<li id ='auditTotal'>
		Sum of Audited Sample Balances: 
	</li>
	<li id ='auditAverage'>
		Average Audited Sample Balance:	
	</li>
	<li id ='auditStd'>
		Std. Dev of the Audited Sample Balances:  
	</li>
	<li>
		Student ID: <?php echo $studentID; ?>
	</li>

</ul>
</div>

<script>

	// Checks to make sure the user has entered the correct amount into each customer's audited amount box
	// If any boxes are incorrect, returns an error and highlights incorrect boxes in red
	// All correct boxes are highlighted in green. Once all the entries are correct, a notification pops
	// up and the audited sample statistics are filled in automatically.

	function finalAudit(){
		let correctAmounts = <?php echo json_encode($correctAuditList); ?>;
		let data = [];
		let a = 0;
		let sampleSize = <?php echo $sampleSize; ?>;
		let failedAudit = false;
		for (let i = 0; i < sampleSize;i++){
			if (parseFloat((((document.getElementById("audit"+i).value)
				.replace('-',"")
				.replace('$',"")
				.replace(',',"")))) != correctAmounts[i]){
					failedAudit = true;
					document.getElementById("audit"+i).style.backgroundColor = "#e85d4e";
			} else {
			data.push(parseFloat((((document.getElementById("audit"+i).value)
				.replace('-',"")
				.replace('$',"")
				.replace(',',"")))));
			a += parseFloat((((document.getElementById("audit"+i).value)
				.replace('-',"")
				.replace('$',"")
				.replace(',',""))));
			document.getElementById("audit"+i).style.backgroundColor = "#7bc12e";
			}
		}
		if (failedAudit == true){
			window.alert("Audit Failed: One or more entries is incorrect");
			return;
		}
		window.alert("Congratulations! You did it!");
		console.log(data.toString());
		console.log(a);
		if (format(a) == '$NaN.undefined'){
			document.getElementById('auditTotal').innerHTML = 'Sum of Audited Sample Balances: N/A: Audited Balances not Complete.';
			document.getElementById('auditAverage').innerHTML = 'Average Audited Sample Balance: N/A: Audited Balances not Complete.'; 
			document.getElementById('auditStd').innerHTML = 'Std. Dev of the Audited Sample Balances: N/A: Audited Balances not Complete.';  
		} else {
			document.getElementById('auditTotal').innerHTML = 'Sum of Audited Sample Balances: ' 
				+ format(a); 
			document.getElementById('auditAverage').innerHTML = 'Average Audited Sample Balance: ' 
				+ format(a/sampleSize);
			document.getElementById('auditStd').innerHTML = 'Std. Dev of the Audited Sample Balances: ' 
				+ format(jStat.stdev(data));

		}
		return data;
	}

	// After the first five confirmations have been examined by the user, the 1st Bal and 2nd Bal 
	// buttons can be used to call revealer1 and revealer2. Each function reveals the results 
	// of the 1st and 2nd Confirmations across the whole sample, respectively. 

	function revealer1(){
		if (confCounter == 5){
			let reveal = document.getElementsByClassName('hide1');
			for (var i = 0; i < reveal.length; i++) {
				reveal[i].style.visibility='visible';
				let audit = document.getElementById("audit"+(i+confTranslater1)).value
				if (audit == ""){
					document.getElementById("audit"+(i+confTranslater1)).value = reveal[i].innerHTML;
				}
			}
		} else {
			window.alert("Sorry, you need to manually complete the first five Confirmations before you can generate the rest");
		}
	}

	function revealer2(){
		if (confCounter == 5){
			let reveal = document.getElementsByClassName('hide2');
			for (var i = 0; i < reveal.length; i++) {
				reveal[i].style.visibility='visible';
				let audit = document.getElementById("audit"+(i+confTranslater2)).value;
				if (audit == ""){
					document.getElementById("audit"+(i+confTranslater2)).value = reveal[i].innerHTML;
				}
			}
		} else {
			window.alert("Sorry, you need to manually complete the first five Confirmations before you can generate the rest");
		}
	}

	// Function transforms cells which have had confirmations buttons clicked inside of cell.
	// Also keeps track to see if all five confirmations have been completed, thus allowing 
	// the revealer functions to be used.

	function confComplete(rowNumber, value, column){
		document.getElementById("confForm"+rowNumber).submit();
		document.getElementById("conf"+rowNumber).innerHTML 
			= value;
		confCounter +=1;
		if (column == 1){
			confTranslater1 +=1;
		} else {
			confTranslater2 +=1;
		}
		let audit = document.getElementById("audit"+rowNumber).value;
		if (audit == ""){
			document.getElementById("audit"+rowNumber).value 
				= value;
		}
	}
	
</script>
</body>
</html>