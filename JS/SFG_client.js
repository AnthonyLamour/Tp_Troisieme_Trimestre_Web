//class SFG
class SFG extends EventTarget{

    //lien vers le fichier php de SFG
    SFGLink;

    //constructeur
    constructor(newSFGLink) {
        super();
        //initialisation du lien
        this.SFGLink = newSFGLink;
    }

    //fonction permettant d'installer SFG
    Install(gameId,password) {
        //vérification du formulaire
        if (VerifFormulaireInstall()) {
            //création de l'objet JSON
            var datasJSON = {
                'action': "install",
                'gameId': gameId,
                'password': password
            };

            //convertion de l'objet JSON en chaine pour le passer en paramètre
            var dbParam = JSON.stringify(datasJSON);

            //création d'une requête XMLHttpRequest
            var xhttp = new XMLHttpRequest();

            //lorsque la requête est envoyé
            xhttp.onreadystatechange = function () {
                //si la requête est prête
                if (this.readyState == 4 && this.status == 200) {
                    //affichage du résultat dans la console
                    console.log(this.responseText);
                    location.reload();
                }
            };

            //affichage de l'installation dans la console
            console.log("SFG install");

            //ouverture du fichier XML
            xhttp.open("GET", "PHP/SFG.php?request=" + dbParam, true);
            //envoi de la requète
            xhttp.send();
        }
    }

    //fonction permettant de réinstaller l'api SFG
    Reinstall(password) {
        //vérification du formulaire
        if (VerifFormulaireReinstall()) {
            //création de l'objet JSON
            var datasJSON = {
                'action': "reinstall",
                'password': password
            };

            //convertion de l'objet JSON en chaine pour le passer en paramètre
            var dbParam = JSON.stringify(datasJSON);

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

            //affichage de la réinstallation dans la console
            console.log("SFG reinstall");

            //ouverture du fichier XML
            xhttp.open("GET", "PHP/SFG.php?request=" + dbParam, true);
            //envoi de la requète
            xhttp.send();
        }
    }

    //fonction permettant d'ajouter une info
    AjouterInfo(ScoreOrComment, action, ParamUsername, ParamInfo) {
        //vérification du formulaire
        if (VerifFormulaireAjout(ScoreOrComment)) {

            //création de l'objet JSON
            var datasJSON = {
                'action': action,
                'username': ParamUsername,
                'info': ParamInfo
            };
            //convertion de l'objet JSON en chaine pour le passer en paramètre
            var dbParam = JSON.stringify(datasJSON);

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
            xhttp.open("GET", "PHP/SFG.php?request=" + dbParam, true);
            //envoi de la requète
            xhttp.send();
        }
    }

    //fonction permettant de récupérer des infos
    RecupererInfos(DivAffichage, action, selectedcol, infoType, ScoreOrComment) {

        //récupération du div
        var MainContent = DivAffichage;
        //reset du div de résultat
        MainContent.innerHTML = "";

        //création de l'objet JSON
        var datasJSON = { 'action': action };
        //convertion de l'objet JSON en chaine pour le passer en paramètre
        var dbParam = JSON.stringify(datasJSON);

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
                if (!json["success"]) {
                    //création d'une nouvelle colone du tableau
                    var newError = document.createElement("span");
                    //set de l'attribut class de la case
                    newError.setAttribute("class", "ErrorPrint");
                    //remplissage de la case
                    newError.innerHTML = "erreur " + json["error"]["code"] + " " + json["error"]["message"];
                    //ajout de la case dans la ligne
                    MainContent.appendChild(newError);
                } else {
                    //création d'un nouveau tableau HTML
                    var newTable = document.createElement("table");
                    //création d'un nouveau head pour le tableau
                    var newHeader = document.createElement("thead");
                    //création d'une nouvelle ligne
                    var newline = document.createElement("tr");
                    //création d'une nouvelle colone
                    var newcol = document.createElement("th");
                    //set de l'attribut pour que le head est une taille de 2 colone
                    if (ScoreOrComment) {
                        newcol.setAttribute("colspan", "2");
                    } else {
                        newcol.setAttribute("colspan", "3");
                    }
                    //set du innerHTML de la colone
                    newcol.innerHTML = json["data"]["gameId"];
                    //ajout de la colone à la ligne
                    newline.appendChild(newcol);
                    //ajout de la ligne au header
                    newHeader.appendChild(newline);
                    //ajout du header au tableau
                    newTable.appendChild(newHeader);

                    //création d'un nouveau body pour le tableau
                    var newTableBody = document.createElement("tbody");
                    //création d'une nouvelle ligne
                    newline = document.createElement("tr");
                    //création d'une nouvelle colone
                    newcol = document.createElement("td");
                    //ajout du numéro de call
                    newcol.innerHTML = "username";
                    //ajout de la colone à la ligne
                    newline.appendChild(newcol);
                    //création d'une nouvelle colone
                    newcol = document.createElement("td");
                    //ajout du call
                    newcol.innerHTML = selectedcol;
                    //ajout de la colone à la ligne
                    newline.appendChild(newcol);

                    if (!ScoreOrComment) {
                        newcol = document.createElement("td");
                        //ajout du call
                        newcol.innerHTML = "date";
                        //ajout de la colone à la ligne
                        newline.appendChild(newcol);
                    }

                    //ajout de la ligne au tableau
                    newTableBody.appendChild(newline);

                    //pour chaque call
                    for (var i = 0; i < json["data"][selectedcol].length; i++) {
                        //création d'une nouvelle ligne
                        newline = document.createElement("tr");
                        //création d'une nouvelle colone
                        newcol = document.createElement("td");
                        //ajout du numéro de call
                        newcol.innerHTML = json["data"][selectedcol][i]["username"];
                        //ajout de la colone à la ligne
                        newline.appendChild(newcol);
                        //création d'une nouvelle colone
                        newcol = document.createElement("td");
                        //ajout du call
                        newcol.innerHTML = json["data"][selectedcol][i][infoType];
                        //ajout de la colone à la ligne
                        newline.appendChild(newcol);

                        if (!ScoreOrComment) {
                            //création d'une nouvelle colone
                            newcol = document.createElement("td");
                            //ajout du call
                            newcol.innerHTML = json["data"][selectedcol][i]["date"];
                            //ajout de la colone à la ligne
                            newline.appendChild(newcol);
                        }

                        //ajout de la ligne au tableau
                        newTableBody.appendChild(newline);
                    }
                    //ajout du body au tableau
                    newTable.appendChild(newTableBody);

                    //ajout du tableau à la page
                    MainContent.appendChild(newTable);
                }
            }
        };

        //ouverture du fichier XML
        xhttp.open("GET", "PHP/SFG.php?request=" + dbParam, true);
        //envoi de la requète
        xhttp.send();
    }
}