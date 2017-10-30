
<!--Footer-part-->

<div class="row-fluid">
  <div id="footer" class="span12"> Developed by <a href="http://www.trillionit.com" target="_blank">Trillion IT Services</a></div>
</div>

<!--end-Footer-part-->
<script>
<?PHP

if($_SERVER['HTTP_HOST'] == "localhost")
$basehref= "http://localhost/ecom-live/";
else
$basehref= "http://trillionit.in/ecom-food/";
?>

var baseurl = "<?PHP echo base_url(); ?>";

//var baseurl='http://trillionit.in/ecom-food/';
</script>

<!--<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular.js"> </script>-->
<script src="resources/angular-js/angular1.5.8.js">  </script>
<script language="javascript" src="resources/angular-js/auto-validator/dist/jcs-auto-validate.min.js"> </script>
<script src="resources/angular-js/dirPagination.js">  </script>
<script src="resources/angular-js/autocomplete.js">  </script>

<script src="resources/angular-js/angularController.js">  </script>


<script src="resources/angular-js/ui-bootstrap-tpls-2.5.0.js"></script>

<script src="js/excanvas.min.js"></script> 
<script src="js/jquery.min.js"></script> 
<script src="js/jquery.ui.custom.js"></script> 
<script src="js/bootstrap.min.js"></script> 

<script src="js/jquery.peity.min.js"></script> 

<script src="js/matrix.js"></script> 
<script src="js/matrix.dashboard.js"></script> 

<script src="resources/js/Jquery.js"> </script>
<script src="resources/js/scripts.js"> </script>




 <script src="resources/js/jquery-ui.js"></script>
<script>
var availableTags=[];
 $( function() {

$("#subcategoryType").autocomplete({
					source: baseurl+'Requestdispatcher/getsubcattypes'
					});

$(document).on('keyup','#product_name',function() 
{

	
		var brand = '0';
		var category = '0';
		var subcategory = '0';

		
		var err_cnt	=0;
		
		brand = $("#brand").val();
		brand = $.trim(brand);
		
		category = $("#category").val();
		category = $.trim(category);

		subcategory	= $(".subcategorie").val();
		subcategory= $.trim(subcategory);
				
		if(brand!='' && brand>0){}
		else{ err_cnt=1; }
		
		if(category>0){}
		else { err_cnt=1; }
		
		if(subcategory!=''){ }
		else{ err_cnt=1; }	
		
		if(err_cnt=="0")
		{
			$("#product_name").autocomplete
							({
								source: baseurl+'Requestdispatcher/getproductNames?brand='+brand+'&category='+category+'&subcategory='+subcategory
							});
		}
		else
			{ 
			
			}


				});
		
  });
  </script>
<script>
  $( function() {
    $( "#Fromdatepicker" ).datepicker({
											dateFormat: "dd-mm-yy"
										});
  } );
  
    $( function() {
    $( "#Todatepicker" ).datepicker({
									dateFormat: "dd-mm-yy"
									});
  } );
  </script>
</body>
</html>
