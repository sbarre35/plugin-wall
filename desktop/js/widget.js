/* ===================== */
/* == Widget selector == */
/* ===================== */

function fn_widget_selector( ctrl ) { 
  
  $.ajax({
		type: "POST", 
      	url: "plugins/wall/core/ajax/widget.ajax.php",     
      	data: {
        	action: "ajax_widget_list"
      	},
      	dataType: 'json',
      	error: function(request, status, error) {

        	$('#md_wall_alert').showAlert({message: error, level: 'danger'});
      	
        },
      	success: function(data) {
        
            if (data.state != 'ok') {
          		
            	$('#md_wall_alert').showAlert({message: data.result, level: 'danger'});
          		
        	} else {
                
              	var selector = [];
              
        		data.result.forEach(function(filename) {
                    var id = filename.substr(0, filename.lastIndexOf('.'));
                	selector.push({ text: id, value: id });
				});
              
              	bootbox.prompt({
    				title: '{{Select a widget}}',
    				inputType: 'select',
    				value: ctrl.val(),
    				inputOptions: selector,
                  	callback: function (result) {
                    	ctrl.val(result);
                	}
            	});
              
            }
    
    	}
	});	
  
}

/* ================== */
/* == ADD FUNCTION == */
/* ================== */

function fn_widget_add( id, filename) {
  
	var element = $.parseHTML('\
    	<div class="eqLogicAction widget_element cursor" data-object_id="' + id + '" style="position: absolute; background-color : #ffffff; height : 140px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px"> \
			<div style="z-index:255; position: absolute; left: 0; top: 5px; background-color: transparent !important; border: none !important"> \
            	<a class="bt_widget_del btn btn-danger btn-xs pull-right" style="color : white"><i class="fa fa-minus-circle"></i></a> \
            	<a class="bt_widget_mod btn btn-info btn-xs pull-right" style="color : white"><i class="fa fa-edit"></i></a> \
            </div> \
            &nbsp;<center><i class="fa fa-tachometer" style="font-size : 7em;color:#767676;"></i></center> \
		  	<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;"><center>' + id + '</center></span> \
            <input type="hidden" class="cmdAttr form-control input-sm" data-l1key="id" value="' + id + '"> \
        </div>');     
  
    $('.widget_container').append(element).packery('appended',element);
    $('.widget_container').packery('reloadItems', element);
  	$('.widget_container').packery({ itemSelector: '.widget_element' });

};

/* ================== */
/* == DEL FUNCTION == */
/* ================== */

function fn_widget_del( id) {
  
	var row = $('.widget_container').find('[data-l1key=id][value='+id+']').closest('.widget_element');
                      
	$('.widget_container').packery('remove',row);
  	$('.widget_container').packery({ itemSelector: '.widget_element' });
  
};
  
/* ====================== */
/* == REFRESH FUNCTION == */
/* ====================== */

function fn_widget_refresh() {
  
	$('.widget_container').empty();
  	$('.widget_container').packery({ itemSelector: '.widget_element' });

	$.ajax({
		type: "POST", 
      	url: "plugins/wall/core/ajax/widget.ajax.php",     
      	data: {
        	action: "ajax_widget_list"
      	},
      	dataType: 'json',
      	error: function(request, status, error) {

        	$('#md_wall_alert').showAlert({message: error, level: 'danger'});
      	
        },
      	success: function(data) {
        
            if (data.state != 'ok') {
          		
            	$('#md_wall_alert').showAlert({message: data.result, level: 'danger'});
          		
        	} else {
                            
        		data.result.forEach(function(filename) {
                    var id = filename.substr(0, filename.lastIndexOf('.'));
                	fn_widget_add( id, filename);
				});
              
            }
    
    	}
	});
  
};

/* ======================= */
/* == TEMPLATE FUNCTION == */
/* ======================= */

function fn_widget_template( element, index) {
  
  	$('.page_detail_menus_data_'+index).find('div>div.Menu').hide();
  	$('.page_detail_menus_data_'+index).find('div>div.'+element.value).show();
    
};

/* ================ */
/* == ADD BUTTON == */
/* ================ */

