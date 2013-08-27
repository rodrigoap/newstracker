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

        function newKeywordArticleRelation($keyword, $idArtFrom, $idArtTo, $dblink) {
            $query = "insert into keyword_article_xref values (?, ?, ?)";
            $stmt = $dblink->prepare($query) or die('Problem preparing query' . $dblink->error);
            $stmt->bind_param("sii", $keyword, $idArtFrom, $idArtTo);
            if (!$stmt->execute())
                echo "Execute failed: (" . $dblink->errno . ") " . $dblink->error;
            $stmt->close();
	}	

$dblink->query("truncate keyword_article_xref");


$query = 'select  k1.value keyword, k1.id_article id_article_1, k2.id_article id_article_2 from keyword k1, keyword k2 
  where k1.id_article > k2.id_article and lower(k1.value) = lower(k2.value)';

$result=$dblink->query($query);
$count = 0;
while($row=$result->fetch_assoc()) {
    $keyword = $row['keyword'];
    $artFromId = $row['id_article_1'];
    $artToId = $row['id_article_2'];
    newKeywordArticleRelation($keyword, $artFromId, $artToId, $dblink);
    $cout++;
}

$result->close();
echo "<br>";
echo "Done. Count=" . $count;
echo "<br>";
?>
        
    </body>    
</html>