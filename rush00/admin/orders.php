<?php
session_start();

include_once $_SERVER["DOCUMENT_ROOT"] . "/database/connect.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/admin/functions.php";

if ( !is_admin() ) {
    header("Location: /admin/index.php");
    exit;
}
$content = "<a class='admin__link' href='/admin/order.php'>New order</a>";

$result = mysqli_query($mysqli,
    "SELECT
    order_id AS id, order_contents AS 'order', order_total AS 'sum', order_name AS client, order_phone AS phone, order_address AS 'address'
    FROM $orders ORDER BY id"
);
$orders_array = mysqli_fetch_all($result, MYSQLI_ASSOC);

if ($orders_array) {
    $content .=
<<<HTML
    <table class='admin__table'>
        <tr>
HTML;
    $columns = array_keys($orders_array[0]);
    foreach ($columns as $column)
        $content .= "<th>" .ucfirst($column). "</th>";
        $content .= "<th>Controls</th>";
        $content .= "<tr>";

    foreach ($orders_array as $order) {
        $content .= "<tr>";
        foreach ($order as $key => $value) {
            $content .= "<td>$value</td>";
        }
        $content .= "<td>";
        $content .= "<a class='admin__edit' href='/admin/order.php?id=" .$order["id"]. "'>Edit</a>";
        $content .= " " . "<a class='admin__delete' href='/admin/methods/deleteOrder.php?id=" .$order["id"]. "'>Delete</a>";
        $content .= "</td>";
        $content .= "</tr>";
    }
    $content .= "</table>";
} else
    $content .= "<div class='admin__status'>No orders.</div>";

include $_SERVER["DOCUMENT_ROOT"] . "/admin/templates/admin.php";
