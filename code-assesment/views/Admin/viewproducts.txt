<div id="content" ng-app="myApp">
  <div id="content-header">
    <div id="breadcrumb"> <a href="<?PHP echo base_url('admin-dashboard')?>" title="Go to dashboard" class="tip-bottom"><i class="icon-home"></i> Dashboard</a> <a href="#">Manage Products</a>
        <a href="<?PHP echo base_url('admin-add-product'); ?>">Add Product</a><a  class="current">View Products</a> </div>
    
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <?PHP echo $this->session->flashdata('add_product_status');?>
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>View products by</h5>
          <div >
            <input type="text" placeholder="Brand" class="form-control" style="width:10%; margin-top:3px" ng-model="search.BrandName">
            <input type="text" placeholder="Category" class="form-control" style="width:10%; margin-top:3px"  ng-model="search.Category_Name">
             <input type="text" placeholder="Sub-Category" class="form-control" style="width:10%; margin-top:3px"  ng-model="search.SubCategory">
              <input type="text" placeholder="Product" class="form-control" style="width:10%; margin-top:3px"  ng-model="search.ProductName">
               <input type="text" placeholder="Status" class="form-control" style="width:10%; margin-top:3px"  ng-model="search.Status">
           </div>  
             
          </div>
          <div class="widget-content nopadding" ng-controller="ecomCtrl" ng-init="getProducts_listing()">
            
            <div ng-if="listProducts.nodata=='yes'" ng-cloak style="margin-top:20px; margin-bottom:10px; width:97%">         <!-- If results yields  no data starts here-->        
            	<div class="alert alert-danger"> <h2> No product added yet</h2></div>
             </div>
             
            <div ng-if="listProducts.nodata==undefined">
            
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th> SLNO</th>
                  <th ng-click="sort('ProductName')" class="anchor_feel">Product Name<i class="fa fa-chevron-up" aria-hidden="true" ng-show="sortKey=='ProductName'" ng-class="{'fa fa-chevron-up':reverse,'fa fa-chevron-down':!reverse}"></i> <!--<span class="fa fa-chevron-up" ng-show="sortKey=='USERNAME'" ng-class="{'fa fa-chevron-up':reverse,'fa fa-chevron-down':!reverse}"></span>-->
<!--                  <i class="fa fa-chevron-up" aria-hidden="true"></i>-->
                  </th>
                 
                  <th>Brand</th>
                  <th>Category</th>
                   <th>Sub Category</th>
                   <th>Status</th>
                   <!--
                 <th>Price</th>
                   <th>Netweight</th>
                   <th>Quantity</th>
                   -->
                   <th>Added by </th>
                  <th>Actions</th>
                  
                </tr>
              </thead>
              
              <tbody>
                           
                            
                <tr  dir-paginate="prdcts in listProducts |orderBy:sortKey:reverse |filter:search |itemsPerPage:10" ng-cloak >
                        <td>{{prdcts.SLNO}} </td>
                        <td>{{prdcts.ProductName | capitalize }}</td>
                        <td>{{prdcts.BrandName}}</td>
                        <td>{{prdcts.Category_Name}}</td>
                        <td>{{prdcts.SubCategory | capitalize }}</td>
                          <td>{{prdcts.Status | capitalize }}</td>
                           <td>{{prdcts.Addedby | capitalize }}</td>
                        <!--
                        <td>{{prdcts.ProductPrice}}</td>
                        <td>{{prdcts.NetWeight}}-{{prdcts.MeasurementUnit}}</td>
                        <td>{{prdcts.Qty}}</td>
                        -->
                       
                        <td>
                        <a href="<?PHP echo base_url('admin-edit-product/')?>{{prdcts.ProductId}}" class="btn btn-sm btn-primary">View/Edit</a>
                      <!--  <span class="anchor_feel btn btn-sm btn-danger delete_Franchiseuser" id="{{users.UserId}}" >Delete</a>-->
                        </td>
                </tr>
                
                <tr ng-if="listProducts.length>0">
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
