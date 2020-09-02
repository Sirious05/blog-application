<?php
require_once("./config.php");
function connect()
{
    $conn = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DBNAME);
    if (!$conn) {
        exit("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf-8");
    return $conn;
}
function close($conn)
{
    mysqli_close($conn);
}

function length($conn)
{
    $sql = "SELECT * FROM goods";
    $result = mysqli_query($conn, $sql);
    return (int) mysqli_num_rows($result);
}
function singleRecord($conn)
{
    if (!isset($_GET['id'])) {
        $id = 1;
        $sql = "SELECT * FROM goods WHERE id=" . $id;
        $result = mysqli_query($conn, $sql);
        $data = [];
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data['id'] = $row['id'];
                $data['name'] = $row['name'];
                $data['description'] = $row['description'];
                $data['image'] = $row['image'];
            }
        }
        return $data;
    } else {
        $id = $_GET['id'];
        $sql = "SELECT * FROM goods WHERE id=" . $id;
        $result = mysqli_query($conn, $sql);
        $data = [];
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data['id'] = $row['id'];
                $data['name'] = $row['name'];
                $data['description'] = $row['description'];
                $data['image'] = $row['image'];
            }
        }
        return $data;
    }
}
function insertDB($conn)
{
    $id = $_POST['id'];
    $title = $_POST['title'];
    $descr = $_POST['descr'];
    $img = $_FILES['img'];
    $sql = "INSERT INTO goods (id,name,description,image)
        VALUES ('" . $id . "', '" . $title . "', '" . $descr . "', '" . $img['name'] . "')";
    move_uploaded_file("{$img['tmp_name']}", "images/" . "{$img['name']}");
    mysqli_query($conn, $sql);
}
function clearImages($conn)
{
    $dir = './images/';
    $sql = "SELECT * FROM goods";
    $result = mysqli_query($conn, $sql);
    $serverImages = [];
    $localImages = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $serverImages[] = $row['image'];
        }
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    if ($file != "." && $file != "..") {
                        $localImages[] = $file;
                    }
                }
                closedir($dh);
            }
        }
        $waste = array_diff($localImages, $serverImages);
        foreach ($waste as $key => $value) {
            unlink($dir . $value);
        }
    }
    close($conn);
}
