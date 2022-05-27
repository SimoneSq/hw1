//Aggiungi Commento

function Aggiungi(event){
    event.preventDefault();
    const input = document.querySelector('#input');
    if(input.value!=""){
        var formData = new FormData();
       formData.append("commento", input.value); 
       fetch("uploadComment.php", {method: 'post', body: formData}).then(onResponseComment).then(onJson);
    }
}

//Like e Unlike

function onJsonLike(json){
    if(json.controllo==true){
        console.log("Likes ok");
    }else{
        console.log("Likes no");
    }
}

function liked(event){
    const box = document.querySelector(".scroll-box");
    box.innerHTML='';
    event.currentTarget.classList.remove('unlike');
    event.currentTarget.classList.add('like');
    event.currentTarget.removeEventListener('click',liked);
    event.currentTarget.addEventListener('click',unliked);

    const post_id = event.currentTarget.id;
    console.log(post_id);
    var formData = new FormData();
    formData.append("post_id", post_id); 
    fetch("updateLike.php", {method: 'post', body: formData}).then(onResponseComment).then(onJsonLike);

    fetchCommenti();
}

function unliked(event){
    const box = document.querySelector(".scroll-box");
    box.innerHTML='';

    event.currentTarget.classList.remove('like');
    event.currentTarget.classList.add('unlike');
    event.currentTarget.removeEventListener('click',unliked);
    event.currentTarget.addEventListener('click',liked);
    
    const post_id = event.currentTarget.id;
    console.log(post_id);
    var formData = new FormData();
    formData.append("post_id", post_id); 
    fetch("deleteLike.php", {method: 'post', body: formData}).then(onResponseComment).then(onJsonLike);
    
    fetchCommenti();
}

//Caricamento Commenti

function onJsonComment(json){
    for(let i in json){
    //Creazioni elementi ed assegnazione classi
        const user = document.createElement("p");
        user.classList.add("user-comment");
        const text = document.createElement("p");
        text.classList.add("par-comment");
        const div_comment = document.createElement("div");
        div_comment.classList.add("comment_margin");
    //Creazione icona like   
        const like = document.createElement("div");
        const div_like = document.createElement("div");
        div_like.setAttribute("id","like_container");
        const like_text = document.createElement("p");
        const like_n_like = document.createElement("p");
        like_n_like.setAttribute("id","cont_like");
        like_text.innerText = "❤"
        like_text.classList.add('unlike');
        like_n_like.innerText = json[i].n_like;
        div_like.appendChild(like_text);
        div_like.appendChild(like_n_like);
        like.appendChild(div_like);
        like_text.setAttribute("id",json[i].post_id);
        like.classList.add('like-box');
    //Inserimento dati all'interno degli elementi creati    
        user.innerText = json[i].username;
        text.innerText = json[i].commento;
    //Append elementi all'interno del box singolo commento
        div_comment.appendChild(user);
        div_comment.appendChild(text);
        div_comment.appendChild(like);
    //Ricerca box commenti ed append del box singolo commento
        const box = document.querySelector('.scroll-box');
        box.appendChild(div_comment);
        if(json[i].controllo){
            console.log("Commento");
            like_text.addEventListener('click',unliked);
            like_text.classList.add('like');
        }else
            like_text.addEventListener('click',liked);
    }
}



function onJson(json){
   if(json.controllo==true){
        console.log("Inserimento avvenuto");
        const user = document.createElement("p");
        user.classList.add("user-comment");
        const text = document.createElement("p");
        text.classList.add("par-comment");
        const like = document.createElement("div");
        const like_text = document.createElement("p");
        const div_like = document.createElement("div");
        div_like.setAttribute("id","like_container");
        const like_n_like = document.createElement("p");
        like_n_like.setAttribute("id","cont_like");
        like_text.setAttribute("id",json.post_id);
        //console.log(document.querySelector(".user-button").textContent);
        user.innerText = json.username;
        //user.innerText = "Guest:";
        like_text.innerText = "❤"
        like.value = json.post_id;
        like_text.classList.add('unlike');
        like_n_like.innerText = 0;
        div_like.appendChild(like_text);
        div_like.appendChild(like_n_like);
        like.appendChild(div_like);
        like.classList.add('like-box');
        console.log("Input value:" + input.value);
        text.innerText = json.commento;
        console.log(user.textContent);
        console.log(text.textContent);
        const div_comment = document.createElement("div");
        div_comment.classList.add("comment_margin");
        div_comment.appendChild(user);
        div_comment.appendChild(text);
        div_comment.appendChild(like);
        const box = document.querySelector('.scroll-box');
        box.appendChild(div_comment);
        input.value="";
        like_text.addEventListener('click',liked);
    }else{
        console.log("Inserimento fallito");
    }
}

function onResponseComment(response){
    return response.json();
}

function fetchCommenti(){
    fetch("fetch_comment.php").then(onResponseComment).then(onJsonComment);
}


//Parte mobile
function menuTendina(event){
    console.log("ok");
    const modale = document.querySelector('#view');
    modale.classList.add('modal');
    modale.classList.remove('hidden');
    const menu= document.querySelector("#menu");
    menu.removeEventListener('click',menuTendina)
    menu.addEventListener('click',chiudiMenu);
}


function chiudiMenu(event){
    const modale = document.querySelector('#view');
    modale.classList.remove('modal');
    modale.classList.add('hidden');
    const menu= document.querySelector("#menu");
    menu.removeEventListener('click',chiudiMenu);
    menu.addEventListener('click',menuTendina)
}

const menu = document.querySelector("#menu");
menu.addEventListener('click',menuTendina);


//General
const send = document.querySelector('#send-comment');
send.addEventListener('click',Aggiungi);
const like = document.querySelector('.unlike');
fetchCommenti();