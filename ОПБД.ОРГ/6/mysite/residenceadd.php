<html>
	<head>
		<title>RESIDENCE ADD</title>
		<style>
			li {listt-style: none;}
		</style>
	</head>
	<body>
		<h2> Enter information for RESIDENCE</h2>
		<ul>
			<form name="insert" action="residenceadd.php" method="POST" >
				<li>Residence ID:</li><li><input type="text" name="id_residence"/></li>
				<li>Room ID:</li><li><input type="text" name="id_room"/></li>
				<li>Customer ID:</li><li><input type="text" name="id_customer"/></li>
				<li>Admin ID:</li><li><input type="text" name="id_admin"/></li>
				<li>Conditions:</li><li><input type="text" name="residence_conditions"/></li>
				<li>Date in:</li><li><input type="text" name="residence_date_in"/></li>
				<li>Date out:</li><li><input type="text" name="residence_date_out"/></li>
				<li><input type="submit" /></li>
				<h2><p><a href="/residence.php">Назад</a></p> <p><a href="/">Домой</a></p></h2>
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
	
	
	$id_residence = $_POST['id_residence'];
	$id_room = $_POST['id_room'];
	$id_customer = $_POST['id_customer'];
	$id_admin = $_POST['id_admin'];
	$residence_conditions = $_POST['residence_conditions'];
	$residence_date_in = $_POST['residence_date_in'];
	$residence_date_out = $_POST['residence_date_out'];
	
	$q = "INSERT INTO \"Residence\" VALUES 
	('$id_residence',
	'$id_room',
	'$id_customer',
	'$id_admin',
	'$residence_conditions',
	'$residence_date_in',
	'$residence_date_out')";

	$query = $pdo->prepare($q);
	$result = $query->execute();
	
	$q = 'select * from "Residence"';
	querryTool($pdo, $q);
?>