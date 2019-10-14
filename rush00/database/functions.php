<?php

function auth($login, $passwd) {
	global $mysqli, $users_table;
	
	if ( !( $result = mysqli_query( $mysqli, "SELECT user_password FROM $users_table WHERE user_login = '$login'") ) )
		return (false);
	$password = mysqli_fetch_row( $result )[0];

	return ( $password == hash("whirlpool", $passwd) );
}

function auth_admin($login, $passwd) {
	global $mysqli, $users_table, $super_group, $admin_group, $user_groups;
	
	$result = mysqli_query($mysqli, "SELECT group_id FROM $user_groups WHERE group_name = '$super_group'");
	$super_groupid = mysqli_fetch_assoc($result)["group_id"];
	$result = mysqli_query($mysqli, "SELECT group_id FROM $user_groups WHERE group_name = '$admin_group'");
	$admin_groupid = mysqli_fetch_assoc($result)["group_id"];
	if ( !( $result = mysqli_query( $mysqli, "SELECT user_password FROM $users_table WHERE user_login = '$login' AND group_id = '$super_groupid' OR group_id = '$admin_groupid'") ) )
		return (false);
	$password = mysqli_fetch_row( $result )[0];

	return ( $password == hash("whirlpool", $passwd) );
}

function is_logged() {
	return ( isset($_SESSION["logged_in_user"]) );
}

function is_admin() {
	return ( isset($_SESSION["admin"]) );
}

function is_root() {
	global $mysqli, $user_groups, $super_group;

	$result = mysqli_query($mysqli, "SELECT group_id FROM $user_groups WHERE group_name = '$super_group'");
	$super_groupid = mysqli_fetch_assoc($result)["group_id"];
	$superadmins = get_users( $super_groupid );

	foreach ($superadmins as $superadmin)
		if ( $_SESSION["logged_in_user"] == $superadmin["login"] )
			return (true);
	return (false);
}

function get_users( $groupid = null) {
	global $mysqli, $users_table, $user_groups;

	$sql = "SELECT user_id, user_login AS 'login', group_name AS 'group name', user_name AS 'name', user_phone AS 'phone', user_address AS 'address'
		FROM $users_table INNER JOIN $user_groups ON ".$users_table.".group_id = "."$user_groups".".group_id";
	if ( $groupid )
		$sql .= " WHERE $users_table.group_id = $groupid";
	$result = mysqli_query($mysqli, $sql);
	$users = mysqli_fetch_all($result, MYSQLI_ASSOC);
	
	return ($users);
}

function is_table( $table_name ) {
	global $mysqli, $database;

	$result = mysqli_query( $mysqli, "SHOW TABLES FROM $database");
	$tables = mysqli_fetch_all( $result, MYSQLI_ASSOC);
	foreach ($tables as $table) {
		if ( $table["Tables_in_shop"] == $table_name)
			return (true);
	}

	return (false);
}