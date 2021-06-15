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
</head>

<!--contenu de la page-->
<body>
	
	<!--titre de la page-->
	<h1>Gestion de fichier JSON en PHP</h1>

	 <!--Contenu de la page-->
    <fieldset id="AjoutUnCall">
        <!--légende du formulaire-->
        <legend>
            Ajouter un call
        </legend>
        <!--Formulaire de la page-->
        <form id="MainFormulaire">
            <!--bouton de validation du formulaire-->
            <input type="button" id="AjoutButton" value="Ajouter" onclick="AjouterUnCall()"/>
        </form>
    </fieldset>

	<!--Contenu de la page-->
    <div id="AffichageDuFichierJSON">
    
    </div>
    
	<!--script js-->
    <script>
		//récupération du div
        MainContent=document.getElementById("AffichageDuFichierJSON");
        function AjouterUnCall(){
            //reset du div de résultat
            MainContent.innerHTML="";
			//création d'une requête XMLHttpRequest
            var xhttp = new XMLHttpRequest();
			//lorsque la requête est envoyé
            xhttp.onreadystatechange = function () {
				//si la requête est prête
                if (this.readyState == 4 && this.status == 200) {
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
					newcol.innerHTML=json["name"];
					//ajout de la colone à la ligne
					newline.appendChild(newcol);
					//ajout de la ligne au header
					newHeader.appendChild(newline);
					//ajout du header au tableau
					newTable.appendChild(newHeader);

					//création d'un nouveau body pour le tableau
					var newTableBody=document.createElement("tbody");

					//pour chaque call
					for(var i=0;i<json["calls"].length;i++){
						//création d'une nouvelle ligne
						newline = document.createElement("tr");
						//création d'une nouvelle colone
						newcol = document.createElement("td");
						//ajout du numéro de call
						newcol.innerHTML="call "+i;
						//ajout de la colone à la ligne
						newline.appendChild(newcol);
						//création d'une nouvelle colone
						newcol = document.createElement("td");
						//ajout du call
						newcol.innerHTML=json["calls"][i];
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
            xhttp.open("GET", "PHP/AjouterUnCall.php", true);
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