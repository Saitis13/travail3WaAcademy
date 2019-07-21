<?php
// fonction de connexion à la base de donnees
function connect(){
	   // $db=new pdo( 'mysql:host=localhost;dbname=MaBdtheque;charset=utf8','root','',  [
	   	// 	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	   	// ]);  
	    	$db=new pdo( 'mysql:host=bernardrnoroot;dbname=bernardrnoroot;charset=utf8','bernardrnoroot','Salticus13',  [
	   		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	  	]);
	return $db;
} 
function verificationNouveaute($nom,$prenom,$nationalite){
	// connexion à la base de données
	$base=connect();
	// requete auprès de la base  
	$requete=$base->prepare('SELECT * FROM  `scenariste` 
   WHERE  `nom_scenariste` =  :nomauteur ');
    //  WHERE  `nom_scenariste` =  :nomauteur et  `prenom_scenariste` =  :prenomauteur' recupération des données
	// On exécute en passant les valeurs pour chaque token
    $requete->execute([
		":nomauteur"  => $nom]);
	// ":prenomauteur"  => $prenom
	$resultat=$requete->fetch();
    $existence= (empty($resultat)) ? 'ko' : 'ok';
 	var_dump($existence);
	return $existence;
    }

function getAllAlbums(){
	// connexion à la base de données
	$base=connect();
	// requete auprès de la base  
	$requete=$base->query('SELECT album.*,
	dessinateur.nom_dessinateur,dessinateur.prenom_dessinateur,
	scenariste.nom_scenariste,scenariste.prenom_scenariste,
	coloriste.nom_coloriste,coloriste.prenom_coloriste,
	editeur.nom as nom_editeur
	FROM album
	inner join dessinateur
	on dessinateur.id=album.id_dessinateur
	
	inner join scenariste
	on scenariste.id=album.id_scenariste
	
	left join coloriste
	on coloriste.id=album.id_coloriste
	
	inner join editeur
	on editeur.id=album.id_editeur
	
	ORDER BY album.titre
	');
	// recupération des données
	$albums=$requete->fetchAll();
	
 	//var_dump($albums);
    return$albums;
}

function getAllAlbumsnonEmpruntes(){
// connexion à la base de données
	$base=connect();
	// requete auprès de la base  
	$requete=$base->query('SELECT album.*,
	dessinateur.nom_dessinateur,dessinateur.prenom_dessinateur,
	scenariste.nom_scenariste,scenariste.prenom_scenariste,
	coloriste.nom_coloriste,coloriste.prenom_coloriste,
	editeur.nom as nom_editeur
	FROM album
	inner join dessinateur
	on dessinateur.id=album.id_dessinateur
	
	inner join scenariste
	on scenariste.id=album.id_scenariste
	
	left join coloriste
	on coloriste.id=album.id_coloriste
	
	inner join editeur
	on editeur.id=album.id_editeur
	
    WHERE  `etat` =  "non emprunte"
	
	ORDER BY album.titre
	');
	// recupération des données
	$albums=$requete->fetchAll();
 	//var_dump($albums);	
    return$albums;
}



function getUnAlbum($id){
	var_dump($id);
	// connexion à la base de données
	$base=connect();
	// requete auprès de la base  
	$requete=$base->prepare('SELECT album.*,
	dessinateur.nom_dessinateur,dessinateur.prenom_dessinateur,
	scenariste.nom_scenariste,scenariste.prenom_scenariste,
	coloriste.nom_coloriste,coloriste.prenom_coloriste,
	editeur.nom as nom_editeur
	
    FROM album
    
	inner join dessinateur
	on dessinateur.id=album.id_dessinateur
	
	inner join scenariste
	on scenariste.id=album.id_scenariste
	
	left join coloriste
	on coloriste.id=album.id_coloriste
	
	inner join editeur
	on editeur.id=album.id_editeur
	
	WHERE 
	album.id = :id');
	
	// On exécute en passant les valeurs pour chaque token
    $requete->execute([
		":id"  => $id ]);
	$cetalbum=$requete->fetch();
 	//var_dump($cetalbum);
return$cetalbum;
}


function suppralbum($id){
	// requete auprès de la base
	$db=connect();
	// On prépare la requête de mise à jour 
	// (donc attention aux codes malveillants )
	$query = $db->prepare('DELETE FROM album			
							WHERE id = :monid');
	// On exécute en passant les valeurs pour chaque token
	$message=$query->execute([
		":monid"            => $id	
	]);
	
	var_dump($message);
 	return $message; 
}

function modifUnAlbum($id,$id_dessinateur,$id_scenariste,$id_graphiste,$id_coloriste,$titre,$serie,$num_serie,$id_editeur,$nom_collection,$page1){
	// requete auprès de la base
	$db=connect();
	// On prépare la requête de mise à jour 
	// (donc attention aux codes malveillants )
	$query=$db->prepare('UPDATE `album` SET 
	`id_dessinateur`=:moniddessinateur,
	`id_scenariste`=:monidscenariste,
	`id_graphiste`=:monidgraphiste,
	`id_coloriste`=:monidcoloriste,
	`titre`=:montitre,
	`serie`=:maserie,
	`num_serie`=:monnumeroserie,
	`id_editeur`=:monidediteur,
	`nom_collection`=:monnomcollection,
	`page1`=:mapage1
	
	 WHERE id=:monid
	');
	
    $message=$query->execute([
	":monid"       => $id,
	":moniddessinateur" =>$id_dessinateur ,
	":monidscenariste"  =>$id_scenariste,
    ":monidgraphiste"   =>$id_graphiste,
	":monidcoloriste"   =>$id_coloriste,
    ":montitre"        =>$titre,
	":maserie"         =>$serie,
	":monnumeroserie"  =>$num_serie,
	":monidediteur"    =>$id_editeur,
	":monnomcollection"=>$nom_collection,
	":mapage1"         =>$page1
	
	]);
	
	var_dump($message);
 	return $message; 
}


//----------------gestion retour et emprunt BD-------------------------------//
function EmpruntUnAlbum($id,$nomEmprunteur){
	// requete auprès de la base
	$db=connect();
	// On prépare la requête de mise à jour 
	// (donc attention aux codes malveillants )
	$query=$db->prepare('UPDATE `album` SET 
	`etat`= "emprunte",
	`date_emprunt`= now(),
	`nom_emprunteur`= :nomemprunteur
	 WHERE id=:monid
	');
    $message=$query->execute([
	":monid"                 => $id,
	":nomemprunteur"         =>$nomEmprunteur
	]);
	// var_dump($message);
 	return $message; 
}
function RendreUnAlbum($id){
	// requete auprès de la base
	$db=connect();
	// On prépare la requête de mise à jour 
	// (donc attention aux codes malveillants )
	$query=$db->prepare('UPDATE `album` SET 
	`etat`= "non emprunte",
	`date_emprunt`= "0000-00-00",
	`nom_emprunteur`= "0"
	
	 WHERE id=:monid
	');
    $message=$query->execute([
	":monid"       => $id
	]);
	
	var_dump($message);
 	return $message; 
}
//----------------gestion retour et emprunt BD--------------------------------//

function ajouterCeScenariste($nom,$prenom,$nationalite){
	var_dump($nom);
    var_dump($prenom);
    var_dump($nationalite);
// requete auprès de la base
	$db=connect();
	// On prépare la requête INSERT INTO table VALUES ('valeur 1', 'valeur 2', ...)
	$query=$db->prepare('INSERT INTO `scenariste` SET 
    `nom_scenariste` =  :nomauteur ,	
	`prenom_scenariste` =  :prenomauteur ,
	`nationalite` =  :nationalite 
	');
	// On exécute en passant les valeurs pour chaque token
    $message=$query->execute([
		":nomauteur"     => $nom,
		":prenomauteur"  => $prenom,
	    ":nationalite"=> $nationalite
		]);
	// 	
	// var_dump($message);
 	return ; 
	
}
function ajouterCeDessinateur($nom,$prenom,$nationalite,$photo){
	var_dump($nom);
    var_dump($prenom);
    var_dump($nationalite);
    var_dump($photo);
// requete auprès de la base
	$db=connect();
	// On prépare la requête INSERT INTO table VALUES ('valeur 1', 'valeur 2', ...)
	$query=$db->prepare('INSERT INTO `dessinateur` SET 
    `nom_dessinateur` =  :nomauteur ,	
	`prenom_dessinateur` =  :prenomauteur ,
	`nationalite` =  :nationalite , 
	`photo` =  :photo 
	');
	// On exécute en passant les valeurs pour chaque token
    $message=$query->execute([
		":nomauteur"     => $nom,
		":prenomauteur"  => $prenom,
		":nationalite"=> $nationalite,
	    ":photo"=> $photo
		]);
	// 	
	// var_dump($message);
 	return ; 
	
}

function ajouterCeColoriste($nom,$prenom,$nationalite){
	var_dump($nom);
    var_dump($prenom);
    var_dump($nationalite);
   
// requete auprès de la base
	$db=connect();
	// On prépare la requête INSERT INTO table VALUES ('valeur 1', 'valeur 2', ...)
	$query=$db->prepare('INSERT INTO `coloriste` SET 
    `nom_coloriste` =  :nomauteur ,	
	`prenom_coloriste` =  :prenomauteur ,
	`nationalite` =  :nationalite 	
	');
	// On exécute en passant les valeurs pour chaque token
    $message=$query->execute([
		":nomauteur"     => $nom,
		":prenomauteur"  => $prenom,
		":nationalite"=> $nationalite
		]);
	// 	
	// var_dump($message);
 	return ; 
	
}	


function verificationNouveauteD($nom,$prenom){
// var_dump("on est dans verification");
	// var_dump($nom);
	// var_dump($prenom);
	// connexion à la base de données
	$base=connect();
	// requete auprès de la base  
	$requete=$base->prepare('SELECT * FROM  `dessinateur` 
   WHERE  `nom_dessinateur` =  :nomauteur ');
	// On exécute en passant les valeurs pour chaque token
    $requete->execute([
		":nomauteur"  => $nom]);
	// ":prenomauteur"  => $prenom
	$resultat=$requete->fetch();
    $existence= (empty($resultat)) ? 'ko' : 'ok';
 	// var_dump($existence);
	return $existence;
    }
    
function verificationNouveauteE($nom){
// var_dump("on est dans verification");
	// var_dump($nom);
	// connexion à la base de données
	$base=connect();
	// requete auprès de la base  
	$requete=$base->prepare('SELECT * FROM  `editeur` 
   WHERE  `nom` =  :nom');
	// On exécute en passant les valeurs pour chaque token
    $requete->execute([
		":nom"  => $nom]);
	$resultat=$requete->fetch();
    $existence= (empty($resultat)) ? 'ko' : 'ok';
 	// var_dump($existence);
	return $existence;
    }

function ajouterUnAlbum($id,$id_dessinateur,$id_scenariste,$id_graphiste,$id_coloriste,$titre,$serie,$num_serie,$id_editeur,$nom_collection,$page1){
	// requete auprès de la base
	$db=connect();
	// On prépare la requête INSERT INTO table VALUES ('valeur 1', 'valeur 2', ...)
	// (donc attention aux codes malveillants )
	$query=$db->prepare('INSERT INTO `album` SET 
	`id_dessinateur`=:moniddessinateur,
	`id_scenariste`=:monidscenariste,
	`id_graphiste`=:monidgraphiste,
	`id_coloriste`=:monidcoloriste,
	`titre`=:montitre,
	`serie`=:maserie,
	`num_serie`=:monnumeroserie,
	`id_editeur`=:monidediteur,
	`nom_collection`=:monnomcollection,
	`etat`="non emprunte",
	`page1`=:mapage1
	');
	
    $message=$query->execute([
	":moniddessinateur"=>$id_dessinateur,
	":monidscenariste" =>$id_scenariste,
    ":monidgraphiste"  =>$id_graphiste,
	":monidcoloriste"  =>$id_coloriste,
    ":montitre"        =>$titre,
	":maserie"         =>$serie,
	":monnumeroserie"  =>$num_serie,
	":monidediteur"    =>$id_editeur,
	":monnomcollection"=>$nom_collection,
	":mapage1"         =>$page1
	]);
	
	var_dump($message);
 	return $message; 
}

function getAllEmprunte(){
	// Je veux tous les albums empruntés
	// requete auprès de la base
	$db=connect();
	// On prépare la requête de liste des albums empruntes
    $requete=$db->query('
	SELECT album. * 
	FROM album
	WHERE  `etat` =  "emprunte"
	ORDER BY  `date_emprunt` DESC 
	');
	// recupération des données
	$albums=$requete->fetchAll();
	return$albums;
}

// partie auteur
function getAllAuthor(){
	// requete auprès de la base
	$db=connect();
	// On prépare la requête de liste des albums empruntes
    $requete=$db->query('
	SELECT scenariste. * 
	FROM scenariste
	ORDER BY scenariste.nom_scenariste
	');
	// recupération des données
	$auteurs=$requete->fetchAll();
	return$auteurs;
}
function getAuthorAlbums($id){
	// je cherche tous les albums pour l'auteur dont je passe id 
	// connexion à la base de données
	$base=connect();
	// requete auprès de la base  
	$requete=$base->prepare('SELECT album.*,
	dessinateur.nom_dessinateur,dessinateur.prenom_dessinateur,
	scenariste.nom_scenariste,scenariste.prenom_scenariste,
	coloriste.nom_coloriste,coloriste.prenom_coloriste,
	editeur.nom as nom_editeur
	
	FROM album
	inner join dessinateur
	on dessinateur.id=album.id_dessinateur
	
	inner join scenariste
	on scenariste.id=album.id_scenariste
	
	left join coloriste
	on coloriste.id=album.id_coloriste
	
	inner join editeur
	on editeur.id=album.id_editeur
	
	where 
	scenariste.id =:monid;
	ORDER BY album.titre
	');
    // On exécute en passant les valeurs pour chaque token
    $requete->execute([
		":monid"            => $id	
	]);
    // recupération des données
	$albums=$requete->fetchAll();
 	//var_dump($albums);
return$albums;
}

// partie dessinateur
function getAllDrawers(){
	// requete auprès de la base
	$db=connect();
	// On prépare la requête de liste des albums de ce dessinateur (id passée)
    $requete=$db->query('
	SELECT dessinateur. * 
	FROM dessinateur
	ORDER BY dessinateur.nom_dessinateur
	');
	// recupération des données
	$dessinateurs=$requete->fetchAll();
	return$dessinateurs;
}
function getDrawerAlbums($id){
	// je cherche tous les albums pour le dessinateur dont je passe id 
	// connexion à la base de données
	$base=connect();
	// requete auprès de la base  
	$requete=$base->prepare('SELECT album.*,
	dessinateur.nom_dessinateur,dessinateur.prenom_dessinateur,
	scenariste.nom_scenariste,scenariste.prenom_scenariste,
	coloriste.nom_coloriste,coloriste.prenom_coloriste,
	editeur.nom as nom_editeur
	
	FROM album
	inner join dessinateur
	on dessinateur.id=album.id_dessinateur
	
	inner join scenariste
	on scenariste.id=album.id_scenariste
	
	left join coloriste
	on coloriste.id=album.id_coloriste
	
	inner join editeur
	on editeur.id=album.id_editeur
	
	where 
	dessinateur.id =:monid;
	ORDER BY album.titre
	');
    // On exécute en passant les valeurs pour chaque token
    $requete->execute([
		":monid"            => $id	
	]);
    // recupération des données
	$albums=$requete->fetchAll();
 	//var_dump($albums);
return$albums;
}
function getInfoScenariste($id){
		// requete auprès de la base
	$db=connect();
	// On prépare la requête de liste des dessinateurs
    $requete=$db->prepare('
	SELECT scenariste.* 
	FROM   scenariste
    WHERE id=:monid
	');
	// On exécute en passant les valeurs pour chaque token
    $requete->execute([
		":monid" => $id	
	]);
    // recupération des données
	$scenariste=$requete->fetch();
	return$scenariste;	
}

function getInfoDessinateur($id){
	// requete auprès de la base
	$db=connect();
	// On prépare la requête de liste des dessinateurs
    $requete=$db->prepare('
	SELECT dessinateur.* 
	FROM   dessinateur
    WHERE id=:monid
	');
	// On exécute en passant les valeurs pour chaque token
    $requete->execute([
		":monid" => $id	
	]);
    // recupération des données
	$dessinateur=$requete->fetch();
	return$dessinateur;	
}

function getInfoColoriste($id){
	// requete auprès de la base
	$db=connect();
	// On prépare la requête de liste des coloristes
    $requete=$db->prepare('
	SELECT coloriste.* 
	FROM   coloriste
    WHERE id=:monid
	');
	// On exécute en passant les valeurs pour chaque token
    $requete->execute([
		":monid" => $id	
	]);
    // recupération des données
	$coloriste=$requete->fetch();
	return	$coloriste;	
}

function getAllDessinateurs()
{
	// requete auprès de la base
	$db=connect();
	// On prépare la requête de liste des dessinateurs
    $requete=$db->query('
	SELECT dessinateur. * 
	FROM   dessinateur
	ORDER BY dessinateur.nom_dessinateur
	');
	// recupération des données
	$dessinateurs=$requete->fetchAll();
	return$dessinateurs;
}
// partie coloriste
function getAllColoristes()
{
	// requete auprès de la base
	$db=connect();
	// On prépare la requête de liste des graphistes
    $requete=$db->query('
	SELECT coloriste. * 
	FROM   coloriste
	ORDER BY coloriste.nom_coloriste
	');
	// recupération des données
	$coloristes=$requete->fetchAll();
	return$coloristes;
}
function getcoloristeAlbums($id){
	// je cherche tous les albums pour cecoloriste dont je passe id 
	// connexion à la base de données
	$base=connect();
	// requete auprès de la base  
	$requete=$base->prepare('SELECT album.*,
	dessinateur.nom_dessinateur,dessinateur.prenom_dessinateur,
	scenariste.nom_scenariste,scenariste.prenom_scenariste,
	coloriste.nom_coloriste,coloriste.prenom_coloriste,
	editeur.nom as nom_editeur
	
	FROM album
	inner join dessinateur
	on dessinateur.id=album.id_dessinateur
	
	inner join scenariste
	on scenariste.id=album.id_scenariste
	
	left join coloriste
	on coloriste.id=album.id_coloriste
	
	inner join editeur
	on editeur.id=album.id_editeur
	
	where 
    coloriste.id =:monid;
	ORDER BY album.titre
	');
    // On exécute en passant les valeurs pour chaque token
    $requete->execute([
		":monid"            => $id	
	]);
    // recupération des données
	$albums=$requete->fetchAll();
    //var_dump($albums);
return$albums;
}
function verificationNouveauteC($nom,$prenom){
// var_dump("on est dans verification");
	// var_dump($nom);
	// var_dump($prenom);
	// connexion à la base de données
	$base=connect();
	// requete auprès de la base  
	$requete=$base->prepare('SELECT * FROM  `coloriste` 
   WHERE  `nom_coloriste` =  :nomauteur ');
	// On exécute en passant les valeurs pour chaque token
    $requete->execute([
		":nomauteur"  => $nom]);
	// ":prenomauteur"  => $prenom
	$resultat=$requete->fetch();
    $existence= (empty($resultat)) ? 'ko' : 'ok';
 	// var_dump($existence);
	return $existence;
    }

// partie editeur
function getAllEditeurs()
{
	// requete auprès de la base
	$db=connect();
	// On prépare la requête de liste des graphistes
    $requete=$db->query('
	SELECT editeur. * 
	FROM   editeur
	ORDER BY editeur.nom
	');
	// recupération des données
	$editeurs=$requete->fetchAll();
	return$editeurs;
}

function getInfoEditeur($id){
	$db=connect();
	// On prépare la requête de liste des albums de cet editeur
    $requete=$db->prepare('
	SELECT editeur.* 
	FROM   editeur
    WHERE editeur.id=:monid
	');
	// On exécute en passant les valeurs pour chaque token
    $requete->execute([
		":monid" => $id	
	]);
    // recupération des données
	$editeur=$requete->fetch();
	return	$editeur;	
}

function ajouterCEditeur($nom){
	var_dump($nom);
// requete auprès de la base
	$db=connect();
	// On prépare la requête INSERT INTO table VALUES ('valeur 1', 'valeur 2', ...)
	$query=$db->prepare('INSERT INTO `editeur` SET 
    	`nom`   =:nom	
	');
	// On exécute en passant les valeurs pour chaque token
    $message=$query->execute([
		":nom"     => $nom
		]);
	// 	
	var_dump($message);
 	return ; 
}
function getEditeurAlbums($id){
    	// je cherche tous les albums pour ce coloriste dont je passe id 
	// connexion à la base de données
	$base=connect();
	// requete auprès de la base  
	$requete=$base->prepare('SELECT album.*,
	dessinateur.nom_dessinateur,dessinateur.prenom_dessinateur,
	scenariste.nom_scenariste,scenariste.prenom_scenariste,
	coloriste.nom_coloriste,coloriste.prenom_coloriste,
	editeur.nom as nom_editeur
	
	FROM album
	inner join dessinateur
	on dessinateur.id=album.id_dessinateur
	
	inner join scenariste
	on scenariste.id=album.id_scenariste
	
	left join coloriste
	on coloriste.id=album.id_coloriste
	
	inner join editeur
	on editeur.id=album.id_editeur
	
	where 
    editeur.id =:monid;
	ORDER BY album.titre
	');
    // On exécute en passant les valeurs pour chaque token
    $requete->execute([
		":monid"  => $id	
	]);
    // recupération des données
	$albums=$requete->fetchAll();
    //var_dump($albums);
return$albums;

}
//// partie editeur//





function rechercheAlbums($partietitre){
	// var_dump("on est dans la fonction");
	//  creation de $morceauachercher variable avec le bout de titre 
	$a="%";
	$morceauachercher=$a.$partietitre.$a;
	//var_dump($morceauachercher);
	// connexion à la base de données
	$db=connect();
	// requete auprès de la base 
	$query = $db->prepare('
	SELECT album.*,
	dessinateur.nom_dessinateur,dessinateur.prenom_dessinateur,
	scenariste.nom_scenariste,scenariste.prenom_scenariste,
	coloriste.nom_coloriste,coloriste.prenom_coloriste,
	editeur.nom as nom_editeur
	
	FROM album
	inner join dessinateur
	on dessinateur.id=album.id_dessinateur
	
	inner join scenariste
	on scenariste.id=album.id_scenariste
	
	left join coloriste
	on coloriste.id=album.id_coloriste
	
	inner join editeur
	on editeur.id=album.id_editeur
	
	where album.titre like  :montitre;

	ORDER BY album.titre
	');

	$query->execute([
		":montitre"       => $morceauachercher]);

	// recupération des données
	$lalbumsrecherche=$query->fetchAll();
	// var_dump($lalbumsrecherche);
	return$lalbumsrecherche;
}

function rechercheSiAuteur($nomsaisi){
    //	var_dump($nomsaisi);
	//  var_dump("on est dans la fonction recherche nom ");
    $db=connect();
    $nomsaisi=strtoupper($nomsaisi);
    //var_dump($nomsaisi);
	// On prépare la requête de liste des scenaristes
    $requete=$db->prepare('
	SELECT id 
	FROM  scenariste
    WHERE nom_scenariste like :masaisie
	');
	// On exécute en passant les valeurs pour chaque token
    $requete->execute([
		":masaisie" => $nomsaisi
	]);
    // recupération des données
	$resultatS=$requete->fetch();
	// var_dump($resultatS);
	// var_dump("on a fini  dans la fonction recherche nom ");
	return$resultatS;	
}

function rechercheSiDessinateur($nomsaisi){
	// var_dump($nomsaisi);
	//var_dump("on est dans la fonction recherche nom ");
    $db=connect();
	// On prépare la requête de liste des dessinateurs
    $requete=$db->prepare('
	SELECT id 
	FROM  dessinateur
    WHERE nom_dessinateur = :masaisie
	');
	// On exécute en passant les valeurs pour chaque token
    $requete->execute([
		":masaisie" => $nomsaisi
	]);
    // recupération des données
	$resultatD=$requete->fetch();
    //var_dump($resultatD);
	//var_dump("on a fini  dans la fonction recherche nom ");
	return$resultatD;	
}
function rechercheSiColoriste($nomsaisi){
	//var_dump($nomsaisi);
	//var_dump("on est dans la fonction recherche nom ");
    $db=connect();
	// On prépare la requête de liste des dessinateurs
    $requete=$db->prepare('
	SELECT id 
	FROM  coloriste
    WHERE nom_coloriste = :masaisie
	');
	// On exécute en passant les valeurs pour chaque token
    $requete->execute([
		":masaisie" => $nomsaisi
	]);
    // recupération des données
	$resultatC=$requete->fetch();
	// var_dump($resultatC);
	//var_dump("on a fini  dans la fonction recherche nom ");
	return$resultatC;	
}

function modifUnScenariste($id,$nomscenariste,$prenomscenariste,$pseudo,$nationalite){
	$db=connect();
	// On prépare la requête de mise à jour 
	// (donc attention aux codes malveillants )
	$query=$db->prepare('UPDATE `scenariste` SET 
	`nom_scenariste`   =:nom,
	`prenom_scenariste`=:prenom,
	`Pseudo`           =:monpseudo,
	`nationalite`      =:nationalite
	
	 WHERE id=:monid
	');
	
    $message=$query->execute([
	":monid"        => $id,
	":nom"          => $nomscenariste,
	":prenom"       => $prenomscenariste,
    ":monpseudo"    => $pseudo,
	":nationalite"  => $nationalite
	]);
	//var_dump($message);
 	return $message;
}
function modifUnDessinateur($id,$nomdessinateur,$prenomdessinateur,$photo,$nationalite){
	$db=connect();
	// On prépare la requête de mise à jour 
	// (donc attention aux codes malveillants )
	$query=$db->prepare('UPDATE `dessinateur` SET 
	`nom_dessinateur`   =:nom,
	`prenom_dessinateur`=:prenom,
	`photo`             =:saphoto,
	`nationalite`       =:nationalite
	
	 WHERE id=:monid
	');
	
    $message=$query->execute([
	":monid"        => $id,
	":nom"          => $nomdessinateur,
	":prenom"       => $prenomdessinateur,
    ":saphoto"      => $photo,
	":nationalite"  => $nationalite
	]);
	//var_dump($message);
 	return $message;
}

function modifUnColoriste($id,$nomcoloriste,$prenomcoloriste,$nationalite){
	$db=connect();
	// On prépare la requête de mise à jour 
	// (donc attention aux codes malveillants )
	$query=$db->prepare('UPDATE `coloriste` SET 
	`nom_coloriste`   =:nom,
	`prenom_coloriste`=:prenom,
	`nationalite`       =:nationalite
	
	 WHERE id=:monid
	');
	
    $message=$query->execute([
	":monid"        => $id,
	":nom"          => $nomcoloriste,
	":prenom"       => $prenomcoloriste,
	":nationalite"  => $nationalite
	]);
	//var_dump($message);
 	return $message;
}
function modifUnEditeur ($id,$nom){
	$db=connect();
	// On prépare la requête de mise à jour 
	// (donc attention aux codes malveillants )
	$query=$db->prepare('UPDATE `editeur` SET 
	`nom`   =:sonnom
	 WHERE id=:monid
	');
	
    $message=$query->execute([
	":monid"        => $id,
	":sonnom"          => $nom
	]);
	//var_dump($message);
 	return $message;
}
// fin de fichier	
?> 