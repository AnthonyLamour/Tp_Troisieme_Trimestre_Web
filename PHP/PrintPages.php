<?php

	//fonction permettant d'afficher la page d'installation
	function PrintInstallPage(){
		//affichage du titre de la page
		echo '<h1>Simply File Games</h1>';
			
		//mise en place du fieldset
		echo '<fieldset id="Install">';
			
		//mise en place de la légende
		echo '<legend id="instalLegend">
				Installation
			</legend>';

		//mise en place du formulaire
		echo '<form class="MainFormulaire">';

		//mise en place de l'input gameId
		echo' <label id="labelGameId" for="gameId">Nom de votre jeu :</label>
				<span id="errorGameId"></span>
				<input type="text" id="gameId" placeholder="nom de votre jeu" />';
			
		//mise en place de l'input mot de passe
		echo '<label for="password">Mot de passe :</label>
				<span id="errorPassword"></span>
				<input type="password" id="password"/>';
			
		//mise en place du bouton de validation
		echo'<input type="button" id="InstallButton" value="Install" onclick=\'InstallSFG()\'/>';
					
		//fermeture du formulaire
		echo'</form>';
				
		//fermeture du fieldset
		echo'</fieldset>';
	}

	//fonction permettant d'afficher la page d'acceuil
	function PrintHomePage(){
		//affichage du titre de la page
		echo '<h1>Simply File Games</h1>';

		//affichage du sous-titre de la page
		echo '<h2>Bienvenue</h2>';

		//mise en place de la section
		echo '<section>';

		//mise en place de l'article
		echo '<article>';

		//mise en place du texte
		echo '<p>Voici des ressources de Simply File Games :</p>';

		//mise en place de la liste
		echo '<ul>';

		//mise en place des liens
		echo '<li><a href = "?page=Highscores">Highscores</a></li>';
		echo '<li><a href = "?page=Comments">Commentaires</a></li>';
		echo '<li><a href = "?page=Reset">Réinstallation</a></li>';

		//fermeture de la liste
		echo '</ul>';

		//fermeture de l'article
		echo '</article>';

		//fermeture de la section
		echo '</section>';
	}

	//fonction permettant d'afficher la page d'Highscores
	function PrintHighscoresPage(){

		//affichage du titre de la page
		echo '<h1>Simply File Games</h1>';

		//mise en place du fieldset
		echo'<fieldset id="AjoutUnScore">';

		//mise en place de la légende
		echo'<legend>
				Gestion de highscores
			</legend>';

		//mise en place du formulaire
		echo'<form class="MainFormulaire">';

		//mise en place de l'input username
		echo'<label for="usernameScore">Username :</label>
			 <span id="errorUsernameScore"></span>
			 <input type="text" id="usernameScore" placeholder="username" />';

		//mise en place de l'input score
		echo'<label for="score">Score :</label>
			 <span id="errorScore"></span>
			 <input type="number" id="score" placeholder="00" />';

		//mise en place du bouton d'ajout de score
		echo'<input type="button" id="AjoutButtonScore" value="Ajouter" onclick=\'AjouterUneInfo(true,"set_highscore","usernameScore","score")\'/>';

		//mise en place du bouton de récupération de scores
		echo'<input type="button" id="RecupButtonScore" value="Recuperer" onclick=\'RecupererInfo("AffichageDuFichierJSONScore","get_highscores","scores","score",true)\'/>';
		
		//fermeture du formulaire
		echo'</form>';
				
		//fermeture du fieldset
		echo'</fieldset>';
		
		//mise en place du div d'affichage
		echo'<div id="AffichageDuFichierJSONScore">
    
			 </div>';
	}

	//fonction permettant d'afficher la page de commentaires
	function PrintCommentsPage(){
		
		//affichage du titre de la page
		echo '<h1>Simply File Games</h1>';

		//mise en place du fieldset
		echo'<fieldset id="AjoutUnCommentaire">';

		//mise en place de la légende
		echo'<legend>
				Gestion de commentaires
			 </legend>';

		//mise en place du formulaire
		echo'<form class="MainFormulaire">';

		//mise en place de l'input username
		echo'<label for="usernameComment">Username :</label>
			 <span id="errorUsernameComment"></span>
			 <input type="text" id="usernameComment" placeholder="username" />';

		//mise en place de l'input comment
		echo'<label for="comment">Commentaire :</label>
			 <span id="errorComment"></span>
			 <textarea id="comment" rows="5" cols="35" placeholder="votre commentaire"></textarea>';

		//mise en place du bouton d'envoi d'un commentaire
		echo'<input type="button" id="AjoutButtonComment" value="Ajouter" onclick=\'AjouterUneInfo(false,"set_comment","usernameComment","comment")\'/>';

		//mise en place du bouton de récupération de commentaires
		echo'<input type="button" id="RecupButtonComment" value="Recuperer" onclick=\'RecupererInfo("AffichageDuFichierJSONComment","get_comments","comments","comment",false)\'/>';
		
		//fermeture du formulaire
		echo'</form>';
				
		//fermeture du fieldset
		echo'</fieldset>';

		//mise en place du div d'affichage
		echo'<div id="AffichageDuFichierJSONComment">
    
			 </div>';
	}

	//fonction permettant d'afficher la page de réinstallation
	function PrintResetPage(){

		//affichage du titre de la page
		echo '<h1>Simply File Games</h1>';

		//mise en place du fieldset
		echo'<fieldset id="Install">';

		//mise en place de la légende
		echo'<legend id="instalLegend">
			 Réinstallation
			 </legend>';

		//mise en place du formulaire
		echo'<form class="MainFormulaire">';

		//mise en place du nom du jeu
		echo'<label id="labelGameId" for="gameId">Nom de votre jeu : </label>';
		//si SFG est installé
		if(file_exists('./data/config.json')){
			//récupération du contenu du fichier en json
			$file_content_json = file_get_contents('./data/config.json');
			//convertion du contenu en tableau
			$file_content_array = json_decode($file_content_json,true);
			//affichage du nom du jeu
			echo $file_content_array['gameId'];
		}else{
			echo "Pas de jeu répertorié.";
		}
		echo'<br/>';
		//mise en place de l'input mot de passe
		echo'<label for="password">Mot de passe :</label>
			 <span id="errorPassword"></span>
			 <input type="password" id="password"/>';

		//mise en place du bouton de reset
		echo '<input type="button" id="InstallButton" value="Install" onclick=\'ReinstallSFG()\'/>';
		
		//fermeture du formulaire
		echo'</form>';

		//fermeture du fieldset
		echo'</fieldset>';
	}
?>