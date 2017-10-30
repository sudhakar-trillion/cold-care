<div id="content" ng-app="myApp">
  <div id="content-header">
    <div id="breadcrumb"> <a href="<?PHP echo base_url('admin-dashboard')?>" title="Go to dashboard" class="tip-bottom"><i class="icon-home"></i> Dashboard</a> <a href="#">Manage users</a>
        <a href="<?PHP echo base_url('admin-add-user'); ?>">Add user</a><a  class="current">View Inctive users</a> </div>
    
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <?PHP echo $this->session->flashdata('user_franchise_added');?>
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>View Users/Franchises</h5>
            <div class="col-md-2">
            <input type="text" placeholder="User name" class="form-control" ng-model="serch.USERNAME">
            </div>
            <div class="col-md-2">
            <input type="text" placeholder="Location" class="form-control" ng-model="serch.Location">
            </div>
          </div>
          <div class="widget-content nopadding" ng-controller="ecomCtrl" ng-init="getuserFranchise('new','Inactive')">
            
            <div ng-if="userfrachises.nodata=='yes'" ng-cloak style="margin-top:20px; margin-bottom:10px; width:97%">         <!-- If results yields  no data starts here-->        
            	<div class="alert alert-danger"> <h2> No Applicant source added yet</h2></div>
             </div>
             
            <div ng-if="userfrachises.nodata==undefined">
            
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th> SLNO</th>
                  <th ng-click="sort('USERNAME')" class="anchor_feel">User Name <i class="fa fa-chevron-up" aria-hidden="true" ng-show="sortKey=='USERNAME'" ng-class="{'fa fa-chevron-up':reverse,'fa fa-chevron-down':!reverse}"></i> <!--<span class="fa fa-chevron-up" ng-show="sortKey=='USERNAME'" ng-class="{'fa fa-chevron-up':reverse,'fa fa-chevron-down':!reverse}"></span>-->
<!--                  <i class="fa fa-chevron-up" aria-hidden="true"></i>-->
                  </th>
                  <th>Owner Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                 <th>Address</th>
                  <th>Location</th>
                  <th> Status</th>
                  <th>Actions</th>
                  
                </tr>
              </thead>
              
              <tbody>
                           
                            
                <tr  dir-paginate="users in userfrachises |orderBy:sortKey:reverse |filter:serch |itemsPerPage:10" ng-cloak >
                        <td>{{users.SLNO}} </td>
                        <td>{{users.USERNAME}}</td>
                        <td>{{users.Owner_Name}}</td>
                        <td>{{users.Email}}</td>
                        <td>{{users.Phone}}</td>
                        <td>{{users.Address}}</td>
                        <td>{{users.Location}}</td>
                        <td>{{users.Status}}</td>
                        <td>
                        <a href="<?PHP echo base_url('admin-edit-user/')?>{{users.UserId}}" class="btn btn-sm btn-primary">View/Edit</a>
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
