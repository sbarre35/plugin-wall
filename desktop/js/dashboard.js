/* ================== */
/* == ADD FUNCTION == */
/* ================== */

function fn_dashboard_add( id, filename) {
  
	var element = $.parseHTML('\
    	<div class="eqLogicAction dashboard_element cursor" data-object_id="' + id + '" style="position: absolute; background-color : #ffffff; height : 140px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px"> \
			<div style="z-index:255; position: absolute; left: 0; top: 5px; background-color: transparent !important; border: none !important"> \
            	<a class="bt_dashboard_del btn btn-danger btn-xs pull-right" style="color : white"><i class="fa fa-minus-circle"></i></a> \
            	<a class="bt_dashboard_mod btn btn-info btn-xs pull-right" style="color : white"><i class="fa fa-edit"></i></a> \
            </div> \
            &nbsp;<center><i class="fa fa-tablet" style="font-size : 7em;color:#767676;"></i></center> \
		  	<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;"><center>' + id + '</center></span> \
            <input type="hidden" class="cmdAttr form-control input-sm" data-l1key="id" value="' + id + '"> \
        </div>');     
  
    $('.dashboard_container').append(element).packery('appended',element);
    $('.dashboard_container').packery('reloadItems', element);
  	$('.dashboard_container').packery({ itemSelector: '.dashboard_element' });

};

/* ================== */
/* == DEL FUNCTION == */
/* ================== */

function fn_dashboard_del( id) {
  
	var row = $('.dashboard_container').find('[data-l1key=id][value='+id+']').closest('.dashboard_element');
                      
	$('.dashboard_container').packery('remove',row);
  	$('.dashboard_container').packery({ itemSelector: '.dashboard_element' });
  
};
  
/* ====================== */
/* == REFRESH FUNCTION == */
/* ====================== */

function fn_dashboard_refresh() {
  
	$('.dashboard_container').empty();
  	$('.dashboard_container').packery({ itemSelector: '.dashboard_element' });

	$.ajax({
		type: "POST", 
      	url: "plugins/wall/core/ajax/dashboard.ajax.php",     
      	data: {
        	action: "ajax_dashboard_list"
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
                	fn_dashboard_add( id, filename);
				});
              
            }
    
    	}
	});
  
};

/* ================ */
/* == ADD BUTTON == */
/* ================ */

$('#bt_dashboard_add').click(function(e) {

	e.preventDefault();
  
  	$('.dashboard_detail').setValues( {
		id: '',
      	options: {
          	hasClock: false,
          	hasCalendar: false,
          	hasRefresh: false,
          	hasAlarm: false,
        	alarmStatusId: '',
          	page: ''
        }
    }, '.eqLogicAttr');
  
    $(".dashboard_detail").find('.eqLogicAttr[data-l1key=id]').prop("readonly", false);
  	$('.dashboard_detail').find('.eqLogicAttr[data-l1key=readonly]').val('FALSE');
  
    $("#dashboard_tab").removeClass("active");
    $("#dashboard_form").addClass("active");
  
});

/* ================ */
/* == MOD BUTTON == */
/* ================ */

$('.dashboard_container').on('click', '.bt_dashboard_mod', function (e) {
  
  	e.preventDefault();
  
	var row = $(this).closest('.dashboard_element');
  	var id = row.find('.cmdAttr[data-l1key=id]').val();
  
    $.ajax({
		type: "POST", 
      	url: "plugins/wall/core/ajax/dashboard.ajax.php",     
      	data: {
        	action: "ajax_dashboard_get",
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
              
              	$('.dashboard_detail').find('[data-l1key=id]').val(id);
          		$('.dashboard_detail').setValues( JSON.parse(data.result), '.eqLogicAttr');

              	$(".dashboard_detail").find('.eqLogicAttr[data-l1key=id]').prop("readonly", true);
  				$('.dashboard_detail').find('.eqLogicAttr[data-l1key=readonly]').val('TRUE');
              
    			$("#dashboard_tab").removeClass("active");
    			$("#dashboard_form").addClass("active");
              
        	}
      	}
    });
  
});

/* ========================= */
/* == ADD VALIDATE BUTTON == */
/* ========================= */

