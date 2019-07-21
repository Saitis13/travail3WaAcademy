<?php
 require_once('templates/partials/header.phtml');
?>
    

    <main>
        <h1>MA BDTHEQUE (partie visiteur)</h1>
        <h2>Un diaporama pour voir quelques couvertures d'albums</h2>
        <nav class="toolbar">
            <a id="toolbar-toggle" href="#"><i class="fa fa-arrow-right"></i> Barre d'outils</a>
            <ul class="hide">
                <li><button id="slider-previous" title="Image précédente"><i class="fa fa-backward"></i></button></li>
                <li><button id="slider-toggle" title="Démarrer/Arrêter le carrousel"><i class="fa fa-play"></i></button></li>           
                <li><button id="slider-next" title="Image suivante"><i class="fa fa-forward"></i></button></li>
                <li><button id="slider-random" title="Sélectionner une image aléatoire"><i class="fa fa-random"></i></button></li>
            </ul>
        </nav>
        <figure id="slider" class="slider">
            <figcaption></figcaption>
            <img src="" alt="Photo du carrousel">           
        </figure>
    </main>
    <!--appel du js -->
    <script src="js/slider.js"></script>
        
</body>
<?php
require_once('templates/partials/footer.phtml');
?>