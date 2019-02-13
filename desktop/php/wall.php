<?php

include_file('core', 'authentification', 'php');

if (!isConnect('admin')) {
  
	throw new Exception('{{401 - Refused access}}');
  
}

?>

<!-- =========== -->
<!-- == Style == -->
<!-- =========== -->

<style>

.dashboard_container, .dashboard_detail, .page_container, .page_detail, .widget_container, .widget_detail, .media_container, .media_detail, .page_detail_widgets, .page_detail_menus {
  
  	border-top: 1px solid #4b4b4b !important; 
    margin-top: 15px !important;
    padding-top: 15px !important;
      
}
  
</style>
  
<!-- =============== -->
<!-- == Plugin id == -->
<!-- =============== -->

<?php

$plugin = plugin::byId('wall');

?>
  
<!-- ================ -->
<!-- == Javascript == -->
<!-- ================ -->

<?php
  
sendVarToJS('eqType', $plugin->getId());

?>
  
<!-- ================= -->
<!-- == Plugin data == -->
<!-- ================= -->

<?php
  
$eqLogics = eqLogic::byType($plugin->getId());

?>
  
<!-- ============================ -->
<!-- == Begin global container == -->
<!-- ============================ -->
  
<div class="row">

	<!-- ========================== -->
    <!-- == Begin principal zone == -->
    <!-- ========================== -->
                  
	<div class="col-lg-12 col-md-12 col-sm-12">
  
		<!-- ================ -->
      	<!-- == Begin tabs == -->
      	<!-- ================ -->
             
      	<ul class="nav nav-tabs" role="tablist">
  
  			<!-- ===================== -->
       		<!-- == Tab [Dashboard] == -->
        	<!-- ===================== -->
             
        	<li role="presentation" class="active">
				<a id="bt_dashboard_tab" href="#dashboard_tab" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-tablet"></i> {{Dashboards}}</a>
        	</li>
        
        	<!-- ================ -->
       		<!-- == Tab [Page] == -->
        	<!-- ================ -->
             
        	<li role="presentation">
          		<a id="bt_page_tab" href="#page_tab" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-table"></i> {{Pages}}</a>
        	</li>
        
        	<!-- ================== -->
        	<!-- == Tab [Widget] == -->
        	<!-- ================== -->
             
        	<li role="presentation">
          		<a id="bt_widget_tab" href="#widget_tab" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-tachometer"></i> {{Widgets}}</a>
        	</li>
        
        	<!-- ================== -->
        	<!-- == Tab [Medias] == -->
        	<!-- ================== -->
             
        	<li role="presentation">
          		<a id="bt_media_tab" href="#media_tab" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-picture-o"></i> {{Medias}}</a>
        	</li>
  
  		<!-- ============== -->
      	<!-- == End tabs == -->
      	<!-- ============== -->
  
  		</ul>
  
  		<!-- =================== -->
  		<!-- == Begin display == -->
  		<!-- =================== -->
  
  		<div class="tab-content" style="height:calc(100% - 50px); overflow:auto; overflow-x: hidden;">
      
  			<!-- =================== -->
  			<!-- == Error Message == -->
  			<!-- =================== -->
  
  			<div style="display: none;" id="md_wall_alert"></div>
  
  			<!-- ========================= -->
  			<!-- == Display [Dashboard] == -->
  			<!-- ========================= -->
  
  			<div role="tabpanel" class="tab-pane active" id="dashboard_tab">  
               <legend>
                	<i class="fa fa-tablet"></i> {{Dashboards}} 
                    <a id="bt_dashboard_refresh" class="btn btn-info btn-sm pull-right" style="color : white; z-index:255"><i class="fa fa-2x fa-refresh"></i></a>
					<a id="bt_dashboard_add" class="btn btn-success btn-sm pull-right" style="color : white; z-index:255"><i class="fa fa-2x fa-plus-circle"></i></a>
                    <input id="filter_dashboard" class="pull-right form-control input-sm" placeholder="Rechercher" style="width: 100px">
				</legend>
                <div class="dashboard_container">
                </div>
    		</div>
                      
            <!-- ====================== -->
  			<!-- == Edit [Dashboard] == -->
  			<!-- ====================== -->
  
  			<div role="tabpanel" class="tab-pane" id="dashboard_form">  
               <legend>
                	<i class="fa fa-tablet"></i> {{My dashboard}} 
                    <a id="bt_dashboard_add_validate" class="btn btn-success eqLogicAction pull-right"><i class="fa fa-check-circle"></i> Sauvegarder</a>
                	<a id="bt_dashboard_add_cancel" class="btn btn-danger eqLogicAction pull-right"><i class="fa fa-times-circle"></i> Annuler</a>
				</legend> 
                <form class="dashboard_detail form-horizontal">
                	<fieldset>
						<div class="form-group">
                      		<label class="col-sm-2 control-label">{{Dashboard identifier}}</label>
                      		<div class="col-sm-10">
                      			<input type="text" class="eqLogicAttr form-control" data-l1key="id">
                      		</div>
                  		</div>  
                        <div class="form-group" style="display:none">
                      		<label class="col-sm-2 control-label">{{Readonly flag}}</label>
                      		<div class="col-sm-10">
                      			<input type="text" class="eqLogicAttr form-control" data-l1key="readonly">
                      		</div>
                  		</div> 
                      	<div class="form-group">
                      		<label class="col-sm-2 control-label">{{Clock flag}}</label>
                      		<div class="col-sm-10">
                      			<input type="checkbox" class="eqLogicAttr form-control" style="width:38px" data-l1key="options" data-l2key="hasClock"/>
							</div>
                      	</div>
                        <div class="form-group">
                      		<label class="col-sm-2 control-label">{{Calendar flag}}</label>
                      		<div class="col-sm-2">
                      			<input type="checkbox" class="eqLogicAttr form-control" style="width:38px" data-l1key="options" data-l2key="hasCalendar"/>
                      		</div>
                      	</div>
                      	 <div class="form-group">
                      		<label class="col-sm-2 control-label">{{Refresh flag}}</label>
                      		<div class="col-sm-2">
                      			<input type="checkbox" class="eqLogicAttr form-control" style="width:38px" data-l1key="options" data-l2key="hasRefresh"/>
                      		</div>
                      	</div>
                      	<div class="form-group">
                      		<label class="col-sm-2 control-label">{{Alarm flag}}</label>
                      		<div class="col-sm-2">
                      			<input type="checkbox" class="eqLogicAttr form-control" style="width:38px" data-l1key="options" data-l2key="hasAlarm"/>
                      		</div>
                      	</div>
                        <div class="form-group">
                      		<label class="col-sm-2 control-label">{{Alarm identifier}}</label>
                      		<div class="col-sm-10">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="options" data-l2key="alarmStatusId">
                      				<div class="input-group-btn" id="bt_dashboard_alarmStatusId">
      									<a class="btn btn-default cursor" title="Choisir une commande"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>
                      		</div>
                  		</div>
                      	<div class="form-group">
                      		<label class="col-sm-2 control-label">{{Start page identifier}}</label>
                      		<div class="col-sm-10">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="options" data-l2key="page">
                      				<div class="input-group-btn" id="bt_dashboard_page">
      									<a class="btn btn-default cursor" title="Choisir une page"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>
                      		</div>
                  		</div>
                    </fieldset>
                </form>                                     
    		</div>
                      
            <!-- ==================== -->
  			<!-- == Display [Page] == -->
  			<!-- ==================== -->
  
  			<div role="tabpanel" class="tab-pane" id="page_tab">  
               <legend>
                	<i class="fa fa-table"></i> {{Pages}} 
					<a id="bt_page_refresh" class="btn btn-info btn-sm pull-right" style="color : white; z-index:255"><i class="fa fa-2x fa-refresh"></i></a>
					<a id="bt_page_add" class="btn btn-success btn-sm pull-right" style="color : white; z-index:255"><i class="fa fa-2x fa-plus-circle"></i></a>
                    <input id="filter_page" class="pull-right form-control input-sm" placeholder="Rechercher" style="width: 100px">
				</legend>
                <div class="page_container">
                </div>
    		</div>          
  
            <!-- ================= -->
  			<!-- == Edit [Page] == -->
  			<!-- ================= -->
  
  			<div role="tabpanel" class="tab-pane" id="page_form">  
               <legend>
                	<i class="fa fa-table"></i> {{My page}} 
                    <a id="bt_page_add_validate" class="btn btn-success eqLogicAction pull-right"><i class="fa fa-check-circle"></i> Sauvegarder</a>
                	<a id="bt_page_add_cancel" class="btn btn-danger eqLogicAction pull-right"><i class="fa fa-times-circle"></i> Annuler</a>
				</legend> 
                <form class="page_detail form-horizontal">
                	<fieldset>
						<div class="form-group">
                      		<label class="col-sm-2 control-label">{{Page identifier}}</label>
                      		<div class="col-sm-10">
                      			<input type="text" class="eqLogicAttr form-control" data-l1key="id">
                      		</div>
                  		</div>  
                        <div class="form-group" style="display:none">
                      		<label class="col-sm-2 control-label">{{Readonly flag}}</label>
                      		<div class="col-sm-10">
                      			<input type="text" class="eqLogicAttr form-control" data-l1key="readonly">
                      		</div>
                  		</div>
                      </fieldset>
                 </form>
                 <form class="page_detail_widgets form-horizontal">
					<div class="row page_detail_widgets_headers">
                    	<div class="col-sm-2" style="text-align:right">
                    		<label class="control-label">{{Objects}}</label>
                    	</div>
                      	<div class="col-sm-2" style="text-align:left">
                      		<label class="control-label" style="text-align:left">{{Widget identifier}}</label>
                      	</div>
                      	<div class="col-sm-2">
                      		<label class="control-label" style="text-align:left">{{Width}}</label>
                      	</div>
                      	<div class="col-sm-2">
                      		<label class="control-label" style="text-align:left">{{Height}}</label>
                      	</div>
                      	<div class="col-sm-4" style="text-align:right">
                      		<label class="control-label" style="text-align:left"><a id="bt_object_add" class="btn btn-success btn-sm pull-right" style="color : white; z-index:255"><i class="fa fa-2x fa-plus-circle"></i></a></label>
                      	</div>
                  	</div>
					<div class="page_detail_widgets_template" style="display:none">
                      <div class="form-group row">
                  	 	<div class="col-sm-2" style="text-align:right">
                   			<label class="control-label">#</label>                            
                        </div>  
                   		<div class="col-sm-2">
                        	<div class="input-group">  
                            	<input type="text" class="eqLogicAttr form-control" data-l1key="widgetData" data-l2key="id"/>
                      			<div class="input-group-btn bt_page_widget_widget">
      								<a class="btn btn-default cursor" title="Choisir un widget"><i class="fa fa fa-ellipsis-h"></i></a>
    							</div>
                      		</div>
                       	</div>
                      	<div class="col-sm-2">
    						<div>  
		                       	<select class="eqLogicAttr form-control" data-l1key="width">
                      				<option value="12.5%">1</option>
                      				<option value="25%">2</option>
                      				<option value="37.5%">3</option>
                      				<option value="50%">4</option>
                      				<option value="62.5%">5</option>
                      				<option value="75%">6</option>
                      				<option value="87.5%">7</option>
                      				<option value="100%">8</option>
                      			</select>
                            </div>
                        </div>
                        <div class="col-sm-2">
    						<div>  
		                       	<select class="eqLogicAttr form-control" data-l1key="height">
                      				<option value="25%">1</option>
                      				<option value="50%">2</option>
                      				<option value="75%">3</option>
                      				<option value="100%">4</option>
                      			</select>
                            </div>
                        </div>
                        <div class="col-sm-4">
    						<div style="height:38px">
                            	<a class="bt_object_del btn btn-danger btn-sm pull-right" style="margin-top: 6px; color : white"><i class="fa fa-2x fa-minus-circle"></i></a>
                            </div>
                        </div>
                      </div>
                 	</div>  
                 	<div class="page_detail_widgets_data">
                    </div>
                 </form>      
                 <form class="page_detail_menus form-horizontal">
                	<div class="form-group row page_detail_menus_headers">
                    	<div class="col-sm-2" style="text-align:right">
                      		<label class="control-label">{{Menus}}</label>
                     	</div>
                      	<div class="col-sm-2" style="text-align:left">
                      		<label class="control-label">{{Template}}</label>
                      	</div>
                      	<div class="col-sm-2">
                      		<label class="control-label" style="text-align:left">{{Page identifier}}</label>
                      	</div>
                      	<div class="col-sm-2">
                      		<label class="control-label" style="text-align:left">{{Title}}</label>
                      	</div>
                      	<div class="col-sm-2">
                      		<label class="control-label" style="text-align:left">{{Media identifier}}</label>
                      	</div>
                      	<div class="col-sm-1">
                      		<label class="control-label" style="text-align:left">{{Selected flag}}</label>
                      	</div>
                  	</div>  
                    <?php for ($i = 1; $i <= 8; $i++) { ?> 
                    	<div class="form-group row page_detail_menus_data page_detail_menus_data_<?php echo $i; ?>">
                    		<div class="col-sm-2" style="text-align:right">
                      			<label class="control-label">#</label>
                                <input type="text" class="eqLogicAttr form-control MenuSpacerComponent MenuLinkComponent" data-l1key="options" data-l2key="message" value="navigate" style="display:none"/>
                            </div>
                            <div class="col-sm-2"> 
                                <select class="eqLogicAttr form-control input MenuSpacerComponent MenuLinkComponent" data-l1key="template" id="bt_widget_template" onchange="fn_widget_template( this,'<?php echo $i; ?>')">
                      				<option value="MenuSpacerComponent">Vide</option>
                      				<option value="MenuLinkComponent">Lien</option>
                      			</select> 
                            </div>
                            <div class="col-sm-2">
                            	<div class="input-group Menu MenuLinkComponent" style="display:none"> 
                      				<input type="text" class="eqLogicAttr form-control MenuLinkComponent" data-l1key="options" data-l2key="data" data-l3key="id">
                      				<div class="input-group-btn bt_page_menu_page">
      									<a class="btn btn-default cursor" title="Choisir une page"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>
                            </div>
                            <div class="col-sm-2">
    							<div class="Menu MenuLinkComponent" style="display:none">  
		                        	<input type="text" class="eqLogicAttr form-control Menu MenuLinkComponent" data-l1key="options" data-l2key="title"/>
                                </div>
                            </div>
                            <div class="col-sm-2">
								<div class="input-group Menu MenuLinkComponent" style="display:none">  
                            		<input type="text" class="eqLogicAttr form-control MenuLinkComponent" data-l1key="options" data-l2key="icon"/>
                      				<div class="input-group-btn bt_page_menu_icon">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>
                            </div>
                            <div class="col-sm-2">
								<div class="input-group Menu MenuLinkComponent" style="display:none">  
	                                <input type="checkbox" class="eqLogicAttr form-control MenuLinkComponent" style="width:38px" data-l1key="options" data-l2key="selected"/>
    							</div>
                            </div>
                        </div>                  		
                 	<?php } ?>
                 </form>
            </div>
                      
			<!-- ====================== -->
  			<!-- == Display [Widget] == -->
  			<!-- ====================== -->
  
            <div role="tabpanel" class="tab-pane" id="widget_tab">  
               <legend>                      
                	<i class="fa fa-tachometer"></i> {{Widgets}} 
                    <a id="bt_widget_refresh" class="btn btn-info btn-sm pull-right" style="color : white; z-index:255"><i class="fa fa-2x fa-refresh"></i></a>
					<a id="bt_widget_add" class="btn btn-success btn-sm pull-right" style="color : white; z-index:255"><i class="fa fa-2x fa-plus-circle"></i></a>
                    <input id="filter_widget" class="pull-right form-control input-sm" placeholder="Rechercher" style="width: 100px">
				</legend>
                <div class="widget_container">
                </div>
    		</div>   
                      
            <!-- =================== -->
  			<!-- == Edit [Widget] == -->
  			<!-- =================== -->
  
  			<div role="tabpanel" class="tab-pane" id="widget_form">  
                      
               <legend>
                	<i class="fa fa-tachometer"></i> {{My page}} 
                    <a id="bt_widget_add_validate" class="btn btn-success eqLogicAction pull-right"><i class="fa fa-check-circle"></i> Sauvegarder</a>
                	<a id="bt_widget_add_cancel" class="btn btn-danger eqLogicAction pull-right"><i class="fa fa-times-circle"></i> Annuler</a>
				</legend>
                      
                <!-- ====================== -->
                <!-- Edit [Widget] / Header -->
                <!-- ====================== -->
                      
                <form class="widget_detail form-horizontal">
                	<fieldset>
						<div class="form-group">
                      		<label class="col-sm-2 control-label">{{Widget identifier}}</label>
                      		<div class="col-sm-10">
                      			<input type="text" class="eqLogicAttr form-control" data-l1key="id">
                      		</div>
                  		</div>  
                        <div class="form-group">
                      		<label class="col-sm-2 control-label">{{Template}}</label>
                      		<div class="col-sm-10">
                      			<input readonly type="text" class="eqLogicAttr form-control" data-l1key="template">
                      		</div>
                  		</div>
                        <div class="form-group" style="display:none">
                      		<label class="col-sm-2 control-label">{{Readonly flag}}</label>
                      		<div class="col-sm-10">
                      			<input readonly type="text" class="eqLogicAttr form-control" data-l1key="readonly">
                      		</div>
                  		</div>
                    </fieldset>
                </form>
                
                <!-- ==================== -->
                <!-- Edit [Widget] / Link -->
                <!-- ==================== -->
                        
                <form class="form-horizontal widget widget-WidgetLinkComponent">
                	<fieldset>
						<div class="form-group" style="display:none">
                           	<label class="col-sm-2 control-label">{{Message}}</label>
                            <div class="col-sm-10">
                              	<input type="hidden" class="eqLogicAttr form-control" data-l1key="message" value="navigate"/>
                            </div>
                    	</div>
                      	<div class="form-group">
                           	<label class="col-sm-2 control-label">{{Top label}}</label>
                            <div class="col-sm-10">
                               	<input class="eqLogicAttr form-control" data-l1key="top"/>
                            </div>
                    	</div>
                      	<div class="form-group">
                           	<label class="col-sm-2 control-label">{{Bottom label}}</label>
                            <div class="col-sm-10">
                               	<input class="eqLogicAttr form-control" data-l1key="bottom"/>
                            </div>
                        </div>
                      	<div class="form-group">
                        	<label class="col-sm-2 control-label">{{Media identifier}}</label>
                            <div class="col-sm-10">   
                      			<div class="input-group">
                      				<input class="eqLogicAttr form-control" data-l1key="icons" data-l2key="link">
                      				<div class="input-group-btn bt_widget_link_icon">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>
                      		</div>
                        </div>
                        <div class="form-group">
                          	<label class="col-sm-2 control-label">{{Page identifier}}</label>
                            <div class="col-sm-10">
                      			<div class="input-group">
                      				<input class="eqLogicAttr form-control" data-l1key="data" data-l2key="id">
                      				<div class="input-group-btn bt_widget_link_page">
      									<a class="btn btn-default cursor" title="Choisir une page"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>
                            </div>
                        </div>
					</fieldset>   
				</form>
                      
                <!-- ====================== -->
                <!-- Edit [Widget] / Camera -->
                <!-- ====================== -->
                        
                <form class="form-horizontal widget widget-WidgetCameraComponent">
                	<fieldset>
						<div class="form-group" style="display:none">
                           	<label class="col-sm-2 control-label">{{Message}}</label>
                            <div class="col-sm-10">
                              	<input type="hidden" class="eqLogicAttr form-control" data-l1key="message" value="navigate"/>
                            </div>
                    	</div>
                      	<div class="form-group">
                           	<label class="col-sm-2 control-label">{{Top label}}</label>
                            <div class="col-sm-10">
                               	<input class="eqLogicAttr form-control" data-l1key="top"/>
                            </div>
                    	</div>
                      	<div class="form-group">
                           	<label class="col-sm-2 control-label">{{Bottom label}}</label>
                            <div class="col-sm-10">
                               	<input class="eqLogicAttr form-control" data-l1key="bottom"/>
                            </div>
                        </div>
                      	<div class="form-group">
                        	<label class="col-sm-2 control-label">{{Camera identifier}}</label>
                            <div class="col-sm-10">   
                      			<div class="input-group">
                      				<input class="eqLogicAttr form-control" data-l1key="cameraId">
                      				<div class="input-group-btn bt_widget_camera_cameraid">
      									<a class="btn btn-default cursor" title="Choisir une commande"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>
                      		</div>
                        </div>
                        <div class="form-group">
                          	<label class="col-sm-2 control-label">{{Camera plugin key}}</label>
                            <div class="col-sm-10">
                      			<input class="eqLogicAttr form-control" data-l1key="key">
                            </div>
                        </div>
					</fieldset>   
				</form>
                      
                <!-- ==================== -->
                <!-- Edit [Widget] / Info -->
                <!-- ==================== -->
                        
                <form class="form-horizontal widget widget-WidgetBinaryDoorComponent">
                	<fieldset>
						<div class="form-group">
                           	<label class="col-sm-2 control-label">{{Top label}}</label>
                            <div class="col-sm-10">
                              	<input type="text" class="eqLogicAttr form-control" data-l1key="top"/>
                            </div>
                    	</div>
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{Bottom label}}</label>
                            <div class="col-sm-10">
                              	<input type="text" class="eqLogicAttr form-control" data-l1key="bottom"/>
                            </div>
                    	</div>
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{Loading label}}</label>
                            <div class="col-sm-4">
                              	<input type="text" class="eqLogicAttr form-control" data-l1key="labels" data-l2key="loading"/>
                            </div>
                      		<label class="col-sm-2 control-label">{{Loading media}}</label>
                            <div class="col-sm-4">                              	
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="loading"/>
                            		<div class="input-group-btn bt_widget_info_loading">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>
                            </div>
						</div>
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{State 0 label}}</label>
                            <div class="col-sm-4">
                              	<input type="text" class="eqLogicAttr form-control" data-l1key="labels" data-l2key="status-0"/>
                            </div>
                      		<label class="col-sm-2 control-label">{{State 0 media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="status-0"/>
                            		<div class="input-group-btn bt_widget_info_status_0">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div>
                    	</div>
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{State 1 label}}</label>
                            <div class="col-sm-4">
                              	<input type="text" class="eqLogicAttr form-control" data-l1key="labels" data-l2key="status-1"/>
                            </div>
                            <label class="col-sm-2 control-label">{{State 1 media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="status-1"/>
                            		<div class="input-group-btn bt_widget_info_status_1">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div>
                        </div>                        
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{Info identifier}}</label>
                            <div class="col-sm-10">
                      			<div class="input-group">
                      				<input class="eqLogicAttr form-control" data-l1key="statusId"/>
                      				<div class="input-group-btn bt_widget_info_statusid">
      									<a class="btn btn-default cursor" title="Choisir une commande"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>
                            </div>
                    	</div>
            		</fieldset>
           		</form>
                      
                <!-- ====================== -->
                <!-- Edit [Widget] / Action -->
                <!-- ====================== -->
                        
                <form class="form-horizontal widget widget-WidgetBinaryLightComponent">
                	<fieldset>
						<div class="form-group">
                           	<label class="col-sm-2 control-label">{{Top label}}</label>
                            <div class="col-sm-10">
                              	<input type="text" class="eqLogicAttr form-control" data-l1key="top"/>
                            </div>
                    	</div>
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{Bottom label}}</label>
                            <div class="col-sm-10">
                              	<input type="text" class="eqLogicAttr form-control" data-l1key="bottom"/>
                            </div>
                    	</div>
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{Loading label}}</label>
                            <div class="col-sm-4">
                              	<input type="text" class="eqLogicAttr form-control" data-l1key="labels" data-l2key="loading"/>
                            </div>
                      		<label class="col-sm-2 control-label">{{Loading media}}</label>
                            <div class="col-sm-4">                              	
                      			<div class="input-group Menu MenuLinkComponent">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="loading"/>
                            		<div class="input-group-btn bt_widget_action_loading">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>
                            </div>
						</div>
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{State 0 label}}</label>
                            <div class="col-sm-4">
                              	<input type="text" class="eqLogicAttr form-control" data-l1key="labels" data-l2key="status-0"/>
                            </div>
                      		<label class="col-sm-2 control-label">{{State 0 media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="status-0"/>
                            		<div class="input-group-btn bt_widget_action_status_0">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div>
                    	</div>
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{State 1 label}}</label>
                            <div class="col-sm-4">
                              	<input type="text" class="eqLogicAttr form-control" data-l1key="labels" data-l2key="status-1"/>
                            </div>
                            <label class="col-sm-2 control-label">{{State 1 media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="status-1"/>
                            		<div class="input-group-btn bt_widget_action_status_1">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div>
                        </div>                        
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{Info identifier}}</label>
                            <div class="col-sm-10">
                      			<div class="input-group">
                      				<input class="eqLogicAttr form-control" data-l1key="statusId"/>
                      				<div class="input-group-btn bt_widget_action_statusid">
      									<a class="btn btn-default cursor" title="Choisir une commande"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>
                            </div>
                    	</div>
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{Action 0 identifier}}</label>
                            <div class="col-sm-4">
                              	<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="offId"/>
                            		<div class="input-group-btn bt_widget_action_offId">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>  
                            </div>
                      		<label class="col-sm-2 control-label">{{Action 0 media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="action-0"/>
                            		<div class="input-group-btn bt_widget_action_action_0">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div>
                    	</div>
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{Action 1 identifier}}</label>
                            <div class="col-sm-4">
                              	<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="onId"/>
                            		<div class="input-group-btn bt_widget_action_onId">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>  
                            </div>
                            <label class="col-sm-2 control-label">{{Action 1 media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="action-1"/>
                            		<div class="input-group-btn bt_widget_action_action_1">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div>
                        </div>
            		</fieldset>
           		</form>
                      
                <!-- ====================== -->
                <!-- Edit [Widget] / Roller -->
                <!-- ====================== -->
                        
                <form class="form-horizontal widget widget-WidgetRollerComponent">
                	<fieldset>
						<div class="form-group">
                           	<label class="col-sm-2 control-label">{{Top label}}</label>
                            <div class="col-sm-10">
                              	<input type="text" class="eqLogicAttr form-control" data-l1key="top"/>
                            </div>
                    	</div>
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{Bottom label}}</label>
                            <div class="col-sm-10">
                              	<input type="text" class="eqLogicAttr form-control" data-l1key="bottom"/>
                            </div>
                    	</div>
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{Loading label}}</label>
                            <div class="col-sm-4">
                              	<input type="text" class="eqLogicAttr form-control" data-l1key="labels" data-l2key="loading"/>
                            </div>
                      		<label class="col-sm-2 control-label">{{Loading media}}</label>
                            <div class="col-sm-4">                              	
                      			<div class="input-group Menu MenuLinkComponent">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="loading"/>
                            		<div class="input-group-btn bt_widget_roller_loading">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>
                            </div>
						</div>
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{State 0 label}}</label>
                            <div class="col-sm-4">
                              	<input type="text" class="eqLogicAttr form-control" data-l1key="labels" data-l2key="status-0"/>
                            </div>
                      		<label class="col-sm-2 control-label">{{State 0 media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="status-0"/>
                            		<div class="input-group-btn bt_widget_roller_status_0">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div>
                    	</div>
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{State 20 label}}</label>
                            <div class="col-sm-4">
                              	<input type="text" class="eqLogicAttr form-control" data-l1key="labels" data-l2key="status-20"/>
                            </div>
                            <label class="col-sm-2 control-label">{{State 20 media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="status-20"/>
                            		<div class="input-group-btn bt_widget_roller_status_20">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div>
                        </div>                        
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{State 40 label}}</label>
                            <div class="col-sm-4">
                              	<input type="text" class="eqLogicAttr form-control" data-l1key="labels" data-l2key="status-40"/>
                            </div>
                            <label class="col-sm-2 control-label">{{State 40 media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="status-40"/>
                            		<div class="input-group-btn bt_widget_roller_status_40">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div>
                        </div>                        
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{State 60 label}}</label>
                            <div class="col-sm-4">
                              	<input type="text" class="eqLogicAttr form-control" data-l1key="labels" data-l2key="status-60"/>
                            </div>
                            <label class="col-sm-2 control-label">{{State 60 media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="status-60"/>
                            		<div class="input-group-btn bt_widget_roller_status_60">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div>
                        </div>                        
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{State 80 label}}</label>
                            <div class="col-sm-4">
                              	<input type="text" class="eqLogicAttr form-control" data-l1key="labels" data-l2key="status-80"/>
                            </div>
                            <label class="col-sm-2 control-label">{{State 80 media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="status-80"/>
                            		<div class="input-group-btn bt_widget_roller_status_80">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div>
                        </div>                        
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{State 100 label}}</label>
                            <div class="col-sm-4">
                              	<input type="text" class="eqLogicAttr form-control" data-l1key="labels" data-l2key="status-100"/>
                            </div>
                            <label class="col-sm-2 control-label">{{State 100 media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="status-100"/>
                            		<div class="input-group-btn bt_widget_roller_status_100">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div>
                        </div>                        
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{Info identifier}}</label>
                            <div class="col-sm-10">
                      			<div class="input-group">
                      				<input class="eqLogicAttr form-control" data-l1key="statusId"/>
                      				<div class="input-group-btn bt_widget_roller_statusid">
      									<a class="btn btn-default cursor" title="Choisir une commande"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>
                            </div>
                    	</div>
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{Slider identifier}}</label>
                            <div class="col-sm-10">
                      			<div class="input-group">
                      				<input class="eqLogicAttr form-control" data-l1key="sliderId"/>
                      				<div class="input-group-btn bt_widget_roller_sliderid">
      									<a class="btn btn-default cursor" title="Choisir une commande"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>
                            </div>
                    	</div>
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{Up identifier}}</label>
                            <div class="col-sm-4">
                              	<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="upId"/>
                            		<div class="input-group-btn bt_widget_roller_upId">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>  
                            </div>
                      		<label class="col-sm-2 control-label">{{Up media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="action-up"/>
                            		<div class="input-group-btn bt_widget_roller_up">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div>
                    	</div>
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{Stop identifier}}</label>
                            <div class="col-sm-4">
                              	<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="stopId"/>
                            		<div class="input-group-btn bt_widget_roller_stopId">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>  
                            </div>
                            <label class="col-sm-2 control-label">{{Stop media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="action-stop"/>
                            		<div class="input-group-btn bt_widget_roller_stop">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div>
                        </div>  
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{Down identifier}}</label>
                            <div class="col-sm-4">
                              	<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="downId"/>
                            		<div class="input-group-btn bt_widget_roller_downId">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>  
                            </div>
                            <label class="col-sm-2 control-label">{{Down media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="action-down"/>
                            		<div class="input-group-btn bt_widget_roller_down">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div>
                        </div> 
            		</fieldset>
           		</form>
                      
                <!-- ====================== -->
                <!-- Edit [Widget] / Slider -->
                <!-- ====================== -->
                        
                <form class="form-horizontal widget widget-WidgetSliderLightComponent">
                	<fieldset>
						<div class="form-group">
                           	<label class="col-sm-2 control-label">{{Top label}}</label>
                            <div class="col-sm-10">
                              	<input type="text" class="eqLogicAttr form-control" data-l1key="top"/>
                            </div>
                    	</div>
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{Bottom label}}</label>
                            <div class="col-sm-10">
                              	<input type="text" class="eqLogicAttr form-control" data-l1key="bottom"/>
                            </div>
                    	</div>
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{Loading label}}</label>
                            <div class="col-sm-4">
                              	<input type="text" class="eqLogicAttr form-control" data-l1key="labels" data-l2key="loading"/>
                            </div>
                      		<label class="col-sm-2 control-label">{{Loading media}}</label>
                            <div class="col-sm-4">                              	
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="loading"/>
                            		<div class="input-group-btn bt_widget_slider_loading">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>
                            </div>
						</div>
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{State 0 label}}</label>
                            <div class="col-sm-4">
                              	<input type="text" class="eqLogicAttr form-control" data-l1key="labels" data-l2key="status-0"/>
                            </div>
                      		<label class="col-sm-2 control-label">{{State 0 media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="status-0"/>
                            		<div class="input-group-btn bt_widget_slider_status_0">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div>
                    	</div>
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{State 20 label}}</label>
                            <div class="col-sm-4">
                              	<input type="text" class="eqLogicAttr form-control" data-l1key="labels" data-l2key="status-20"/>
                            </div>
                            <label class="col-sm-2 control-label">{{State 20 media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="status-20"/>
                            		<div class="input-group-btn bt_widget_slider_status_20">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div>
                        </div>                        
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{State 40 label}}</label>
                            <div class="col-sm-4">
                              	<input type="text" class="eqLogicAttr form-control" data-l1key="labels" data-l2key="status-40"/>
                            </div>
                            <label class="col-sm-2 control-label">{{State 40 media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="status-40"/>
                            		<div class="input-group-btn bt_widget_slider_status_40">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div>
                        </div>                        
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{State 60 label}}</label>
                            <div class="col-sm-4">
                              	<input type="text" class="eqLogicAttr form-control" data-l1key="labels" data-l2key="status-60"/>
                            </div>
                            <label class="col-sm-2 control-label">{{State 60 media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="status-60"/>
                            		<div class="input-group-btn bt_widget_slider_status_60">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div>
                        </div>                        
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{State 80 label}}</label>
                            <div class="col-sm-4">
                              	<input type="text" class="eqLogicAttr form-control" data-l1key="labels" data-l2key="status-80"/>
                            </div>
                            <label class="col-sm-2 control-label">{{State 80 media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="status-80"/>
                            		<div class="input-group-btn bt_widget_slider_status_80">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div>
                        </div>                        
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{State 100 label}}</label>
                            <div class="col-sm-4">
                              	<input type="text" class="eqLogicAttr form-control" data-l1key="labels" data-l2key="status-100"/>
                            </div>
                            <label class="col-sm-2 control-label">{{State 100 media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="status-100"/>
                            		<div class="input-group-btn bt_widget_slider_status_100">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div>
                        </div>                        
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{Info identifier}}</label>
                            <div class="col-sm-10">
                      			<div class="input-group">
                      				<input class="eqLogicAttr form-control" data-l1key="statusId"/>
                      				<div class="input-group-btn bt_widget_slider_statusid">
      									<a class="btn btn-default cursor" title="Choisir une commande"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>
                            </div>
                    	</div>
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{Slider identifier}}</label>
                            <div class="col-sm-10">
                      			<div class="input-group">
                      				<input class="eqLogicAttr form-control" data-l1key="sliderId"/>
                      				<div class="input-group-btn bt_widget_slider_sliderid">
      									<a class="btn btn-default cursor" title="Choisir une commande"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>
                            </div>
                    	</div>
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{On identifier}}</label>
                            <div class="col-sm-4">
                              	<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="onId"/>
                            		<div class="input-group-btn bt_widget_slider_onId">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>  
                            </div>
                      		<label class="col-sm-2 control-label">{{On media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="action-on"/>
                            		<div class="input-group-btn bt_widget_slider_on">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div>
                    	</div>
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{Off identifier}}</label>
                            <div class="col-sm-4">
                              	<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="offId"/>
                            		<div class="input-group-btn bt_widget_slider_offId">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>  
                            </div>
                            <label class="col-sm-2 control-label">{{Off media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="action-off"/>
                            		<div class="input-group-btn bt_widget_slider_off">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div>
                        </div> 
            		</fieldset>
           		</form>

                <!-- ====================== -->
                <!-- Edit [Widget] / Alarm -->
                <!-- ====================== -->
                        
                <form class="form-horizontal widget widget-WidgetAlarmComponent">
                	<fieldset>
						<div class="form-group">
                           	<label class="col-sm-2 control-label">{{Top label}}</label>
                            <div class="col-sm-10">
                              	<input type="text" class="eqLogicAttr form-control" data-l1key="top"/>
                            </div>
                    	</div>
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{Bottom label}}</label>
                            <div class="col-sm-10">
                              	<input type="text" class="eqLogicAttr form-control" data-l1key="bottom"/>
                            </div>
                    	</div>
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{Code à 4 chiffres}}</label>
                            <div class="col-sm-10">
                              	<input type="text" class="eqLogicAttr form-control" data-l1key="code"/>
                            </div>
                    	</div>
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{Info identifier}}</label>
                            <div class="col-sm-10">
                      			<div class="input-group">
                      				<input class="eqLogicAttr form-control" data-l1key="statusId"/>
                      				<div class="input-group-btn bt_widget_alarm_statusid">
      									<a class="btn btn-default cursor" title="Choisir une commande"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>
                            </div>
                    	</div>
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{Action off identifier}}</label>
                            <div class="col-sm-4">
                              	<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="offId"/>
                            		<div class="input-group-btn bt_widget_alarm_offId">
      									<a class="btn btn-default cursor" title="Choisir une commande"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>  
                            </div>
                      		<label class="col-sm-2 control-label">{{Action on media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="offId"/>
                            		<div class="input-group-btn bt_widget_alarm_onId">
      									<a class="btn btn-default cursor" title="Choisir une commande"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div>
                    	</div>                        
                      	<div class="form-group">
                           	<label class="col-sm-2 control-label">{{Validate media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="bouton-validate"/>
                            		<div class="input-group-btn bt_widget_alarm_bouton_validate">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div><label class="col-sm-2 control-label">{{Cancel media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="bouton-cancel"/>
                            		<div class="input-group-btn bt_widget_alarm_bouton_cancel">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div>
                        </div>                       
						<div class="form-group">
                           	<label class="col-sm-2 control-label">{{Success on media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="success-on"/>
                            		<div class="input-group-btn bt_widget_alarm_success_on">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div><label class="col-sm-2 control-label">{{Success off media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="success-off"/>
                            		<div class="input-group-btn bt_widget_alarm_success_off">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div>
                        </div>                       
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{Button 0 media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="bouton-0"/>
                            		<div class="input-group-btn bt_widget_alarm_bouton_0">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div><label class="col-sm-2 control-label">{{Button 1 media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="bouton-1"/>
                            		<div class="input-group-btn bt_widget_alarm_bouton_1">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div>
                        </div>  
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{Button 2 media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="bouton-2"/>
                            		<div class="input-group-btn bt_widget_alarm_bouton_2">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div><label class="col-sm-2 control-label">{{Button 3 media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="bouton-3"/>
                            		<div class="input-group-btn bt_widget_alarm_bouton_3">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div>
                        </div> 
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{Button 4 media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="bouton-4"/>
                            		<div class="input-group-btn bt_widget_alarm_bouton_4">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div><label class="col-sm-2 control-label">{{Button 5 media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="bouton-5"/>
                            		<div class="input-group-btn bt_widget_alarm_bouton_5">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div>
                        </div>  
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{Button 6 media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="bouton-6"/>
                            		<div class="input-group-btn bt_widget_alarm_bouton_6">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div><label class="col-sm-2 control-label">{{Button 7 media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="bouton-7"/>
                            		<div class="input-group-btn bt_widget_alarm_bouton_7">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div>
                        </div>  
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{Button 8 media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="bouton-8"/>
                            		<div class="input-group-btn bt_widget_alarm_bouton_8">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div>
                      		<label class="col-sm-2 control-label">{{Button 9 media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="bouton-9"/>
                            		<div class="input-group-btn bt_widget_alarm_bouton_9">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div>
                        </div>  
                        <div class="form-group">
                           	<label class="col-sm-2 control-label">{{Error media}}</label>
                            <div class="col-sm-4">
                      			<div class="input-group">  
                      				<input type="text" class="eqLogicAttr form-control" data-l1key="icons" data-l2key="error"/>
                            		<div class="input-group-btn bt_widget_alarm_error">
      									<a class="btn btn-default cursor" title="Choisir une image"><i class="fa fa fa-ellipsis-h"></i></a>
    								</div>
                      			</div>                              	
                            </div>
                        </div>  
            		</fieldset>
           		</form>
                      
            </div>
            
            <!-- ===================== -->
  			<!-- == Display [Media] == -->
  			<!-- ===================== -->
  
  			<div role="tabpanel" class="tab-pane" id="media_tab">  
               <legend>
                	<i class="fa fa-picture-o"></i> {{Medias}} 			
					<a id="bt_media_refresh" class="btn btn-info btn-sm pull-right" style="color : white; z-index:255"><i class="fa fa-2x fa-refresh"></i></a>
					<a id="bt_media_add" class="btn btn-success btn-sm pull-right" style="color : white; z-index:255"><i class="fa fa-2x fa-plus-circle"></i></a>
                    <input id="filter_media" class="pull-right form-control input-sm" placeholder="Rechercher" style="width: 100px">
				</legend>
                <input style="display: none; visibility: hidden" id="bt_media_select" type="file" name="filename" data-url="plugins/wall/core/ajax/media.ajax.php?action=ajax_media_add">
                <div class="media_container">
                </div>
    		</div>   
  			
  		<!-- ================= -->
  		<!-- == End display == -->
  		<!-- ================= -->
  
  		</div>
  
    <!-- ======================== -->
    <!-- == End principal zone == -->
    <!-- ======================== -->
   
    </div>
  
<!-- ========================== -->
<!-- == End global container == -->
<!-- ========================== -->
  
</div>

<!-- =============== -->
<!-- == Plugin js == -->
<!-- =============== -->

<?php
  
include_file('core', 'plugin.template', 'js');
include_file('desktop', 'wall', 'js', 'wall');  
include_file('desktop', 'dashboard', 'js', 'wall');
include_file('desktop', 'page', 'js', 'wall');
include_file('desktop', 'widget', 'js', 'wall');
include_file('desktop', 'media', 'js', 'wall');
    
?>
<script>
  
fn_dashboard_refresh();
fn_page_refresh();
fn_widget_refresh()
fn_media_refresh();
  
</script>
  