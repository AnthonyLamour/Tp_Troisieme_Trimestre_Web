<?php

	class GestionDeFichierJSON{
		
		//chemin d'accès du fichier
		private $file_path;

		private $isFileInit;

		//constructeur
		function __construct($new_file_path,$data){
			//initialisation du chemin d'accès
			$this->file_path=$new_file_path;
			
			//création du fichier si inexistant
			$my_file=fopen($this->file_path,'a');
			//fermeture du fichier
			fclose($my_file);

			//récupération du contenu du fichier sous forme de tableau
			$file_content_array = $this->get_file_json_as_object();
			//si le fichier est vide
			if($file_content_array==null){
				//ajout de data dans le fichier
				$file_content_array=$data;
				$this->isFileInit=true;
			}else{
				$this->isFileInit=false;
			}

			//ajout du contenu dans le fichier
			$this->set_file_json_from_object($file_content_array);
		}

		//fonction permettant d'afficher le contenu du fichier
		function echo_file(){
			$file_content_array = $this->get_file_json_as_object();
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
					default :
						break;
				}
			}
		}

		//fonction permettant de récupérer le contenu du fichier json sous forme de tableau
		function get_file_json_as_object(){
			//récupération du contenu du fichier en json
			$file_content_json = file_get_contents($this->file_path);
			//convertion du contenu en tableau
			$file_content_array = json_decode($file_content_json,true);
			//renvoi du tableau
			return $file_content_array;
		}

		//fonction permettant d'encoder les datas en json et de les enregistrer dans le fichier
		function set_file_json_from_object($data){
			//encodage en json
			$file_content_json = json_encode($data);
			//ajout du nouveau json au fichier
			file_put_contents($this->file_path, $file_content_json);
		}

		function success($data) {

			echo json_encode(

				[

					"success" => true,

					"data" => $data

				]

			);

			die;
		}

 

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
						$file_content_array = $this->get_file_json_as_object();

						//ajout du contenu
						array_push($file_content_array[$arguments[0]],(object) ["username" => $arguments[2],$arguments[1] => $arguments[3]]);

						//enregistrement dans le fichier
						$this->set_file_json_from_object($file_content_array);
						break;
					case 5:
						//récupération du contenu du fichier sous forme de tableau
						$file_content_array = $this->get_file_json_as_object();

						//ajout du contenu
						array_push($file_content_array[$arguments[0]],(object) ["username" => $arguments[2],$arguments[1] => $arguments[3], "date" => $arguments[4]]);

						//enregistrement dans le fichier
						$this->set_file_json_from_object($file_content_array);
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

		function GetIsFileInit(){
			return $this->isFileInit;
		}

	}

?>