<!DOCTYPE html>
<html lang="en" style="background-color: #222425">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Entry</title>
</head>
<body>
		<a href="home.php">
	<img src="../images/icons/logo.png" alt="PunkCloud Logo" width="auto" height="auto">
    	</a> 
    <h1>Add Entry</h1>
	<form action="tools/insertEntry.php" method="post">
		<label>English Name: </label><input type="text" name="eng_name"><br>
		<label>Romanized Name: </label><input type="text" name="rom_name"><br>
		<label>Image Path: </label><input type="file" name="image"><br>
		<button type="submit" name="submit">Submit</button>
	</form>
</body>
</html>