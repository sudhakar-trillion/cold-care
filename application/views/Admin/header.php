<!DOCTYPE html>
<html lang="en">
<head>
<title>Matrix Admin</title>

<?PHP

if($_SERVER['HTTP_HOST'] == "localhost")
$basehref= "http://localhost/ecom-live/";
else
$basehref= "http://trillionit.in/ecom-food/";
?>



 <base href="<?PHP echo $basehref; ?>">
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<!--<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>-->
<link rel="stylesheet" href="css/Bootstrapv3.3.7.css"/>
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="css/fullcalendar.css" />
<link rel="stylesheet" href="css/matrix-style.css" />
<link rel="stylesheet" href="css/matrix-media.css" />
<link href="font-awesome/css/font-awesome.css" rel="stylesheet" />

<link rel="stylesheet" href="css/jquery.gritter.css" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>

<link rel="stylesheet" href="css/admin/style.css"/>
<!--<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"/>-->
<link rel="stylesheet" href="css/jQuery-UIv1.12.1.css"/>


<!--    <link href="resources/css/bootstrap.css" rel="stylesheet">-->
<!--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css"/>-->
<style>

[ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak 
{
  display: none !important;
}

</style>
<style>


button.close {
	-webkit-appearance: none;
	padding: 0;
	cursor: pointer;
	background: 0 0;
	border: 0
}
.modal-open {
	overflow: hidden
}
.modal {
	position: fixed;
	width:auto !important;
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
	z-index: 1050;
	display: none;
	overflow: hidden;
	-webkit-overflow-scrolling: touch;
	outline: 0
}
.modal.fade .modal-dialog {
	-webkit-transition: -webkit-transform .3s ease-out;
	-o-transition: -o-transform .3s ease-out;
	transition: transform .3s ease-out;
	-webkit-transform: translate(0, -25%);
	-ms-transform: translate(0, -25%);
	-o-transform: translate(0, -25%);
	transform: translate(0, -25%)
}
.modal.in .modal-dialog {
	-webkit-transform: translate(0, 0);
	-ms-transform: translate(0, 0);
	-o-transform: translate(0, 0);
	transform: translate(0, 0)
}
.modal-open .modal {
	overflow-x: hidden;
	overflow-y: auto
}
.modal-dialog {
	position: relative;
	width: auto;
	margin: 10px
}
.modal-content {
	position: relative;
	background-color: #fff;
	-webkit-background-clip: padding-box;
	background-clip: padding-box;
	border: 1px solid #999;
	border: 1px solid rgba(0,0,0,.2);
	border-radius: 6px;
	outline: 0;
	-webkit-box-shadow: 0 3px 9px rgba(0,0,0,.5);
	box-shadow: 0 3px 9px rgba(0,0,0,.5)
}
.modal-backdrop {
	position: fixed;
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
	z-index: 1040;
	background-color: #000
}
.modal-backdrop.fade {
	filter: alpha(opacity=0);
	opacity: 0
}
.modal-backdrop.in {
	filter: alpha(opacity=50);
	opacity: .5
}
.modal-header {
	padding: 15px;
	border-bottom: 1px solid #e5e5e5
}
.modal-header .close {
	margin-top: -2px
}
.modal-title {
	margin: 0;
	line-height: 1.42857143
}
.modal-body {
	position: relative;
	padding: 15px
}
.modal-footer {
	padding: 15px;
	text-align: right;
	border-top: 1px solid #e5e5e5
}
.modal-footer .btn+.btn {
	margin-bottom: 0;
	margin-left: 5px
}
.modal-footer .btn-group .btn+.btn {
	margin-left: -1px
}
.modal-footer .btn-block+.btn-block {
	margin-left: 0
}
.modal-scrollbar-measure {
	position: absolute;
	top: -9999px;
	width: 50px;
	height: 50px;
	overflow: scroll
}
@media (min-width:768px) {
.modal-dialog {
	width: 600px;
	margin:110px auto 0;
}
.modal-content {
	-webkit-box-shadow: 0 5px 15px rgba(0,0,0,.5);
	box-shadow: 0 5px 15px rgba(0,0,0,.5)
}
.modal-sm {
	width: 400px
}
}
@media (min-width:992px) {
.modal-lg {
	width: 900px
}
}
  .full button span {
    background-color: limegreen;
    border-radius: 32px;
    color: black;
  }
  .partially button span {
    background-color: orange;
    border-radius: 32px;
    color: black;
  }
  .filter-input-colms .form-control{
	height: 30px;
	margin: 3px 0;
	width: 100%;
	float: left;
	padding: 0 5px;	  
  }
  .btns-filters{
	  padding-top:3px;
	  padding-bottom:3px;
  }
  .filter-input-colms .col-md-2{
	  padding:0 5px;
  }
  .navbar{
	min-height:0;
  }
  textarea{width:220px;}
  select, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"], .uneditable-input{height:30px !important; line-height:30px !important;	  width:220px;  }
  input[type="radio"]{ margin:0px 5px 0 0;  }
  input.form-control{width:100%;}
</style>
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="#"><img src="resources/site/img/demo-store-1401086283.jpg" alt="" class="img-responsive" /></a></h1>
</div>
<!--close-Header-part--> 


<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li  class="dropdown" id="profile-messages" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text">Welcome <?PHP echo $this->session->userdata('username');?></span><b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a href="javascript:void(0)" data-toggle="modal" data-target="#forgotpass" ><i class="icon-user"></i> Change password</a></li>
        <li class="divider"></li>
       
        <li class="divider"></li>
        <li><a href="<?PHP echo base_url('admin-logout')?>"><i class="icon-key"></i> Log Out</a></li>
      </ul>
    </li>
    <li class=""><a title="" href="<?PHP echo base_url('admin-logout')?>"><i class="icon icon-share-alt"></i> <span class="text">Logout</span></a></li>
   
  </ul>
</div>
<!--close-top-Header-menu-->
<!--start-top-serch-->
<!--close-top-serch-->
<!--sidebar-menu-->
<div id="sidebar"><a href="<?PHP echo base_url('admin-dashboard');?>" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
  <ul>
    <li class=" <?PHP if($this->uri->segment(1)=="admin-dashboard"){ echo 'active open';  }?> "><a href="<?PHP echo base_url('admin-dashboard');?>"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    
  
    <li class="submenu <?PHP if( $this->uri->segment(1)=="admin-view-user" || $this->uri->segment(1)=="admin-add-user" ){ echo 'active open';  }?> "> <a href="#"><i class="icon icon-th-list"></i> <span>Manage Users</span> <span class="label label-important"></span></a>
      <ul>
        <!--<li><a href="form-common.html">Basic Form</a></li>
        <li><a href="form-validation.html">Form with Validation</a></li>
        <li><a href="form-wizard.html">Form with Wizard</a></li>-->
        
        <li><a href="<?PHP echo base_url('admin-add-user'); ?>">Add User</a> </li>
        <li><a href="<?PHP echo base_url('admin-view-user'); ?>">View User</a> </li>
        
      </ul>
    </li>
    <li class="submenu <?PHP if( $this->uri->segment(1)=="admin-add-brand" || $this->uri->segment(1)=="admin-view-brands" || $this->uri->segment(1)=="admin-edit-brand"  ){ echo 'active open';  }?>"> <a href="#"><i class="icon icon-tint"></i> <span>Manage Brands</span> <span class="label label-important"></span></a>
      <ul>
       <li ><a href="<?PHP echo base_url('admin-add-brand'); ?>">Add Brand</a> </li>
        <li><a href="<?PHP echo base_url('admin-view-brands'); ?>">View Brands</a> </li>
        
      </ul>
    </li>
    
    
    <li class="submenu <?PHP if( $this->uri->segment(1)=="admin-add-category" || $this->uri->segment(1)=="admin-view-categories" || $this->uri->segment(1)=="admin-edit-category"  ){ echo 'active open';  }?>"> <a href="#"><i class="icon icon-tint"></i> <span>Manage Categories</span> <span class="label label-important"></span></a>
      <ul>
       <!-- <li><a href="<?PHP echo base_url('admin-add-category'); ?>">Add Category</a> </li>-->
        <li><a href="<?PHP echo base_url('admin-view-categories'); ?>">View Category</a> </li>
        
      </ul>
    </li>
    
      <li class="submenu <?PHP if( $this->uri->segment(1)=="admin-add-subcategory" || $this->uri->segment(1)=="admin-view-subcategories" || $this->uri->segment(1)=="admin-edit-subcategory"  ){ echo 'active open';  }?>"> <a href="#"><i class="icon icon-tint"></i> <span>Manage Sub-Categories</span> <span class="label label-important"></span></a>
      <ul>
     <!--   <li><a href="<?PHP echo base_url('admin-add-subcategory'); ?>">Add Sub-Category</a> </li>-->
        <li><a href="<?PHP echo base_url('admin-view-subcategories'); ?>">View Sub-Category</a> </li>
        
      </ul>
    </li>
      
      <li class="submenu <?PHP if( $this->uri->segment(1)=="admin-add-measurement" || $this->uri->segment(1)=="admin-view-measurements" || $this->uri->segment(1)=="admin-edit-measurement"  ){ echo 'active open';  }?>"> <a href="#"><i class="icon icon-tint"></i> <span>Manage Measurements</span> <span class="label label-important"></span></a>
      <ul>
        <li><a href="<?PHP echo base_url('admin-add-measurement'); ?>">Add Measurement</a> </li>
        <li><a href="<?PHP echo base_url('admin-view-measurements'); ?>">View Measurements</a> </li>
        
      </ul>
    </li>
    
          <li class="submenu <?PHP if( $this->uri->segment(1)=="admin-add-base-uom" || $this->uri->segment(1)=="admin-view-base-uom" || $this->uri->segment(1)=="admin-edit-base-uom"  ){ echo 'active open';  }?>"> <a href="#"><i class="icon icon-tint"></i> <span>Manage Base UOM</span> <span class="label label-important"></span></a>
      <ul>
        <li><a href="<?PHP echo base_url('admin-add-base-uom'); ?>">Add Base UOM</a> </li>
        <li><a href="<?PHP echo base_url('admin-view-base-uom'); ?>">View Base UOM</a> </li>
        
      </ul>
    </li>
      
      <li class="submenu  <?PHP if( $this->uri->segment(1)=="admin-add-product" || $this->uri->segment(1)=="admin-view-products" || $this->uri->segment(1)=="admin-edit-product"  ){ echo 'active open';  }?>"> <a href="#"><i class="icon icon-tint"></i> <span>Manage Products</span> <span class="label label-important"></span></a>
      <ul>
        <li><a href="<?PHP echo base_url('admin-add-product'); ?>">Add Product</a> </li>
        <li><a href="<?PHP echo base_url('admin-view-products'); ?>">View Products</a> </li>
        
      </ul>
    </li>
    
<!-- Manage Orders -->    
    
    <li class="submenu  <?PHP if( $this->uri->segment(1)=="admin-view-orders" || $this->uri->segment(1)=="admin-view-orders-category" || $this->uri->segment(1) =="admin-view-orders-products" || $this->uri->segment(1)=="admin-change-order-status" || $this->uri->segment(1) == "admin-view-order"  || $this->uri->segment(1) == "admin-view-todays-deliveries" ){ echo 'active open';  }?>"> <a href="#"><i class="icon icon-tint"></i> <span>Manage Orders</span> <span class="label label-important"></span></a>
      <ul>
       
        <li><a href="<?PHP echo base_url('admin-view-orders'); ?>">Orders by stores</a> </li>
        
        <li><a href="<?PHP echo base_url('admin-view-orders-category'); ?>">Orders by category</a> </li>
        <li><a href="<?PHP echo base_url('admin-view-orders-products'); ?>">Orders by product </a> </li>
        <li><a href="<?PHP echo base_url('admin-view-todays-deliveries'); ?>"> Today's deliveries</a> </li>
        
      </ul>
    </li>
    
    
  </ul>
</div>
<!--sidebar-menu-->


<div id="forgotpass" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Change password</h4>
      </div>
      
      <div class="modal-body">
      	
        	<div class="form-group">
            	<input type="text" name="reg_email" id="newpassword" class="form-control" placeholder="Enter new password" />
                <span style="color:red" class="chngepwd_err"></span>
            </div>
            
            <div class="form-group">
                <button type="button" class="btn btn-success pull-right change_pwd">SUBMIT</button>
            </div>
            <div class="clearfix"></div>
       
      </div>
    </div>

  </div>
</div>