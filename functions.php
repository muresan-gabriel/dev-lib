<?php

function check_login($con)
{
    if(isset($_SESSION['user_id']))
    {
        $id = $_SESSION['user_id'];
        $query = "select * from users where user_id = '$id' limit 1";

        $result = mysqli_query($con, $query);
        if($result && mysqli_num_rows($result) > 0)
        {
            $user_data = mysqli_fetch_assoc($result);
            return $user_data;
        }
    }

    // redirect to login
    header("Location: sign-in.php");
}

function get_assets($con)
{
    if(isset($_SESSION['user_id']))
    {
        $id = $_SESSION['user_id'];
        $query = "select * from assets where user_id = '$id'";

        $result = mysqli_query($con, $query);
        if($result && mysqli_num_rows($result) > 0)
        {
            $asset_data = mysqli_fetch_assoc($result);
            return $asset_data;
        }
    }
}

function get_user_details($con, $asset_user_id)
{
    if(isset($_SESSION['user_id']))
    {
        $query = "select * from users where user_id = '$asset_user_id'";
        $result = mysqli_query($con, $query);
            $asset_data = mysqli_fetch_assoc($result);
            return $asset_data;
    }

}

function get_all_assets($con, $asset_id)
{
    if(isset($_SESSION['user_id']))
    {
        $query = "select * from assets where id = '$asset_id'";

        $result = mysqli_query($con, $query);
        if($result && mysqli_num_rows($result) > 0)
        {
            $asset_data = mysqli_fetch_assoc($result);
            return $asset_data;
        }
    }
}

function get_profile_data($con, $user_id)
{
    if(isset($_SESSION['user_id']))
    {
        $query = "select * from users where user_id = '$user_id'";

        $result = mysqli_query($con, $query);
        if($result && mysqli_num_rows($result) > 0)
        {
            $asset_data = mysqli_fetch_assoc($result);
            return $asset_data;
        }
    }
}

function random_num($length)
{
    $text = "";
    if($length < 5)
    {
        $length = 5;
    }
    $len = rand(4,$length);
    for($i = 0; $i < $len; $i++) {
        $text .= rand(0,9);
    }

    return $text;
}

function get_username($login_function) {
    $user_data = $login_function;
    return $user_data['username'];
}

function get_name($login_function) {
    $user_data = $login_function;
    return $user_data['full_name'];
}

function get_bio($login_function) {
    $user_data = $login_function;
    return $user_data['bio'];
}

function get_website($login_function) {
    $user_data = $login_function;
    return $user_data['website'];
}

function get_password($login_function) {
    $user_data = $login_function;
    return $user_data['password'];
}

function get_email($login_function) {
    $user_data = $login_function;
    return $user_data['email'];
}

function get_role($login_function) {
    $user_data = $login_function;
    return $user_data['role'];
}

function get_profile_pic($login_function) {
    $user_data = $login_function;
    return $user_data['profile_picture'];
}


function get_id($login_function) {
    $user_data = $login_function;
    return $user_data['user_id'];
}

function get_asset_id($get_asset) {
    $asset_data = $get_asset;
    return $asset_data['id'];
}

function get_asset_name($get_asset) {
    $asset_data = $get_asset;
    return $asset_data['name'];
}


function get_asset_thumbnail($get_asset) {
    $asset_data = $get_asset;
    return $asset_data['thumbnail'];
}

function approve() {
    $id = $_POST['asset_id'];
    // update
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "auth-dev-lib";
    $dbport = "3306";
    $con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname, $dbport);
    $query = $con->prepare("update assets set status='approved' where id=?");
    if(!$query->bind_param("i", $_POST['asset_id'])) {
        die('{"success":false, "error":"Could not bind the parameters"}');
    }
    if(!$query->execute()) {
        die('{"success":false, "error":"mysql execute error: '.mysqli_error($db).'"}');
    }

    // redirect
    if($_SERVER['HTTP_REFERER']) {
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }
    else {
        header("Location: /");
    }
    die();
}
function decline() {
    $id = $_POST['asset_id'];
    // update
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "auth-dev-lib";
    $dbport = "3306";
    $con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname, $dbport);
    $query = $con->prepare("update assets set status='declined' where id=?");
    if(!$query->bind_param("i", $_POST['asset_id'])) {
        die('{"success":false, "error":"Could not bind the parameters"}');
    }
    if(!$query->execute()) {
        die('{"success":false, "error":"mysql execute error: '.mysqli_error($db).'"}');
    }

    // redirect
    if($_SERVER['HTTP_REFERER']) {
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }
    else {
        header("Location: /");
    }
    die();
}

function process() {
    $id = $_POST['asset_id'];
    // update
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "auth-dev-lib";
    $dbport = "3306";
    $con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname, $dbport);
    $query = $con->prepare("update assets set status='processing' where id=?");
    if(!$query->bind_param("i", $_POST['asset_id'])) {
        die('{"success":false, "error":"Could not bind the parameters"}');
    }
    if(!$query->execute()) {
        die('{"success":false, "error":"mysql execute error: '.mysqli_error($db).'"}');
    }

    // redirect
    if($_SERVER['HTTP_REFERER']) {
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }
    else {
        header("Location: /");
    }
    die();
}

function delete_asset() {
    $id = $_POST['asset_id'];
    // update
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "auth-dev-lib";
    $dbport = "3306";
    $con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname, $dbport);
    $query = $con->prepare("delete from assets where id=?");
    if(!$query->bind_param("i", $_POST['asset_id'])) {
        die('{"success":false, "error":"Could not bind the parameters"}');
    }
    if(!$query->execute()) {
        die('{"success":false, "error":"mysql execute error: '.mysqli_error($db).'"}');
    }

    // redirect
    if($_SERVER['HTTP_REFERER']) {
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }
    else {
        header("Location: /");
    }
    die();
}

if(isset($_POST['approve_asset'])) {
    approve();
}
if(isset($_POST['decline_asset'])) {
    decline();
}
if(isset($_POST['process_asset'])) {
    process();
}
if(isset($_POST['delete_asset'])) {
    delete_asset();
}

function delete() {
    $id = $_POST['user_id'];
    // update
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "auth-dev-lib";
    $dbport = "3306";
    $con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname, $dbport);
    $query = $con->prepare("delete from users where user_id=?;");
    if(!$query->bind_param("i", $_POST['user_id'])) {
        die('{"success":false, "error":"Could not bind the parameters"}');
    }
    if(!$query->execute()) {
        die('{"success":false, "error":"mysql execute error: '.mysqli_error($db).'"}');
    }


    $queryDelete = $con->prepare("delete from assets where user_id=?;");
    if(!$queryDelete->bind_param("i", $_POST['user_id'])) {
        die('{"success":false, "error":"Could not bind the parameters"}');
    }
    if(!$queryDelete->execute()) {
        die('{"success":false, "error":"mysql execute error: '.mysqli_error($db).'"}');
    }

    // redirect
    if($_SERVER['HTTP_REFERER']) {
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }
    else {
        header("Location: /");
    }
    die();
}
if(isset($_POST['delete_user'])) {
    delete();
}

?>
