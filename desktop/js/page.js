/* =================== */
/* == Page selector == */
/* =================== */

function fn_page_selector( ctrl ) { 
  
  $.ajax({
		type: "POST", 
      	url: "plugins/wall/core/ajax/page.ajax.php",     
      	data: {
        	action: "ajax_page_list"
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
    				title: '{{Select a page}}',
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

function fn_page_add( id, filename) {
  
	var element = $.parseHTML('\
    	<div class="eqLogicAction page_element cursor" data-object_id="' + id + '" style="position: absolute; background-color : #ffffff; height : 140px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px"> \
			<div style="z-index:255; position: absolute; left: 0; top: 5px; background-color: transparent !important; border: none !important"> \
            	<a class="bt_page_del btn btn-danger btn-xs pull-right" style="color : white"><i class="fa fa-minus-circle"></i></a> \
            	<a class="bt_page_mod btn btn-info btn-xs pull-right" style="color : white"><i class="fa fa-edit"></i></a> \
            </div> \
            &nbsp;<center><i class="fa fa-table" style="font-size : 7em;color:#767676;"></i></center> \
		  	<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;"><center>' + id + '</center></span> \
            <input type="hidden" class="cmdAttr form-control input-sm" data-l1key="id" value="' + id + '"> \
        </div>');     
  
    $('.page_container').append(element).packery('appended',element);
    $('.page_container').packery('reloadItems', element);
  	$('.page_container').packery({ itemSelector: '.page_element' });

};

/* ================== */
/* == DEL FUNCTION == */
/* ================== */

function fn_page_del( id) {
  
	var row = $('.page_container').find('[data-l1key=id][value='+id+']').closest('.page_element');
                      
	$('.page_container').packery('remove',row);
  	$('.page_container').packery({ itemSelector: '.page_element' });
  
};

/* ================== */
/* == RAZ FUNCTION == */
/* ================== */

function fn_raz_widget() {
  
	var step; for (step = 1; step <=8; step++) {  
    	$('.page_detail_menus_data_'+step).setValues( {
          "options": {
            "message": "navigate",
            "data": {
              "id": ""
            },
            "title": "",
            "icon": "",
            "selected": "0"
          },
          "template": "MenuLinkComponent"
        }, '.MenuLinkComponent');    
      	$('.page_detail_menus_data_'+step).setValues( {
          "options": {
            "message": "navigate"
          },
          "template": "MenuSpacerComponent"
        }, '.MenuSpacerComponent');    
    }
  
  	$('.page_detail_widgets_data').empty();
  
}

/* ====================== */
/* == REFRESH FUNCTION == */
/* ====================== */

function fn_page_refresh() {
  
	$('.page_container').empty();
  	$('.page_container').packery({ itemSelector: '.page_element' });

	$.ajax({
		type: "POST", 
      	url: "plugins/wall/core/ajax/page.ajax.php",     
      	data: {
        	action: "ajax_page_list"
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
                	fn_page_add( id, filename);
				});
              
            }
    
    	}
	});
  
};

/* ================ */
/* == ADD BUTTON == */
/* ================ */

$('#bt_page_add').click(function(e) {

	e.preventDefault();
  
  	fn_raz_widget();
  
  	$('.page_detail').setValues( {
		id: ''
    }, '.eqLogicAttr');

    $(".page_detail").find('.eqLogicAttr[data-l1key=id]').prop("readonly", false);
  	$('.page_detail').find('.eqLogicAttr[data-l1key=readonly]').val('FALSE');
  
    $("#page_tab").removeClass("active");
    $("#page_form").addClass("active");
  
});

/* ================ */
/* == MOD BUTTON == */
/* ================ */

$('.page_container').on('click', '.bt_page_mod', function (e) {
  
  	e.preventDefault();
  
	var row = $(this).closest('.page_element');
  	var id = row.find('.cmdAttr[data-l1key=id]').val();
  
    $.ajax({
		type: "POST", 
      	url: "plugins/wall/core/ajax/page.ajax.php",     
      	data: {
        	action: "ajax_page_get",
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
              
              	$('.page_detail').find('[data-l1key=id]').val(id);
          		$('.page_detail').setValues( JSON.parse(data.result), '.eqLogicAttr');

              	var json = JSON.parse(data.result);

               	fn_raz_widget();

              	var menus = json.options.dashboardData.menuData;
              
              	var step; for (step = 1; step <=8; step++) {  
                  	var idx = step -1;
    				var template = menus[idx].template;
    				$('.page_detail_menus_data_'+step).setValues( menus[idx], '.'+template);      
    			}
              
              	$(".page_detail_widgets_data").empty();
        
        		json.options.dashboardData.groupsData.forEach(function(element) {
                	$(".page_detail_widgets_template").clone().appendTo(".page_detail_widgets_data").show().removeClass("page_detail_widgets_template").addClass("page_detail_widgets_data_content").setValues(element,'.eqLogicAttr');
				});
              
              	$(".page_detail").find('.eqLogicAttr[data-l1key=id]').prop("readonly", true);
  				$('.page_detail').find('.eqLogicAttr[data-l1key=readonly]').val('TRUE');
  
    			$("#page_tab").removeClass("active");
    			$("#page_form").addClass("active");
  
        	}
      	}
    });
  
});