$('#bt_widget_add').click(function(e) {

	e.preventDefault();
  
  	bootbox.prompt({
    	title: "{{Identifiant du widget}}",
    	inputType: 'select',
    	value: 'WidgetBinaryLightComponent',
    	inputOptions: [        
        	{
            	text: 'Camera',
            	value: 'WidgetCameraComponent',
        	},
        	{
            	text: 'Action',
            	value: 'WidgetBinaryLightComponent',
        	},
        	{
            	text: 'Info',
            	value: 'WidgetBinaryDoorComponent',
        	},
        	{
            	text: 'Slider',
            	value: 'WidgetSliderLightComponent',
        	},
            {
            	text: 'Alarm',
            	value: 'WidgetAlarmComponent',
        	},
            {
            	text: 'Roller',
            	value: 'WidgetRollerComponent',
        	},
            {
            	text: 'Lien',
            	value: 'WidgetLinkComponent',
        	}    
    	],
    	callback: function (result) {
        	if (result) {
 
                fn_widget_change(result);
                  
                $('.widget_detail').setValues( {
					id: '',
      				template: result,
                    message: 'navigate'
   	 			}, '.eqLogicAttr');
              
                $('.widget-'+result).find('.eqLogicAttr').val('');
              
                $('.widget-'+result).setValues( {
					message: 'navigate'
   	 			}, '.eqLogicAttr');
              
              	$(".widget_detail").find('.eqLogicAttr[data-l1key=id]').prop("readonly", false);
  				$('.widget_detail').find('.eqLogicAttr[data-l1key=readonly]').val('FALSE');
  
  				$("#widget_tab").removeClass("active");
    			$("#widget_form").addClass("active");
              
            }
    	}
  	});
  
});

/* ================ */
/* == MOD BUTTON == */
/* ================ */

$('.widget_container').on('click', '.bt_widget_mod', function (e) {
  
  	e.preventDefault();
  
	var row = $(this).closest('.widget_element');
  	var id = row.find('.cmdAttr[data-l1key=id]').val();
  
    $.ajax({
		type: "POST", 
      	url: "plugins/wall/core/ajax/widget.ajax.php",     
      	data: {
        	action: "ajax_widget_get",
          	id: id
      	},
      	dataType: 'json',
      	error: function(request, status, error) {

        	$('#md_wall_alert').showAlert({message: error, level: 'danger'});

      	},
      	success: function(data) {

        	if (data.state != 'ok') {

          		$('#md_wall_alert').showAlert({message: data.result, level: 'danger'});

        	} else {
              
              	var json = JSON.parse(data.result);
              
              	$('.widget_detail').find('[data-l1key=id]').val(id);
              	$('.widget_detail').setValues( json, '.eqLogicAttr');
				$('.widget-'+json.template).setValues( json.options, '.eqLogicAttr');
              
              	fn_widget_change(json.template);
              
              	$(".widget_detail").find('.eqLogicAttr[data-l1key=id]').prop("readonly", true);
  				$('.widget_detail').find('.eqLogicAttr[data-l1key=readonly]').val('TRUE');
  
    			$("#widget_tab").removeClass("active");
    			$("#widget_form").addClass("active");
  
        	}
      	}
    });
  
});

/* ========================= */
/* == ADD VALIDATE BUTTON == */
/* ========================= */

$('#bt_widget_add_validate').click(function(e) {

  e.preventDefault();
  
  var id = $('.widget_detail').find('[data-l1key=id]').val();
  var template = $('.widget_detail').find('[data-l1key=template]').val();
  var data = $('.widget-'+template).getValues( '.eqLogicAttr');
  var readonly = data[0]['readonly'];
  var json = JSON.stringify({ template: template, options: data[0] },null,2);
  
  if( id != "" ) {
  
  	$.ajax({
		type: "POST", 
      	url: "plugins/wall/core/ajax/widget.ajax.php",     
      	data: {
        	action: "ajax_widget_add",
          	id: id,
        	json: json,
      	},
      	dataType: 'json',
      	error: function(request, status, error) {

        	$('#md_wall_alert').showAlert({message: error, level: 'danger'});

      	},
      	success: function(data) {

        	if (data.state != 'ok') {

          		$('#md_wall_alert').showAlert({message: data.result, level: 'danger'});

        	} else {

          		var readonly = $('.widget_detail').find('.eqLogicAttr[data-l1key=readonly]').val();
              
              	if( readonly == 'FALSE' ) {
                  
              		$('#md_wall_alert').showAlert({message: '{{Widget créé avec succès}}', level: 'success'});
                  
                } else {
                  
                  	$('#md_wall_alert').showAlert({message: '{{Widget modifié avec succès}}', level: 'success'});
                  
                }
  
              	$("#widget_tab").addClass("active");
    			$("#widget_form").removeClass("active");
  
          		fn_widget_refresh();

        	}
      	}
    });
  } else {
    $('#md_wall_alert').showAlert({message: 'veuillez mettre un identifiant non vide', level: 'danger'});
  }
  
});

