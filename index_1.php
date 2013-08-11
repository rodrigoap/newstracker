<?php header("Content-Type: text/html;charset=utf-8");?>
<html>
    <head>
        <title>NewsTracker</title>
        <style>
            body { font-family: Arial, Helvetica, sans-serif; font-size: 11px}
        </style>
    </head>
    <body>
<?php

include 'db.php';

	function getArticle($articleId, $dblink) {
            $query = "select * from article where id=" . $articleId;
            $result = $dblink->query($query);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            return $row;
	}


$query = 'select * from  
(select  count(k1.value) count, k1.id_article id_article_1, k2.id_article id_article_2 from keyword k1, keyword k2 
  where k1.id_article < k2.id_article and k1.value= k2.value
  group by id_article_1, id_article_2 order by count desc) kk
where COUNT > 2 order by id_article_1';

$result=$dblink->query($query);

$lastFromId = -1;
$sourceId = 1;
while($row=$result->fetch_assoc()) {
    $artFromId = $row['id_article_1'];
    $artToId = $row['id_article_2'];
    if ($lastFromId != $artFromId) {
        $articleFrom = getArticle($artFromId, $dblink);
        $lastFromId = $articleFrom['id'];
        echo "<br>";
        echo "<br>";
        echo "<br>-------------------------------------------------------------<br>";
        echo "<a href='".$articleFrom['link']."'><img width='16px' height='16px' src='images/source-".$articleFrom['id_source']."'/>" . $articleFrom['title'] . "</a>";
    }
    $articleTo = getArticle($artToId, $dblink);
    echo "<br>";
    //echo 'to:' . $articleTo['title'];
    echo "<a href='".$articleTo['link']."'><img width='16px' height='16px' src='images/source-".$articleTo['id_source']."'/>" . $articleTo['title'] . "</a>";
    //echo "<br>";
}

$result->close();

?>
        
    </body>    
</html>