<?php
    include 'dbconfing.php';
    session_start();
    $conn=mysqli_connect($dbconfing['host'],$dbconfing['user'],$dbconfing['password'],$dbconfing['name']);
    $query = "SELECT * FROM comments";
    $res = mysqli_query($conn, $query);
    $postArray = array();
    $user_id = $_SESSION['user_id'];
    while($row = mysqli_fetch_assoc($res)){
        $post_id = $row['post_id'];
        $query_controllo ="SELECT * FROM likes WHERE user= $user_id AND comment= $post_id";
        $controllo = mysqli_query($conn,$query_controllo) or die(mysqli_error($conn));
        if(mysqli_num_rows($controllo)>0){
            $postArray[] = array('user_id' => $row['user_id'],'post_id' => $row['post_id'],'username' => $row['username'], 'commento' => $row['commento'], 'n_like' => $row['n_like'], 'controllo' => 1);
        }else{
            $postArray[] = array('user_id' => $row['user_id'],'post_id' => $row['post_id'],'username' => $row['username'], 'commento' => $row['commento'], 'n_like' => $row['n_like'], 'controllo' => 0);
        }
       // $postArray[] = array('user_id' => $row['user_id'],'post_id' => $row['post_id'],'username' => $row['username'], 'commento' => $row['commento'], 'n_like' => $row['n_like'],'like' => true);
        //array_push($postArray,$row);
    }

    echo json_encode($postArray);
    mysqli_close($conn);


?> 