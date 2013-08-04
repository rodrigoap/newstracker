<?php
    header("Content-Type: text/html;charset=utf-8");

include 'db.php';

$query = "select * from keyword";
$q=$dblink->query($query);
while($r=$q->fetch_assoc()) {
    print_r($r);
    echo '<br>';
}

?>
