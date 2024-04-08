<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Entry</title>
</head>
<body>
		<a href="home.php">
	<img src="../logo.png" alt="PunkCloud Logo" width="auto" height="auto">
    	</a> 
    <h1>Add Entry</h1>
	<form action="tools/insertEntry.php" method="post">
		<label>English Name: </label><input type="text" name="eng_name"><br>
		<label>Romanized Name: </label><input type="text" name="rom_name"><br>
		<label>Image Path: </label><input type="file" name="image"><br>
		<label>Status: </label><select name="status">
			<option>Unaired</option>
			<option>Airing</option>
			<option>Completed</option>
		</select><br>
		<label>Episode Number: </label><input type="number" name="epi_num"><br>
		<label>Start Date: </label><input type="date" name="start_date"><br>
		<label>End Date: </label><input type="date" name="end_date"><br>
		<label>Air Season: </label><select name="air_season">
			<option></option>
			<option>Summer 2024</option>
			<option>Spring 2024</option>
			<option>Winter 2024</option>
			<option>Fall 2023</option>
			<option>Summer 2023</option>
			<option>Spring 2023</option>
			<option>Winter 2023</option>
		</select><br>
		<label>Demographic: </label><select name="demographic">
			<option></option>
			<option>Josei</option>
			<option>Kids</option>
			<option>Seinen</option>
			<option>Shoujo</option>
			<option>Shounen</option>
		</select><br><br>
		<button type="submit" name="submit">Submit</button>
	</form>
</body>
</html>