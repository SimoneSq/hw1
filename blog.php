<?php
    session_start();

    if(!isset($_SESSION['username'])){
        header('Location: login.php');
        exit;
    }
?>
<html>
    <head>
        <title>Blog</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="blog.css"/>
        <script src="blog.js" defer></script>
    </head>
    <body>

        <header>
            <nav>
                <div id="logo">TysonLover</div>
                <div id="links">
                    <a>Help</a>
                    <a>About</a>
                    <a href="home.php" class='home-tag'>Home</a>
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
            <div id='view' class='hidden'>
                <a>Help</a>
                <a>About</a>
                <a href="home.php">Home</a>
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
            <div class="scroll-box">
            
            </div>
            <textarea type="text" id="input" name='comment' placeholder="  Inserisci commento"></textarea>
            <button id="send-comment" type='submit'>Commenta</button>

        </section>
        <iframe class="hidden" style="border-radius:12px" src="https://open.spotify.com/embed/track/156zRgKOtm3Q3e2XV6UYjy?utm_source=generator" width="50%" height="80px" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"></iframe>
        </footer> 
    </body>
</html>