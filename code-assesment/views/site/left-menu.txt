
  
<div class="row" id="columns_inner">
          <!--- left column starts here --->
            <div id="left_column" class="column col-xs-12 col-sm-12 col-md-3">
             
             <div id="categories_block_left" class="block">
                
                <h2 class="title_block">
                Brands
                
                <?PHP
				/*
				if($this->uri->segment(1)=="categories"){ echo str_replace("-"," ",$this->uri->segment(2));}
				else{ echo "Brands"; }
				*/
				?>
                 </h2>
                <div class="block_content">
                  <ul class="tree-view-menu">
                   
					<?PHP
					$CI= &get_instance();
					$CI->db->order_by('BrandName','ASC');
					$CI->db->where('Status','Active');
					$brnds = $CI->db->get('brands');
					
					if($this->uri->segment(1)=="categories")
					{
						foreach($brnds->result() as $brnd)
						{
							?>
						<li class="tree-menu-list"><a href="<?php echo base_url($brnd->BrandName."/".$this->uri->segment(2)."/products"); ?>" title=""> <?PHP echo ucwords($brnd->BrandName);?> </a></li>     
							<?PHP	
						}
					}
					elseif($this->uri->segment(1)=="category" )
					{
					foreach($brnds->result() as $brnd)
						{
							?>
						<li class="tree-menu-list"><a href="<?php echo base_url($brnd->BrandName."/".$this->uri->segment(3)."/products"); ?>" title=""> <?PHP echo ucwords($brnd->BrandName);?> </a></li>     
							<?PHP	
						}
					}
					elseif($this->uri->segment(3)=="products")
					{
						foreach($brnds->result() as $brnd)
						{
							?>
						<li class="tree-menu-list"><a href="<?php echo base_url($brnd->BrandName."/".$this->uri->segment(2)."/products"); ?>" title=""> <?PHP echo ucwords($brnd->BrandName);?> </a></li>     
							<?PHP	
						}
					}
					else
					{
						foreach($brnds->result() as $brnd)
						{
							?>
						<li class="tree-menu-list"><a href="<?php echo base_url("brand/").$brnd->BrandName; ?>" title=""> <?PHP echo ucwords($brnd->BrandName);?> </a></li>     
							<?PHP	
						}
					}
					?>
                    
                  </ul>
                  
                </div>
                
                <div  class="tm_subbanner">
                  <ul>
                    <li class="tmsubbanner-container"> <a href="#" title="Subbanner 1"> 
                    <img src="resources/site/modules/tmsubbanner/img/sub-banner-1.png" alt="Subbanner 1" class="img-responsive"/> 
                    </a></li>
                 </ul>
                 </div>
              </div>
             
             
             
            </div>
          <!--- left column ends here --->