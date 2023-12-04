<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<br>
	<h3>Add new application</h3>
	<form action="includes/insert_application.php" method="POST">
		<input type="text" name="num" placeholder="Program Number">
		<br>
		<input type="text" name="uin" placeholder="Student UIN">
		<br>
		<input type="text" name="uncom" placeholder="Are you enrolled in any uncompleted certifications?">
		<br>
		<input type="text" name="com" placeholder="Have you completed any certifications?">
		<br>
		<input type="text" name="purpose" placeholder="Purpose statement">
		<br>
		<button type="submit" name="submit">Submit</button>
	</form>
		
	<br>
	<br>
	<br>
	<br>
	
	<h3>Edit existing application</h3>
	Edit response to "Have you completed any certifications with the Cybersecurity Center?"
	<form action="includes/edit_app_com.php" method="POST">
		<input type="text" name="appnum" placeholder="Application number">
		<br>
		<input type="text" name="com" placeholder="Answer here">
		<br>
		<button type="submit" name="submit">Submit</button>
	</form>
	<br>
	Edit response to "Are you enrolled in any uncompleted certifications with the Cybersecurity Center?"
	<form action="includes/edit_app_uncom.php" method="POST">
		<input type="text" name="appnum" placeholder="Application number">
		<br>
		<input type="text" name="uncom" placeholder="Answer here">
		<br>
		<button type="submit" name="submit">Submit</button>
	</form>
	<br>
	Edit purpose statement
	<form action="includes/edit_app_purpose.php" method="POST">
		<input type="text" name="appnum" placeholder="Application number">
		<br>
		<input type="text" name="purpose" placeholder="Purpose statement here">
		<br>
		<button type="submit" name="submit">Submit</button>
	</form>
	
	<br>
	<br>
	<br>
	<br>
	
	<h3>Remove application</h3>
	<form action="includes/remove_application.php" method="POST">
		<input type="text" name="appnum" placeholder="Application number">
		<br>
		<button type="submit" name="submit">Submit</button>
	</form>

	<br>
	<br>
	<br>
	<br>
	
	<h3>Review application</h3>
	<form action="includes/select_application.php" method="POST">
		<input type="text" name="uin" placeholder="Student UIN">
		<br>
		<button type="submit" name="submit">Submit</button>
	</form>

	
</body>
</html>