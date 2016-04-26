<?php

$sid = $_POST['submission_id'];
$formId = $_POST['formID'];
$ip = $_POST['ip'];
$companyname = $_POST['companyname'];
$companyurl = $_POST['companyurl'];
$category = $_POST['category'];
$commodity = $_POST['commodity'];


?>
<!DOCTYPE html>
<html>
<head>
<style>
	
</style>

</head>


<body>
 
 	<div>
 			<p>This is a simple PHP script that gets the value of the data via POST then output it here:</p>
 			<p>Submission ID is <?php echo $sid; ?></p>
 			<p>Form ID is <?php echo $formId; ?></p>
 			<p>Company's name is <?php echo $companyname; ?></p>
 			<p>Company's URL is <?php echo $companyurl; ?></p>
 			<p>Company category is <?php echo $category; ?></p>
 			<p>Commodity? <?php echo $commodity; ?></p>
 	</div>

<script>

	alert("Submission ID is <?php echo $sid; ?>");

</script>

</body>

</html>
