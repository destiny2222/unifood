<?php

$file = 'ProductList.xls';
$html = file_get_contents($file);

$dom = new DOMDocument();
@$dom->loadHTML($html);

$tables = $dom->getElementsByTagName('table');
if ($tables->length == 0) {
    die("No table found\n");
}

$table = $tables->item(0);
$rows = $table->getElementsByTagName('tr');

$fp = fopen('ProductList.csv', 'w');

foreach ($rows as $row) {
    $cols = $row->getElementsByTagName('th');
    if ($cols->length == 0) {
        $cols = $row->getElementsByTagName('td');
    }
    
    $data = [];
    foreach ($cols as $col) {
        $data[] = trim($col->textContent);
    }
    fputcsv($fp, $data);
}

fclose($fp);
echo "Converted to ProductList.csv\n";
