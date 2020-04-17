<?php  
if(empty($_GET['purchase_id']))
 exit('URLパラメータがありません ?purchase_id=2');

 require 'header.php';
 require '../connect.php'; 

 $sql = 'SELECT p.id,name,address,`created` 
 FROM purchase as p 
 LEFT JOIN customer as c 
 ON p.customer_id=c.id 
 WHERE p.id = ? ';

$stmt=$pdo->prepare( $sql );
$stmt->execute([ $_GET['purchase_id']]);
$row = $stmt->fetchAll();
echo "<li> {$row[0]['id']}"
 ,"<li> {$row[0]['name']}"
 ,"<li> {$row[0]['address']}"
 ,"<li> {$row[0]['created']}";

$sql = 'SELECT d.product_id,name ,price,count
 ,count * price as shokei
 FROM purchase_detail as d
 LEFT JOIN product as s
 ON s.id = d.product_id
 WHERE purchase_id = ? ';

$stmt=$pdo->prepare( $sql );
$stmt->execute([ $_GET['purchase_id']]);

echo '<table border="1">';
foreach ($stmt as $row) {
  echo "<tr> <td>{$row['product_id']}</td> <td>{$row['name']}</td>
   <td>{$row['price']}</td> <td>{$row['count']}</td>  <td>{$row['shokei']}</td> </tr>
  ";
}
echo '</table>';