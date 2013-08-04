<?php

header("Content-Type: text/html;charset=utf-8");

$sourceId = $_GET["src"];

include 'db.php';

	function isNewArticle($link, $dblink) {
            $query = "select count(*) count from article where link=?";
            $stmt = $dblink->prepare($query) or die('Problem preparing query');
            $stmt->bind_param("s", $link);
            $stmt->execute();
            $stmt->bind_result($result);
            $stmt->fetch();  
            $stmt->close();
            //echo $result;
            return $result;
	}	

	function newArticle($link, $title, $sourceId, $dblink) {
            $query = "insert into article (id_source, title, link) values (?, ? , ?)";
            $stmt = $dblink->prepare($query) or die('Problem preparing query');
            $stmt->bind_param("iss", $sourceId, $title, $link);
            if (!$stmt->execute())
                echo "Faculty Execute failed: (" . $dblink->errno . ") " . $dblink->error;
            $articleId = $stmt->insert_id;
            $stmt->close();
            return $articleId;
	}	

	function newKeyword($articleId, $token, $dblink) {
            $query = "insert into keyword (id_article, value) values (?, ?)";
            $stmt = $dblink->prepare($query) or die('Problem preparing query' . $dblink->errno . ") " . $dblink->error);
            $stmt->bind_param("is", $articleId, $token);
            if (!$stmt->execute())
                echo "Faculty Execute failed: (" . $dblink->errno . ") " . $dblink->error;
            $articleId = $stmt->insert_id;
            $stmt->close();
            return $keywordId;
	}	

	function getSourceUrl($sourceId, $dblink) {
            $query = "select link from source where id=?";
            $stmt = $dblink->prepare($query) or die('Problem preparing query');
            $stmt->bind_param("i", $sourceId);
            $stmt->execute();
            $stmt->bind_result($result);
            $stmt->fetch();  
            $stmt->close();
            //echo $result;
            return $result;
	}
$sourceUrl = getSourceUrl($sourceId, $dblink);
echo "sourceUrl=" . $sourceUrl . "<br>";
//$sourceUrl = 'http://clarin.feedsportal.com/c/33088/f/577681/index.rss';

$dom = new DOMDocument('1.0', 'UTF-8');
$dom->strictErrorChecking = FALSE;
$dom->preserveWhiteSpace = FALSE; // change to FALSE to see the difference
$dom->load($sourceUrl);
foreach ($dom->getElementsByTagName('item') as $item) {
    $title = "";
    $link = "";
    foreach($item->childNodes as $node) {
        $nodeName = $node->nodeName;
        if ($nodeName == "title") {
            $title = $node->nodeValue;
        } else if ($nodeName == "guid") {
            $link = $node->nodeValue;
        }
        //$node->nodeType,
        //$nodeValue = $node->nodeValue;
    }
    $newArticle = isNewArticle($link, $dblink);
    if ($newArticle == 0) {
        $articleId = newArticle($link, $title, $sourceId, $dblink);
        $filteredTitle = preg_replace ("/[^a-zA-Z0-9áéíóúñÑÁÉÍÓÚüÜ ]/", "", $title);
        $tokens = preg_split("/[\s,]+/", $filteredTitle);
        foreach ($tokens as $token) {
            if (strlen($token) > 3) {
                echo $token . "<br>";
                $keywordId = newKeyword($articleId, $token, $dblink);
            }
        }        
    }
}

$dblink->close();


?>
