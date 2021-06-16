<?php
	//include de la class GestionDeFichierJSON
	include 'GestionFichierJSON.php';

	//fonction permettant d'initialiser un fichier score
	function InitScore(){
		//création de data par défaut
		$data = [
			"gameId" => "Persona",
			"scores" => []
		];

		//création d'un nouveau fichier highscores.json avec data
		return new GestionDeFichierJSON("../highscores.json",$data);
	}
	
	//fonction permettant d'initialiser un fichier comments
	function InitComments(){
		//création de data par défaut
		$data = [
			"gameId" => "Persona",
			"comments" => []
		];

		//création d'un nouveau fichier comments.json avec data
		return new GestionDeFichierJSON("../comments.json",$data);
	}

	switch ($_GET['action']) {
		case 'get_highscores':
			//initialisation d'un fichier de score
			$my_JSON=InitScore();
			if($my_JSON->GetIsFileInit()){
				$my_JSON->error(2,"le fichier highscores est corrompu");
			}else{
				$my_JSON->success($my_JSON->get_file_json_as_object());
			}
			break;
		case 'set_highscore':
			//initialisation d'un fichier de score
			$my_JSON=InitScore();
			//ajout d'un nouveau score
			$my_JSON->AddInfo('scores','score',$_GET['username'],$_GET['info']);
			$json_content=$my_JSON->get_file_json_as_object();
			usort($json_content["scores"], array('GestionDeFichierJSON','sort_score'));
			$my_JSON->set_file_json_from_object($json_content);
			$my_JSON->success($my_JSON->get_file_json_as_object());
			break;
		case 'get_comments':
			//initialisation d'un fichier de comments
			$my_JSON=InitComments();
			if($my_JSON->GetIsFileInit()){
				$my_JSON->error(3,"le fichier comments est corrompu");
			}else{
				$my_JSON->success($my_JSON->get_file_json_as_object());
			}
			break;
		case 'set_comment':
			//initialisation d'un fichier de comments
			$my_JSON=InitComments();
			//ajout d'un nouveau score
			$my_JSON->AddInfo('comments','comment',$_GET['username'],$_GET['info'],date("Y-m-d H:i:s"));
			$my_JSON->success($my_JSON->get_file_json_as_object());
			break;
		default:
			die;
			break;
	}

?>