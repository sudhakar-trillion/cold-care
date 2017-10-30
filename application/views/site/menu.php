<div id="">
  <div class="header-container">
    <header id="header">
      
      <div>
        <div class="container">
          <div class="row">
          
<!--------------------------------------------------------------------------- 
			    Logo starts here
---------------------------------------------------------------------------->
			
            <div id="header_logo" class="col-sm-3"> 
                <a href="<?php echo base_url(''); ?>" title="">
                    <img class="logo img-responsive" src="resources/site/img/demo-store-1401086283.jpg" alt="Logo" width="auto" height="64"/> 
                </a>

            </div>
            
<!--------------------------------------------------------------------------- 
			    Logo starts here
---------------------------------------------------------------------------->


            
<!--------------------------------------------------------------------------- 
			    Main menu code starts here
---------------------------------------------------------------------------->

            <div id="block_top_menu" class="sf-contener clearfix col-lg-9 col-md-9 col-sm-12 col-xs-12">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span> 
              </button>
           	  
              <ul class="menu-content">
           		<?PHP
		   		$this->db->order_by('Category_Name','DESC');
				$categories_qry = $this->db->get('categories');
				foreach($categories_qry->result() as $categ )
				{
						$this->db->where('CategId',$categ->CategoryID);
						$this->db->order_by('SubCategory','DESC');
						
					$subqry = $this->db->get('subcategories');
					if($subqry->num_rows()>0)
					{
					?>
                    <li class="dropdown_btn">
                        <a href="<?PHP echo base_url('categories/'.ucwords(strtolower(str_replace(" ","-",$categ->Category_Name))));?>" title="">
                        <?PHP echo $categ->Category_Name; ?>
                        </a>
                        <i class="fa fa-caret-down dropdown-toggle" aria-hidden="true"></i>
                        <ul  class="sub-menu">
                        <?PHP
                        foreach($subqry->result() as $subc)
                        {
                        ?>
                         <li><a href="<?PHP echo base_url('category/'.$subc->SubCategory."/".str_replace(" ","-",strtolower($categ->Category_Name)));?>" title=""><?PHP echo $subc->SubCategory;?></a></li>
                        <?PHP	
                        }
                        ?>
                        </ul>
                    <?PHP
					}
					else
					{
						?>
                         <li>
                         <a href="<?PHP echo base_url('categories/'.ucwords(strtolower(str_replace(" ","-",$categ->Category_Name))));?>" title=""><?PHP echo $categ->Category_Name; ?></a>
                         </li>
                        <?PHP
					}
					?>
                    
                    <?PHP
				}
		   
		   ?>
			</ul>

              <ul class="login-button">
              	<li class="active dropdown">
                <?PHP
				if($this->session->userdata('UserName')=='')
				{
				?>
                	<a href="javascript:void(0)" data-toggle="modal" data-target="#loginModal" title="">
                	    <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                    </a>
                <?PHP
				}
				else
				{
				?>
				<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"> 
                   <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                   <i class="fa fa-caret-down" aria-hidden="true"></i>
                </a>
                
                <ul class="dropdown-menu">
                	<li class="label_name"><?php echo $this->session->userdata('UserName'); ?></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo base_url('order-list'); ?>">My orders</a></li>
                    <li><a href="<?php echo base_url('profile-info'); ?>">Personal info</a></li>
                    <li><a href="<?php echo base_url('logout'); ?>">Log Out</a></li>
                </ul>
                <?PHP	
				}
				?>
                </li>
              </ul>
              
              <ul class="cart-buttons">
              	
              	<li class="cart-icon"><i class="fa fa-shopping-basket" aria-hidden="true"></i></li>
                <li class="cart-items-no">
                    <a href="cart-view">
                    
                    <?PHP $cartitems = $this->session->userdata('lastcartItem');
					
					if( !empty($cartitems))
						{
					 //load the sessioned items into the array 
					 ?>
                    		<span class="items-no cartItems"><?PHP echo sizeof($cartitems); ?></span> <b>cart items</b>
                    <?PHP
						}
						else
						{
						?>
                        	<span class="items-no cartItems">0 </span>cart items
						<?PHP	
						}
						?>
                    </a>
                </li>
                
              </ul>

            </div>
            
<!--------------------------------------------------------------------------- 
			    Main menu code starts here
---------------------------------------------------------------------------->


          </div>
        </div>
      </div>
    </header>
  </div>
  
  
  
<!------------------------- 
	Login Modal popup code 
    Starts Here
-------------------------->

<div id="loginModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">LOGIN</h4>
      </div>
      
      <div class="modal-body">
      	<form method="post" class="login-form-pop">
            <div class="form-group">
                <input type="text" name="username" id="username_popup" class=" form-control" placeholder="User Id">
                <span class="location_icon"><i class="fa fa-user-circle-o" aria-hidden="true"></i></span>
            </div>
             <span style="color:red" class="err_msg" id="username-err"></span>
            <div class="form-group">
                <input type="password" name="password" id="password_popup" class="form-control" placeholder="Password">
                <span class="location_icon"><i class="fa fa-lock" aria-hidden="true"></i></span>
            </div>
             <span style="color:red" class=" err_msg" id="pwd-err"></span>
            <div class="form-group">
                <a href="javascript:void(0)" data-toggle="modal" data-target="#forgotpass" class="pull-left forgot-text">Forgot password</a>
                <button type="button" class="btn btn-success pull-right loginpopbtn">LOGIN</button>
            </div>
            <div class="clearfix"></div>        
         </form>
      </div>
    </div>

  </div>
</div>


<!------------------------- 
	Login Modal popup code 
    Ends Here
-------------------------->

<!------------------------- 
	Forgotpass Modal popup
    Code starts Here
-------------------------->
<div id="forgotpass" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Forgot password</h4>
      </div>
      
      <div class="modal-body">
      	<form method="post" class="login-form-pop">
        	<div class="form-group">
            	<input type="text" name="reg_email" id="forget_reg_email" class="form-control" placeholder="Registed Email" />
                <span style="color:red" class="forget_reg_email_err"></span>
            </div>
            
            <div class="form-group">
                <button type="button" class="btn btn-success pull-right forget_pwd">SUBMIT</button>
            </div>
            <div class="clearfix"></div>
        </form>
      </div>
    </div>

  </div>
</div>

<!------------------------- 
	Forgotpass Modal popup
    Code ends Here
-------------------------->


<!--------------------------------------------------------------------------- 
	Main container Code starts Here and ends in every page
---------------------------------------------------------------------------->
  <div class="bg-trans-container">
    <div id="columns" class="container">
      <div class="inner_container">
        <div class="inner_container_sub">