<?php

header('Content-Type: application/json');

try {
  
	require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';
  
	include_file('core', 'authentification', 'php');

  	$uploaddir = dirname(__FILE__) . '/../../assets/medias/';
  
	if (!file_exists($uploaddir)) {
    	mkdir($uploaddir);
        if (!file_exists($uploaddir)) {
        	throw new Exception(__("{{Répertoire d'upload non trouvé}} : ", __FILE__) . $uploaddir);
        }
    }  		
  		
  	if (init('action') == 'ajax_media_list') {
  
    	$files = array_values(array_diff(scandir($uploaddir), array('.', '..')));
      
		ajax::success($files);
      
    }
  
    if (init('action') == 'ajax_media_add') {
      
        if (!isset($_FILES['filename'])) {
            throw new Exception(__('{{Aucun fichier trouvé. Vérifié parametre PHP (post size limit}}', __FILE__));
        }
        
      	$extension = strtolower(strrchr($_FILES['filename']['name'], '.'));
      
        if (!in_array($extension, array('.png'))) {
            throw new Exception('{{Seul les images sont acceptées (autorisé .png)}} : ' . $extension);
        }
      
        if (filesize($_FILES['filename']['tmp_name']) > 1000000) {
            throw new Exception(__('{{Le fichier est trop gros}} (maximum 8mo)', __FILE__));
        }
        
      	if (!move_uploaded_file($_FILES['filename']['tmp_name'], $uploaddir . '/' . $_FILES['filename']['name'])) {
            throw new Exception(__('{{Impossible de déplacer le fichier temporaire}}', __FILE__));
        }
      
        if (!file_exists($uploaddir . '/' . $_FILES['filename']['name'])) {
            throw new Exception(__("{{Impossible d'uploader le fichier (limite du serveur web ?)}}", __FILE__));
        }
      
        ajax::success();
    }
  
    if (init('action') == 'ajax_media_del') {
      
        $filename = init('filename');
      
      	unlink($uploaddir . $filename);
        
      	ajax::success();
      
    }
    
    throw new Exception(__('Aucune methode correspondante à : ', __FILE__) . init('action'));

} catch (Exception $e) {
  
	ajax::error(displayExeption($e), $e->getCode());
  
}

?>
