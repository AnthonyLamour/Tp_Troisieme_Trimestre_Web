<?php

	//class SFG
	class SFG{
		
		//chemin d'accès des fichiers
		private $config_file_path;
		private $score_file_path;
		private $comment_file_path;
		//chemin d'accès du dossier data
		private $data_folder_path;

		//constructeur
		function __construct($new_config_file_path,$new_score_file_path,$new_comment_file_path,$new_data_folder_path){
			//initialisation des chemins d'accès
			$this->data_folder_path=$new_data_folder_path;
			$this->file_config_path=$this->data_folder_path.$new_config_file_path;
			$this->file_score_path=$this->data_folder_path.$new_score_file_path;
			$this->file_comment_path=$this->data_folder_path.$new_comment_file_path;
		}

		//fonction permettant la création du fichier config
		function Install($gameId,$password){
			//création du fichier de config
			$this->InitConfig($gameId,$password);
			//appelle de reinstall
			$this->Reinstall($password);
		}

		//fonction permettant de réinstaller les fichiers
		function Reinstall($password){
			//si le fichier de config existe
			if(file_exists($this->file_config_path)){
				//récupération de son contenu
				$file_content_array = $this->get_file_json_as_object($this->file_config_path);
				//si le mot de passe est correct
				if($password==$file_content_array["password"]){
					//création du fichier de score
					$this->InitScore($file_content_array['gameId']);
					//création du fichier de commentaire
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

			//création d'un nouveau fichier config.json avec data
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
			//si le fichier n'existe pas
			if(!file_exists($file_path)){
				//ajout du contenu dans le fichier
				$this->set_file_json_from_object($file_path,$data);
				//renvoi vrai
				return true;
			}
		}

		//fonction permettant d'afficher le contenu d'un fichier
		function echo_file($file_path){
			//récupération du contenu du fichier
			$file_content_array = $this->get_file_json_as_object($file_path);
			//pour chaque élément du contenu
			foreach ($file_content_array as $key => $value)
			{
				//en fonction de la clé
				switch ( $key ) {
					//si gameId
					case 'gameId' :
						//afficher la valeur de gameId
						echo "gameId: $value";
						break;
					//si scores
					case 'scores' : 
						//afficher la valeur des scores
						foreach ($value as $key2 => $value2){
							echo ' username : ' . $value2['username'] . ']<br />';
							echo ' score : ' . $value2['score'] . ']<br />';
						}
						break;
					//si comments
					case 'comments' :
						//afficher les commentaires
						foreach ($value as $key2 => $value2){
							echo ' username : ' . $value2['username'] . ']<br />';
							echo ' comment : ' . $value2['comment'] . ']<br />';
							echo ' date : ' . $value2['date'] . ']<br />';
						}
						break;
					//si mot de passe
					case 'password' :
						//afficher le mot de passe
						echo "password: $value";
						break;
					//par défaut
					default :
						//ne rien faire
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

			//affichage des données et de success true
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

			//affichage de l'erreur et de success false
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

		//override de la fonction AddInfo
		function __call($name_of_function, $arguments) {
              
			// si le nom de la fonction est AddInfo
			if($name_of_function == 'AddInfo') {
				//en fonction du nombre d'arguments de la fonction
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
					//récupération des highscores
					if(!file_exists($this->file_score_path)){
						$this->error(200,"fichier inexistant");
					}else{
						$this->success($this->get_file_json_as_object($this->file_score_path));
					}
					break;
				case 'set_highscore':
					//ajout d'un score
					if(!file_exists($this->file_score_path)){
						$this->error(200,"fichier inexistant");
					}else{
						$this->AddInfo('scores','score',$datas['username'],$datas['info']);
						$json_content=$this->get_file_json_as_object($this->file_score_path);
						usort($json_content["scores"], array('SFG','sort_score'));
						$this->set_file_json_from_object($this->file_score_path,$json_content);
						$this->success($this->get_file_json_as_object($this->file_score_path));
					}
					break;
				case 'get_comments':
					//récupération des commentaires
					if(!file_exists($this->file_comment_path)){
						$this->error(200,"fichier inexistant");
					}else{
						$this->success($this->get_file_json_as_object($this->file_comment_path));
					}
					break;
				case 'set_comment':
					//ajout d'un commentaire
					if(!file_exists($this->file_comment_path)){
						$this->error(200,"fichier inexistant");
					}else{
						$this->AddInfo('comments','comment',$datas['username'],$datas['info'],date("Y-m-d H:i:s"));
						$this->success($this->get_file_json_as_object($this->file_comment_path));
					}
					break;
				default:
					//renvoie d'erreur
					$this->error(12, "ressource indéfinie");
					die;
					break;
			}
		}
	}

	//initialisation d'un objet de type SFG
	$my_SFG = new SFG("/config.json","/highscores.json","/comments.json","../data");
	
	//appelle de l'intéraction avec SFG
	$my_SFG->interact(json_decode($_GET['request'],true));

?>