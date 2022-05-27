<?php
    session_start();
    include 'dbconfing.php';

    $conn=mysqli_connect($dbconfing['host'],$dbconfing['user'],$dbconfing['password'],$dbconfing['name']);
    $query = "SELECT * FROM contents";
    $res=mysqli_query($conn, $query) or die(mysqli_error($conn)); 
    $postArray = array();
    while($row = mysqli_fetch_assoc($res)){
        array_push($postArray,$row);
    }

    echo json_encode($postArray);
    mysqli_close($conn);


?>