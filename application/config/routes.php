<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['404_override'] = 'Site/Pagenotfound';
$route['translate_uri_dashes'] = FALSE;



$route['default_controller'] = 'Site';

$route['page-not-found'] ='Site/Pagenotfound';


///////////// site routes /////////////////
//$route['index'] = 'site';



$route['brand/:any'] = "Site/categoryproduct/";
$route['categories/:any'] = "Site/categoryAllproduct/";
$route[':any/:any/products'] = 'Site/brandsproducts';
$route['product-view/:any/:any'] = 'Site/productview';
$route['cart-view'] = 'Site/cartview';
$route['checkout'] = 'Site/checkout';

$route['login'] = 'Site/login';
$route['confirm-order/:any'] = 'Site/confirmorder';
$route['category/:any/:any'] = "Site/filtered";

$route['order-list'] = 'Site/orderlist';
$route['order-history/:any'] = 'Site/orderhistory';

$route['profile-info'] = 'Site/profileinfo';

$route['order-list'] = 'Site/orderlist';
$route['logout'] = 'Site/logout';

$route['confirm-registration/:any'] = 'Site/confirmregistration';




$route['admin-logout'] = 'Admin/logout';





////// Admin routes ///////////////////////

$route['admin-dashboard'] = 'Admin/dashboard';

$route['admin-add-user'] = 'Admin/adduser';
$route['admin-view-user'] = 'Managemissilenous/viewuser';
$route['admin-edit-user/:num'] = 'Admin/edituser/$1';

$route['admin-view-new-users'] = 'Managemissilenous/viewnewusers';
$route['admin-view-active-users'] = 'Managemissilenous/viewactiveusers';
$route['admin-view-inactive-users'] = 'Managemissilenous/viewinactiveusers';


/////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////
/////////////////////////   Brand routing ///////////////////////////////

$route['admin-add-brand'] = 'Admin/addbrand';
$route['admin-view-brands'] = 'Managemissilenous/viewbrands';
$route['admin-edit-brand/:num'] = 'admin/editbrand/$1';

$route['admin-add-category']= 'Admin/addcategory';
$route['admin-view-categories']= 'Managemissilenous/viewcategories';
$route['admin-edit-category/:num'] = 'Admin/editcategory/$1';



$route['admin-add-subcategory']= 'Admin/addsubcategory';
$route['admin-view-subcategories']= 'Managemissilenous/viewsubcategories';
$route['admin-edit-subcategory/:num'] = 'Admin/editsubcategory/$1';



$route['admin-add-base-uom']= 'Admin/addbaseuom';
$route['admin-view-base-uom']= 'Managemissilenous/viewbaseuom';
$route['admin-edit-base-uom/:num'] = 'Admin/editbaseuom/$1';


$route['admin-add-measurement']= 'Admin/addmeasurement';
$route['admin-view-measurements']= 'Managemissilenous/viewmeasurements';
$route['admin-edit-measurement/:num'] = 'Admin/editmeasurement/$1';

$route['admin-add-product'] = 'Admin/addproduct';
$route['admin-view-products'] = 'Managemissilenous/viewproducts';
$route['admin-edit-product/:num'] = 'Admin/editproduct/$1';

$route['admin-view-orders']			 = $this->config->item('viewAllorders');
$route['admin-view-awaiting-orders'] = $this->config->item('viewAllorders');//'Admin/viewAllorders';
$route['admin-view-confirmed-orders'] = $this->config->item('viewAllorders');//'Admin/viewAllorders';
$route['admin-view-delivered-orders'] = $this->config->item('viewAllorders');//'Admin/viewAllorders';
$route['admin-view-cancelled-orders'] = $this->config->item('viewAllorders');//'Admin/viewAllorders';

$route['admin-view-order/:num'] = 'Managemissilenous/vieworder/$1';
$route['admin-change-order-status/:num'] = 'Managemissilenous/ChangeOrderStatus/$1';

$route['admin-view-orders-category'] = 'Managemissilenous/vieworderbycategory';
$route['admin-view-orders-products'] = 'Managemissilenous/vieworderbyproduct';
$route['admin-view-todays-deliveries'] = 'Managemissilenous/todaysdeliveries';