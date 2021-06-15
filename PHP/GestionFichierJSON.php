<?php
	
	//class GestionDeFichierJSON
	class GestionDeFichierJSON{
	
		//chemin d'accès du fichier
		private $file_path;

		//constructeur
		function GestionDeFichierJSON($new_file_path,$data){
			//initialisation du chemin d'accès
			$this->file_path=$new_file_path;
			
			//création du fichier si inexistant
			$my_file=fopen($this->file_path,'a');
			//fermeture du fichier
			fclose($my_file);

			//récupération du contenu du fichier sous forme de tableau
			$file_content_array = $this->GetJSONContent();
			//si le fichier est vide
			if($file_content_array==null){
				//ajout de data dans le fichier
				$file_content_array=$data;
			}

			//ajout du contenu dans le fichier
			$file_content_json = json_encode($file_content_array);
			file_put_contents($this->file_path, $file_content_json);
		}

		//fonction permettant de récupérer le contenu du fichier json sous forme de tableau
		function GetJSONContent(){
			//récupération du contenu du fichier en json
			$file_content_json = file_get_contents($this->file_path);
			//convertion du contenu en tableau
			$file_content_array = json_decode($file_content_json,true);
			//renvoi du tableau
			return $file_content_array;
		}

		//fonction permettant de récupérer la taille du fichier
		function GetJSONSize(){
			//renvoi de la taille du fichier
			return filesize($this->file_path);
		}

		//fonction permettant d'ajouter un call au fichier
		function AddCall($new_call){
			//récupération du contenu du fichier sous forme de tableau
			$file_content_array = $this->GetJSONContent();
			//ajout du nouveau call
			array_push($file_content_array["calls"],$new_call);
			//encodage en json
			$file_content_json = json_encode($file_content_array);
			//ajout du nouveau json au fichier
			file_put_contents($this->file_path, $file_content_json);
		}
	}

?>