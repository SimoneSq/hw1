function onJson(json){
    const section = document.querySelector('section');
    //Carico dinamicamente i primi 3 blocchi dal database
    for(let i in json){
        const div = document.createElement("div");
        div.setAttribute("id","section-item");
        const h1 = document.createElement("h1");
        h1.innerText=json[i].title;
        const img = document.createElement("img");
        img.src=json[i].img;
        const a = document.createElement("a");
        const p = document.createElement("p");
        p.innerText=json[i].p;
        a.appendChild(p);
        div.appendChild(h1);
        div.appendChild(img);
        div.appendChild(a);
        section.appendChild(div);
    }
    //Creo il blocco per spotify
    const div_spoty = document.createElement("div");
    const div_input = document.createElement("div");
    const img = document.createElement("img");
    div_spoty.setAttribute("id","section-item");
    div_spoty.classList.add("div_spoty_conf");
    const h1_spoty = document.createElement("h1");
    h1_spoty.innerText="Ascolta qualcosa mentre navighi!";
    
    const input = document.createElement("input");
    input.setAttribute("id","search_input");
    input.setAttribute("placeholder","Immetti nome traccia")
    const button = document.createElement("button");
    button.innerText= "Cerca";
    button.setAttribute("id","search_spotify");
    button.addEventListener('click',ricercaTraccia);
    div_input.appendChild(input);
    div_input.appendChild(button);
    div_input.classList.add("div_input")
    div_spoty.appendChild(h1_spoty);
    div_spoty.appendChild(img);
    div_spoty.appendChild(div_input);
    section.appendChild(div_spoty);
}

function onResponse(response){
    console.log(response);
    return response.json();
}

//Spotify
function onJsonSpoty(json){
    console.log(json);
    const div = document.querySelector(".div_spoty_conf");
    const img = div.querySelector("img");
    img.src= json.tracks.items[0].album.images[1].url;
    const footer = document.querySelector("footer");
    //  div.appendChild(img);
    const player = footer.querySelector("iframe");
    player.classList.remove("hidden");
    let url ="https://open.spotify.com/embed/track/"+json.tracks.items[0].id+"?utm_source=generator"
    player.src=url;
}

function onResponseSpoty(response){
    console.log(response);
    return response.json();
}

function ricercaTraccia(event){
    console.log("Ricerca ok");
    const text = document.querySelector("#search_input");
    if(text.value!=""){
        console.log(text.value);
        fetch("spotify.php?track=" + encodeURIComponent(text.value)).then(onResponseSpoty).then(onJsonSpoty);
    }
    text.value="";
}

//Parte mobile
function menuTendina(event){
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

fetch("loadContent.php").then(onResponse).then(onJson);
const menu= document.querySelector("#menu");
menu.addEventListener('click',menuTendina);
