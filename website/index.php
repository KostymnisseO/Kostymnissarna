<?php include_once "shared/erpnextinterface.php"; ?>

<!DOCTYPE html>
<html lang="sv">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="style.css">
    <style>
        #cover-img {
            position: relative;
            background-image: linear-gradient(
                    to bottom, 
                    rgba(255,255,255,0), 
                    rgba(255,255,255,0), 
                    var(--silver-100)
                ), 
                url('img/gnomesak.jpg');
            background-size: cover;
            background-position: center;
            object-fit: cover;
            height: 20em;
            width: 100%;
            font-size: small;
        }
        
        #cover-img p,  
        #cover-img a {
            background: none;
            color: var(--silver-100);
            margin: 0.2em;
        }
        
        .hori-content {
             display: flex;
             flex-direction: row;
             align-items: stretch;
             width: 100%;
             box-shadow: 0 3px 8px var(--drop-shadow);
             background-color: white;
        }
        
        .hori-content h1 {
            color: var(--silver-100);
            background: none;
            margin: 1em;
        }
        
        .hori-content>div {
            display: flex;
            flex-direction: column;
            justify-content: center;
            margin: 0;
            padding: 2em;
            background-color: var(--ocean);
        }

        .hori-content div:first-child {
            border-radius: 0 15em 15em 0;
            text-align: left;
        }
        
        
        .hori-content div:last-child {
            border-radius: 15em 0 0 15em;
            text-align: right;
        }
        
        .hori-content p {
            flex-shrink: 3;
            padding: 3em;
            margin: 0;
            background-color: white;
        }
        
        #home-main {
            display: flex;
            flex-direction: column;
            gap: 5em;
            padding: 5em 0 5em 0;
            margin: 0;
            max-width: unset;
            width: 100%;
        }

        #news {
            max-width: 60em;
            margin: 0 auto 0 auto;    
        }

        #newsfeed::before ,
        #newsfeed::after {
            position: sticky;
            display: inline-block;
            height: 17em;
            width: 3em;
            z-index: 10;
            content: "";
        }

        #newsfeed::before{
            top: 0;
            left: 0;
            background-image: linear-gradient(to right, var(--silver-100), rgba(255,255,255,0));
        }

        #newsfeed::after{
            top: 0;
            right: 0;
            background-image: linear-gradient(to left, var(--silver-100), rgba(255,255,255,0));
        }

        #newsfeed {
            position: relative;
            gap: 2em;
            overflow-x: scroll;
            overflow-y: hidden;
            white-space: nowrap;
        }

        #newsfeed article {
            display: inline-block;
            width: 30em;
            max-height: 20em;
            overflow: hidden;
            max-width: 20em;
            margin: 2em;
            white-space: wrap;
        }

        #final-words {
            max-width: 60em;
            margin: 0 auto 0 auto;
            text-align: center;
        }

        #final-words img {
            max-height: 10em;
        }

        hr {
            color: var(--azure);
        }
    </style>
  </head>
  <body>
    <?php include "shared/header.php"; ?>
    <div id="cover-img">
        <p><a href="https://flic.kr/p/2kFBcxg" target="_blank">"You Rang?"</a> by <a href="https://www.flickr.com/photos/cogdog/" target="_blank">Alan Levine</a> is in the <a href="https://wiki.creativecommons.org/Public_domain" target="_blank">Public Domain, CC0</a></p>
    </div>
    <main id="home-main">
        <div class="hori-content">
            <div>
                <h1>Välkommen till din vårdcentral i Mölndal</h1>
            </div>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin porttitor nunc at viverra congue. Nullam consectetur gravida eros viverra aliquam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Curabitur volutpat libero sed odio posuere viverra. In ipsum arcu, vulputate nec justo vel, cursus tristique tortor. Praesent vitae justo non lorem fringilla blandit. Nunc vitae quam varius, porta turpis sed, vestibulum mi. Mauris aliquet egestas justo non iaculis. Donec gravida quam eu mi eleifend, quis ullamcorper mi semper. Etiam vel diam sit amet tortor sagittis finibus volutpat non nisl. Morbi eu facilisis diam. Vestibulum auctor condimentum mattis. Duis nec tincidunt ligula, et malesuada purus.
            </p>
        </div>
        <div>
            <div id="news">
                <h2>Nyheter från vårdcentralen</h2>
                <div id="newsfeed">
                    <article>
                        <h3>Lorem ipsum</h3>
                        <hr>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin porttitor nunc at viverra congue. Nullam consectetur gravida eros viverra aliquam.</p>
                    </article>
                    <article>
                        <h3>Lorem ipsum</h3>
                        <hr>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin porttitor nunc at viverra congue. Nullam consectetur gravida eros viverra aliquam.</p>
                    </article>
                    <article>
                        <h3>Lorem ipsum</h3>
                        <hr>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin porttitor nunc at viverra congue. Nullam consectetur gravida eros viverra aliquam.</p>
                    </article>
                    <article>
                        <h3>Lorem ipsum</h3>
                        <hr>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin porttitor nunc at viverra congue. Nullam consectetur gravida eros viverra aliquam.</p>
                    </article>
                    <article>
                        <h3>Lorem ipsum</h3>
                        <hr>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin porttitor nunc at viverra congue. Nullam consectetur gravida eros viverra aliquam.</p>
                    </article>
                </div>
            </div>
        </div>
        <div class="hori-content">
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin porttitor nunc at viverra congue. Nullam consectetur gravida eros viverra aliquam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Curabitur volutpat libero sed odio posuere viverra. In ipsum arcu, vulputate nec justo vel, cursus tristique tortor. Praesent vitae justo non lorem fringilla blandit. Nunc vitae quam varius, porta turpis sed, vestibulum mi. Mauris aliquet egestas justo non iaculis. Donec gravida quam eu mi eleifend, quis ullamcorper mi semper. Etiam vel diam sit amet tortor sagittis finibus volutpat non nisl. Morbi eu facilisis diam. Vestibulum auctor condimentum mattis. Duis nec tincidunt ligula, et malesuada purus.
            </p>
            <div>
                <h1>En modern och personlig vård</h1>
            </div>
        </div>
        <div id="final-words">
            <img src="img/healthcare_center.jpg" />
            <h2>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin porttitor nunc at viverra congue. 
            </h2>
        </div>
    </main>
    <?php include "shared/footer.php"; ?>
  </body>
</html>
