//DONNEES************************je joue avec 6 couvertures********
const images= [
	{source: "images/1.jpg", legende: "couverture de l'album L'enfant clone "},
	{source: 'images/2.jpg', legende: "couverture de l'album La croisière des oubliés "},
	{source: "images/3.jpg", legende: "couverture de l'album Les Seigneurs force"},
	{source: 'images/4.jpg', legende: "couverture de l'album Merlin contre le Père Noël"},
	{source: "images/5.jpg", legende: "couverture de l'album La pagode des brumes"},
	{source: 'images/6.jpg', legende: "couverture de l'album La croisière des oubliés"}
];

let compteur = 0;
let etatLecture = false;
let intervalId;
let numImgActuelle =0;



const max=images.length-1;
const min=0;

const img = document.querySelector('img');
const fig = document.querySelector('figcaption');
const buttonNext = document.querySelector('#slider-next');
const buttonPrevious = document.querySelector('#slider-previous');
const buttonPlay = document.querySelector('#slider-toggle');
const buttonAlea = document.querySelector('#slider-random');
const buttonArrow = document.querySelector('#toolbar-toggle');

//FONCTION*****************************

function afficher(){
	img.src=images[compteur].source;
	img.alt=images[compteur].legende;
	fig.innerHTML = images[compteur].legende;
}

//Fonction afficher l'image suivante
//1.On crée la fonction
function imageSuivante(){
	//2.On va augmenter de 1 le compteur
	if(compteur == images.length-1){
		compteur = 0;
	}
	else{
		compteur++;
	}
	
	//afficher
	afficher();
}
function imagePrécédent(){
	//2.diminuer de 1 le compteur
	if(compteur == 0){
		compteur = images.length-1;
	}else {
		compteur--;
	}
	afficher();
}
function diaporama() {
	//vérifier l'état de etatLecture
	//si (== false) ->lire le diaporama (setInterval)

	if(etatLecture == false){
		intervalId = window.setInterval(imageSuivante, 2000);
		etatLecture = true;
	}
	//sinon (== true) -> arret du diaporama (clearInterval)
	else {
		window.clearInterval(intervalId);
		etatLecture = false;
	}
}
function getRandomArbitrary(min, max) {
	//genere un chiffre entre 0 et 5 
  return Math.random() * (max - min) + min;
}

function alea (){
while (numImgActuelle == compteur){
	numImgActuelle =parseInt(getRandomArbitrary(min, max));
	}
	compteur = numImgActuelle;
	afficher();
}

function cacheLaBarre(){
// je cache la barre ou pas 
// Affiche ou cache la barre d'outils.
  document.querySelector('.toolbar ul').classList.toggle('.hide');
}

//CODE*********************************
afficher();
buttonNext.addEventListener('click', imageSuivante);
buttonPrevious.addEventListener('click', imagePrécédent);
buttonPlay.addEventListener('click', diaporama);
buttonAlea.addEventListener('click', alea);
//CODE********* buttonArrow.addEventListener('click', cacheLaBarre);