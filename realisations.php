<?php
 require_once('templates/partials/header.phtml');
?>
    
    <main>
        <h1>Mes réalisations</h1>
        <h2>un diaporama pour voir mes images 3D</h2>
        <nav class="toolbar">
            <a id="toolbar-toggle" href="#"><i class="fa fa-arrow-right"></i> Barre d'outils</a>
            <ul class="hide">
                <li><button id="slider-previous" title="Image précédente"><i class="fa fa-backward"></i></button></li>
                <li><button id="slider-toggle" title="Démarrer/Arrêter le carrousel"><i class="fa fa-play"></i></button></li>
                <!--<li><button id="slider-stop" title="Arreter le carrousel"> <i class="fa fa-stop" aria-hidden="true"></i></button></li>-->
                <li><button id="slider-next" title="Image suivante"><i class="fa fa-forward"></i></button></li>
                <li><button id="slider-random" title="Sélectionner une image aléatoire"><i class="fa fa-random"></i></button></li>
            </ul>
        </nav>

        <figure id="slider" class="slider">
            <img src="*" alt="Photo du carrousel">
            <figcaption></figcaption>
        </figure>

        <h1>Ma serie de pages</h1> 
        <img src="images/UnderConstruction.gif" alt="en travaux">
           <!--appel du js -->
        <script src="js/slider1.js"></script>
        <!-- <script src="js/tombelaneige.js"></script> -->

    </main>

<?php
 require_once('templates/partials/footer.phtml');
?>
