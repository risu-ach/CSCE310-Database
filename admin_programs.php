<!-- Made by Matthew Edge -->
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<br>
	<h3>Add new program</h3>
	<form action="includes/insert_program.php" method="POST">
		<input type="text" name="num" placeholder="Program Number">
		<br>
		<input type="text" name="name" placeholder="Program Name">
		<br>
		<input type="text" name="desc" placeholder="Description">
		<br>
		<button type="submit" name="submit">Submit</button>
	</form>
		
	<br>
	<br>
	<br>
	<br>
	
	<h3>Edit existing program</h3>
	Edit progam name
	<form action="includes/edit_program_name.php" method="POST">
		<input type="text" name="num" placeholder="Program Number">
		<br>
		<input type="text" name="name" placeholder="New Name">
		<br>
		<button type="submit" name="submit">Submit</button>
	</form>
	<br>
	Edit program description
	<form action="includes/edit_program_desc.php" method="POST">
		<input type="text" name="num" placeholder="Program Number">
		<br>
		<input type="text" name="desc" placeholder="New description">
		<br>
		<button type="submit" name="submit">Submit</button>
	</form>
	
	<br>
	<br>
	<br>
	<br>
	
	<h3>Remove program</h3>
	<form action="includes/remove_program.php" method="POST">
		<input type="text" name="num" placeholder="Program Number">
		<br>
		<button type="submit" name="submit">Submit</button>
	</form>
	
	<br>
	<br>
	<br>
	<br>
	
	<h3>View program report</h3>
	<form action="includes/select_program.php" method="POST">
		<input type="text" name="num" placeholder="Program Number">
		<br>
		<button type="submit" name="submit">Submit</button>
	</form>
	
</body>
</html>