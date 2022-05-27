//Mappa
const formMap={
    name: 0,
    surname: 0,
    username: 0,
    email: 0,
    password: 0,
    conf_pass: 0
};

//Controllo Nome
function checkNome(event){
    const value = event.currentTarget;
    controllo=/^([a-zA-Z\xE0\xE8\xE9\xF9\xF2\xEC\x27]\s?)+$/; //Permette di definire il pattern di sole lettere grandi e piccole
    const span = value.parentNode.querySelector("#errore");
    const riga = value.parentNode.querySelector("#riga");
  //console.log(value.value);
    if(value.value.length > 0){
        if(controllo.test(value.value)){ //Controllo che il nome sia composto solo da lettere
            span.classList.add("hidden");
            riga.classList.remove("hidden");
            formMap.name=1;
        }else{
            span.classList.remove("hidden");
            riga.classList.add("hidden");
            formMap.name=0;
        }
    }else{
        span.classList.remove("hidden");
        riga.classList.add("hidden");
        formMap.name=0;
    }
    checkForm();
}

//Controllo Cognome

function checkCognome(event){
    const value = event.currentTarget;
    controllo=/^([a-zA-Z\xE0\xE8\xE9\xF9\xF2\xEC\x27]\s?)+$/;
    const span = document.querySelector("#span_dex");
    const riga = value.parentNode.querySelector("#riga_dex");
   if(value.value.length > 0){
       if(controllo.test(value.value)){
            span.classList.add("hidden");
            riga.classList.remove("hidden");
            formMap.surname=1;
       }else{
        span.classList.remove("hidden");
        riga.classList.add("hidden");
        formMap.surname=0;
        }
    }else{
        span.classList.remove("hidden");
        riga.classList.add("hidden");
        formMap.surname=0;
    }
        //console.log(arrayCheck);
        checkForm();
}

function onResponse(response){
    return response.json();
}

//Controllo Username
function jsonUsername(json){
    const result = json.exist;
    const span = document.querySelector("#username-span");
    if(result){ //Username esiste nel database
        span.innerText='Nome utente già utilizzato';    
        span.classList.remove("hidden");
        formMap.username=0;
    }
    else{
        console.log('Non Esiste');
        span.classList.add("hidden");
        formMap.username=1;
    }
    checkForm();
}

function checkUsername(event){
    const user=event.target.value;
    const span = document.querySelector("#username-span");
    console.log(span.textContent);
    // console.log(user.value); //Controllo value;
    console.log(user);
    if(user != ""){
        if(!/^[a-zA-Z0-9_]{1,15}$/.test(user)){ //Verifica se il pattern dato e' stato rispettato dal valore di user
            span.innerText='';
            span.innerText='Caratteri non consentiti';
            span.classList.remove("hidden");
            formMap.username=0;
            //console.log(arrayCheck);
            return;
        }
        else{
            fetch("check_username_client.php?q="+encodeURIComponent(user)).then(onResponse).then(jsonUsername);
        }
    }
    else{
        span.innerText='';
        span.innerText='Inserire username';
        span.classList.remove("hidden");
        formMap.username=0;
    }
}

//Controllo email

function jsonEmail(json){
    const result = json.exist;
    const span = document.querySelector('#email-span');
    if(result){ //Username esiste nel database
        span.innerText='Email già utilizzato';    
        span.classList.remove("hidden");
        formMap.email=0;
    }
    else{
        console.log('Non Esiste');
        span.classList.add("hidden");
        formMap.email=1;
    }
    checkForm();
}

function checkEmail(event){
    const email = event.currentTarget;
    const span = document.querySelector('#email-span');
    console.log(email.value);
    if(email.value === ""){
        span.innerText="Inserire un indirizzo mail";
        span.classList.remove('hidden');
        formMap.email=0;
    }else{
        if(!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(String(email.value).toLowerCase())) {
            span.innerText="Indirizzo email non valido";
            span.classList.remove('hidden');
            formMap.email=0;
        }else{
            fetch("check_email_client.php?q="+encodeURIComponent(String(email.value).toLowerCase())).then(onResponse).then(jsonEmail);
        }
    }
    checkForm();
}

//Controllo password

function checkPassword(event){
    const pass = event.currentTarget;
    const span= document.querySelector('#password_span');

    if(pass.value.length==0){
        span.innerText='Inserire una password';
        span.classList.remove('hidden');
        formMap.password=0;
    }else{
        if(pass.value.length<8){
            span.innerText='La password non rispetta le specifiche';
            span.classList.remove('hidden');
            formMap.password=0;
        }else{
            span.classList.add('hidden');
            formMap.password=1;
        }
    }
    checkForm();
}

//Controllo conf_pass
function checkConf_pass(event){
    const current_pass = event.currentTarget;
    //console.log(current_pass.value);
    const password = document.querySelector('input[name="password"]');
    const span= document.querySelector('#conf_pass');
        //console.log(password.value);
        let result = current_pass.value.localeCompare(password.value);
        if(result==0){
            console.log("Password uguali");
            span.classList.add('hidden');
            formMap.conf_pass=1;
        }else{
            span.classList.remove('hidden');
            formMap.conf_pass=0;
        }
    checkForm();
}

//Funzione Check Form
function checkForm(){
    const registra = document.querySelector('#registra');
    console.log(formMap);
    if(formMap.name==1 && formMap.surname==1 && formMap.username==1 && formMap.email==1 && formMap.password==1 && formMap.conf_pass==1 ){
        registra.disabled=false; //Solo se tutti i campi della mappa sono = 1 si attiva il bottone
        console.log(formMap);
    }
}

//Reinderizzamento verso la pagina di login
function returnLogin(event){
    event.preventDefault();
    window.location.assign("http://localhost/return.php");
}

//Blocco il tasto "avanti" per la registrazione e lo sblocco solo se il form e' completo
const registra = document.querySelector('#registra');
registra.disabled=true;

const nome = document.querySelector('input[name="nome"]')//input[name="nome"] Mi permette di prendere l'input con quel determinato id
nome.addEventListener('blur',checkNome);
const surname = document.querySelector('input[name="cognome"]');
surname.addEventListener('blur',checkCognome);
const username = document.querySelector('input[name="username"]');
username.addEventListener('blur',checkUsername);
const email = document.querySelector('input[name="email"]');
email.addEventListener('blur',checkEmail);
const password = document.querySelector('input[name="password"]');
password.addEventListener('blur',checkPassword);
const conf_password = document.querySelector('input[name="conf-password"]');
conf_password.addEventListener('blur',checkConf_pass);

const cancella = document.querySelector('#log');
cancella.addEventListener('click',returnLogin);


