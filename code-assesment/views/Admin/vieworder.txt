<div id="content" ng-app="myApp" ng-controller="ecomCtrl" >
  <div id="content-header">
    <div id="breadcrumb"> <a href="<?PHP echo base_url('admin-dashboard')?>" title="Go to dashboard" class="tip-bottom"><i class="icon-home"></i> Dashboard</a> <a href="<?PHP echo base_url('admin-view-orders');?>">View orders by stores</a>
   
       <a class="current">View Ordered Products </a> 
       
       </div>
    
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <?PHP echo $this->session->flashdata('user_franchise_added');?>
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>View Products in order</h5>
             
             <button type="button" class="btn btn-warning pull-right"  style="margin-top:2px; margin-right:5px" ng-click="download_orderd_product_excelsheet('<?PHP echo $this->uri->segment(2);?>')"> <i class="fa fa-download" aria-hidden="true"></i> Excel</button>
               
           
          </div>
          <div class="widget-content nopadding" ng-init="getAllproductsperorder('<?PHP echo $this->uri->segment(2);?>')">
           
            <div ng-if="Allproductsperorder.invalidOrder=='yes'" ng-cloak style="margin-top:20px; margin-bottom:10px; width:97%">         <!-- If results yields  no data starts here-->        
            	<div class="alert alert-danger"> 
                    		<h2 >Invalid order number</h2>

                        
                       
                        
                </div>
                
                
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
                <td colspan="2"> </td>
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