/* ======================= */
/* == ADD CANCEL BUTTON == */
/* ======================= */

$('#bt_widget_add_cancel').click(function(e) {

	e.preventDefault();
  
    $("#widget_tab").addClass("active");
    $("#widget_form").removeClass("active");

});

/* ================ */
/* == DEL BUTTON == */
/* ================ */
  
$('.widget_container').on('click', '.bt_widget_del', function (e) {
  
  	e.preventDefault();
  
  	var row = $(this).closest('.widget_element');
  	var id = row.find('.cmdAttr[data-l1key=id]').val();
  
  	bootbox.confirm('{{Etes-vous sûr de vouloir supprimer la widget}} <span style="font-weight: bold ;">' + id + '</span> ?', function(result) {
		if (result) {
        	$.ajax({
              	type: "POST", 
          		url: "plugins/wall/core/ajax/widget.ajax.php",     
          		data: {
            		action: "ajax_widget_del",
            		id: id,
          		},
          		dataType: 'json',
          		error: function(request, status, error) {
                  
            		$('#md_wall_alert').showAlert({message: error, level: 'danger'});
          		
                },
          		success: function(data) {
                  
            		if (data.state != 'ok') {
                      
              			$('#md_wall_alert').showAlert({message: data.result, level: 'danger'});
                      
            		} else {
                  
            			$('#md_wall_alert').showAlert({message: '{{Widget supprimé avec succes}}', level: 'success'});
                      	
                    	fn_widget_del( id);
                    
                    }
          		}
        	});
      	}
    });
  
});

/* =============== */
/* == TAB EVENT == */
/* =============== */

$('#bt_widget_tab').click( function (e) {

	e.preventDefault();
  
  	fn_widget_refresh();
    
});

/* =================== */
/* == REFRESH EVENT == */
/* =================== */

$('#bt_widget_refresh').click( function (e) {

	e.preventDefault();
  
  	fn_widget_refresh();
  
});

/* ================== */
/* == FILTER EVENT == */
/* ================== */

$('#filter_widget').on('input',function(e){
  
	e.preventDefault();
  
    var filter = $('#filter_widget').val();
  
  	$('.widget_container .eqLogicAction').each(function( index ) {
      
    	var current = $( this ).find('.cmdAttr[data-l1key=id]').val();
      
        if( filter == "" || current.indexOf( filter ) != -1 ) {
          
          	$( this ).show();
        
        } else {
          
        	$( this ).hide();
      
        }
      
    });
  
    $('.widget_container').packery({ itemSelector: '.widget_element' }); 
  
});

/* ======================= */
/* == Template hid/show == */
/* ======================= */

function fn_widget_change( str ) {

	$('.widget').hide();
  	$('.widget-'+str).show();
  
};

/* =================== */
/* == Selector link == */
/* =================== */

$(".bt_widget_link_page").click(function(e) {
 
  e.preventDefault();
  
  fn_page_selector( $('.widget-WidgetLinkComponent').find('.eqLogicAttr[data-l1key=data][data-l2key=id]') );  
  
});

$(".bt_widget_link_icon").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetLinkComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=link]') );  
  
});

/* ===================== */
/* == Selector camera == */
/* ===================== */
  
$(".bt_widget_camera_cameraid").click(function(e) {
  
  e.preventDefault();
  
  var el = $(this);
  
  jeedom.eqLogic.getSelectModal({cmd: {type: 'info'}}, function (result) {
    el.closest('.input-group').find('.eqLogicAttr[data-l1key=cameraId]').value(result.human);
  });
  
});

/* =================== */
/* == Selector info == */
/* =================== */

$(".bt_widget_info_loading").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetBinaryDoorComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=loading]') );  
  
});

$(".bt_widget_info_status_0").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetBinaryDoorComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=status-0]') );  
  
});

$(".bt_widget_info_status_1").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetBinaryDoorComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=status-1]') );  
  
});
  
$(".bt_widget_info_statusid").click(function(e) {
  
  e.preventDefault();
  
  var el = $(this);
  
  jeedom.cmd.getSelectModal({cmd: {type: 'info'}}, function (result) { 
    el.closest('.input-group').find('.eqLogicAttr[data-l1key=statusId]').value(result.human);
  });
  
});

/* ===================== */
/* == Selector action == */
/* ===================== */

$(".bt_widget_action_loading").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetBinaryLightComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=loading]') );  
  
});

$(".bt_widget_action_status_0").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetBinaryLightComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=status-0]') );  
  
});

$(".bt_widget_action_status_1").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetBinaryLightComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=status-1]') );  
  
});
  
