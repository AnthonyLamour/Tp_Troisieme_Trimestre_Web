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
</head>

<!--contenu de la page-->
<body>
	
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
            <input type="button" id="RecupButtonScore" value="Recuperer" onclick='RecupererInfo("AffichageDuFichierJSONScore","get_highscores","scores","score")'/>
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
            <input type="button" id="RecupButtonComment" value="Recuperer" onclick='RecupererInfo("AffichageDuFichierJSONComment","get_comments","comments","comment")'/>
        </form>
    </fieldset>

	<!--Contenu de la page-->
    <div id="AffichageDuFichierJSONComment">
    
    </div>
    
	<!--script js-->
    <script>
		//fonction permettant d'ajouter du score
        function AjouterUneInfo(ScoreOrComment,action,idParamUsername,idParamInfo){
			//vérification du formulaire
			if(VerifFormulaireAjout(ScoreOrComment)){

				//définition de l'action
				var actionParam = action;
				//définition du username
				var usernameParam = document.getElementById(idParamUsername).value;
				//définition de l'information à ajouter
				var infoParam = document.getElementById(idParamInfo).value;

				//création d'une requête XMLHttpRequest
				var xhttp = new XMLHttpRequest();

				//lorsque la requête est envoyé
				xhttp.onreadystatechange = function () {
					//si la requête est prête
					if (this.readyState == 4 && this.status == 200) {
						//affichage du résultat dans la console
						console.log(this.responseText);
					}
				};

				//ouverture du fichier XML
				xhttp.open("GET", "PHP/InteractionAvecJSON.php?action=" + actionParam +"&username="+usernameParam+"&info="+infoParam, true);
				//envoi de la requète
				xhttp.send();
			}
        }

		//fonction permettant de récupérer les scores
		function RecupererInfo(idDivAffichage,action,selectedcol,infoType){

			//récupération du div
			MainContent=document.getElementById(idDivAffichage);
			//reset du div de résultat
			MainContent.innerHTML="";

			//définition de l'action
			var actionParam = action;

			//création d'une requête XMLHttpRequest
			var xhttp = new XMLHttpRequest();

			//lorsque la requête est envoyé
			xhttp.onreadystatechange = function () {
				//si la requête est prête
				if (this.readyState == 4 && this.status == 200) {
					
					//affichage du résultat dans la console
					console.log(this.responseText);

					//récupération du contenu json
                    var json = JSON.parse(this.responseText);
					//création d'un nouveau tableau HTML
					var newTable = document.createElement("table");
					//création d'un nouveau head pour le tableau
					var newHeader = document.createElement("thead");
					//création d'une nouvelle ligne
					var newline = document.createElement("tr");
					//création d'une nouvelle colone
					var newcol = document.createElement("th");
					//set de l'attribut pour que le head est une taille de 2 colone
					newcol.setAttribute("colspan","2");
					//set du innerHTML de la colone
					newcol.innerHTML=json["gameId"];
					//ajout de la colone à la ligne
					newline.appendChild(newcol);
					//ajout de la ligne au header
					newHeader.appendChild(newline);
					//ajout du header au tableau
					newTable.appendChild(newHeader);

					//création d'un nouveau body pour le tableau
					var newTableBody=document.createElement("tbody");
					//création d'une nouvelle ligne
					newline = document.createElement("tr");
					//création d'une nouvelle colone
					newcol = document.createElement("td");
					//ajout du numéro de call
					newcol.innerHTML="username";
					//ajout de la colone à la ligne
					newline.appendChild(newcol);
					//création d'une nouvelle colone
					newcol = document.createElement("td");
					//ajout du call
					newcol.innerHTML=selectedcol;
					//ajout de la colone à la ligne
					newline.appendChild(newcol);
					//ajout de la ligne au tableau
					newTableBody.appendChild(newline);

					//pour chaque call
					for(var i=0;i<json[selectedcol].length;i++){
						//création d'une nouvelle ligne
						newline = document.createElement("tr");
						//création d'une nouvelle colone
						newcol = document.createElement("td");
						//ajout du numéro de call
						newcol.innerHTML=json[selectedcol][i]["username"];
						//ajout de la colone à la ligne
						newline.appendChild(newcol);
						//création d'une nouvelle colone
						newcol = document.createElement("td");
						//ajout du call
						newcol.innerHTML=json[selectedcol][i][infoType];
						//ajout de la colone à la ligne
						newline.appendChild(newcol);
						//ajout de la ligne au tableau
						newTableBody.appendChild(newline);
					}
					//ajout du body au tableau
					newTable.appendChild(newTableBody);

					//ajout du tableau à la page
					MainContent.appendChild(newTable);
				}
			};

			//ouverture du fichier XML
			xhttp.open("GET", "PHP/InteractionAvecJSON.php?action=" + actionParam, true);
			//envoi de la requète
			xhttp.send();	
        }
    </script>
	
    <!--footer-->
    <footer>
        <!--paragraphe de footer-->
        <p>Anthony LAMOUR étudiant en Master 2 à Ludus Académie</p>
    </footer>
</body>

</html>