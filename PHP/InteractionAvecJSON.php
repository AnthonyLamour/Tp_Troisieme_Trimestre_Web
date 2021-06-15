<?php
	//include de la class GestionDeFichierJSON
	include 'GestionFichierJSON.php';

	//fonction permettant d'initialiser un fichier score
	function InitScore(){
		//cr�ation de data par d�faut
		$data = [
			"gameId" => "Persona",
			"scores" => []
		];

		//cr�ation d'un nouveau fichier highscores.json avec data
		return new GestionDeFichierJSON("../highscores.json",$data);
	}
	
	//fonction permettant d'initialiser un fichier comments
	function InitComments(){
		//cr�ation de data par d�faut
		$data = [
			"gameId" => "Persona",
			"comments" => []
		];

		//cr�ation d'un nouveau fichier comments.json avec data
		return new GestionDeFichierJSON("../comments.json",$data);
	}

	switch ($_GET['action']) {
		case 'get_highscores':
			//initialisation d'un fichier de score
			$my_JSON=InitScore();
			//r�cup�ration du contenu du fichier de score
			$json_content=$my_JSON->get_file_json_as_object();
			//renvoi du contenu du fichier en json
			echo json_encode($json_content);
			break;
		case 'set_highscore':
			//initialisation d'un fichier de score
			$my_JSON=InitScore();
			//ajout d'un nouveau score
			$my_JSON->AddInfo('scores','score',$_GET['username'],$_GET['info']);
			$json_content=$my_JSON->get_file_json_as_object();
			usort($json_content["scores"], array('GestionDeFichierJSON','sort_score'));
			$my_JSON->set_file_json_from_object($json_content);
			break;
		case 'get_comments':
			//initialisation d'un fichier de comments
			$my_JSON=InitComments();
			//r�cup�ration du contenu du fichier de comments
			$json_content=$my_JSON->get_file_json_as_object();
			//renvoi du contenu du fichier en json
			echo json_encode($json_content);
			break;
		case 'set_comment':
			//initialisation d'un fichier de comments
			$my_JSON=InitComments();
			//ajout d'un nouveau score
			$my_JSON->AddInfo('comments','comment',$_GET['username'],$_GET['info']);
			break;
		default:
			die;
			break;
	}

?>