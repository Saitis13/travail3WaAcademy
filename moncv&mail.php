<?php
 require_once('templates/partials/header1.phtml');
?>
    <main>
        <h1>CURRICULUM VITAE de Bernard RAPHAËL</h1>
        
        <div id="civilite">
             <p> <span>Bernard RAPHAËL</span></p>  
             <p> 19 av de la Martheline</p>
             <p> Le Lancier</p> 
             <p> 13009 MARSEILLE</p>  
             <p> Tel: 07.77.92.65.48 </p>
             <p> E-Mail: bernard.raphael@laposte.net</p> 
        </div>
        
        <h2> Développeur Intégrateur WEB</h2>
        <h3> Créateur de solutions</h3>
        <div id="parcours">
             <p> <span>2009 - 2017 RESPONSABLE DE DEVELOPPEMENT</span> -DRILNET Marseille 100p CA > 8M€. Mission : Permettre la distribution d’une application « serious game » de formation dédiée
au domaine pétrolier.</p>
             <ul>
            		<li>  Upgrade sous ADOBE Director 8,6 à 11,5 (langage Lingo, M.u.s). 
                		<ul>
                            <li>Création : des applications de gestion de données 
                                <ul>
                                   <li>commerciales.</li>
                                   <li>gestion des évaluations et notes.</li>
                                   <li>gestion des droits des utilisateurs</li>
                                </ul>
                            </li>    
                        <li> Modification de la résolution de l’ensemble du contenu de l’application.</li>
                        <li> De la navigation (ergonomie).</li>
                        <li> Du Quizz (validation des acquis).</li>
                        <li> Du Pré quizz (partie serveur et application).</li>
                        <li> Intégration d'éléments 3D créé ex nihilo.</li>
                        <li> Établissement d’une retro-ingénierie palliant à l’absence d’un cahier des charges initial.</li>
                        </ul>
                    </li>
            		<li>  Création : d'un éditeur de document infalsifiable et, de réalisation commerciale 3D. </li>
            		<li> Gestion du parc informatique hardware.</li>
    		 </ul>
    		
             <p> <span>2005 - 2006 FORMATEUR INFORMATIQUE </span>- AFTC 13 Assoc 1901 Aix en Provence – Aubagne. Enseigne auprès d’une dizaine d’apprenants. Logiciels : Suite Office, création d'un journal, langage : initiation au html 3.Maintenance informatique 1er niveau.</p>
             <p> <span>2004 - 2005 ADJOINT ADMINISTRATIF </span>- Université de la Méditerranée Service Administratif Recherche. Assistance et consolidation de dossiers de financement Ministériel ; 95 UR. En charge de leur contrôle budgétaire. Gestion des fournisseurs.</p> 
             <p> <span>2001 - TECHNICIEN DE MAINTENANCE HARD ET SOFT</span>-École Supérieure des ingénieurs de Luminy. Serveur et parc (250 machines). Mise en place des structures informatiques à la demande.</p> 
             <p> <span>2001 - DEVELOPPEUR </span>- Societé MathInformatique sous-traitant IBM pour la Caisse d'Epargne Modification des interfaces des terminaux de caisse ( affichage et calcul) pour le basculement Franc €uro (langague OS2)</p>
             <p> <span>2000 - DEVELOPPEUR (stage DU)</span>-Societé Média Pétrole Elaboration du code pour mettre en réseau et Internet un serious game </p> 
        </div>

        <h5> Formations </h5>
        <div id="formations">
             <p> <span>2017 (en cours) Developpeur Intégrateur Web</span> -societe 3WA - Marseille </p> 
             <p> <span>2014 ITIL Foundation Certificate in IT Service Management</span> -societe AXELOS Management du systeme d'information,infrastructure des technologies de l'information </p>
             <p> <span>2000 Licence Développement d'application et génie logiciel </span>Universite Aix Marseille III</p> 
             <p> <span>1989 Doctorat de Biologie </span>Universite Sciences et techniques du Languedoc - Montpellier</p>
        </div>

        <div id="divers">
             <p> <span>Anglais</span> : Pratique et cours régulier sur le dernier poste, niveau opérationnel de base.</p>  
             <p> <span>Languages</span> :PHP/MYSQL, HTML5, CSS, C,OS2,  Lingo </p>
             <p> <span>Logiciels</span> :Suite Office, Open Office, 3D</p>    
        </div>  
             
        <section id="contact" class="container">
			<h2>Contactez-moi</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
			<form   method="POST" action="libraries/application.php">
				<input type="text" name="name" placeholder="Votre prénom">
				<input type="text" name="mail" placeholder="Votre mail">
				<textarea name="message" rows="1" placeholder="Votre message"></textarea>
				<button type="submit" name="button">Envoyer</button>
				<button type="reset" name="button">Effacer</button>
			</form>
		</section>
        
    </main>

<?php
require_once('templates/partials/footer.phtml');
?>
