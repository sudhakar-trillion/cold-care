<div id="content" ng-app="myApp">
  <div id="content-header">
    <div id="breadcrumb"> <a href="<?PHP echo base_url('admin-dashboard')?>" title="Go to dashboard" class="tip-bottom"><i class="icon-home"></i> Dashboard</a> <a href="<?PHP echo base_url('admin-view-orders');?>">View orders</a>
   
       <a class="current">Change Ordered Status</a> 
       
       </div>
    
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <?PHP echo $this->session->flashdata('ChangeOrder_status');?>
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>View Products in order</h5>
           
          </div>
          <div class="widget-content nopadding" ng-controller="ecomCtrl" ng-init="getAllproductsperorder('<?PHP echo $this->uri->segment(2);?>')">
           
            <div ng-if="Allproductsperorder.invalidOrder=='yes'" ng-cloak style="margin-top:20px; margin-bottom:10px; width:97%">         <!-- If results yields  no data starts here-->        
            	<div class="alert alert-danger"> <h2>Invalid order number</h2></div>
             </div>
             
            <div ng-if="Allproductsperorder.invalidOrder==undefined">
            
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th> SLNO</th>
                  <th ng-click="sort('Owner_Name')" class="anchor_feel">OrderId<i class="fa fa-chevron-up" aria-hidden="true" ng-show="sortKey=='Owner_Name'" ng-class="{'fa fa-chevron-up':reverse,'fa fa-chevron-down':!reverse}"></i> <!--<span class="fa fa-chevron-up" ng-show="sortKey=='USERNAME'" ng-class="{'fa fa-chevron-up':reverse,'fa fa-chevron-down':!reverse}"></span>-->
<!--                  <i class="fa fa-chevron-up" aria-hidden="true"></i>-->
                  </th>
                  <th>Product Name</th>
             		<th>GrossWeight</th>
                  <th>Quantity</th>
                  <th>Price</th>                  
                  <th>Status</th>
	              <th>Ordered On</th>
                 
                  
                </tr>
              </thead>
              
              <tbody>
                           
                            
                <tr  dir-paginate="order in Allproductsperorder |orderBy:sortKey:reverse |filter:search |itemsPerPage:10" ng-cloak >
                        <td>{{order.SLNO}} </td>
                    <td>{{order.OrderId}}</td>
                       <td>{{order.ProductName}}</td>
                      	<td>{{order.GrossWeight}}-{{order.MeasurementUnit}} </td>
                        <td>{{order.quantity}} </td>
                        <td> Rs. {{order.ProductPrice}}</td>
                        <td><b>{{order.Status}}</b></td>
                        <td>{{order.orderedOn}} </td>
                       
                       
                </tr>
                <tr>
                <td colspan="4"> </td>
                <td ><strong>Grand total</strong> </td>
                <td ng-cloak><b>Rs. {{TotalAmount}}</b></td>
                <td ng-cloak ng-show="showstatus">
               <strong>Order Id#</strong> <input type="text" id="orderId" ng-model="orderID" disabled="disabled" style="width:50px" />
               
             <div class="" ng-if="disp_not">
             <div class="col-md-3" style="padding:0px"><strong>Scheduled On</strong></div>
            <div class="col-md-9">
                <p class="input-group">
                  <input type="text" id="scheduledOn" class="form-control" placeholder='<?PHP echo date('d-m-Y');?>' uib-datepicker-popup="{{format}}" ng-model="dt" is-open="popup1.opened" datepicker-options="dateOptions" ng-required="true" close-text="Close" alt-input-formats="altInputFormats" />
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-default" ng-click="open1()"><i class="glyphicon glyphicon-calendar"></i></button>
                  </span>
                </p>
                </div>
                
               <div class='clearfix'> </div> 
              </div>
              
              <div ng-if="disp_not">
              
              <div class="col-md-3" style="padding:0px; margin-top: 39px;"><strong>Scheduled At</strong></div>
                <div class="col-md-9">
               
               <!--<div uib-timepicker ng-model="mytime" ng-change="changed()" hour-step="hstep" minute-step="mstep" show-meridian="ismeridian"></div>-->
                
                	<div class="time_colm_group">
                    	<div class="time_dec">
                        	<span class="glyphicon glyphicon-chevron-up  inc_dec" inc="yes" incby="hrs"></span>
                        </div>
                        
                        <div class="time_colm">
                        	<input type="text" class="form-control" id="hrs" readonly value="<?PHP echo "11";?>" />
                        </div>
                        
                        <div class="time_inc">
                        	<span class="glyphicon glyphicon-chevron-down  inc_dec" inc="no" incby="hrs"></span>
                        </div>
                    </div>
                    
                    <div class="time_colm_group">
                    	<div class="time_dec">
                        	<span class="glyphicon glyphicon-chevron-up inc_dec" inc="yes" incby="mins"></span>
                        </div>
                        
                        <div class="time_colm">
                        	<input type="text" class="form-control" id="mins" readonly value="<?PHP echo date("i");?>" />
                        </div>
                        
                        <div class="time_inc">
                        	<span class="glyphicon glyphicon-chevron-down inc_dec" inc="no" incby="mins"></span>
                        </div>
                    </div>
                    
                    <div class="time_colm_group">
                    	<div class="time_dec">
                        	<span class="glyphicon glyphicon-chevron-up am_pm" ampm="AM"> </span>
                        </div>
                        
                        <div class="time_colm">
                        <span class="meridian" >AM</span>  
                        </div>
                        
                        <div class="time_inc">
                        	<span class="glyphicon glyphicon-chevron-down am_pm" ampm="PM"></span>
                        </div>
                    </div>
                
                </div>
              
              </div>
               <div class='clearfix'></div>
                        <select ng-model="selectedItem" id="changeOrderStatus" class="form-control" style="margin-top:10px">
                        <option ng-repeat="item in orderstatus" value="{{item}}">{{item}}</option>
                        </select>
                        
<textarea name="reasontocancel" id="reasontocancel" placeholder="Reason to cancel order" style="display:none" class="form-control"></textarea>
                        
                        <input type="button" class="btn btn-block btn-primary" id="changestatusbtn" value="Change status" />
                        
                        <div class="form-group">
                   <div class="select_ajax_load"></div>
                   </div>
                
                 </td>
                 <td>
                 </td>
                </tr>
                
                
                <tr ng-if="Allproductsperorder.length>0">
                	<td colspan="10" >
                		 <dir-pagination-controls direction-links="true" boundary-links="true" > </dir-pagination-controls>
                    </td>
                </tr>
                                
                                
                            </tbody>
              
              
            </table>
		</div>
          </div>
        </div>
       
        
        
      </div>
          </div>
        </div>
      </div>
    </div>
    
    
  </div>
</div>
<!-- modal popup starts here -->            
            <div id="view_user" class="modal fade modified-popup" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">View user</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- modal popup ends here -->
