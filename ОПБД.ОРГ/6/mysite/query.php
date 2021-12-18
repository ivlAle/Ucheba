<html>
	<head>
		<title>HOTEL QUERY</title>
	</head>
	
	<body>
		<h1> Запросы </h1>
		<h2><p><a href="/">Назад</a></p></h2>
		
	</body>
</html>
<?php
	

	$dbuser = 'postgres';
	$dbpass = '1234';
	$host = 'localhost';
	$dbname = 'postgres';
	
	$pdo = new PDO("pgsql:host=$host;dbname=$dbname",$dbuser,$dbpass);
	
	
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
	
	echo '1.Вывести количество комнат каждого типа.';
	$q = 'select count(*), "Type_Room" from "Room" group by "Type_Room"';
	querryTool($pdo, $q);
	
	echo '2.Вывести сумму, которую потратил клиент «2» за все время.';
	$q = 'select sum("Total_cost") from "List_of_Services" where "id_customer" = 2';
	querryTool($pdo, $q);
	
	echo '3.Вывести Номер, Имя уборщика и Дату уборки.';
	$q = 'select "ID_Room", "Name_Employee", "Cleaning_Date" from "Room" as a, "Cleaning" as b, "Hotel_Employee" as c
where "a"."Floor_Room" = "b"."Cleaning_Floor" and "b"."id_employee" = "c"."ID_Employee"';
	querryTool($pdo, $q);
	
	echo '4.Вывести кол-во клиентов, которых заселил каждый администратор.';
	$q = 'select count(*), "Name_Admin" from "Residence" as "r", "Admin" as "a" where "r"."id_admin" = "a"."ID_Admin" group by "Name_Admin"';
	querryTool($pdo, $q);
	
	echo '5.Вывести имена клиентов и сотрудников, которые предоставляли им услуги.';
	$q = 'select "Name_Customer", "Name_Employee" from "Customer" as c, "Hotel_Employee" as h, "List_of_Services" as l where "c"."ID_Customer" = "l"."id_customer" and "l"."id_employee" = "h"."ID_Employee"';
	querryTool($pdo, $q);
	

?>