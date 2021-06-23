<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<!--head de la page-->
<head>
    <!--encodage de la page-->
    <meta charset="utf-8" />
    <!--titre de la page-->
    <title>Accueil</title>
    <!--lien vers le CSS de la page-->
    <link rel="stylesheet" href="CSS/Style.css" />
    <!--icone de la page-->
    <link rel="icon" href="Images/Icon.jpg">
	<!--lien vers le fichier js de vérification de formulaires-->
    <script type="text/javascript" src="./JS/VerificationFormulaire.js" charset="utf-8"></script>
	<!--lien vers le fichier js de SFG-->
    <script type="text/javascript" src="./JS/SFG_client.js" charset="utf-8"></script>
</head>

<!--contenu de la page-->
<body>

	<!--titre de la page-->
	<h1>Gestion de l'installation</h1>

	 <!--Contenu de la page-->
    <fieldset id="Install">
        <!--légende du formulaire-->
        <legend id="instalLegend">
			<?php
				//modification de la légende en fonction de si SFG est déjà installé
				if(file_exists("./data/config.json")){
					echo 'Réinstallation';
				}else{
					echo 'Installation';
				}
			?>
        </legend>
        <!--Formulaire de la page-->
        <form class="MainFormulaire">
			<?php
				//modification du formulaire en fonction de si SFG est déjà installé
				if(!file_exists("./data/config.json")){
					echo '<!--input gameId-->
						  <label id="labelGameId" for="gameId">Nom de votre jeu :</label>
					      <span id="errorGameId"></span>
					      <input type="text" id="gameId" placeholder="nom de votre jeu" />';
				}
			?>
			
			<!--input password-->
			<label for="password">Mot de passe :</label>
			<span id="errorPassword"></span>
			<input type="password" id="password"/>
			<?php
				//modification du bouton en fonction de si SFG est déjà installé
				if(file_exists("./data/config.json")){
					echo '<!--bouton de validation du formulaire-->
						  <input type="button" id="InstallButton" value="Install" onclick=\'ReinstallSFG()\'/>';
				}else{
					echo '<!--bouton de validation du formulaire-->
						  <input type="button" id="InstallButton" value="Install" onclick=\'InstallSFG()\'/>';
				}
			?>
        </form>
    </fieldset>
	
	<!--titre de la page-->
	<h1>Gestion de highscore</h1>

	 <!--Contenu de la page-->
    <fieldset id="AjoutUnScore">
        <!--légende du formulaire-->
        <legend>
            Ajouter d'un score
        </legend>
        <!--Formulaire de la page-->
        <form class="MainFormulaire">
			<!--input usernameScore-->
			<label for="usernameScore">Username :</label>
			<span id="errorUsernameScore"></span>
			<input type="text" id="usernameScore" placeholder="username" />
			<!--input score-->
			<label for="score">Score :</label>
			<span id="errorScore"></span>
			<input type="number" id="score" placeholder="00" />
            <!--bouton de validation du formulaire-->
            <input type="button" id="AjoutButtonScore" value="Ajouter" onclick='AjouterUneInfo(true,"set_highscore","usernameScore","score")'/>
			<!--bouton de récupération de score-->
            <input type="button" id="RecupButtonScore" value="Recuperer" onclick='RecupererInfo("AffichageDuFichierJSONScore","get_highscores","scores","score",true)'/>
        </form>
    </fieldset>

	<!--Contenu de la page-->
    <div id="AffichageDuFichierJSONScore">
    
    </div>

	<!--titre de la page 2-->
	<h1>Gestion de commentaires</h1>

	 <!--Contenu de la page-->
    <fieldset id="AjoutUnCommentaire">
        <!--légende du formulaire-->
        <legend>
            Ajouter d'un commentaires
        </legend>
        <!--Formulaire de la page-->
        <form class="MainFormulaire">
			<!--input usernameComment-->
			<label for="usernameComment">Username :</label>
			<span id="errorUsernameComment"></span>
			<input type="text" id="usernameComment" placeholder="username" />
			<!--input comment-->
			<label for="comment">Commentaire :</label>
			<span id="errorComment"></span>
			<textarea id="comment" rows="5" cols="35" placeholder="votre commentaire"></textarea>
            <!--bouton de validation du formulaire-->
            <input type="button" id="AjoutButtonComment" value="Ajouter" onclick='AjouterUneInfo(false,"set_comment","usernameComment","comment")'/>
			<!--bouton de récupération de commentaires-->
            <input type="button" id="RecupButtonComment" value="Recuperer" onclick='RecupererInfo("AffichageDuFichierJSONComment","get_comments","comments","comment",false)'/>
        </form>
    </fieldset>

	<!--Contenu de la page-->
    <div id="AffichageDuFichierJSONComment">
    
    </div>
    
	<!--script js-->
    <script>

		//création de l'objet SFG
		mySFG = new SFG("PHP/SFG.php");

		//fonctoin permettant d'installer l'api SFG
		function InstallSFG(){
			//appelle de la fonction membre Install
			mySFG.Install(document.getElementById("gameId").value,document.getElementById("password").value,document.getElementById("labelGameId"),document.getElementById("gameId"),document.getElementById("errorGameId"),document.getElementById("InstallButton"),document.getElementById("instalLegend"));
		}

		//fonction permettant de réinstaller l'api SFG
        function ReinstallSFG(){
			//appelle de la fonction membre Reinstall
			mySFG.Reinstall(document.getElementById("password").value);
        }

		//fonction permettant d'ajouter une info
        function AjouterUneInfo(ScoreOrComment,action,idParamUsername,idParamInfo){
			//appelle de la fonction membre AjoutInfo
			mySFG.AjouterInfo(ScoreOrComment,action,document.getElementById(idParamUsername).value,document.getElementById(idParamInfo).value);
        }

		//fonction permettant de récupérer des infos
		function RecupererInfo(idDivAffichage,action,selectedcol,infoType,ScoreOrComment){
			//appelle de la fonction membre RecupererInfo
			mySFG.RecupererInfos(document.getElementById(idDivAffichage),action,selectedcol,infoType,ScoreOrComment);
        }
    </script>
	
    <!--footer-->
    <footer>
        <!--paragraphe de footer-->
        <p>Anthony LAMOUR étudiant en Master 2 à Ludus Académie</p>
    </footer>
</body>

</html>