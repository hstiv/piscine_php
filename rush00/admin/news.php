<?php

session_start();

include_once $_SERVER["DOCUMENT_ROOT"] . "/database/connect.php";

if ( !is_admin() ) {
    header("Location: /admin/index.php");
    exit;
}

$content = "<a href='/admin/news_item.php'>Add news</a>";

$result = mysqli_query($mysqli, "SELECT * FROM $news");
$news_array = mysqli_fetch_all($result, MYSQLI_ASSOC);

if ($news_array) {
    $content .=
<<<HTML
    <table class='admin__table'>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Contents</th>
            <th>Controls</th>
        </tr>
HTML;
    foreach ($news_array as $i => $item) {
        $content .= "<tr>";
        $content .= "<td>" .$item["news_id"]. "</td>";
        $content .= "<td>" .$item["news_title"]. "</td>";
        $content .= "<td>" .$item["news_contents"]. "</td>";
        $content .= "<td>";
        $content .= "<a class='admin__edit' href='/admin/news_item.php?id=" .$item["news_id"]. "'>Edit</a>";
        $content .= " " . "<a class='admin__delete' href='/admin/methods/deleteNews.php?id=" .$item["news_id"]. "'>Delete</a>";
        $content .= "</td>";
        $content .= "</tr>";
    }
    $content .= "</table>";
} else
    $content .= "<div class='admin__status'>No news.</div>";

include $_SERVER["DOCUMENT_ROOT"] . "/admin/templates/admin.php";