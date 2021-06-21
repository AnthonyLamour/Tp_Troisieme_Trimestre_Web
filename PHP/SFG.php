<?php

	class SFG{
		
		//chemin d'accès des fichiers
		private $config_file_path;
		private $score_file_path;
		private $comment_file_path;

		//constructeur
		function __construct($new_config_file_path,$new_score_file_path,$new_comment_file_path){
			//initialisation des chemins d'accès
			$this->file_config_path=$new_config_file_path;
			$this->file_score_path=$new_score_file_path;
			$this->file_comment_path=$new_comment_file_path;
		}

		//fonction permettant la création du fichier config
		function Install($gameId,$password){
			$this->InitConfig($gameId,$password);
			$this->Reinstall($password);
		}

		//fonction permettant de réinstaller les fichiers
		function Reinstall($password){
			if(file_exists($this->file_config_path)){
				$file_content_array = $this->get_file_json_as_object($this->file_config_path);
				if($password==$file_content_array["password"]){
					$this->InitScore($file_content_array['gameId']);
					$this->InitComments($file_content_array['gameId']);
				}
			}
		}

		//fonction permettant d'initialiser un fichier config
		function InitConfig($gameId,$password){
			//création de data par défaut
			$data = [
				"gameId" => $gameId,
				"password" => $password
			];

			//création d'un nouveau fichier highscores.json avec data
			$this->check_file($this->file_config_path,$data);
		}

		//fonction permettant d'initialiser un fichier score
		function InitScore($gameId){
			//création de data par défaut
			$data = [
				"gameId" => $gameId,
				"scores" => []
			];

			//création d'un nouveau fichier highscores.json avec data
			$this->check_file($this->file_score_path,$data);
		}

		//fonction permettant d'initialiser un fichier comments
		function InitComments($gameId){
			//création de data par défaut
			$data = [
				"gameId" => $gameId,
				"comments" => []
			];

			//création d'un nouveau fichier comments.json avec data
			$this->check_file($this->file_comment_path,$data);
		}

		//fonction permettant de créer un fichier
		function check_file($file_path,$data){
			if(!file_exists($file_path)){
				//ajout du contenu dans le fichier
				$this->set_file_json_from_object($file_path,$data);
				return true;
			}
		}

		//fonction permettant d'afficher le contenu du fichier
		function echo_file($file_path){
			$file_content_array = $this->get_file_json_as_object($file_path);
			foreach ($file_content_array as $key => $value)
			{
				switch ( $key ) {
					case 'gameId' :
						echo "gameId: $value";
						break;
					case 'scores' : 
						foreach ($value as $key2 => $value2){
							echo ' username : ' . $value2['username'] . ']<br />';
							echo ' score : ' . $value2['score'] . ']<br />';
						}
						break;
					case 'comments' : 
						foreach ($value as $key2 => $value2){
							echo ' username : ' . $value2['username'] . ']<br />';
							echo ' comment : ' . $value2['comment'] . ']<br />';
							echo ' date : ' . $value2['date'] . ']<br />';
						}
						break;
					case 'password' : 
						echo "password: $value";
						break;
					default :
						break;
				}
			}
		}

		//fonction permettant de récupérer le contenu du fichier json sous forme de tableau
		function get_file_json_as_object($file_path){
			//récupération du contenu du fichier en json
			$file_content_json = file_get_contents($file_path);
			//convertion du contenu en tableau
			$file_content_array = json_decode($file_content_json,true);
			//renvoi du tableau
			return $file_content_array;
		}

		//fonction permettant d'encoder les datas en json et de les enregistrer dans le fichier
		function set_file_json_from_object($file_path,$data){
			//encodage en json
			$file_content_json = json_encode($data);
			//ajout du nouveau json au fichier
			file_put_contents($file_path, $file_content_json);
		}

		//fonction de retour en cas de succès
		function success($data) {

			echo json_encode(

				[

					"success" => true,

					"data" => $data

				]

			);

			die;
		}


		//fonction de retour en cas d'échec
		function error($code,$message) {

			echo json_encode(

				[

					"success" => false,

					"error" => [

						"code" => $code,

						"message" => $message

					]

				]

			);

			die;

		}

		function __call($name_of_function, $arguments) {
              
			// It will match the function name
			if($name_of_function == 'AddInfo') {
              
				switch (count($arguments)) {
					case 4:
						//récupération du contenu du fichier sous forme de tableau
						$file_content_array = $this->get_file_json_as_object($this->file_score_path);

						//ajout du contenu
						array_push($file_content_array[$arguments[0]],(object) ["username" => $arguments[2],$arguments[1] => $arguments[3]]);

						//enregistrement dans le fichier
						$this->set_file_json_from_object($this->file_score_path,$file_content_array);
						break;
					case 5:
						//récupération du contenu du fichier sous forme de tableau
						$file_content_array = $this->get_file_json_as_object($this->file_comment_path);

						//ajout du contenu
						array_push($file_content_array[$arguments[0]],(object) ["username" => $arguments[2],$arguments[1] => $arguments[3], "date" => $arguments[4]]);

						//enregistrement dans le fichier
						$this->set_file_json_from_object($this->file_comment_path,$file_content_array);
						break;
				}
			}
		}

		//fonction permettant de trier les scores
		public static function sort_score($a,$b){
			if ($a['score'] == $b['score']) {
				return 0;
			}
			if($a['score'] < $b['score']){
				return 1;
			}else{
				return -1;
			}
		}

		//fonction permettant d'intéragir avec les fichiers
		function interact($datas){
			switch ($datas["action"]){
				case 'install':
					//initialisation de SFG
					$this->Install($datas['gameId'],$datas['password']);
					if(!file_exists($this->file_score_path)){
						$this->error(1,"le fichier config est corrompu");
					}else{
						$this->success($this->get_file_json_as_object($this->file_config_path));
					}
					break;
				case 'reinstall':
					//réinstallatoin de SFG
					$this->Reinstall($datas['password']);
					if(!file_exists($this->file_score_path)){
						$this->error(1,"le fichier config est corrompu");
					}else{
						$this->success($this->get_file_json_as_object($this->file_config_path));
					}
					break;
				case 'get_highscores':
					if(!file_exists($this->file_score_path)){
						$this->error(2,"le fichier highscores est corrompu");
					}else{
						$this->success($this->get_file_json_as_object($this->file_score_path));
					}
					break;
				case 'set_highscore':
					if(!file_exists($this->file_score_path)){
						$this->error(2,"le fichier highscores est corrompu");
					}else{
						$this->AddInfo('scores','score',$datas['username'],$datas['info']);
						$json_content=$this->get_file_json_as_object($this->file_score_path);
						usort($json_content["scores"], array('SFG','sort_score'));
						$this->set_file_json_from_object($this->file_score_path,$json_content);
						$this->success($this->get_file_json_as_object($this->file_score_path));
					}
					break;
				case 'get_comments':
					if(!file_exists($this->file_comment_path)){
						$this->error(3,"le fichier comments est corrompu");
					}else{
						$this->success($this->get_file_json_as_object($this->file_comment_path));
					}
					break;
				case 'set_comment':
					if(!file_exists($this->file_comment_path)){
						$this->error(2,"le fichier comments est corrompu");
					}else{
						$this->AddInfo('comments','comment',$datas['username'],$datas['info'],date("Y-m-d H:i:s"));
						$this->success($this->get_file_json_as_object($this->file_comment_path));
					}
					break;
				default:
					die;
					break;
			}
		}
	}

	$my_SFG = new SFG("../config.json","../highscores.json","../comments.json");
	
	$my_SFG->interact(json_decode($_GET['datas'],true));

?>