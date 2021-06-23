// fonction permettant de v�rifier la validit� du formulaire d'ajout
function VerifFormulaireAjout(ScoreOrComment) {

    //variable bool permettant de savoir si le formulaire est valide
    var FromValide = true;
    ////valeur de l'input username
    var username = "";

    //objet de message d'�rreur de username
    var ErreurUsername = "";

    if (ScoreOrComment) {
        //tableau contenant tout les chiffres
        var Chiffres = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '-', '+'];

        //valeur de l'input score
        var score = document.getElementById("score").value;
        //valeur de l'input username
        username = document.getElementById("usernameScore").value;
        
        //objet de message d'�rreur de username
        ErreurUsername = document.getElementById("errorUsernameScore");
        //objet de message d'�rreur de score
        var ErreurScore = document.getElementById("errorScore");

        //reset des messages d'�rreurs
        ErreurUsername.innerHTML = "";
        ErreurScore.innerHTML = "";

        //gestion d'�rreur de username
        if (username == "") {
            ErreurUsername.innerHTML = "Veuillez entrer un nom d'utilisateur";
            FromValide = false;
        }

        //gestion d'�rreur de score
        if (score == "") {
            ErreurScore.innerHTML = "Veuillez entrer un score";
            FromValide = false;
        } else {
            for (var i = 0; i < score.length; i++) {
                if (Chiffres.indexOf(score[0]) == -1) {
                    ErreurScore.innerHTML = "Un score n'est compos� que de chiffres";
                    FromValide = false;
                    return FromValide;
                }
            }
            if (score < 0) {
                ErreurScore.innerHTML = "Un score n'est pas n�gatif";
                FromValide = false;
            }
        }
    } else {
        //valeur de l'input comment
        var comment = document.getElementById("comment").value;
        //valeur de l'input username
        username = document.getElementById("usernameComment").value;

        //objet de message d'�rreur de username
        ErreurUsername = document.getElementById("errorUsernameComment");
        //objet de message d'�rreur de comment
        var ErreurComment = document.getElementById("errorComment");

        //reset des messages d'�rreurs
        ErreurUsername.innerHTML = "";
        ErreurComment.innerHTML = "";

        //gestion d'�rreur de username
        if (username == "") {
            ErreurUsername.innerHTML = "Veuillez entrer un nom d'utilisateur";
            FromValide = false;
        }

        //gestion d'�rreur de comment
        if (comment == "") {
            ErreurComment.innerHTML = "Veuillez entrer un commentaire";
            FromValide = false;
        }
    }

    //renvoi de FromValide
    return FromValide;
}

// fonction permettant de v�rifier la validit� du formulaire d'installation
function VerifFormulaireInstall() {

    //variable bool permettant de savoir si le formulaire est valide
    var FromValide = true;

    //valeur de l'input gameId
    var gameId = document.getElementById("gameId").value;;
    //valeur de l'input password
    var password = document.getElementById("password").value;;

    //objet de message d'�rreur de gameId
    var ErreurGameId = document.getElementById("errorGameId");
    //objet de message d'�rreur de password
    var ErreurPassword = document.getElementById("errorPassword");

    //reset des messages d'�rreurs
    ErreurGameId.innerHTML = "";
    ErreurPassword.innerHTML = "";

    //gestion d'�rreur de gameId
    if (gameId == "") {
        ErreurGameId.innerHTML = "Veuillez entrer un nom de jeu";
        FromValide = false;
    }

    //gestion d'�rreur de password
    if (password == "") {
        ErreurPassword.innerHTML = "Veuillez entrer un mot de passe";
        FromValide = false;
    }

    //renvoi de FromValide
    return FromValide;
}

// fonction permettant de v�rifier la validit� du formulaire de r�installation
function VerifFormulaireReinstall() {

    //variable bool permettant de savoir si le formulaire est valide
    var FromValide = true;

    //valeur de l'input password
    var password = document.getElementById("password").value;;

    //objet de message d'�rreur de password
    var ErreurPassword = document.getElementById("errorPassword");

    //reset des messages d'�rreurs
    ErreurPassword.innerHTML = "";


    //gestion d'�rreur de password
    if (password == "") {
        ErreurPassword.innerHTML = "Veuillez entrer un mot de passe";
        FromValide = false;
    }

    //renvoi de FromValide
    return FromValide;
}