<html>
	<head>
		<title>CLIENT ADD</title>
		<style>
			li {listt-style: none;}
		</style>
	</head>
	<body>
		<h2> Enter information for CLIENT</h2>
		<ul>
			<form name="insert" action="clientadd.php" method="POST" >
				<li>Client ID:</li><li><input type="text" name="ID_Customer"/></li>
				<li>Client Name:</li><li><input type="text" name="Name_Customer"/></li>
				<li>Client Passport:</li><li><input type="text" name="Passport_Number_Customer"/></li>
				<li>Client City:</li><li><input type="text" name="City_Customer"/></li>
				<li><input type="submit" /></li>
				<h2><p><a href="/client.php">Назад</a></p> <p><a href="/">Домой</a></p></h2>
			</form>
		</ul>
	</body>
</html>
<?php
	
	$dbuser = 'postgres';
	$dbpass = '1234';
	$host = 'localhost';
	$dbname = 'postgres';
	
	$pdo = new PDO("pgsql:host=$host;dbname=$dbname", $dbuser, $dbpass);
	
	function querryTool($pdo, $q){
		$result = $pdo->query($q);
		$result_mass = $result->fetchAll(pdo::FETCH_ASSOC);
		
		$keys = array_keys($result_mass[0]);
		echo"<table>";
		foreach($keys as $title){
			echo"<th>$title</th>";
		}
		
		echo "</tr>";
		foreach($result_mass as $line) {
			echo "<tr>";
			foreach($line as $col_value){
				echo "<td>$col_value</td>";
			}
			echo "</tr>";
		}
		echo "</table><br>";
	}
	
	
	$ID_Customer = $_POST['ID_Customer'];
	$Name_Customer = $_POST['Name_Customer'];
	$City_Customer = $_POST['City_Customer'];
	$Passport_Number_Customer = $_POST['Passport_Number_Customer'];
	
	$q = "INSERT INTO \"Customer\" VALUES 
	('$Name_Customer',
	'$City_Customer',
	'$ID_Customer',
	'$Passport_Number_Customer')";

	$query = $pdo->prepare($q);
	$result = $query->execute();
	
	$q = 'select * from "Customer"';
	querryTool($pdo, $q);
?>