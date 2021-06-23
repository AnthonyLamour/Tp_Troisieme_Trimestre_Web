// fonction permettant de vérifier la validité du formulaire d'ajout
function VerifFormulaireAjout(ScoreOrComment) {

    //variable bool permettant de savoir si le formulaire est valide
    var FromValide = true;
    ////valeur de l'input username
    var username = "";

    //objet de message d'érreur de username
    var ErreurUsername = "";

    if (ScoreOrComment) {
        //tableau contenant tout les chiffres
        var Chiffres = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '-', '+'];

        //valeur de l'input score
        var score = document.getElementById("score").value;
        //valeur de l'input username
        username = document.getElementById("usernameScore").value;
        
        //objet de message d'érreur de username
        ErreurUsername = document.getElementById("errorUsernameScore");
        //objet de message d'érreur de score
        var ErreurScore = document.getElementById("errorScore");

        //reset des messages d'érreurs
        ErreurUsername.innerHTML = "";
        ErreurScore.innerHTML = "";

        //gestion d'érreur de username
        if (username == "") {
            ErreurUsername.innerHTML = "Veuillez entrer un nom d'utilisateur";
            FromValide = false;
        }

        //gestion d'érreur de score
        if (score == "") {
            ErreurScore.innerHTML = "Veuillez entrer un score";
            FromValide = false;
        } else {
            for (var i = 0; i < score.length; i++) {
                if (Chiffres.indexOf(score[0]) == -1) {
                    ErreurScore.innerHTML = "Un score n'est composé que de chiffres";
                    FromValide = false;
                    return FromValide;
                }
            }
            if (score < 0) {
                ErreurScore.innerHTML = "Un score n'est pas négatif";
                FromValide = false;
            }
        }
    } else {
        //valeur de l'input comment
        var comment = document.getElementById("comment").value;
        //valeur de l'input username
        username = document.getElementById("usernameComment").value;

        //objet de message d'érreur de username
        ErreurUsername = document.getElementById("errorUsernameComment");
        //objet de message d'érreur de comment
        var ErreurComment = document.getElementById("errorComment");

        //reset des messages d'érreurs
        ErreurUsername.innerHTML = "";
        ErreurComment.innerHTML = "";

        //gestion d'érreur de username
        if (username == "") {
            ErreurUsername.innerHTML = "Veuillez entrer un nom d'utilisateur";
            FromValide = false;
        }

        //gestion d'érreur de comment
        if (comment == "") {
            ErreurComment.innerHTML = "Veuillez entrer un commentaire";
            FromValide = false;
        }
    }

    //renvoi de FromValide
    return FromValide;
}

// fonction permettant de vérifier la validité du formulaire d'installation
function VerifFormulaireInstall() {

    //variable bool permettant de savoir si le formulaire est valide
    var FromValide = true;

    //valeur de l'input gameId
    var gameId = document.getElementById("gameId").value;;
    //valeur de l'input password
    var password = document.getElementById("password").value;;

    //objet de message d'érreur de gameId
    var ErreurGameId = document.getElementById("errorGameId");
    //objet de message d'érreur de password
    var ErreurPassword = document.getElementById("errorPassword");

    //reset des messages d'érreurs
    ErreurGameId.innerHTML = "";
    ErreurPassword.innerHTML = "";

    //gestion d'érreur de gameId
    if (gameId == "") {
        ErreurGameId.innerHTML = "Veuillez entrer un nom de jeu";
        FromValide = false;
    }

    //gestion d'érreur de password
    if (password == "") {
        ErreurPassword.innerHTML = "Veuillez entrer un mot de passe";
        FromValide = false;
    }

    //renvoi de FromValide
    return FromValide;
}

// fonction permettant de vérifier la validité du formulaire de réinstallation
function VerifFormulaireReinstall() {

    //variable bool permettant de savoir si le formulaire est valide
    var FromValide = true;

    //valeur de l'input password
    var password = document.getElementById("password").value;;

    //objet de message d'érreur de password
    var ErreurPassword = document.getElementById("errorPassword");

    //reset des messages d'érreurs
    ErreurPassword.innerHTML = "";


    //gestion d'érreur de password
    if (password == "") {
        ErreurPassword.innerHTML = "Veuillez entrer un mot de passe";
        FromValide = false;
    }

    //renvoi de FromValide
    return FromValide;
}