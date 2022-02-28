<?php
include './simple_html_dom.php';



$coll = [];

for($i=1;$i<=73;$i++)
{
    $url = 'https://bincheck.org/russia?page=' . $i;
    $html = str_get_html(file_get_contents($url));

    if (is_bool($html)) {
        echo "Page {$i}: Failure" . PHP_EOL;
        continue;
    }

    $tbl = $html->find('table.table-bordered', 0);
    $tbody = $tbl->find('tbody', 0);

    foreach ($tbody->find('tr') as $tr) {

        $bin = [];
        foreach ($tr->find('td') as $td) {
            $bin[] = trim($td->plaintext);
        }

        if (count($bin) === 3) {
            $coll[$bin[2]] = $bin[0];
            echo 'Page ' . $i . ': ' . count($coll) . PHP_EOL;
        }
    }
}

file_put_contents('./bins.json', json_encode($coll));