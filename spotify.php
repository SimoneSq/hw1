<?php
    session_start();
    $id_client ='b3d6fddbe2684067b1b64ce228ad43dc';
    $secret= 'b18142a76f924cd689f6bedecce41099';

    //Richiesta del token
    $richiesta = curl_init(); //Inizializzo la sessione cUrl
    //Setto le opzioni della cUrl
    curl_setopt($richiesta, CURLOPT_URL, 'https://accounts.spotify.com/api/token' ); //Imposto l'url
    curl_setopt($richiesta, CURLOPT_POST, 1); //Specifico che il metodo è post
    curl_setopt($richiesta, CURLOPT_POSTFIELDS, 'grant_type=client_credentials'); //Setto i tipi di dati da inviare
    curl_setopt($richiesta, CURLOPT_RETURNTRANSFER, 1); //Setta il risultato come stringa
    //Inserisco nella richiesta l'id e l'id_secret
    curl_setopt($richiesta, CURLOPT_HTTPHEADER, array('Authorization: Basic '.base64_encode($id_client.':'.$secret)));
    //Prendo il token e lo decodifico (Ritorna un JSON la richiesta) solo se è andato bene
    $token=json_decode(curl_exec($richiesta), true);
    //Chiudo la sessione cUrl
    curl_close($richiesta);    

    //Richiesta traccia utente
    $traccia = urlencode($_GET["track"]); //Prendo il nome della traccia dalla richiesta della fetch
    //$url = 'https://api.spotify.com/v1/?type=track&q='.$traccia; //creo l'url
    $url = 'https://api.spotify.com/v1/search?type=track&q='.$traccia;
    $richiesta_traccia = curl_init(); //Inizializzo un altra sessione cUrl
    curl_setopt($richiesta_traccia, CURLOPT_URL, $url); 
    curl_setopt($richiesta_traccia, CURLOPT_RETURNTRANSFER, 1);
    //Questa volta aggiungo alla richiesta il token
    curl_setopt($richiesta_traccia, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$token['access_token']));
    //Eseguo la richiesta
    $res=curl_exec($richiesta_traccia);
    //Chiudo la sessione
    curl_close($richiesta_traccia);
    //Do come valore di ritorno il JSON ottenuto dalla cUrl
    echo $res;

?>