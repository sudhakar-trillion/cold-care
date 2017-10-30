<div id="content" ng-app="myApp">
  <div id="content-header">
    <div id="breadcrumb"> <a href="<?PHP echo base_url('admin-dashboard')?>" title="Go to dashboard" class="tip-bottom"><i class="icon-home"></i> Dashboard</a> <a class="anchor_feel">Manage categories</a> <a href="<?PHP echo base_url('admin-add-category');?>">Add category</a>   <a href="#" class="current">View categories</a> </div>
    
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <?PHP echo $this->session->flashdata('category-add-status');?>
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>View Categories</h5>
          </div>
          <div class="widget-content nopadding" ng-controller="ecomCtrl" ng-init="getcategories()">
            
            <div ng-if="list_Categories.nodata=='yes'" ng-cloak style="margin-top:20px; margin-bottom:10px; width:97%">         <!-- If results yields  no data starts here-->        
            	<div class="alert alert-danger"> <h2> No category added yet</h2></div>
             </div>
             
            <div ng-if="list_Categories.nodata==undefined">
            
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th> SLNO</th>
                  <th ng-click="sort('Category_Name')" class="anchor_feel">Category Name <i class="fa fa-chevron-up" aria-hidden="true" ng-show="sortKey=='Category_Name'" ng-class="{'fa fa-chevron-up':reverse,'fa fa-chevron-down':!reverse}"></i>
                   </th>
                 
                  <th>Status</th>
                  <th>Actions</th>
                  
                </tr>
              </thead>
              
              <tbody>
                           
                            
                <tr  dir-paginate="category in list_Categories |orderBy:sortKey:reverse |filter:search |itemsPerPage:10" ng-cloak >
                        <td>{{category.SLNO}} </td>
                         <td>{{category.Category_Name}}</td>
                       
                        <td>{{category.Status}}</td>
                        <td>
                        <a href="<?PHP echo base_url('admin-edit-category/')?>{{category.CategoryID}}" class="btn btn-sm btn-primary">View/Edit</a>
                      <!--  <span class="anchor_feel btn btn-sm btn-danger delete_Franchiseuser" id="{{users.UserId}}" >Delete</a>-->
                        </td>
                </tr>
                
                <tr ng-if="userfrachises.length>0">
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
