<?php
	include 'GestionDeHighscore.php';

	//cr�ation de data par d�faut
	$data = [
		"gameId" => "Persona",
		"scores" => []
	];

	//cr�ation d'un nouveau fichier highscores.json avec data
	$my_JSON = new GestionDeHighscore("../highscores.json",$data);
	
	switch ($_GET['action']) {
		case 'get_highscores':
			//r�cup�ration du contenu du fichier
			$json_content=$my_JSON->GetJSONContent();
			//renvoi du contenu du fichier en json
			echo json_encode($json_content);
			break;
		case 'set_highscore':
			//ajout d'un score
			$my_JSON->AddScore($_GET['username'],$_GET['score']);
			break;
		default:
			die;
			break;
	}

?>