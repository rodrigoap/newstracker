<?php

include 'db.php';

$query = '
select a.link, a.title, kva.value, kva.count from article a,
	(SELECT k.id_article, k.value, kv.count from keyword k,
		(SELECT count(id_article) count, value from keyword GROUP BY value) kv
	where k.value = kv.value) kva
where a.id = kva.id_article and count > 1
ORDER BY count desc, value desc';

$result = $dblink->query($query);

$keyword = "";
$keywordList = "";
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $currentLeyword = $row['value'];
    if ($currentLeyword == $keyword){
    } else {
        echo $keyword;
        echo "<br><br>";
        $keyword = $currentLeyword;
    }
    echo "<a href='".$row['link']."'>" . $row['title'] . "</a>";
    echo "<br>";
}

$result->close();

?>