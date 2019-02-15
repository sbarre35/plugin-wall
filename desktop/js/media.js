/* ==================== */
/* == Media selector == */
/* ==================== */

function fn_media_selector( ctrl ) { 
  
  $.ajax({
		type: "POST", 
      	url: "plugins/wall/core/ajax/media.ajax.php",     
      	data: {
        	action: "ajax_media_list"
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
    				title: '{{Select a media}}',
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

function fn_media_add( id, filename) {
  
	var element = $.parseHTML('\
    	<div class="eqLogicAction media_element cursor" data-object_id="' + id + '" style="position: absolute; background-color : #ffffff; height : 140px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px"> \
			<div style="z-index:255; position: absolute; left: 0; top: 5px; background-color: transparent !important; border: none !important"> \
            	<a class="bt_media_del btn btn-danger btn-xs pull-right" style="color : white"><i class="fa fa-minus-circle"></i></a> \
            </div> \
          	&nbsp;<center><img width="80px" height="80px" src="wall/medias/' + filename + '"></center> \
		  	<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;"><center>' + id + '</center></span> \
            <input type="hidden" class="cmdAttr form-control input-sm" data-l1key="id" value="' + id + '"> \
			<input type="hidden" class="cmdAttr form-control input-sm" data-l1key="filename" value="' + filename + '"> \
        </div>');     
     
    $('.media_container').append(element).packery('appended',element);
    $('.media_container').packery('reloadItems', element);
  	$('.media_container').packery({ itemSelector: '.media_element' });

};

/* ================== */
/* == DEL FUNCTION == */
/* ================== */

function fn_media_del( id) {

	var row = $('.media_container').find('[data-l1key=id][value='+id+']').closest('.media_element');
                      
	$('.media_container').packery('remove',row);
  	$('.media_container').packery({ itemSelector: '.media_element' });
  
};
 
/* ====================== */
/* == REFRESH FUNCTION == */
/* ====================== */

function fn_media_refresh() {
  
	$('.media_container').empty();
  	$('.media_container').packery({ itemSelector: '.media_element' });

	$.ajax({
		type: "POST", 
      	url: "plugins/wall/core/ajax/media.ajax.php",     
      	data: {
        	action: "ajax_media_list"
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
  					fn_media_add( id, filename);
				});
            }
    
    	}
	});
  
};

/* ================ */
/* == ADD BUTTON == */
/* ================ */

$('#bt_media_add').click(function(e) {

	e.preventDefault();
  
	$('#bt_media_select').click();
  
});

$('#bt_media_select').fileupload({
	replaceFileInput: false,
  	dataType: 'json',
  	done: function(e, data) {
      
    	if (data.result.state != 'ok') {
      		
        	$('#md_wall_alert').showAlert({message: data.result, level: 'danger'});
          
    	} else {
      
    		$('#md_wall_alert').showAlert({message: '{{Fichier ajouté avec succes}}', level: 'success'});
          	          
    		var url = $(this).val();
          
    		var filename = url.substring(url.lastIndexOf('\\')+1);
    		var id = filename.substring(0,filename.lastIndexOf('.'));
    	
          	fn_media_add( id, filename);
          
  			$(this).val('');
      
        }
    }
});

/* ================ */
/* == DEL BUTTON == */
/* ================ */
  
$('.media_container').on('click', '.bt_media_del', function (e) {
  
  	e.preventDefault();
  
	var row = $(this).closest('.media_element');
  	var filename = row.find('.cmdAttr[data-l1key=filename]').val();
  	var id = filename.substring(0,filename.lastIndexOf('.'));
  
    bootbox.confirm('{{Etes-vous sûr de vouloir supprimer le media}} <span style="font-weight: bold ;">' + id + '</span> ?', function(result) {
		if (result) {
        	$.ajax({
              	type: "POST", 
          		url: "plugins/wall/core/ajax/media.ajax.php",     
          		data: {
            		action: "ajax_media_del",
            		filename: filename,
          		},
          		dataType: 'json',
          		error: function(request, status, error) {
                  
            		$('#md_wall_alert').showAlert({message: error, level: 'danger'});
          		
                },
          		success: function(data) {
                  
            		if (data.state != 'ok') {
                      
              			$('#md_wall_alert').showAlert({message: data.result, level: 'danger'});
                      
            		} else {
                  
            			$('#md_wall_alert').showAlert({message: '{{Media supprimé avec succes}}', level: 'success'});
                      	
                       fn_media_del(id);
                    
                    }
          		}
        	});
      	}
    });
  
});

/* =============== */
/* == TAB EVENT == */
/* =============== */

$('#bt_media_tab').click( function (e) {

	e.preventDefault();
  
  	fn_media_refresh();
    
});

/* =================== */
/* == REFRESH EVENT == */
/* =================== */

$('#bt_media_refresh').click( function (e) {

	e.preventDefault();
  
  	fn_media_refresh();
    
});

/* ================== */
/* == FILTER EVENT == */
/* ================== */

$('#filter_media').on('input',function(e){
  
	e.preventDefault();
  
    var filter = $('#filter_media').val();
  
  	$('.media_container .eqLogicAction').each(function( index ) {
      
    	var current = $( this ).find('.cmdAttr[data-l1key=id]').val();
      
        if( filter == "" || current.indexOf( filter ) != -1 ) {
          
          	$( this ).show();
        
        } else {
          
        	$( this ).hide();
      
        }
      
    });
  
    $('.media_container').packery({ itemSelector: '.media_element' }); 
  
});
