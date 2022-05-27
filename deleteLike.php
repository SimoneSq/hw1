<?php
    session_start();
    header('Content-Type: application/json');
    include 'dbconfing.php';
  
    if(!empty($_POST['post_id'])){
        $conn=mysqli_connect($dbconfing['host'],$dbconfing['user'],$dbconfing['password'],$dbconfing['name']);
        $post_id =  mysqli_real_escape_string($conn, $_POST["post_id"]);
        $user_id = mysqli_real_escape_string($conn, $_SESSION["user_id"]);
        $query = "DELETE FROM likes WHERE user=$user_id AND comment=$post_id";
        mysqli_query($conn, $query) or die(mysqli_error($conn)); 

        $resp['controllo']=true;
        echo json_encode($resp);
        mysqli_close($conn);
    }else{
        $resp['controllo']=false;
        echo json_encode($resp);
    }

?>