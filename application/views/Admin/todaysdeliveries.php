<div id="content" ng-app="myApp" ng-controller="ecomCtrl">
  <div id="content-header">
    <div id="breadcrumb"> <a href="<?PHP echo base_url('admin-dashboard')?>" title="Go to dashboard" class="tip-bottom"><i class="icon-home"></i> Dashboard</a> <a href="<?PHP echo base_url('admin-view-orders');?>">Manage orders</a>
<a  class="current"> Orders by products </a> </div>
    
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">

        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            
          <h5>View today's delivery orders</h5>   
         
         
           </div>  
          </div>
          <div class="widget-content nopadding"  ng-init="getAllorderstobedelivered()">

            <div ng-if="todaydelivered_orders.nodata=='yes'" ng-cloak style="margin-top:20px; margin-bottom:10px; width:97%">         <!-- If results yields  no data starts here-->        
            	<div class="alert alert-danger"> <h2> No orders to be deliver today</h2></div>
             </div>
             
            <div ng-if="todaydelivered_orders.nodata==undefined">
            
            <table class="table table-bordered table-striped" ng-cloak>
              <thead>
                <tr>
                  <th> SLNO</th>
                  <th ng-click="sort('Owner_Name')" class="anchor_feel">Store Name <i class="fa fa-chevron-up" aria-hidden="true" ng-show="sortKey=='Owner_Name'" ng-class="{'fa fa-chevron-up':reverse,'fa fa-chevron-down':!reverse}"></i> <!--<span class="fa fa-chevron-up" ng-show="sortKey=='USERNAME'" ng-class="{'fa fa-chevron-up':reverse,'fa fa-chevron-down':!reverse}"></span>-->
<!--                  <i class="fa fa-chevron-up" aria-hidden="true"></i>-->
                  </th>
                 
                  <th>OrderId</th>
             
                  <th>Order Status</th>                  
                <!--  <th>Quantity</th> -->
                  <th>Order Price</th>
	              <th>Ordered On</th>
                   <th>Scheduled At</th>
                  <th>Actions</th>
                  
                </tr>
              </thead>
              
              <tbody>
                           
                            
                <tr  dir-paginate="order in todaydelivered_orders |orderBy:sortKey:reverse |itemsPerPage:10" ng-cloak >
                        <td todate="order.todate">{{order.SLNO}} </td>
                    
                       <td>{{order.Owner_Name}}</td>
                    
                   
                    <td>{{order.OrderId}}</td>
                        <td>{{order.OrderStatus}}</td>
                        <!--<td>{{order.TotalProducts}}</td>-->
                        <td>Rs.{{order.Total_Amount}}/-</td>
                        <td>{{order.OrderedOn}}</td>
                         <td>{{order.scheduledAt }}</td>
                        <td>

                        <a href="<?PHP echo base_url('admin-view-order/')?>{{order.OrderId}}" class="btn btn-sm btn-primary">View </a>
                       
                        </td>
                </tr>
                
                <tr ng-if="todaydelivered_orders.length>0">
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
