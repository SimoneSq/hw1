<?php
    session_start();
    header('Content-Type: application/json');
    include 'dbconfing.php';
  
    if(!empty($_POST['post_id'])){
        $conn=mysqli_connect($dbconfing['host'],$dbconfing['user'],$dbconfing['password'],$dbconfing['name']);
        $post_id =  mysqli_real_escape_string($conn, $_POST["post_id"]);
        $user_id = mysqli_real_escape_string($conn, $_SESSION["user_id"]);
        $query = "SELECT FROM likes WHERE user=$user_id AND comment = $post_id";
        $res = mysqli_query($conn,$query) or die(mysqli_error($conn));
        if(mysqli_num_rows($res)>0){
            $resp['like']=true;
            echo json_encode($resp);
        }else{
            $resp['like']=false;
            echo json_encode($resp);
        }
        mysqli_close($conn);
    }else{
        $resp['controllo']=false;
        echo json_encode($resp);
    }

?>