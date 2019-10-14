<?php
/* This script is only run once to install database (create tables and fill it with data) */
include_once $_SERVER["DOCUMENT_ROOT"] . "/database/config.php";

/* Connect to server */
if ( !($mysqli = mysqli_connect( $db_host, $db_user, $db_passwd ) ) )
    exit("Error connectiong to mysql server.");

/* Create database */
mysqli_query($mysqli, "DROP DATABASE IF EXISTS $database");
if ( !mysqli_query($mysqli, "CREATE DATABASE $database") )
    exit("Error creating database.");
if ( !mysqli_select_db($mysqli, $database) )
    exit("Error selecting database.");
print("Database '$database' created.<br>");

/* Create tables */
$tables = [
    $user_groups => "group_id INT AUTO_INCREMENT PRIMARY KEY, group_name VARCHAR(255) NOT NULL UNIQUE",
    $users_table => "user_id INT AUTO_INCREMENT PRIMARY KEY, group_id INT NOT NULL, user_login VARCHAR(255) NOT NULL UNIQUE, user_password VARCHAR(255) NOT NULL, user_name VARCHAR(255), user_phone VARCHAR(255), user_address VARCHAR(255), FOREIGN KEY (group_id) REFERENCES $user_groups(group_id)",
    $categories => "category_id INT AUTO_INCREMENT PRIMARY KEY, category_name VARCHAR(255) NOT NULL UNIQUE",
    $products => "product_id INT AUTO_INCREMENT PRIMARY KEY, category_id INT NOT NULL, product_name VARCHAR(255) NOT NULL, product_description TEXT NOT NULL, product_price INT NOT NULL, product_photo VARCHAR(255), FOREIGN KEY (category_id) REFERENCES $categories(category_id)",
    $orders => "order_id INT AUTO_INCREMENT PRIMARY KEY, order_contents TEXT NOT NULL, order_total INT NOT NULL, order_name VARCHAR(255) NOT NULL, order_phone VARCHAR(255) NOT NULL, order_address VARCHAR(255) NOT NULL",
    $news => "news_id INT AUTO_INCREMENT PRIMARY KEY, news_title VARCHAR(255) NOT NULL, news_contents TEXT NOT NULL"
];
foreach ( $tables as $table => $options ) {
    if ( !( mysqli_query($mysqli, "CREATE TABLE $table (" . $options . ")") ) )
        exit("Error creating table '$table'.");
    print("Table '$table' created.<br>");
}

/* Add groups of users: superadmins, admins, users */
if ( !mysqli_query($mysqli, "INSERT INTO $user_groups VALUES (NULL, '$super_group'), (NULL, '$admin_group'), (NULL, '$user_group')") )
    exit("Error creating groups.");

/* Add superadmin */
$result = mysqli_query($mysqli, "SELECT group_id FROM $user_groups WHERE group_name = '$super_group'");
$super_groupid = mysqli_fetch_assoc($result)["group_id"];
$super_passwd = "root";
$hashed_passwd = hash("whirlpool", $super_passwd);
if ( !mysqli_query($mysqli, "INSERT INTO $users_table VALUES (NULL, $super_groupid, '$super_login', '$hashed_passwd', NULL, NULL, NULL)") )
    exit("Error creating '$super_login'.");
print("Superadmin created: $super_login:$super_passwd.<br>");

/* Add admin */
$result = mysqli_query($mysqli, "SELECT group_id FROM $user_groups WHERE group_name = '$admin_group'");
$admin_groupid = mysqli_fetch_assoc($result)["group_id"];
$admin_passwd = "admin";
$hashed_passwd = hash("whirlpool", $admin_passwd);
if ( !mysqli_query($mysqli, "INSERT INTO $users_table VALUES (NULL, $admin_groupid, '$admin_login', '$hashed_passwd', NULL, NULL, NULL)") )
    exit("Error creating admin.");
print("Admin created: $admin_login:$admin_passwd.<br>");

/* Add categories */
/* All goods are in /database/includes/goods.csv */
/* Format is as follows: title;category;description;price;photo*/
$handle = fopen($_SERVER["DOCUMENT_ROOT"] . "/database/includes/goods.csv", "r");
flock($handle, LOCK_SH);
$columns = fgetcsv($handle, 0, ";");
while ( ( $product = fgetcsv($handle, 0, ";") ) )
    $products_array[] = $product;
flock($handle, LOCK_UN);
/* array_column: return the values from a single column in the input array */
$categories_array = array_unique( array_column($products_array, 0) );
/* Reindex array (after array_unique we may have random keys) */
sort($categories_array);
$sql = "INSERT INTO $categories VALUES";
foreach ($categories_array as $i => $category) {
    $sql .= " (NULL, '$category')";
    if ($i < count($categories_array) - 1)
        $sql .= ", ";
}
if ( !( mysqli_query($mysqli, $sql) ) )
    exit("Error creating $categories.");

/* Add products */
$sql = "INSERT INTO $products VALUES";
foreach ($products_array as $i => $product) {
    $sql .= " (NULL" ;
    foreach ($product as $p => $column) {
        /* Replace values in products with keys from $categories_array (so they reference $categories table) */
        /* sql index id starts from 1 (array_search is 0 index-based) */
        if ( $p == 0 && ( $index = array_search($column, $categories_array) ) === FALSE )
            exit("Error creating $products (wrong category).");
        $sql .= ", " . ($p == 0 ? $index + 1 : '"'.$column.'"');
    }
    $sql .= ")";
    if ($i < count($products_array) - 1)
        $sql .= ", ";
}

if ( !( mysqli_query($mysqli, $sql) ) )
    exit("Error creating $products.");

mysqli_close( $mysqli );

print("Installation complete.");