/* ========================= */
/* == ADD VALIDATE BUTTON == */
/* ========================= */

$('#bt_page_add_validate').click(function(e) {

  e.preventDefault();
  
  var data = $('.page_detail').getValues( '.eqLogicAttr');
  
  var id = data[0]['id'];
  var readonly = data[0]['readonly'];
  
  var groupData = $('.page_detail_widgets_data_content').getValues('.eqLogicAttr');

  groupData.forEach(function(element) {
    element.groupsData=null;
  })
      
  var step; var menus = []; for (step = 1; step <=8; step++) {  
   	var template = $('.page_detail_menus_data_'+step).find('[data-l1key=template]').val();
  	menus.push( $('.page_detail_menus_data_'+step).getValues( '.'+template)[0]);      
  }
  
  var json = JSON.stringify({ options: { dashboardData: { groupsData: groupData, menuData: menus } } },null,2);
  
  if (id != "" ) { 
    $.ajax({
		type: "POST", 
      	url: "plugins/wall/core/ajax/page.ajax.php",     
      	data: {
        	action: "ajax_page_add",
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

          		var readonly = $('.page_detail').find('.eqLogicAttr[data-l1key=readonly]').val();
              
              	if( readonly == 'FALSE' ) {
                  
              		$('#md_wall_alert').showAlert({message: '{{Page créée avec succès}}', level: 'success'});
                  
                } else {
                  
                  	$('#md_wall_alert').showAlert({message: '{{Page modifiée avec succès}}', level: 'success'});
                  
                }
  
              	$("#page_tab").addClass("active");
    			$("#page_form").removeClass("active");
  
          		fn_page_refresh();

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

$('#bt_page_add_cancel').click(function(e) {

	e.preventDefault();
  
    $("#page_tab").addClass("active");
    $("#page_form").removeClass("active");
  
});

/* ================ */
/* == DEL BUTTON == */
/* ================ */
  
$('.page_container').on('click', '.bt_page_del', function (e) {
  
  	e.preventDefault();
  
  	var row = $(this).closest('.page_element');
  	var id = row.find('.cmdAttr[data-l1key=id]').val();
  
  	bootbox.confirm('{{Etes-vous sûr de vouloir supprimer la page}} <span style="font-weight: bold ;">' + id + '</span> ?', function(result) {
		if (result) {
        	$.ajax({
              	type: "POST", 
          		url: "plugins/wall/core/ajax/page.ajax.php",     
          		data: {
            		action: "ajax_page_del",
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
                  
            			$('#md_wall_alert').showAlert({message: '{{Page supprimée avec succes}}', level: 'success'});
                      	
                    	fn_page_del( id);
                    
                    }
          		}
        	});
      	}
    });
  
});

/* =============== */
/* == TAB EVENT == */
/* =============== */

$('#bt_page_tab').click( function (e) {

	e.preventDefault();
  
  	fn_page_refresh();
    
});

/* =================== */
/* == REFRESH EVENT == */
/* =================== */

$('#bt_page_refresh').click( function (e) {

	e.preventDefault();
  
  	fn_page_refresh();
    
});

/* ================== */
/* == FILTER EVENT == */
/* ================== */

$('#filter_page').on('input',function(e){
  
	e.preventDefault();
  
    var filter = $('#filter_page').val();
  
  	$('.page_container .eqLogicAction').each(function( index ) {
      
    	var current = $( this ).find('.cmdAttr[data-l1key=id]').val();
      
        if( filter == "" || current.indexOf( filter ) != -1 ) {
          
          	$( this ).show();
        
        } else {
          
        	$( this ).hide();
      
        }
      
    });
  
    $('.page_container').packery({ itemSelector: '.page_element' }); 
  
});

/* ================ */
/* == OBJECT ADD == */
/* ================ */

$('#bt_object_add').click(function(e) {

	e.preventDefault();
  
    $(".page_detail_widgets_template").clone().appendTo(".page_detail_widgets_data").show().removeClass("page_detail_widgets_template").addClass("page_detail_widgets_data_content");
  
});
  
/* ================ */
/* == OBJECT DEL == */
/* ================ */

$('.page_detail_widgets_data').on('click', '.bt_object_del', function (e) {
  
  	e.preventDefault();
  
	var row = $(this).closest('.page_detail_widgets_data_content').remove();
  
});

/* =================== */
/* == Selector page == */
/* =================== */

$(".bt_page_menu_page").click(function(e) {
 
  e.preventDefault();
  
  fn_page_selector( $(this).closest('.page_detail_menus_data').find('.eqLogicAttr[data-l1key=options][data-l2key=data][data-l3key=id]') );  
  
});

/* =================== */
/* == Selector icon == */
/* =================== */

$(".bt_page_menu_icon").click(function(e) {
 
  e.preventDefault();
  
  fn_media_selector( $(this).closest('.page_detail_menus_data').find('.eqLogicAttr[data-l1key=options][data-l2key=icon]') );  
  
});

/* ===================== */
/* == Selector widget == */
/* ===================== */

$('.page_detail_widgets_data').on('click', '.bt_page_widget_widget', function (e) {
 
  e.preventDefault();

  fn_widget_selector( $(this).closest('.page_detail_widgets_data_content').find('.eqLogicAttr[data-l1key=widgetData][data-l2key=id]') );  
  
});

