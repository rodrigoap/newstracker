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
	function getArticlesKeywords($articleIdFrom, $articleIdTo, $dblink) {
            $query = "select keyword from keyword_article_xref where id_article_from=" . 
                    $articleIdFrom . " and id_article_to=" . $articleIdTo;
            
            $result = $dblink->query($query);
            $keywords = array();
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                array_push($keywords, $row["keyword"]);
            }
            return $keywords;
	}



$query = 'select * from groups order by id_article_from desc';

$result=$dblink->query($query);

$lastFromId = -1;
$sourceId = 1;
while($row=$result->fetch_assoc()) {
    $artFromId = $row['id_article_from'];
    $artToId = $row['id_article_to'];
    if ($lastFromId != $artFromId) {
        $articleFrom = getArticle($artFromId, $dblink);
        $lastFromId = $articleFrom['id'];
        echo "<br>";
        echo "<br>";
        echo "<br>-------------------------------------------------------------<br>";
        echo "$artFromId<a href='".$articleFrom['link']."'><img width='16px' height='16px' src='images/source-".$articleFrom['id_source']."'/>" . $articleFrom['title'] . "</a>";
    }
    $articleTo = getArticle($artToId, $dblink);
    echo "<br>";
    echo "$artToId<a href='".$articleTo['link']."'><img width='16px' height='16px' src='images/source-".$articleTo['id_source']."'/>" . $articleTo['title'] . "</a>";
    echo "<br>";
    $keywords = getArticlesKeywords($artFromId, $artToId, $dblink);
    foreach ($keywords as $kw) {
        echo " | " . $kw;
    }
    echo " |<br>";
}

$result->close();

?>
        
    </body>    
</html>