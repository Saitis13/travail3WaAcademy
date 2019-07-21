//DONNEES************************je joue avec 6 couvertures********
const images= [
	{source: "images/2002.jpg", legende:  "voeux 2002"},
	{source: "images/2004.jpg", legende:  "voeux 2004"},
	{source: "images/2015.jpg", legende:  "voeux 2015"},
	{source: "images/2017.jpg", legende:  "joyeux Noël 2017"}
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
  document.querySelector('.toolbar ul').classList.toggle('hide');
}

//CODE*********************************
afficher();
buttonNext.addEventListener('click', imageSuivante);
buttonPrevious.addEventListener('click', imagePrécédent);
buttonPlay.addEventListener('click', diaporama);
buttonAlea.addEventListener('click', alea);
buttonArrow.addEventListener('click', cacheLaBarre);