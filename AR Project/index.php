
<!DOCTYPE html>

<html>
<head>
	<title>TAD'S AR PROJECT</title>
	<link rel="styleSheet" type="text/css" href="StyleSheet.css">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:900|Work+Sans:300" rel="stylesheet">
	<style>
		.center { 
			text-align: center; 
		}

		button {
			width: 9.75vw; 
			clear:both; 
			float:right;
			margin-right: 2.5vw; 
		}

		input {
			width: 9vw; 
			clear:both; 
			float:right;
			margin-right: 2.5vw; 
		}
	</style>
</head>


<body>

<br>

<p style="text-align:center; font-size: 1.5em;">

	<b>Welcome to the Accounts Receivable Project!</b><br>

</p>

<br>

<button type="button" 
		id="instructions" 
		onClick="window.open('instructions.php');">Instructions!</button>

<br>

<ul>
	<li class='center'>BOOKS</li>
	<li># of Accounts: 1,000</li>
	<li>Sum of Balances: $2,973,451.92</li>
	<li>Average Balance: $2,973.45</li>
	<li>Std. Dev of the Balances: $1,032.62</li>
</ul>

<br>

<ul>
	<li class='center'>SAMPLE</li>
	<form action="dataProcessing.php" method = "Post">
		<li>Enter the Required Sample Size: <input type="text" name="sampleSize"></input></li>
		<li>Enter the Last four Digits of your Student ID: <input type="text" name="studentID"></input></li>
		<li>Generate the Random Numbers for the Sample: <button id="randomSample" type="submit" value="submit">Generate Sample!</button></li>
	</form>
</ul>

</body>


</html>


