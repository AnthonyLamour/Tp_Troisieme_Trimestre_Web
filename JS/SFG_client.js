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
        //v�rification du formulaire
        if (VerifFormulaireInstall()) {
            //cr�ation de l'objet JSON
            var datasJSON = {
                'action': "install",
                'gameId': gameId,
                'password': password
            };

            //convertion de l'objet JSON en chaine pour le passer en param�tre
            var dbParam = JSON.stringify(datasJSON);

            //cr�ation d'une requ�te XMLHttpRequest
            var xhttp = new XMLHttpRequest();

            //lorsque la requ�te est envoy�
            xhttp.onreadystatechange = function () {
                //si la requ�te est pr�te
                if (this.readyState == 4 && this.status == 200) {
                    //affichage du r�sultat dans la console
                    console.log(this.responseText);
                    location.reload();
                }
            };

            //affichage de l'installation dans la console
            console.log("SFG install");

            //ouverture du fichier XML
            xhttp.open("GET", "PHP/SFG.php?request=" + dbParam, true);
            //envoi de la requ�te
            xhttp.send();
        }
    }

    //fonction permettant de r�installer l'api SFG
    Reinstall(password) {
        //v�rification du formulaire
        if (VerifFormulaireReinstall()) {
            //cr�ation de l'objet JSON
            var datasJSON = {
                'action': "reinstall",
                'password': password
            };

            //convertion de l'objet JSON en chaine pour le passer en param�tre
            var dbParam = JSON.stringify(datasJSON);

            //cr�ation d'une requ�te XMLHttpRequest
            var xhttp = new XMLHttpRequest();

            //lorsque la requ�te est envoy�
            xhttp.onreadystatechange = function () {
                //si la requ�te est pr�te
                if (this.readyState == 4 && this.status == 200) {
                    //affichage du r�sultat dans la console
                    console.log(this.responseText);
                }
            };

            //affichage de la r�installation dans la console
            console.log("SFG reinstall");

            //ouverture du fichier XML
            xhttp.open("GET", "PHP/SFG.php?request=" + dbParam, true);
            //envoi de la requ�te
            xhttp.send();
        }
    }

    //fonction permettant d'ajouter une info
    AjouterInfo(ScoreOrComment, action, ParamUsername, ParamInfo) {
        //v�rification du formulaire
        if (VerifFormulaireAjout(ScoreOrComment)) {

            //cr�ation de l'objet JSON
            var datasJSON = {
                'action': action,
                'username': ParamUsername,
                'info': ParamInfo
            };
            //convertion de l'objet JSON en chaine pour le passer en param�tre
            var dbParam = JSON.stringify(datasJSON);

            //cr�ation d'une requ�te XMLHttpRequest
            var xhttp = new XMLHttpRequest();

            //lorsque la requ�te est envoy�
            xhttp.onreadystatechange = function () {
                //si la requ�te est pr�te
                if (this.readyState == 4 && this.status == 200) {
                    //affichage du r�sultat dans la console
                    console.log(this.responseText);
                }
            };

            //ouverture du fichier XML
            xhttp.open("GET", "PHP/SFG.php?request=" + dbParam, true);
            //envoi de la requ�te
            xhttp.send();
        }
    }

    //fonction permettant de r�cup�rer des infos
    RecupererInfos(DivAffichage, action, selectedcol, infoType, ScoreOrComment) {

        //r�cup�ration du div
        var MainContent = DivAffichage;
        //reset du div de r�sultat
        MainContent.innerHTML = "";

        //cr�ation de l'objet JSON
        var datasJSON = { 'action': action };
        //convertion de l'objet JSON en chaine pour le passer en param�tre
        var dbParam = JSON.stringify(datasJSON);

        //cr�ation d'une requ�te XMLHttpRequest
        var xhttp = new XMLHttpRequest();

        //lorsque la requ�te est envoy�
        xhttp.onreadystatechange = function () {
            //si la requ�te est pr�te
            if (this.readyState == 4 && this.status == 200) {

                //affichage du r�sultat dans la console
                console.log(this.responseText);

                //r�cup�ration du contenu json
                var json = JSON.parse(this.responseText);
                if (!json["success"]) {
                    //cr�ation d'une nouvelle colone du tableau
                    var newError = document.createElement("span");
                    //set de l'attribut class de la case
                    newError.setAttribute("class", "ErrorPrint");
                    //remplissage de la case
                    newError.innerHTML = "erreur " + json["error"]["code"] + " " + json["error"]["message"];
                    //ajout de la case dans la ligne
                    MainContent.appendChild(newError);
                } else {
                    //cr�ation d'un nouveau tableau HTML
                    var newTable = document.createElement("table");
                    //cr�ation d'un nouveau head pour le tableau
                    var newHeader = document.createElement("thead");
                    //cr�ation d'une nouvelle ligne
                    var newline = document.createElement("tr");
                    //cr�ation d'une nouvelle colone
                    var newcol = document.createElement("th");
                    //set de l'attribut pour que le head est une taille de 2 colone
                    if (ScoreOrComment) {
                        newcol.setAttribute("colspan", "2");
                    } else {
                        newcol.setAttribute("colspan", "3");
                    }
                    //set du innerHTML de la colone
                    newcol.innerHTML = json["data"]["gameId"];
                    //ajout de la colone � la ligne
                    newline.appendChild(newcol);
                    //ajout de la ligne au header
                    newHeader.appendChild(newline);
                    //ajout du header au tableau
                    newTable.appendChild(newHeader);

                    //cr�ation d'un nouveau body pour le tableau
                    var newTableBody = document.createElement("tbody");
                    //cr�ation d'une nouvelle ligne
                    newline = document.createElement("tr");
                    //cr�ation d'une nouvelle colone
                    newcol = document.createElement("td");
                    //ajout du num�ro de call
                    newcol.innerHTML = "username";
                    //ajout de la colone � la ligne
                    newline.appendChild(newcol);
                    //cr�ation d'une nouvelle colone
                    newcol = document.createElement("td");
                    //ajout du call
                    newcol.innerHTML = selectedcol;
                    //ajout de la colone � la ligne
                    newline.appendChild(newcol);

                    if (!ScoreOrComment) {
                        newcol = document.createElement("td");
                        //ajout du call
                        newcol.innerHTML = "date";
                        //ajout de la colone � la ligne
                        newline.appendChild(newcol);
                    }

                    //ajout de la ligne au tableau
                    newTableBody.appendChild(newline);

                    //pour chaque call
                    for (var i = 0; i < json["data"][selectedcol].length; i++) {
                        //cr�ation d'une nouvelle ligne
                        newline = document.createElement("tr");
                        //cr�ation d'une nouvelle colone
                        newcol = document.createElement("td");
                        //ajout du num�ro de call
                        newcol.innerHTML = json["data"][selectedcol][i]["username"];
                        //ajout de la colone � la ligne
                        newline.appendChild(newcol);
                        //cr�ation d'une nouvelle colone
                        newcol = document.createElement("td");
                        //ajout du call
                        newcol.innerHTML = json["data"][selectedcol][i][infoType];
                        //ajout de la colone � la ligne
                        newline.appendChild(newcol);

                        if (!ScoreOrComment) {
                            //cr�ation d'une nouvelle colone
                            newcol = document.createElement("td");
                            //ajout du call
                            newcol.innerHTML = json["data"][selectedcol][i]["date"];
                            //ajout de la colone � la ligne
                            newline.appendChild(newcol);
                        }

                        //ajout de la ligne au tableau
                        newTableBody.appendChild(newline);
                    }
                    //ajout du body au tableau
                    newTable.appendChild(newTableBody);

                    //ajout du tableau � la page
                    MainContent.appendChild(newTable);
                }
            }
        };

        //ouverture du fichier XML
        xhttp.open("GET", "PHP/SFG.php?request=" + dbParam, true);
        //envoi de la requ�te
        xhttp.send();
    }
}