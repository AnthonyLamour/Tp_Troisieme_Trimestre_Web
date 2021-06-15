<?php
	
	//class GestionDeFichierJSON
	class GestionDeFichierJSON{
	
		//chemin d'acc�s du fichier
		private $file_path;

		//constructeur
		function GestionDeFichierJSON($new_file_path,$data){
			//initialisation du chemin d'acc�s
			$this->file_path=$new_file_path;
			
			//cr�ation du fichier si inexistant
			$my_file=fopen($this->file_path,'a');
			//fermeture du fichier
			fclose($my_file);

			//r�cup�ration du contenu du fichier sous forme de tableau
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

		//fonction permettant de r�cup�rer le contenu du fichier json sous forme de tableau
		function GetJSONContent(){
			//r�cup�ration du contenu du fichier en json
			$file_content_json = file_get_contents($this->file_path);
			//convertion du contenu en tableau
			$file_content_array = json_decode($file_content_json,true);
			//renvoi du tableau
			return $file_content_array;
		}

		//fonction permettant de r�cup�rer la taille du fichier
		function GetJSONSize(){
			//renvoi de la taille du fichier
			return filesize($this->file_path);
		}

		//fonction permettant d'ajouter un call au fichier
		function AddCall($new_call){
			//r�cup�ration du contenu du fichier sous forme de tableau
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