$('#bt_dashboard_add_validate').click(function(e) {

  e.preventDefault();
  
  var id = $('.dashboard_detail').find('[data-l1key=id]').val();
  
  var data = $('.dashboard_detail').getValues( '.eqLogicAttr');
  
  var id = data[0]['id'];
  var json = JSON.stringify({ options: data[0]['options'] },null,2);
  var readonly = data[0]['readonly'];
  
  if ( id != "") {
    $.ajax({
		type: "POST", 
      	url: "plugins/wall/core/ajax/dashboard.ajax.php",     
      	data: {
        	action: "ajax_dashboard_add",
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

          		var readonly = $('.dashboard_detail').find('.eqLogicAttr[data-l1key=readonly]').val();
              
              	if( readonly == 'FALSE' ) {
                  
              		$('#md_wall_alert').showAlert({message: '{{Dashboard créé avec succès}}', level: 'success'});
                  
                } else {
                  
                  	$('#md_wall_alert').showAlert({message: '{{Dashboard modifié avec succès}}', level: 'success'});
                  
                }

              	$("#dashboard_tab").addClass("active");
    			$("#dashboard_form").removeClass("active");
              
          		fn_dashboard_refresh();

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

$('#bt_dashboard_add_cancel').click(function(e) {

	e.preventDefault();
  
    $("#dashboard_tab").addClass("active");
    $("#dashboard_form").removeClass("active");
  
});

/* ================ */
/* == DEL BUTTON == */
/* ================ */
  
$('.dashboard_container').on('click', '.bt_dashboard_del', function (e) {
  
  	e.preventDefault();
  
	var row = $(this).closest('.dashboard_element');
  	var id = row.find('.cmdAttr[data-l1key=id]').val();
  
  	bootbox.confirm('{{Etes-vous sûr de vouloir supprimer le dashboard}} <span style="font-weight: bold ;">' + id + '</span> ?', function(result) {
		if (result) {
        	$.ajax({
              	type: "POST", 
          		url: "plugins/wall/core/ajax/dashboard.ajax.php",     
          		data: {
            		action: "ajax_dashboard_del",
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
                  
            			$('#md_wall_alert').showAlert({message: '{{Dashboard supprimé avec succes}}', level: 'success'});
                      	
                    	fn_dashboard_del( id);
                    
                    }
          		}
        	});
      	}
    });
  
});

/* =============== */
/* == TAB EVENT == */
/* =============== */

$('#bt_dashboard_tab').click( function (e) {

	e.preventDefault();
  
  	fn_dashboard_refresh();
    
});

/* =================== */
/* == REFRESH EVENT == */
/* =================== */

$('#bt_dashboard_refresh').click( function (e) {

	e.preventDefault();
  
  	fn_dashboard_refresh();
    
});

/* ================== */
/* == FILTER EVENT == */
/* ================== */

$('#filter_dashboard').on('input',function(e){
  
	e.preventDefault();
  
    var filter = $('#filter_dashboard').val();
  
  	$('.dashboard_container .eqLogicAction').each(function( index ) {
      
    	var current = $( this ).find('.cmdAttr[data-l1key=id]').val();
      
        if( filter == "" || current.indexOf( filter ) != -1 ) {
          
          	$( this ).show();
        
        } else {
          
        	$( this ).hide();
      
        }
      
    });
  
    $('.dashboard_container').packery({ itemSelector: '.dashboard_element' }); 
  
});

/* ============================ */
/* == Selector alarmStatusId == */
/* ============================ */

$("#bt_dashboard_alarmStatusId").click(function(e) {
  
  e.preventDefault();
  
  var el = $(this);
  
  jeedom.cmd.getSelectModal({cmd: {type: 'info'}}, function (result) { 
    el.closest('.input-group').find('.eqLogicAttr[data-l2key=alarmStatusId]').value(result.human);
  });
  
});

/* =================== */
/* == Selector page == */
/* =================== */

$("#bt_dashboard_page").click(function(e) {
  
  e.preventDefault();
  
  fn_page_selector( $('.dashboard_detail').find('.eqLogicAttr[data-l2key=page]') );  
  
});
