<html>
	<head>
		<title>RESIDENCE DELETE</title>
	</head>
	
	<body>
		<h1> Что удалить? </h1>
		<h2><p><a href="/residence.php">Назад</a></p></h2>
		<h2>Введите ID</h2>
		<ul>
			<form name="insert" action = "residencedelete.php" method="POST">
			<br>ID:</br><br><input type = "text" name = "id_residence"/></br>
			<br><input type = "submit" /></br>
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
	
	$q = 'select * from "Residence"';
	querryTool($pdo, $q);
	
	$id_residence = $_POST['id_residence'];
	$q = "delete from \"Residence\" where \"id_residence\"=$id_residence";
	$query = $pdo->prepare($q);
	$result = $query->execute();
	
?>