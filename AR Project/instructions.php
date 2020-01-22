<!DOCTYPE html>
<html>
<head>
	<title>Instructions!</title>
	<link rel="styleSheet" type="text/css" href="StyleSheet.css">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:900|Work+Sans:300" rel="stylesheet">
	<style>
		body {margin: 0px;}
		ul {list-style: none outside none; margin: 0px; padding: 0px; padding-bottom: 50px;
			width: 50%; margin-left: auto; margin-right: auto; border-top: solid;}
		li {width: 100%; margin: 0px; padding: 0px; border-width: 1px; padding-left: 0%; padding-right:0%; border: none; border-bottom: solid; border-radius: 0px;}
		/*div{width:50%; float:left; margin: 0px;}*/
	</style>
</head>
<body>

<br>

<p style="text-align:center; font-size: 1.5em;">

<b>Welcome to the Accounts Receivable Project!</b><br>

</p>

<br>

<ul>
	<div>
		<li>1. Calculate the required sample size and enter it on the Summary worksheet</li>
		<li>2. Enter the last four digits of your student ID on the Summary Worksheet</li>
		<li>3. Press the Generate Pushbutton to create a random sample of Account numbers</li>
		<li>4. Manually examine the first five confirmations. Each Confirmation can be found
		by clicking a button labelled "CONF".</li>
		<li>5. Press the 1st Balance button on the results page to receive the responses to the first requests</li>
		<li>6. Press the 2nd Balance button on the results page to receive the responses to the second requests</li>
	</div>
	<div>
		<li>7. For the "Audited Bal" inputs which are still empty, check to see if there is a Purchase Order,
		Bill of Lading, and Invoice for the account. If All three exist and the dollar amount for
		the Purchase Order matches the amount for the Invoice, then record that amount in the Audited Bal input area.<br>
		<span style="color:#e85d4e;">WARNING:</span> If either the Purchase Order or Invoice is missing, what does that tell us?<br>
		<span style="color:#e85d4e;">WARNING:</span> If the Purchase order amount does not match the Invoice amount, what does that tell us?
		What if the amounts don't match AND the Bill of Lading doesn't exist?<br>
		<span style="color:green;">TIP:</span> The Bill of Lading doesn't matter unless the Purchase Order and Invoice don't match. If a 
		product is on back-order, the Purchase Order and Invoice will match, but no Bill of Lading will have been created.</li>
		<li>8. Once all the "Audited Bal" input areas are filled, scroll to the bottom of the page and press the button labelled "Final Audit". If all of your entries are correct, the system will issue the final statistics needed to complete the project. If any entries are incorrect, the system will return an
		error and highlight any erroneous cells in red. Keep trying until the system tells you that the audit
		has been completed.</li>
	</div>
</ul>
										

</body>
</html>