<?php
echo "<nav>";
echo "<ul class='pagination mt-3'>";

// button for first page
if($page > 1){
    echo "<li class='page-item btn-success'>
            <a class='page-link' href='{$page_url}' title='Go to the first page.'>
                First
            </a>
          </li>";
}

// calculate total pages
$total_pages = ceil($total_rows / $records_per_page);

// range of links to show
$range = 2;

// display links to 'range of pages' around 'current page'
$initial_num = $page - $range;
$condition_limit_num = ($page + $range) + 1;

for ($x = $initial_num; $x < $condition_limit_num; $x++) {

    if (($x > 0) && ($x <= $total_pages)) {

        // current page
        if ($x == $page) {
            echo "<li class='page-item active' aria-current='page'>
                    <span class='page-link'>
                        $x
                        <span class='visually-hidden'>(current)</span>
                    </span>
                  </li>";
        }
        // other pages
        else {
            echo "<li class='page-item'>
                    <a class='page-link' href='{$page_url}page=$x'>$x</a>
                  </li>";
        }
    }
}

// button for last page
if($page < $total_pages){
    echo "<li class='page-item'>
            <a class='page-link' href='" .$page_url. "page={$total_pages}' title='Last page is {$total_pages}.'>
                Last
            </a>
          </li>";
}

echo "</ul>";
echo "</nav>";
?>
