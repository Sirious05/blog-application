<?php
require_once('./functions.php');
function takePaginationRecord($conn)
{
    $currentPage = 0;
    $lengthRecords = 2;
    if (isset($_GET['page'])) {
        $currentPage = (int) $_GET['page'];
    }
    $sql = "SELECT * FROM goods LIMIT $lengthRecords OFFSET " . $lengthRecords * $currentPage;
    $result = mysqli_query($conn, $sql);
    if ($_GET['page'] > (length($conn) / $lengthRecords)) {
        return false;
    }
    return $result;
}
