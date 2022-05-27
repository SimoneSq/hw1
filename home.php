<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('Location: login.php');
        exit;
    }
?>
<html>
    <head>
        <title>Mini Homework 1</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="home.css"/>
        <script src="home.js" defer></script>
    </head>
    <body>

        <header>
            <nav>
                <div id="logo">TysonLover</div>
                <div id="links">
                    <a>Help</a>
                    <a>About</a>
                    <a href="blog.php">Blog</a>
                    <?php 
                        if(!empty($_SESSION['username'])){
                            echo "<a class='user-button' href='logout.php'>".$_SESSION['username']."</a>";
                        }else{
                            echo "<a class='user-button' href='logout.php'>Guest</a>";
                        }
                    ?>
                </div>

                <div id="menu">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>

            </nav>
            <h1>
                <strong>Scopri il mondo della lotta</strong></br>
                <em>Notizie, articoli e molto altro...</em></br>
            </h1>

            <div id='view' class='hidden'>
                <a>Help</a>
                <a>About</a>
                <a href="blog.php">Blog</a>
                <?php 
                        if(!empty($_SESSION['username'])){
                            echo "<a href='logout.php'>".$_SESSION['username']."</a>";
                        }else{
                            echo "<a  href='logout.php'>Guest</a>";
                        }
                    ?>
            </div>
        </header>

        <section>
            <!--<div id="section-item">
                <h1>Sezione Articoli</h1>
                <img src="https://sport.periodicodaily.com/wp-content/uploads/2021/11/ufc-news-768x512-1.png"/>
                <a><p>Leggi le ultime notizie sul mondo della lotta...</p></a>
            </div>
            <div id="section-item">
                <h1>Sezione Merchandising</h1>
                <img src="https://library.sportingnews.com/styles/twitter_card_120x120/s3/2022-03/everlast%20boxing%20gloves.jpg?itok=keHm65Sb"/>
                <a><p>Scopri l'attrezzatura usata dai campioni...</p></a>
            </div> -->
        </section>

       <!-- <section>
            <div id="section-item">
                <h1>Sezione Classifiche</h1>
                <img src="https://s3.eu-central-1.amazonaws.com/gitalia.cdn/wp-content/uploads/2016/05/16132840/taglio-del-peso-ufc.jpg"/>
                <a><p>Tutti i risultati dei combattimenti...</p></a>
            </div>
            <div id="section-item">
                <h1>Sezione Storia</h1>
                <img class="flex" src="https://curiosando708090.altervista.org/wp-content/uploads/2011/09/muhammad_ali_versus_sonny_liston.jpg"/>
                <a><p>Rivivi gli incontri leggendari</p></a>
            </div>
        </section>-->

        <footer>
        <iframe class="hidden" style="border-radius:12px" src="https://open.spotify.com/embed/track/156zRgKOtm3Q3e2XV6UYjy?utm_source=generator" width="50%" height="80px" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"></iframe>
            <p>Per informazioni generali contattare lo staff</p>
            <em>Creato da Simone Squillaci</em>
        </footer> 
    </body>
</html>