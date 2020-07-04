<?php


function Arrange($count, $contents)
{
    $columns = 3; // 3 items in a row
    $rows = ceil($count / $columns);
    $remainder = $count % $columns;
    $postChunks = array_chunk($contents, $columns);
    $p=0;
    if ($remainder > 0) {
        $p=1;
    }

    foreach (array_slice($postChunks, 0, $rows-$p) as $posts) {
        echo('<div class="row">');
        foreach ($posts as $post) {
            echo('<div class="pricing-column col-md-4">');
            echo($post);
            echo('</div>');
        }
        echo('</div>');
    }

    if ($remainder > 0) {
        foreach (array_slice($postChunks, -1) as $remposts) {
            echo('<div class="row">');
            foreach ($remposts as $rempost) {
                echo('<div class="pricing-column col-md-' . 12/$remainder . '">');
                echo($rempost);
                echo('</div>');
            }
            echo('</div>');
        }
    }
}
