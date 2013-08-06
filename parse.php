<?php

$sourceUrl = 'http://www.infobae.com/rss/hoy.xml';

$dom = new DOMDocument('1.0', 'UTF-8');
$dom->strictErrorChecking = FALSE;
$dom->preserveWhiteSpace = FALSE; // change to FALSE to see the difference
$dom->load($sourceUrl);
foreach ($dom->getElementsByTagName('item') as $item) {
    foreach($item->childNodes as $node) {
        $nodeName = $node->nodeName;
        echo $nodeName;
        echo "<br>";
    }
}
?>
