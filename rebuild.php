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

        function newGroupEntry($idArtFrom, $idArtTo, $dblink) {
            $query = "insert into groups values (?, ?)";
            $stmt = $dblink->prepare($query) or die('Problem preparing query' . $dblink->error);
            $stmt->bind_param("ii", $idArtFrom, $idArtTo);
            if (!$stmt->execute())
                echo "Execute failed: (" . $dblink->errno . ") " . $dblink->error;
            $stmt->close();
	}	

$dblink->query("truncate groups");


$query = 'select * from  
(select  count(k1.value) count, k1.id_article id_article_1, k2.id_article id_article_2 from keyword k1, keyword k2 
  where k1.id_article > k2.id_article and lower(k1.value) = lower(k2.value)
  group by id_article_1, id_article_2 order by count desc) kk
where COUNT > 2 order by id_article_1 desc';

$result=$dblink->query($query);

$alreadyAdded = array();
$lastFromId = -1;
$sourceId = 1;
while($row=$result->fetch_assoc()) {
    $artFromId = $row['id_article_1'];
    $artToId = $row['id_article_2'];
    if ($lastFromId != $artFromId) {
        if (in_array($artFromId, $alreadyAdded)) {
        } else {
            $articleFrom = getArticle($artFromId, $dblink);
            $lastFromId = $articleFrom['id'];
            echo "<br>";
            echo "<br>";
            echo "<br>-------------------------------------------------------------<br>";
            echo "$artFromId<a href='".$articleFrom['link']."'><img width='16px' height='16px' src='images/source-".$articleFrom['id_source']."'/>" . $articleFrom['title'] . "</a>";
        }
    }
    if (in_array($artToId, $alreadyAdded)) {
    } else {
        array_push($alreadyAdded, $artToId);
        $articleTo = getArticle($artToId, $dblink);
        echo "<br>";
        echo "$artToId<a href='".$articleTo['link']."'><img width='16px' height='16px' src='images/source-".$articleTo['id_source']."'/>" . $articleTo['title'] . "</a>";
        newGroupEntry($artFromId, $artToId, $dblink);
    }    
}

$result->close();

?>
        
    </body>    
</html>