$(".bt_widget_action_action_0").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetBinaryLightComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=action-0]') );  
  
});

$(".bt_widget_action_action_1").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetBinaryLightComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=action-1]') );  
  
});

$(".bt_widget_action_statusid").click(function(e) {
  
  e.preventDefault();
  
  var el = $(this);
  
  jeedom.cmd.getSelectModal({cmd: {type: 'info'}}, function (result) { 
    el.closest('.input-group').find('.eqLogicAttr[data-l1key=statusId]').value(result.human);
  });
  
});

$(".bt_widget_action_offId").click(function(e) {
  
  e.preventDefault();
  
  var el = $(this);
  
  jeedom.cmd.getSelectModal({cmd: {type: 'action'}}, function (result) { 
    el.closest('.input-group').find('.eqLogicAttr[data-l1key=offId]').value(result.human);
  });
  
});
  
$(".bt_widget_action_onId").click(function(e) {
  
  e.preventDefault();
  
  var el = $(this);
  
  jeedom.cmd.getSelectModal({cmd: {type: 'action'}}, function (result) { 
    el.closest('.input-group').find('.eqLogicAttr[data-l1key=onId]').value(result.human);
  });
  
});

/* ===================== */
/* == Selector roller == */
/* ===================== */

$(".bt_widget_roller_loading").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetRollerComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=loading]') );  
  
});

$(".bt_widget_roller_status_0").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetRollerComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=status-0]') );  
  
});

$(".bt_widget_roller_status_20").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetRollerComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=status-20]') );  
  
});

$(".bt_widget_roller_status_40").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetRollerComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=status-40]') );  
  
});

$(".bt_widget_roller_status_60").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetRollerComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=status-60]') );  
  
});

$(".bt_widget_roller_status_80").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetRollerComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=status-80]') );  
  
});

$(".bt_widget_roller_status_100").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetRollerComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=status-100]') );  
  
});

$(".bt_widget_roller_up").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetRollerComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=action-up]') );  
  
});

$(".bt_widget_roller_stop").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetRollerComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=action-stop]') );  
  
});

$(".bt_widget_roller_down").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetRollerComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=action-down]') );  
  
});

$(".bt_widget_roller_statusid").click(function(e) {
  
  e.preventDefault();
  
  var el = $(this);
  
  jeedom.cmd.getSelectModal({cmd: {type: 'info'}}, function (result) { 
    el.closest('.input-group').find('.eqLogicAttr[data-l1key=statusId]').value(result.human);
  });
  
});

$(".bt_widget_roller_sliderid").click(function(e) {
  
  e.preventDefault();
  
  var el = $(this);
  
  jeedom.cmd.getSelectModal({cmd: {type: 'action'}}, function (result) { 
    el.closest('.input-group').find('.eqLogicAttr[data-l1key=sliderId]').value(result.human);
  });
  
});

$(".bt_widget_roller_upId").click(function(e) {
  
  e.preventDefault();
  
  var el = $(this);
  
  jeedom.cmd.getSelectModal({cmd: {type: 'action'}}, function (result) { 
    el.closest('.input-group').find('.eqLogicAttr[data-l1key=upId]').value(result.human);
  });
  
});

$(".bt_widget_roller_downId").click(function(e) {
  
  e.preventDefault();
  
  var el = $(this);
  
  jeedom.cmd.getSelectModal({cmd: {type: 'action'}}, function (result) { 
    el.closest('.input-group').find('.eqLogicAttr[data-l1key=downId]').value(result.human);
  });
  
});

$(".bt_widget_roller_stopId").click(function(e) {
  
  e.preventDefault();
  
  var el = $(this);
  
  jeedom.cmd.getSelectModal({cmd: {type: 'action'}}, function (result) { 
    el.closest('.input-group').find('.eqLogicAttr[data-l1key=stopId]').value(result.human);
  });
  
});

/* ===================== */
/* == Selector slider == */
/* ===================== */

$(".bt_widget_slider_loading").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetsliderComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=loading]') );  
  
});

$(".bt_widget_slider_status_0").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetsliderComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=status-0]') );  
  
});

$(".bt_widget_slider_status_20").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetsliderComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=status-20]') );  
  
});

$(".bt_widget_slider_status_40").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetsliderComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=status-40]') );  
  
});

$(".bt_widget_slider_status_60").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetsliderComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=status-60]') );  
  
});

$(".bt_widget_slider_status_80").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetsliderComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=status-80]') );  
  
});

