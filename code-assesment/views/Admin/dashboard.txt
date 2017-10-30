<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a></div>
  </div>
<!--End-breadcrumbs-->

<!--Action boxes-->
  <div class="container-fluid">
    <div class="quick-actions_homepage">
      <!--<ul class="quick-actions">
        <li class="bg_lb"> <a href="index.html"> <i class="icon-dashboard"></i> <span class="label label-important">20</span> My Dashboard </a> </li>
        <li class="bg_lg span3"> <a href="charts.html"> <i class="icon-signal"></i> Charts</a> </li>
        <li class="bg_ly"> <a href="widgets.html"> <i class="icon-inbox"></i><span class="label label-success">101</span> Widgets </a> </li>
        <li class="bg_lo"> <a href="tables.html"> <i class="icon-th"></i> Tables</a> </li>
        <li class="bg_ls"> <a href="grid.html"> <i class="icon-fullscreen"></i> Full width</a> </li>
        <li class="bg_lo span3"> <a href="form-common.html"> <i class="icon-th-list"></i> Forms</a> </li>
        <li class="bg_ls"> <a href="buttons.html"> <i class="icon-tint"></i> Buttons</a> </li>
        <li class="bg_lb"> <a href="interface.html"> <i class="icon-pencil"></i>Elements</a> </li>
        <li class="bg_lg"> <a href="calendar.html"> <i class="icon-calendar"></i> Calendar</a> </li>
        <li class="bg_lr"> <a href="error404.html"> <i class="icon-info-sign"></i> Error</a> </li>

      </ul>-->
      
      <ul class="site-stats">
<?PHP

//get total user
$this->db->where('Role','2');
$total_users = $this->db->get('users');


//get total number of Active users
$this->db->where('Status','Active');
$this->db->where('Role','2');
$active_users = $this->db->get('users');


//get total number of Inactive users
$this->db->where('Status','Inactive');
$this->db->where('Role','2');
$inactive_users = $this->db->get('users');

//get total number of New users
$this->db->where('Status','New');
$this->db->where('Role','2');
$new_users = $this->db->get('users');

//get the toal orders
$total_orders = $this->db->get('orders');

//get the toal orders in awaiting status
$this->db->where('OrderStatus','Awaiting');
$total_awaiting_orders = $this->db->get('orders');

//get the toal orders in Confirmed status
$this->db->where('OrderStatus','Confirmed');
$total_confirmed_orders = $this->db->get('orders');

//get the toal orders in Delivered status
$this->db->where('OrderStatus','Delivered');
$total_delivered_orders = $this->db->get('orders');

//get the toal orders in Cancelled status
$this->db->where('OrderStatus','Cancelled');
$total_cancelled_orders = $this->db->get('orders');

//get the toal products
//$this->db->where('OrderStatus','Canceled');
$total_products= $this->db->get('products');


///total orders cost 

$this->db->select('sum(Total_Amount) as Amount');
$this->db->from('orders');
$this->db->where('OrderStatus','Delivered');
$totalamount = $this->db->get();

?>           
              
              
              
              
              
              
                <li class="bg_lh span3 "><a href="<?PHP echo base_url('admin-view-user'); ?> "> <i class="icon-user "></i> <strong><?PHP echo $total_users->num_rows(); ?></strong> <small>Total Users</small></a></li>
                
                <li class="bg_lh span3"><a href="<?PHP echo base_url('admin-view-new-users'); ?> "> <i class="icon-user"></i> <strong><?PHP echo $new_users->num_rows(); ?></strong> <small>New Users </small></a></li>
                
                <li class="bg_lh  span3"><a href="<?PHP echo base_url('admin-view-active-users'); ?> "> <i class="icon-user "></i> <strong><?PHP echo $active_users->num_rows(); ?></strong> <small>Active Users</small></a></li>
                
                <li class="bg_lh span3"><a href="<?PHP echo base_url('admin-view-inactive-users'); ?> "><i class="icon-user"></i> <strong><?PHP echo $inactive_users->num_rows(); ?></strong> <small>Inactive Users </small></a></li>
                                 
                <li class="bg_lh span3"><a href="<?PHP echo base_url('admin-view-orders'); ?> "><i class="icon-shopping-cart"></i> <strong><?PHP echo $total_orders ->num_rows(); ?></strong> <small>Total Orders</small></a></li>
                
                <li class="bg_lh span3"><a href="<?PHP echo base_url('admin-view-awaiting-orders'); ?> "><i class="icon-tag"></i> <strong><?PHP echo $total_awaiting_orders->num_rows(); ?></strong> <small>Awaiting Orders</small></a></li>
                
                <li class="bg_lh span3"><a href="<?PHP echo base_url('admin-view-confirmed-orders'); ?> "><i class="icon-repeat"></i> <strong><?PHP echo $total_confirmed_orders->num_rows(); ?></strong> <small>Confirmed Orders</small></a></li>
                
                 <li class="bg_lh span3"><a href="<?PHP echo base_url('admin-view-delivered-orders'); ?> "><i class="icon-globe"></i> <strong><?PHP echo $total_delivered_orders->num_rows(); ?></strong> <small>Delivered Orders</small></a></li>
                
                <li class="bg_lh span3"><a href="<?PHP echo base_url('admin-view-cancelled-orders'); ?> "><i class="icon-globe"></i> <strong><?PHP echo $total_cancelled_orders->num_rows(); ?></strong> <small>Cancelled Orders</small></a></li>
                
                <li class="bg_lh span3"><a href="<?PHP echo base_url('admin-view-products'); ?> "><i class="icon-globe"></i> <strong><?PHP echo $total_products->num_rows();?></strong> <small>Total Products</small></a></li>
                
                <li class="bg_lh span3"><a ><i class="icon-shopping-cart"></i> <strong>Rs.<?PHP echo $totalamount->row('Amount'); ?></strong> <small>Total Orders Sales Amount</small></a></li>
                
              </ul>
    </div>
<!--End-Action boxes-->    

<!--Chart-box-->    
<!--
    <div class="row-fluid">
      <div class="widget-box">
        <div class="widget-title bg_lg"><span class="icon"><i class="icon-signal"></i></span>
          <h5>Site Analytics</h5>
        </div>
        <div class="widget-content" >
          <div class="row-fluid">
            <div class="span9">
              <div class="chart"></div>
            </div>
           
           
          </div>
        </div>
      </div>
    </div>-->
<!--End-Chart-box--> 
    <hr/>
    
    
  </div>
</div>