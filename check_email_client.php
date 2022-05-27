<?php
    include 'dbconfing.php';
    $conn=mysqli_connect($dbconfing['host'],$dbconfing['user'],$dbconfing['password'],$dbconfing['name']);
    $email = mysqli_real_escape_string($conn,$_GET['q']);
    //Genero la query
    $query = "SELECT username FROM utenti WHERE email = '$email' ";
    //Eseguo la query
    $res=mysqli_query($conn,$query) or die(mysqli_error($conn));
    //Ritorno alla richiesta un JSON che contiene un valore che ci permette di determinare se il valore esiste o no
    if(mysqli_num_rows($res) > 0){
        $response = array('exist' => true);
    }
    else{
        $response = array('exist' => false);
    }
    echo json_encode($response);
  
    mysqli_close($conn);
?>