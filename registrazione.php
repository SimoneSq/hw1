<?php
    session_start();

    include 'dbconfing.php';
    //Verifica che i campi non siano vuoti.
    if(!empty($_POST['nome']) && !empty($_POST['cognome']) && !empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password']) 
        && !empty($_POST['conf-password'])){
        
        $conn=mysqli_connect($dbconfing['host'],$dbconfing['user'],$dbconfing['password'],$dbconfing['name']);
        $error = array();

    //Controllo nome
    //Controlla se il nome rispetta il pattern (In questo caso se è composto solo da lettere minuscole/maiuscole)
        if(!preg_match('/^([a-zA-Z\xE0\xE8\xE9\xF9\xF2\xEC\x27]\s?)+$/', $_POST['nome'])){ 
            $error[]="Nome non valido";
        }
    //Controllo cognome
        if(!preg_match('/^([a-zA-Z\xE0\xE8\xE9\xF9\xF2\xEC\x27]\s?)+$/', $_POST['cognome'])){ 
            $error[]="Cognome non valido";
        }
    //Controllo username
        if(!preg_match('/^[a-zA-Z0-9_]{1,15}$/',$_POST['username'])){
            $error[] = "L'username contiene caratteri non consentiti"; 
        }
        //Se l'username e' valido, non deve essere presente nel database per essere registrato.
        else{
            $username = mysqli_real_escape_string($conn,$_POST['username']);
            $query = "SELECT username FROM utenti WHERE username = '$username' ";
            //Eseguo la query
            $res=mysqli_query($conn,$query);
            if(mysqli_num_rows($res)>0){ 
                $error[]= "Username già esistente";
            }
        }
    

        //Controllo password
        if(strlen($_POST["password"])<8){
            $error[]="Caratteri insufficienti";
        }
        if($_POST["password"] != $_POST["conf-password"]){
            $error[]="Errore conferma password";
        }

        //Controllo Email
        if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){//Applica un filtro all'email, controlla l'email come fa con l'username. In questo caso di default php controlla se l'email sia scritta in maniera corretta
            $error[]="E-mail non valida";
        } 
        //Controllo se l'email e' gia' stata inserita
        $email = mysqli_real_escape_string($conn,$_POST['email']);
        $query = "SELECT email FROM utenti WHERE email = '$email'";
        $res=mysqli_query($conn,$query);
        if(mysqli_num_rows($res)>0){
            $error[]="Email già utilizzata";
        }

        //Controllo numero errori & caricamento registrazione nel database
        if(count($error) == 0){
            $nome = mysqli_real_escape_string($conn,$_POST['nome']);
            $cognome = mysqli_real_escape_string($conn,$_POST['cognome']);
            $password = mysqli_real_escape_string($conn,$_POST['password']);

            $query = "INSERT INTO UTENTI(username,nome,cognome,email,password)
            VALUES('$username', '$nome', '$cognome', '$email', '$password')";
            //Eseguo la query e e controllo se ha successo
            if(mysqli_query($conn,$query)){
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['user_id'] = mysqli_insert_id($conn);

                header('Location: home.php');
                exit;
            }
        }
        //Ciclo per vedere se gli errori vengono letti
        /*else{
            foreach ($error as $err) {
                echo "$err <br>";
                }
        }*/
        
        mysqli_close($conn);
    }  
?>

<html>
    <head>
        <title>Registrazione</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="registrazione.css"/>
        <script src='registrazione.js' defer></script>
    </head>
    
    <body>

        <header>
                <div id="logo">TysonLover</div>
        </header>
        <main>
            <form name='form-register' method='post'>
                <h1>Registrazione</h1>
                <div class='div_register_utenti'>
                    <div class='label'>
                        <label>Nome</label>
                        <input type='text' id="input" name='nome' placeholder="Mario">
                        <span id="riga">.</span>
                        <span id="errore" class='hidden'>Nome mancante o non valido</span>
                    </div>
                    <div class='label_dex'>
                        <label>Cognome</label>
                        <input type='text' id="input" name='cognome' placeholder="Rossi">
                        <span id="riga_dex">.</span>
                        <span class='hidden' id="span_dex">Cognome mancante o non valido</span>

                    </div>
                </div>
                <div class='div_register'>
                    <label>Nome Utente <input type='text' id="input" name='username' placeholder="Inserire nome utente unico"></label>
                    <span id='username-span' class='hidden'>Nome utente già utilizzato</span>
                </div>
                <div class='div_register'>
                    <label>E-mail <input type='text' id="input" name='email'placeholder="Example@gmail.com"></label>
                    <span id='email-span' class='hidden'>Email non valida</span>
                </div>
                <div class='div_register'>
                    <label>Password <input type='password' id="input" name='password' placeholder="Numero di caratteri minimi 8"></label>
                    <span id="password_span" class='hidden'>La password non rispetta le specifiche</span>
                </div>
                <div class='div_register'>               
                    <label>Conferma Password</label> 
                    <input type='password' id="input" name='conf-password' placeholder="Password inserita nel campo precedente">
                    <span id="conf_pass" class='hidden'>Password non coincidono</span>
                </div>       
                <button type='submit' class="cancella" id='log'>Cancella</button>
                <button type='submit' class="avanti" id='registra'>Avanti</button>

            </form>  
        </main>

        <footer>
            <div id="logo-footer">TysonLover account</div>
            <div id="footer-info">O46001862 Squillaci Simone</div>
        </footer>

    </body>
</html>