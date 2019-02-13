<?php

header('Content-Type: application/json');

try {
  
	require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';
  
	include_file('core', 'authentification', 'php');

  	$uploaddir = dirname(__FILE__) . '/../../assets/widgets/';
  
	if (!file_exists($uploaddir)) {
    	mkdir($uploaddir);
        if (!file_exists($uploaddir)) {
        	throw new Exception(__("{{Répertoire d'upload non trouvé}} : ", __FILE__) . $uploaddir);
        }
    }
  				
  	if (init('action') == 'ajax_widget_list') {
  
    	$files = array_values(array_diff(scandir($uploaddir), array('.', '..')));
      
		ajax::success($files);
      
    }
    
  	if (init('action') == 'ajax_widget_add') {
    	
      	$id = init ("id");
      	$json = init ("json");
      
   		$file = fopen($uploaddir.$id.".json",'w+');
   		fwrite( $file, $json);
   		fclose( $file);
      
  		ajax::success();
    
    }
  
    if (init('action') == 'ajax_widget_get') {
    	
      	$id = init ("id");
      
      	$string = file_get_contents($uploaddir.$id.".json");
      
  		ajax::success($string);
    
    }
   
    if (init('action') == 'ajax_widget_del') {
      
        $id = init ("id");
      
      	ajax::success( unlink($uploaddir.$id.".json") );
      
    }
    throw new Exception(__('Aucune methode correspondante à : ', __FILE__) . init('action'));

} catch (Exception $e) {
  
	ajax::error(displayExeption($e), $e->getCode());
  
}

?>
