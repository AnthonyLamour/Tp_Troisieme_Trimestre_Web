<!DOCTYPE html>

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
	
	<nav id="MainNav">
        <h1>Acceuil :</h1>
        <a href="index.php" class="navLink">acceuil</a>
    </nav>

	<?php

		include "PHP/PrintPages.php";
		//si SFG n'est pas installé
		if(!file_exists("./data/config.json")){
			//afficher la page d'installation
			PrintInstallPage();
		}
		//sinon si une page doit être chargée
		else if(isset($_GET["page"])){
			
			//en fonction de la page à charger
			switch($_GET["page"]){
				//page de Highscores
				case "Highscores":
					//affichage de la page de Highscores
					PrintHighscoresPage();
					break;
				//page de commentaires
				case "Comments":
					//affichage de la page de commentaires
					PrintCommentsPage();
					break;
				//page de commentaires
				case "Reset":
					//affichage de la page de reset
					PrintResetPage();
					break;
				//par défaut
				default:
					//afficher la page d'acceuil
					PrintHomePage();
					break;
			}
		}
		//sinon
		else{
			//afficher la page d'acceuil
			PrintHomePage();
		}
	?>
    
	<!--script js-->
    <script>

		//création de l'objet SFG
		mySFG = new SFG("PHP/SFG.php");

		//fonctoin permettant d'installer l'api SFG
		function InstallSFG(){
			//appelle de la fonction membre Install
			mySFG.Install(document.getElementById("gameId").value,document.getElementById("password").value);
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