<?php
    session_start();
    include 'dbconfing.php';

    if(!empty($_SESSION['username'])){
        header('Location: home.php');
        exit;
    }

    $valid = true;
    $pass_ver = true;
    $user_ver = true;
    //Caso sessione non attiva
    //Controllo se esistono username e password
    if(!empty($_POST['username']) && !empty($_POST['password'])){
    //Se sono stati settati, mi connetto al database
        $conn=mysqli_connect($dbconfing['host'],$dbconfing['user'],$dbconfing['password'],$dbconfing['name']) or die(mysqli_error($conn));
    //Assegno i valori a due variabili (Con L'SQL Injection)
        $username = mysqli_real_escape_string($conn,$_POST['username']);
    //Con la password, posso fare direttamente il login perche' ritorna qualcosa solo se sia l'user e la password sono verificate
    //$query = "SELECT username,password FROM utenti where username= '$username' AND password = '$password'";
        $password = mysqli_real_escape_string($conn,$_POST['password']);
    //Controllo se esistono nel server
        $query = "SELECT user_id,username,password FROM utenti where username = '$username'";
        $res = mysqli_query($conn,$query) or die(mysqli_error($conn));
        if(mysqli_num_rows($res)>0){
        //Copio le righe in un array associativo
            $entry = mysqli_fetch_assoc($res);
            //Controllo se l'utente e' quello registrato (Per evitare l'accesso a utenti con lettere maiuscole)
            if(strcmp($_POST['username'],$entry['username'])===0){
                $password_hash=password_hash($_POST['password'],PASSWORD_DEFAULT);
                //Verifico se la password e' corretta
                if(password_verify($entry['password'],$password_hash)){ //Verifica se le password sono uguali trasformando tutto in ASCII più sicuro
                    $_SESSION['username'] = $_POST['username'];
                    $_SESSION['user_id'] = $entry['user_id'];
                    header('Location: home.php');
                //Libero la memoria dai risultati
                    mysqli_free_result($res);
                    mysqli_close($conn);
                    exit;
                }else{
            //Gestisco il caso utente non trovato nel database o password errata
                    global $valid;
                    $valid=false;
                }
            }else{
                global $valid;
                $valid=false;
            }
        }
        else{
            global $valid;
            $valid=false;
        }
    }
// Gestione dei vari casi di informazioni mancanti
    if(!empty($_POST['username']) && empty($_POST['password'])){
        global $pass_ver;
        $pass_ver=false;
    }
    if(empty($_POST['username']) && !empty($_POST['password'])){
        global $user_ver;
        $user_ver=false;
    }
?>

<html>
    <head>
        <title>Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="login.css"/>
        <script src="login.js" defer></script>
    </head>
    
    <body>

        <header>
                <div id="logo">TysonLover</div>
        </header>

        <section>
            <main>
                <form name='form-login' method='post' id="main-item">
                    <h1>Login</h1>
                    <div id="div-login">
                       <!-- <label>Nome Utente</label> -->
                        <input type='text' id="input" name='username' placeholder="Nome utente">
                    </div>
                    <div id="div-login">
                       <!-- <label>Password</label> -->
                        <input type='password'id="input" name='password' placeholder="Password">

                    <!-- Gestione dei vari casi di mancato inserimento dei dati -->

                        <?php if($valid==false){
                        echo "<p id='errore'> Utente o password errato</p>";
                        }
                        if($pass_ver==false){
                            echo "<p id='errore'> Inserire password</p>";
                            }
                        if($user_ver==false){
                            echo "<p id='errore'> Inserire username</p>";
                        }
                        ?>


                    </div>
       
                    <button type='submit'>Accedi</button>
                </form>  
                <div id="iscrizione">
                        <p>Non hai un account?<a href="registrazione.php"> iscriviti</a><p>
                </div>
            </main>
        </section>

        <footer>
        <div id="logo-footer">TysonLover account</div>
        <div id="footer-info">O46001862 Squillaci Simone</div>
        </footer>
    </body>
</html>