<html>
    <head>
        <title>Exercitiul 6 b.</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
.button {
  display: inline-block;
  padding: 10px 20px;
  font-size:  25px;
  cursor: pointer;
  text-align: center;	
  text-decoration: none;
  color: #000000;
  background-color: #C0C0C0;
  border: double;
}
table {
    text-align:center;
    margin: auto;
    border: double 10px;
    border-color: black;
}
body {
    background-color: #999999;
}
th {
    background-color: #C0C0C0;
    color: black;
    border: 3px;
}
td{
    border: solid 1px;
    border-color: black;
    width: auto;
    margin: 5px;
}
tr{
    text-align: center;
    margin: 5px;
    
}
</style> 
    </head>
	
    <body>
        <div>
		
			<p style="">Exercitiul 6 b.</p> 
            <a href="index.html" class="button">Inapoi</a>
        </div>
    </body>

<?php
// se precizează că se foloseşte PEAR DB
require_once('PEAR.php');
$user = 'root';
$pass = '';
$host = 'localhost';
$db_name = 'subiect 16';
// se stabileşte şirul pentru conexiune universală sau DSN
$dsn= new mysqli( $host, $user, $pass, $db_name);
// se verifică dacă a funcţionat conectarea
if ($dsn->connect_error)
{
	die('Eroare la conectare:'. $dsn->connect_error);
}
// se emite interogarea
$query = "
select nume, min(valoare) as minim, max(valoare) as maxim, avg(valoare) as medie
from ((Miscari join Carduri using (nrcard) ) join Conturi using (nrcont)) join Persoane using (idpers)
where data_nasterii >=str_to_date('01/01/1998','%m/%d/%Y') and data_nasterii <= str_to_date('12/31/1999','%m/%d/%Y') and data_ora >='01-Jan-2021 00:00:00' and data_ora <= '31-Dec-2022 23:59:59'
group by (nume);";
$result = mysqli_query($dsn, $query);
// verifică dacă rezultatul este în regulă
if (!$result)
{
	die('Interogare gresita :'.mysqli_error());
}
// se obţine numărul tuplelor returnate
$num_results = mysqli_num_rows($result);
// se afişează fiecare tuplă returnată
echo ' <Table style = "width:30%">
<tr>
 <th>Nr.crt.</th>
 <th>minim</th>
 <th>maxim</th>
 <th>medie</th>
 </tr>'; 
for ($i=0; $i <$num_results; $i++)
{
$row = mysqli_fetch_assoc($result);
echo '<tr><td>'.($i+1).'</td>';
echo '<td>'.stripslashes($row['minim']).'</td>';
echo '<td>'.stripslashes($row['maxim']).'</td>';
echo '<td>'.stripslashes($row['medie']).'</td>';
}
echo '</table>';
// deconectarea de la BD
//$db->disconnect();
mysqli_close($dsn);
?>
