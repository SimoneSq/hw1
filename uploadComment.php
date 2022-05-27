<?php
    session_start();
    header('Content-Type: application/json');
    include 'dbconfing.php';
  
    if(!empty($_POST['commento'])){
        $conn=mysqli_connect($dbconfing['host'],$dbconfing['user'],$dbconfing['password'],$dbconfing['name']);
        $commento =  mysqli_real_escape_string($conn, $_POST["commento"]);
        $user_id = mysqli_real_escape_string($conn, $_SESSION["user_id"]);
        $username = mysqli_real_escape_string($conn, $_SESSION['username']);
        $query = "INSERT INTO comments (user_id,username,commento,n_like) VALUES ($user_id,'$username','$commento',0)";
        mysqli_query($conn, $query); 
        $query_id = "SELECT post_id FROM comments ORDER BY post_id DESC LIMIT 1";
        $res=mysqli_query($conn, $query_id) or die(mysqli_error($conn)); 
        $post_idreq = mysqli_fetch_assoc($res);
        $resp['post_id']=$post_idreq['post_id'];
        $resp['controllo']=true;
        $resp['username']=$username;
        $resp['commento']=$commento;
        echo json_encode($resp);

        mysqli_close($conn);

    }else{
        $resp['controllo']=false;
        echo json_encode($resp);
    }


?>