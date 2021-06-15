<?php
	//include du fichier de la class GestionDeFichierJSON
	include 'GestionFichierJSON.php';

	//création de data par défaut
	$data = [
		"name" => "test",
		"calls" => []
	];

	//création d'un nouveau fichier test.json avec data
	$my_JSON_test = new GestionDeFichierJSON("../test.json",$data);
	//ajout d'un call
	$my_JSON_test->AddCall(date("d-m-Y H:m:s"));

	//récupération du contenu du fichier sous forme de tableau
	$json_content=$my_JSON_test->GetJSONContent();
	
	//renvoi du contenu du fichier en json
	echo json_encode($json_content);
?>