$(".bt_widget_slider_status_100").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetsliderComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=status-100]') );  
  
});

$(".bt_widget_slider_on").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetsliderComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=action-on]') );  
  
});

$(".bt_widget_slider_off").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetsliderComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=action-off]') );  
  
});

$(".bt_widget_slider_statusid").click(function(e) {
  
  e.preventDefault();
  
  var el = $(this);
  
  jeedom.cmd.getSelectModal({cmd: {type: 'info'}}, function (result) { 
    el.closest('.input-group').find('.eqLogicAttr[data-l1key=statusId]').value(result.human);
  });
  
});

$(".bt_widget_slider_sliderid").click(function(e) {
  
  e.preventDefault();
  
  var el = $(this);
  
  jeedom.cmd.getSelectModal({cmd: {type: 'action'}}, function (result) { 
    el.closest('.input-group').find('.eqLogicAttr[data-l1key=sliderId]').value(result.human);
  });
  
});

$(".bt_widget_slider_offId").click(function(e) {
  
  e.preventDefault();
  
  var el = $(this);
  
  jeedom.cmd.getSelectModal({cmd: {type: 'action'}}, function (result) { 
    el.closest('.input-group').find('.eqLogicAttr[data-l1key=offId]').value(result.human);
  });
  
});

$(".bt_widget_slider_onId").click(function(e) {
  
  e.preventDefault();
  
  var el = $(this);
  
  jeedom.cmd.getSelectModal({cmd: {type: 'action'}}, function (result) { 
    el.closest('.input-group').find('.eqLogicAttr[data-l1key=onId]').value(result.human);
  });
  
});

/* ==================== */
/* == Selector alarm == */
/* ==================== */

$(".bt_widget_alarm_statusid").click(function(e) {
  
  e.preventDefault();
  
  var el = $(this);
  
  jeedom.cmd.getSelectModal({cmd: {type: 'info'}}, function (result) { 
    el.closest('.input-group').find('.eqLogicAttr[data-l1key=statusId]').value(result.human);
  });
  
});

$(".bt_widget_alarm_offId").click(function(e) {
  
  e.preventDefault();
  
  var el = $(this);
  
  jeedom.cmd.getSelectModal({cmd: {type: 'action'}}, function (result) { 
    el.closest('.input-group').find('.eqLogicAttr[data-l1key=offId]').value(result.human);
  });
  
});
  
$(".bt_widget_alarm_onId").click(function(e) {
  
  e.preventDefault();
  
  var el = $(this);
  
  jeedom.cmd.getSelectModal({cmd: {type: 'action'}}, function (result) { 
    el.closest('.input-group').find('.eqLogicAttr[data-l1key=onId]').value(result.human);
  });
  
});

$(".bt_widget_alarm_bouton_0").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetAlarmComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=bouton-0]') );  
  
});

$(".bt_widget_alarm_bouton_1").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetAlarmComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=bouton-1]') );  
  
});

$(".bt_widget_alarm_bouton_2").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetAlarmComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=bouton-2]') );  
  
});

$(".bt_widget_alarm_bouton_3").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetAlarmComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=bouton-3]') );  
  
});

$(".bt_widget_alarm_bouton_4").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetAlarmComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=bouton-4]') );  
  
});

$(".bt_widget_alarm_bouton_5").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetAlarmComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=bouton-5]') );  
  
});

$(".bt_widget_alarm_bouton_6").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetAlarmComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=bouton-6]') );  
  
});

$(".bt_widget_alarm_bouton_7").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetAlarmComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=bouton-7]') );  
  
});

$(".bt_widget_alarm_bouton_8").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetAlarmComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=bouton-8]') );  
  
});

$(".bt_widget_alarm_bouton_9").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetAlarmComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=bouton-9]') );  
  
});

$(".bt_widget_alarm_bouton_validate").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetAlarmComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=bouton-validate]') );  
  
});

$(".bt_widget_alarm_bouton_cancel").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetAlarmComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=bouton-cancel]') );  
  
});

$(".bt_widget_alarm_success_on").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetAlarmComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=success-on]') );  
  
});

$(".bt_widget_alarm_success_off").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetAlarmComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=success-off]') );  
  
});

$(".bt_widget_alarm_key_on").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetAlarmComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=key-on]') );  
  
});

$(".bt_widget_alarm_key_off").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetAlarmComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=key-off]') );  
  
});

$(".bt_widget_alarm_error").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $('.widget-WidgetAlarmComponent').find('.eqLogicAttr[data-l1key=icons][data-l2key=error]') );  
  
});