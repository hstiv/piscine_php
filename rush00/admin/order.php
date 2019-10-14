<?php
session_start();

include_once $_SERVER["DOCUMENT_ROOT"] . "/database/connect.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/database/functions.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/admin/functions.php";

if ( !is_admin() ) {
    header("Location: /admin/index.php");
    exit;
}

/* If id - edit, else create new product */
$id = isset( $_GET["id"] ) ? filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT) : "";
if ($id) {
    $result = mysqli_query($mysqli,
    "SELECT
    order_contents AS 'order', order_total AS 'sum', order_name AS client, order_phone AS phone, order_address AS 'address'    
    FROM $orders WHERE order_id = $id");
    $order = mysqli_fetch_assoc($result);
}
if (gettype($order["order"]) == "array")
    $order["order"] = serialized_to_order($order["order"]);

$result = mysqli_query($mysqli,
    "SELECT
    order_contents AS 'order', order_total AS 'sum', order_name AS client, order_phone AS phone, order_address AS 'address'
    FROM $orders LIMIT 1"
);
$columns = array_keys( mysqli_fetch_assoc($result) );

switch ($_GET["result"]) {
    case "0":
        $error = "<div class='admin__error'>Couldn't update database.</div>";
        break;
    case "1":
        $error = "<div class='admin__success'>Successfully updated database.</div>";
        break;
    case "2":
        $error = "<div class='admin__error'>Incorrect information provided.</div>";
        break;
    default:
        break;
}

$header = "<h2>" .($id ? "Edit Order #" .$id : "Create new Order"). "</h2>";
$action = $id ? "/admin/methods/editOrder.php?id=$id" : "/admin/methods/newOrder.php";
$content .= 
<<<HTML
    $header
    $error
    <form class="admin__form" action=$action method="POST">
        <input type="hidden" name="id" value="$id">
HTML;

foreach ($columns as $column) {
    $content .= ucfirst($column). ": ";
    if ($column == "category") 
        $content .= $select;
    else
        $content .= "<input class='admin__input' type='text' name='$column' value='$order[$column]' required>";
    $content .= "<br>";
}

$content .=
<<<HTML
        <br>
        <input class="admin__button admin__button_submit" type="submit" name="submit" value="OK">
    </form>
HTML;

include $_SERVER["DOCUMENT_ROOT"] . "/admin/templates/admin.php";