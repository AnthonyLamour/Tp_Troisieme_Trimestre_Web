<?php

	class GestionDeFichierJSON{
		
		//chemin d'accès du fichier
		private $file_path;

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

		//fonction permettant d'ajouter du contenu au fichier
		function AddInfo($selectedcol,$infotype,$username,$info){
			//récupération du contenu du fichier sous forme de tableau
			$file_content_array = $this->get_file_json_as_object();

			//ajout du contenu
			array_push($file_content_array[$selectedcol],(object) ["username" => $username,$infotype => $info]);

			//enregistrement dans le fichier
			$this->set_file_json_from_object($file_content_array);
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

	}

?>