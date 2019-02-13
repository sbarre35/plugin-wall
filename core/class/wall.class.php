<?php

require_once dirname(__FILE__).'/../../../../core/php/core.inc.php';

config::save("api","JSONAPIKEY","wall");

class wall extends eqLogic {

  /*************** Attributs ***************/

  /************* Static methods ************/

  public static function event() {
    
    $action = init('action');
    
    if( $action == 'dashboard' ) {
    
      	$id = init('id');
      
      	$uploaddir = dirname(__FILE__) . '/../../assets/dashboards/';
      
    	$string = file_get_contents($uploaddir.$id.".json");
		
        $dashboard = json_decode($string, true);
      
      	$dashboard['options']['alarmStatusId'] = jeedom::fromHumanReadable( $dashboard['options']['alarmStatusId'] );      
      	$dashboard['options']['alarmStatusId'] = preg_replace( array( "/^#/", "/#$/") , array ( "", ""),  $dashboard['options']['alarmStatusId']);
      
      	$output = "{";
      
      	$pages = array_diff(scandir(dirname(__FILE__) . '/../../assets/pages'), array('.', '..'));
        $string = "";     
        $separator = "";      
      	foreach ($pages as $page) {
      		$path_parts = pathinfo($page);
      		$id = $path_parts['filename'];      
      		$string = $string . $separator . "	\"" . $id . "\"";
      		$separator = ",";          
    	}      
  		$string = "	\"pages\" : [" .$string."]";
      
      	$output = $output." ".$string.",";
      
        $widgets = array_diff(scandir(dirname(__FILE__) . '/../../assets/widgets'), array('.', '..'));
        $string = "";     
        $separator = "";      
      	foreach ($widgets as $widget) {
      		$path_parts = pathinfo($widget);
      		$id = $path_parts['filename'];      
      		$string = $string . $separator . "	\"" . $id . "\"";
      		$separator = ",";          
    	}      
  		$string = "	\"widgets\" : [" .$string."]";
      
        $output = $output." ".$string.",";
      
        $medias = array_diff(scandir(dirname(__FILE__) . '/../../assets/medias'), array('.', '..'));
        $string = "";     
        $separator = "";      
      	foreach ($medias as $media) {
      		$path_parts = pathinfo($media);
      		$id = $path_parts['filename'];      
      		$string = $string . $separator . "	\"" . $id . "\"";
      		$separator = ",";          
    	}      
  		$string = "	\"medias\" : [" .$string."]";
      
        $output = $output." ".$string;      
      
        $output .= "}";
  
    	$list = json_decode($output, true);
    
      	$json = (object)array_merge((array)$dashboard, (array)$list);
      
    	header("Content-type:application/json") ;
      
  		ajax::success($json);
  
    }
  
    if( $action == 'page' ) {
      
    	$id = init('id');
    
      	$uploaddir = dirname(__FILE__) . '/../../assets/pages/';
      
    	$string = file_get_contents($uploaddir.$id.".json");
		
      	$json = json_decode($string, true);
      
      	header("Content-type:application/json") ;
      
  		ajax::success($json['options']);
    
    }
    
    if( $action == 'widget' ) {
      
    	$id = init('id');
    
      	$uploaddir = dirname(__FILE__) . '/../../assets/widgets/';
      
    	$string = file_get_contents($uploaddir.$id.".json");
		
      	$json = json_decode($string, true);
      
      	if( $json['template'] == 'WidgetBinaryDoorComponent' ) {
          
        	$json['options']['statusId'] = jeedom::fromHumanReadable( $json['options']['statusId'] );      
         	$json['options']['statusId'] = preg_replace( array( "/^#/", "/#$/") , array ( "", ""),  $json['options']['statusId']);
          
        }
      
        if( $json['template'] == 'WidgetBinaryLightComponent' ) {
          
        	$json['options']['statusId'] = jeedom::fromHumanReadable( $json['options']['statusId'] );      
         	$json['options']['statusId'] = preg_replace( array( "/^#/", "/#$/") , array ( "", ""),  $json['options']['statusId']);
          
            $json['options']['onId'] = jeedom::fromHumanReadable( $json['options']['onId'] );      
         	$json['options']['onId'] = preg_replace( array( "/^#/", "/#$/") , array ( "", ""),  $json['options']['onId']);
          
            $json['options']['offId'] = jeedom::fromHumanReadable( $json['options']['offId'] );      
         	$json['options']['offId'] = preg_replace( array( "/^#/", "/#$/") , array ( "", ""),  $json['options']['offId']);
          
        }
      
        if( $json['template'] == 'WidgetCameraComponent' ) {
          
        	$json['options']['cameraId'] = jeedom::fromHumanReadable( $json['options']['cameraId'] );      
         	$json['options']['cameraId'] = preg_replace( array( "/^#eqLogic/", "/#$/") , array ( "", ""),  $json['options']['cameraId']);
                    
        }
      
        if( $json['template'] == 'WidgetSliderLightComponent' ) {
          
        	$json['options']['statusId'] = jeedom::fromHumanReadable( $json['options']['statusId'] );      
         	$json['options']['statusId'] = preg_replace( array( "/^#/", "/#$/") , array ( "", ""),  $json['options']['statusId']);
          
            $json['options']['sliderId'] = jeedom::fromHumanReadable( $json['options']['sliderId'] );      
         	$json['options']['sliderId'] = preg_replace( array( "/^#/", "/#$/") , array ( "", ""),  $json['options']['sliderId']);
          
            $json['options']['onId'] = jeedom::fromHumanReadable( $json['options']['onId'] );      
         	$json['options']['onId'] = preg_replace( array( "/^#/", "/#$/") , array ( "", ""),  $json['options']['onId']);
          
            $json['options']['offId'] = jeedom::fromHumanReadable( $json['options']['offId'] );      
         	$json['options']['offId'] = preg_replace( array( "/^#/", "/#$/") , array ( "", ""),  $json['options']['offId']);
          
        }
      
        if( $json['template'] == 'WidgetAlarmComponent' ) {
          
        	$json['options']['statusId'] = jeedom::fromHumanReadable( $json['options']['statusId'] );      
         	$json['options']['statusId'] = preg_replace( array( "/^#/", "/#$/") , array ( "", ""),  $json['options']['statusId']);
          
            $json['options']['onId'] = jeedom::fromHumanReadable( $json['options']['onId'] );      
         	$json['options']['onId'] = preg_replace( array( "/^#/", "/#$/") , array ( "", ""),  $json['options']['onId']);
          
            $json['options']['offId'] = jeedom::fromHumanReadable( $json['options']['offId'] );      
         	$json['options']['offId'] = preg_replace( array( "/^#/", "/#$/") , array ( "", ""),  $json['options']['offId']);

        }
      
        if( $json['template'] == 'WidgetRollerComponent' ) {
          
        	$json['options']['statusId'] = jeedom::fromHumanReadable( $json['options']['statusId'] );      
         	$json['options']['statusId'] = preg_replace( array( "/^#/", "/#$/") , array ( "", ""),  $json['options']['statusId']);
          
            $json['options']['sliderId'] = jeedom::fromHumanReadable( $json['options']['sliderId'] );      
         	$json['options']['sliderId'] = preg_replace( array( "/^#/", "/#$/") , array ( "", ""),  $json['options']['sliderId']);
          
            $json['options']['upId'] = jeedom::fromHumanReadable( $json['options']['upId'] );      
         	$json['options']['upId'] = preg_replace( array( "/^#/", "/#$/") , array ( "", ""),  $json['options']['upId']);
          
            $json['options']['stopId'] = jeedom::fromHumanReadable( $json['options']['stopId'] );      
         	$json['options']['stopId'] = preg_replace( array( "/^#/", "/#$/") , array ( "", ""),  $json['options']['stopId']);
          
            $json['options']['downId'] = jeedom::fromHumanReadable( $json['options']['downId'] );      
         	$json['options']['downId'] = preg_replace( array( "/^#/", "/#$/") , array ( "", ""),  $json['options']['downId']);
          
        }
      
      	header("Content-type:application/json") ;
      
  		ajax::success($json);
    
    }
    
    if( $action == 'media' ) {
      
    	$id = init('id');
		
        $string = "{ }";
      
        $json = json_decode($string, true);
      
      	header("Content-type:application/json") ;
      
  		ajax::success($json);
    
    }
    
    if( $action == 'png' ) {
      
    	$id = init('id');
      
        $uploaddir = dirname(__FILE__) . '/../../assets/medias/';
    
        $im = imagecreatefrompng($uploaddir.$id.".png");

		header('Content-Type: image/png');

		imagepng($im);
		imagedestroy($im);
    
    }
    
   throw new Exception(__('Aucune methode correspondante à : ', __FILE__) . init('action'));
    
  }
  
  /**************** Methods ****************/

  /********** Getters and setters **********/

}

class wallCmd extends cmd {

  /*************** Attributs ***************/

  /************* Static methods ************/

  /**************** Methods ****************/
  public function execute($_options = array()) {

  }

  /********** Getters and setters **********/

}
