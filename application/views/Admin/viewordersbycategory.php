<div id="content" ng-app="myApp" ng-controller="ecomCtrl">
  <div id="content-header">
    <div id="breadcrumb"> <a href="<?PHP echo base_url('admin-dashboard')?>" title="Go to dashboard" class="tip-bottom"><i class="icon-home"></i> Dashboard</a> <a href="<?PHP echo base_url('admin-view-orders');?>">Manage orders</a>
<a  class="current"> Orders by categories </a> </div>
    
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <?PHP echo $this->session->flashdata('user_franchise_added');?>
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <div class="col-sm-10 filter-input-colms row">
            <div class="col-md-2">
             <h5>View all orders</h5>
            </div>
            <div class="col-md-2"  ng-init="categories()">
          <!--  <input type="text" placeholder="Store name" class="form-control" ng-model="srch.Owner_Name"> -->
 
         <select data-ng-options="c.Category_Name for c in categ" class="form-control" data-ng-model="srch.Category"></select>
          
          
            </div>
            <div class="col-md-2">
            <input type="text" placeholder="Order id" class="form-control" ng-model="srch.OrderId">
            </div>
            <div class="col-md-2">
            <input type="text" placeholder="Order status" class="form-control" ng-model="srch.OrderStatus">
            </div>
             <div class="col-md-2">
                <p class="input-group">
                  <input type="text" class="form-control" placeholder='From date' uib-datepicker-popup="{{format}}" ng-model="srch.OrderedOn" is-open="popup1.opened" datepicker-options="dateOptions" ng-required="true" close-text="Close" alt-input-formats="altInputFormats" />
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-default" ng-click="open1()"><i class="glyphicon glyphicon-calendar"></i></button>
                  </span>
                </p>
              </div>
      
               <div class="col-md-2">
                <p class="input-group">
                  <input type="text" class="form-control" placeholder='To date' uib-datepicker-popup="{{format}}" ng-model="srch.todate" is-open="popup2.opened" datepicker-options="dateOptions" ng-required="true" close-text="Close" alt-input-formats="altInputFormats" />
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-default" ng-click="open2()"><i class="glyphicon glyphicon-calendar"></i></button>
                  </span>
                </p>
              </div>
            </div>
           <!-- <input type="text" placeholder="To date" class="form-control" style="width:10%; margin-top:3px" id="" ng-model="srch.todate" >-->
           <div class="col-md-2 btns-filters">

             <button type="button" class="btn btn-success" ng-click="getordersbyfilter()">Search</button>
             <button type="submit" class="btn btn-warning" ng-click="download_orders_by_excelsheet()"><i class="fa fa-download" aria-hidden="true"></i> Excel</button> 
             

           <!--  <a href="<?PHP echo base_url('Requestdispatcher/download_orders_by_excelsheet');?>" class="btn btn-warning" style="width:50%; text-align:left"><i class="fa fa-download" aria-hidden="true"></i> Excel</a>
           -->

                   <div ng-show="loader" ng-cloak style="position: absolute; top: 5px; left: 48%; width: 25px;">  <img src="resources/site/img/loading2.gif"></div>
            <!--
            &nbsp;
             <input type="button" class="btn btn-primary" value="Export" />
           -->
           
           </div>
             <!--<input type="text" placeholder="Store name" class="form-control" style="width:10%; margin-top:3px">
            <input type="text" placeholder="Order id" class="form-control" style="width:10%; margin-top:3px" >
            <input type="text" placeholder="Order status" class="form-control" style="width:10%; margin-top:3px">
            <input type="text" placeholder="From date" class="form-control" style="width:10%; margin-top:3px"  >
            <input type="text" placeholder="To date" class="form-control" style="width:10%; margin-top:3px" >
            
            <input type="button" class="btn btn-success" style="margin-top:-7px" value="Search" ng-click="getordersbyfilter()"/>
            &nbsp;
             <input type="button" class="btn btn-primary" style="margin-top:-7px" value="Export" />
             
             -->
           </div>  
          </div>
          <div class="widget-content nopadding"  ng-init="getAllorders()">
            
            <div ng-if="listorders.nodata=='yes'" ng-cloak style="margin-top:20px; margin-bottom:10px; width:97%">         <!-- If results yields  no data starts here-->        
            	<div class="alert alert-danger"> <h2> No orders placed yet</h2></div>
             </div>
             
            <div ng-if="listorders.nodata==undefined">
            
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th> SLNO</th>
                  <th ng-click="sort('Owner_Name')" class="anchor_feel">Store Name <i class="fa fa-chevron-up" aria-hidden="true" ng-show="sortKey=='Owner_Name'" ng-class="{'fa fa-chevron-up':reverse,'fa fa-chevron-down':!reverse}"></i> <!--<span class="fa fa-chevron-up" ng-show="sortKey=='USERNAME'" ng-class="{'fa fa-chevron-up':reverse,'fa fa-chevron-down':!reverse}"></span>-->
<!--                  <i class="fa fa-chevron-up" aria-hidden="true"></i>-->
                  </th>
                  <th>Category</th>
                 
                  <th>OrderId</th>
             
                  <th>Order Status</th>                  
                <!--  <th>Quantity</th> -->
                  <th>Order Price</th>
	              <th>Ordered On</th>
                  <th>Actions</th>
                  
                </tr>
              </thead>
              
              <tbody>
                           
                            
                <tr  dir-paginate="order in listorders |orderBy:sortKey:reverse |itemsPerPage:10" ng-cloak >
                        <td todate="order.todate">{{order.SLNO}} </td>
                    
                       <td>{{order.Owner_Name}}</td>
                       <td>{{order.Category}} </td>
                   
                    <td>{{order.OrderId}}</td>
                        <td>{{order.OrderStatus}}</td>
                        <!--<td>{{order.TotalProducts}}</td>-->
                        <td>Rs.{{order.Total_Amount}}/-</td>
                        <td>{{order.OrderedOn}}</td>
                        <td>

                        <a href="<?PHP echo base_url('admin-view-order/')?>{{order.OrderId}}" class="btn btn-sm btn-primary">View </a>
                        &nbsp;&nbsp;
                         <a href="<?PHP echo base_url('admin-change-order-status/')?>{{order.OrderId}}" class="btn btn-sm btn-success">Change Status</a>
                      <!--  <span class="anchor_feel btn btn-sm btn-danger delete_Franchiseuser" id="{{users.UserId}}" >Delete</a>-->
                        </td>
                </tr>
                
                <tr ng-if="listorders.length>0">
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
