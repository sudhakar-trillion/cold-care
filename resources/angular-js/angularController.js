//var myApp = angular.module('myApp', ['ui.bootstrap','angularUtils.directives.dirPagination','jcs-autoValidate','autocomplete']);
var myApp = angular.module('myApp', ['ui.bootstrap','angularUtils.directives.dirPagination','jcs-autoValidate']);

//capitalise the string
myApp.filter('capitalize', function() {
    return function(input) {
      return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
    }
});




myApp.controller('ecomCtrl',function($scope, $http){
	
	$scope.userfrachises=[];
	$scope.UserFranchise=[];
	
	$scope.list_Brands=[];
	$scope.list_Categories=[];
	$scope.listunits=[];
    $scope.listProducts = [];
	$scope.listsubcateg = [];
	$scope.listuoms = [];
	$scope.listorders = [];
	$scope.Allproductsperorder = [];
	
	$scope.operand1= Math.floor(Math.random() * 10)+1;
	$scope.operand2 = Math.floor(Math.random() * 10)+1;
	
    $scope.signUP = [];
	$scope.TotalAmount=0;
	$scope.orderstatus = ['Change Status','Shipped','Delivered','Cancelled'];
	$scope.selectedItem = 'Change Status';
	$scope.orderID = '';
	
	$scope.todate = '';
	$scope.srch = {};
	$scope.loader=false;
	$scope.showstatus= false;
	
	$scope.stores = [];
	$scope.categ = [];
	$scope.prdcts = [];
	$scope.todaydelivered_orders = [];
	$scope.disp_not=true;
	
	
	
	
/*  date picker related of angular starts here */

$scope.today = function() {
    $scope.srch.OrderedOn = '';//new Date();
	$scope.srch.todate = '';//new Date();
	$scope.dt=new Date();
	//console.log($scope.dt);

  };
  $scope.today();

  $scope.clear = function() {
    $scope.dt = null;
	 $scope.srch.OrderedOn = null;
	$scope.srch.todate =null;
  };

  $scope.inlineOptions = {
    customClass: getDayClass,
    minDate: new Date(),
    showWeeks: true
  };

  $scope.dateOptions = {
   // dateDisabled: disabled,
    formatYear: 'yy',
    maxDate: new Date(2020, 5, 22),
    minDate: new Date(),
    startingDay: 0
  };

  // Disable weekend selection
  function disabled(data) {
    var date = data.date,
      mode = data.mode;
    return mode === 'day' && (date.getDay() === 1 || date.getDay() === 7);
  }

  $scope.toggleMin = function() {
    $scope.inlineOptions.minDate = $scope.inlineOptions.minDate ? null : new Date();
    $scope.dateOptions.minDate = $scope.inlineOptions.minDate;
  };

  $scope.toggleMin();

  $scope.open1 = function() {
    $scope.popup1.opened = true;
  };

  $scope.open2 = function() {
    $scope.popup2.opened = true;
  };

  $scope.setDate = function(year, month, day) {
    $scope.dt = new Date(year, month, day);

  };

  $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd-MM-yyyy', 'shortDate'];
  $scope.format = $scope.formats[2];
  $scope.altInputFormats = ['M!/d!/yyyy'];

  $scope.popup1 = {
    opened: false
  };

  $scope.popup2 = {
    opened: false
  };

  var tomorrow = new Date();
  tomorrow.setDate(tomorrow.getDate() +1);
  var afterTomorrow = new Date();
  afterTomorrow.setDate(tomorrow.getDate() + 1);
  $scope.events = [
    {
      date: tomorrow,
      status: 'full'
    },
    {
      date: afterTomorrow,
      status: 'partially'
    }
  ];

  function getDayClass(data) {
    var date = data.date,
      mode = data.mode;
    if (mode === 'day') {
     var dayToCheck = new Date(date).setHours(0,0,0,0);
	
	  //var dayToCheck = new Date(date);

      for (var i = 0; i < $scope.events.length; i++) {
        var currentDay = new Date($scope.events[i].date).setHours(0,0,0,0);
		//var currentDay = new Date($scope.events[i].date);

        if (dayToCheck === currentDay) {
          return $scope.events[i].status;
        }
      }
    }

    return '';
  }

/*  date picker related of angular ends here */

/* Timepicker starts here */

$scope.mytime = new Date();

  $scope.hstep = 1;
  $scope.mstep = 15;

  $scope.options = {
    hstep: [1, 2, 3],
    mstep: [1, 5, 10, 15, 25, 30]
  };

  $scope.ismeridian = true;
  $scope.toggleMode = function() {
    $scope.ismeridian = ! $scope.ismeridian;
  };

  $scope.update = function() {
    var d = new Date();
    d.setHours( 14 );
    d.setMinutes( 0 );
    $scope.mytime = d;
  };

  $scope.changed = function () {
    console.log('Time changed to: ' + $scope.mytime);
  };

  $scope.clear = function() {
    $scope.mytime = null;
  };

/* Timepicker ends here*/





//register function goeshere

$scope.register=function()
{
	console.log(signUP);
}
	
	
	$scope.getuserFranchise = function(type,yes_no) {
		
		$http({
				  method:'post',
				  url  : baseurl+"Requestdispatcher/getuserFranchise",
				  data:{"type":type,"yes_no":yes_no},
				  headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
				  }).success(function(respon) {
					  $scope.userfrachises = respon; 
					  
					  
				  });
		
		};
		
/////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
/* Listing the users ends here*/
/////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////

$scope.getusers=function($userid)
{
	$http({
			method:'post',
			url  : baseurl+"Requestdispatcher/getAUserFranchiseDetails",
			data:{"UserId":$userid},
			  headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
			}).success(function(respo)
										{ 
											$scope.UserFranchise = respo; 
										 });
};


/////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
/* getting a user for edit ends here*/
/////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////



/////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
/* listing of brands starts here*/
/////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////

$scope.getbrands=function()
{
		$http({
				url:baseurl+"Requestdispatcher/getbrands",
				method:'POST',
				//data:{"UserId":$userid},
				headers : {'Content-Type': 'application/x-www-form-urlencoded'}
				}).success(function(resp) { $scope.list_Brands = resp; });
};



/////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
/* listing of brands  ends here*/
/////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
		

$scope.Activate_inactivate_brand=function(slno,id,status)
									{ 
										$http({
												url:baseurl+"Requestdispatcher/Activate_inactivate_brand",
												method:'POST',
												data:{"BrandId":id,'Status':status},
												headers:{'Content-Type':'application/x-www-form-urlencoded'}
												}).success(function(resp) { 
																			if(resp=="1")
																			{
																				if(status=="Active") { $scope.list_Brands[slno].Status='Inactive'; }
																				else { $scope.list_Brands[slno].Status='Active'; }
																			}
																			
																			});
										
										
										
									};		

//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
/* Get the categories list starts here */
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////

$scope.getcategories = function()
						{
								
								$http({
									url:baseurl+"Requestdispatcher/getcategories",
									method:'POST',
									headers:{'Content-Type':'aplication/x-www-form-urlencoded'}										
										}).success(function(resp_data) { $scope.list_Categories=resp_data; });
							
						}



//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
/* Get the categories list ends here  */
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////

/* get the list of subcategories */

//$scope.listsubcateg = [];

///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////


$scope.getsubcategories = function()
{
	$http({
			url:baseurl+"Requestdispatcher/getsubcategories",
			method:'POST',
			headers:{'Content-Type':'aplication/x-www-form-urlencoded'}										
			}).success(function(resp_data) { $scope.listsubcateg = resp_data; });
};




////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////

/* List of uoms starts here */

$scope.getuoms = function() { 
						$http({
							url:baseurl+"Requestdispatcher/getuoms",
							method:'POST',
							headers:{'Content-Type':'aplication/x-www-form-urlencoded'}										
						}).success(function(resp_data) { $scope.listuoms = resp_data; });
							
							};

////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
/* Get the Measurements list starts here */
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////

$scope.getunits = function()
						{
								
								$http({
									url:baseurl+"Requestdispatcher/getunits",
									method:'POST',
									headers:{'Content-Type':'aplication/x-www-form-urlencoded'}										
										}).success(function(resp_data) 
                                                    { 
                                                        $scope.listunits=resp_data; 
                                                    });
							
						}



//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
/* Get the Measurements list ends here  */
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////



$scope.Activate_inactivate_unit=function(slno,id,status)
									{ 
										$http({
												url:baseurl+"Requestdispatcher/Activate_inactivate_unit",
												method:'POST',
												data:{"MeasurementId":id,'Status':status},
												headers:{'Content-Type':'application/x-www-form-urlencoded'}
												}).success(function(resp) { 
																			if(resp=="1")
																			{
																				if(status=="Active") { $scope.listunits[slno].Status='Inactive'; }
																				else { $scope.listunits[slno].Status='Active'; }
																			}
																			
																			});	
									};	

//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
/* getting the list of products added */
    
$scope.getProducts_listing = function()
{
    
    $http({
            url:baseurl+"Requestdispatcher/getProducts_listing",
            method:'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded'},        
            }).success(function(resp) 
                      {
                        $scope.listProducts=resp;
                        });//success ends here
    //$scope.listProducts
}
    
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* List out all the orders */
$scope.getAllorders = function()
{
//kindly go at the 	getAllorders method of Requestdispatcher controller you can 
//find the inline documentation there

	    $http({
            url:baseurl+"Requestdispatcher/getAllorders",
            method:'POST',

            headers:{'Content-Type':'application/x-www-form-urlencoded'},        
            }).success(function(resp) 
                      {
                        	$scope.listorders=resp;							
                        });//success ends here
						
				$scope.stores('');		
	    				
						
	
};



//get the storenames

$scope.stores = function(storeName)
{
	
		$http({
            url:baseurl+"Requestdispatcher/getstores",
            method:'POST',

            headers:{'Content-Type':'application/x-www-form-urlencoded'},        
            }).success(function(resp) 
                      {
                        	$scope.stores=resp;	
							if(storeName=='')
							$scope.srch.Owner_Name = $scope.stores[0];
							else
							$scope.srch.Owner_Name = storeName;
                        });//success ends here		
};




//get categories

$scope.categories = function()
{
	
		$http({
            url:baseurl+"Requestdispatcher/getcatego",
            method:'POST',

            headers:{'Content-Type':'application/x-www-form-urlencoded'},        
            }).success(function(resp) 
                      {
                        	$scope.categ=resp;	
							$scope.srch.Category = $scope.categ[0];

							
                        });//success ends here		
};


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//$scope.getordersbyfilter=function(store,orderid,orderstatus,fromdate,todate)
$scope.getordersbyfilter = function(todate)
{
	// i had faced a problem that when a user clicks on the search button am able to 
	//fetch the data but it is not showing the filters with which user had searched
	//to store them i had used the below variable frmdata and tdated.
	
	
	var frmdate = '';
	var todated ='';

	if($scope.srch!=null)
	{
		console.log($scope.srch.OrderedOn); 
	
	var orderon = $scope.srch.OrderedOn;
	var todate = $scope.srch.todate;
	
	if($scope.srch.OrderedOn!='')	
	{
		//converted the date format to Y-m-d
		
		var date = new Date($scope.srch.OrderedOn),
        mnth = ("0" + (date.getMonth()+1)).slice(-2),
        day  = ("0" + date.getDate()).slice(-2);
   	 $scope.srch.OrderedOn= [ date.getFullYear(), mnth, day ].join("-");
	
	console.log($scope.srch.OrderedOn);	
	
	frmdate = $scope.srch.OrderedOn;
	
	}
	
	
	if($scope.srch.todate!='')	
	{
		//converted the date format to Y-m-d
		var date = new Date($scope.srch.todate),
        mnth = ("0" + (date.getMonth()+1)).slice(-2),
        day  = ("0" + date.getDate()).slice(-2);
    	$scope.srch.todate= [ date.getFullYear(), mnth, day ].join("-");
		
		todated =$scope.srch.todate;
	
	}
	$scope.loader=true;
	
	var store_name = $scope.srch.Owner_Name['Store'];
	var store_id = $scope.srch.Owner_Name['ID'];
	
	var selected_store = [{'ID':store_id,'Store':store_name}];
	
	if( store_name =='Select Store')
	{
		$scope.srch.Owner_Name = '';
	}
	else
		$scope.srch.Owner_Name = store_name;	

//i tried to send the $scope.srch json but it is not going as i wished so i had prepared my own format and i sent that to the server


	var data ={'filter':{"OrderedOn":frmdate,"todate":todated,"todate":todated,'Category':$scope.srch.Category,'Product':$scope.srch.Product,'Owner_Name':$scope.srch.Owner_Name,'OrderStatus':$scope.srch.OrderStatus,'OrderId':$scope.srch.OrderId}};


	
	 $http({
						url:baseurl+"Requestdispatcher/getordersbyfilter",
						method:'POST',
						//data:{"filter":$scope.srch},
						data:data,
						headers:{'Content-Type':'application/x-www-form-urlencoded'},  
						}).success(function(resp) 
								  {
									 
										$scope.loader=false;
										$scope.listorders=resp;
										
										for (var key in $scope.stores) 
										{
											if( $scope.stores[key].ID == store_id)
											{
											$scope.srch.Owner_Name =$scope.stores[key];		
											}
										}
										
									});//success ends here
		
		$scope.srch.OrderedOn = orderon;
		$scope.srch.todate = todate;
		
		//once the response comes back i had shown the dates with which the user had searched by using the above two line
		
	
	};


	

};


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/* 
when user clicks on the Download Excel button below code will executes 
we will send the whole form data to the download_orders_by_excelsheet method of Requestdispatcher controller
*/
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$scope.download_orders_by_excelsheet = function()
{
	var frmdate = '';
	var todated ='';
	if($scope.srch!=null)
	{
		//console.log($scope.srch.OrderedOn); 
	//	console.log($scope.srch.todate); 
	
	var orderon = $scope.srch.OrderedOn;
	var todate = $scope.srch.todate;
	
	if($scope.srch.OrderedOn!='')	
	{
		var date = new Date($scope.srch.OrderedOn),
        mnth = ("0" + (date.getMonth()+1)).slice(-2),
        day  = ("0" + date.getDate()).slice(-2);
   	 $scope.srch.OrderedOn= [ date.getFullYear(), mnth, day ].join("-");
	frmdate = $scope.srch.OrderedOn;
	
	console.log($scope.srch.OrderedOn);	
	}
	
	
	if($scope.srch.todate!='')	
	{
		var date = new Date($scope.srch.todate),
        mnth = ("0" + (date.getMonth()+1)).slice(-2),
        day  = ("0" + date.getDate()).slice(-2);
    	$scope.srch.todate= [ date.getFullYear(), mnth, day ].join("-");

		todated =$scope.srch.todate;
		console.log($scope.srch.todate);	
	}
	//
	
	var store_name = $scope.srch.Owner_Name['Store'];
	var store_id = $scope.srch.Owner_Name['ID'];
	
	var selected_store = [{'ID':store_id,'Store':store_name}];
	
	if( store_name =='Select Store')
	{
		$scope.srch.Owner_Name = '';
	}
	else
		$scope.srch.Owner_Name = store_name;	
	
	$scope.loader=true;
	
	console.log(frmdate);
	console.log(todated);
	
	/*
	{"filter":
				{"OrderedOn":"2017-01-31T18:30:00.000Z","todate":"2017-02-28T18:30:00.000Z","Category":{"CategoryID":"0","Category_Name":"Select Category"},"Owner_Name":""}}:
				*/
	
	
	//var data ={'filter':{"OrderedOn":frmdate,"todate":todated,"todate":todated,'Category':$scope.srch.Category,'Owner_Name':$scope.srch.Owner_Name}};
	var data ={'filter':{"OrderedOn":frmdate,"todate":todated,"todate":todated,'Category':$scope.srch.Category,'Product':$scope.srch.Product,'Owner_Name':$scope.srch.Owner_Name,'OrderStatus':$scope.srch.OrderStatus,'OrderId':$scope.srch.OrderId}};
				
	
	 $http({
			url:baseurl+"Requestdispatcher/download_orders_by_excelsheet",
			method:'POST',
			//data:{"filter":$scope.srch},
			data:data,
			headers:{'Content-Type':'application/x-www-form-urlencoded'},  
			}).success(function(resp) 
					  {
						///  return false;
							
							if(resp!="no data")
							{
								location.href=baseurl+resp;
								
								setTimeout(
											$http({
														url:baseurl+"Requestdispatcher/deleteexcelsheet",
														method:'POST',
														data:{"excelname":resp},
														headers:{'Content-Type':'application/x-www-form-urlencoded'},  
														 }).success(function() { 	$scope.loader=false; })
											,1000);
							
							//in response we get the excel file name
								
							//once the excel workbook gets downloaded, i had made a call to the Requestdispatcher controller deleteexcelsheet method
							//and deletes the same excel workbook which has stored in the server
						
							}
							else
								alert("No orders found");
							
		
							
							
							for (var key in $scope.stores) 
							{
								if( $scope.stores[key].ID == store_id)
								{
									$scope.srch.Owner_Name =$scope.stores[key];		
								}
							}
						});//success ends here
		
		$scope.srch.OrderedOn = orderon;
		$scope.srch.todate = todate;
		
	
	};


	

	
};


//download the products under an order

$scope.download_orderd_product_excelsheet = function(orderid)
{
	
	$http({
			url:baseurl+"Requestdispatcher/download_orderd_product_excelsheet",
			method:'POST',
			data:{"orderid":orderid},
			headers:{'Content-Type':'application/x-www-form-urlencoded'},  
		}).success(function(resp) { 
									//return false;	
										if(resp!="no data")
										{
											location.href=baseurl+resp;
											
												setTimeout(
																$http({
																			url:baseurl+"Requestdispatcher/deleteexcelsheet",
																			method:'POST',
																			data:{"excelname":resp},
																			headers:{'Content-Type':'application/x-www-form-urlencoded'},  
																		}).success(function() { })
															,10000);
											
										}
										else
										alert("No orders found");
		});
	
};


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/* 
when user clicks on the Download Excel button below code will executes 
we will send the whole form data to the download_orders_by_excelsheet method of Requestdispatcher controller
*/
//ends here
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





/* get the products which are ordered in an order*/

$scope.getAllproductsperorder=function(orderid)
									{ 
										$http({
												url:baseurl+"Requestdispatcher/getAllproductsperorder",
												method:'POST',
												data:{"orderid":orderid},
												headers:{'Content-Type':'application/x-www-form-urlencoded'}
												}).success(function(resp) { 
																			$scope.Allproductsperorder = resp;
																			var len = ($scope.Allproductsperorder.length)-1;
																			$scope.TotalAmount= $scope.Allproductsperorder[len].TotalAmount;
																			$scope.selectedItem = $scope.Allproductsperorder[0].Status;//'Change Status';
																			$scope.orderID =$scope.Allproductsperorder[len].OrderId;
																			
																			 
																			//if($scope.Allproductsperorder[0].Status == "Awaiting" || $scope.Allproductsperorder[0].Status == "Delivered" || $scope.Allproductsperorder[0].Status =="Cancelled" )
																			if($scope.Allproductsperorder[0].Status == "Awaiting" || $scope.Allproductsperorder[0].Status == "Delivered"  )
																			{
																				$scope.showstatus= false;	
																				console.log($scope.Allproductsperorder[0].Status);
																			}
																			else
																			{
																				$scope.showstatus= true;	
																				console.log("Hey"+$scope.Allproductsperorder[0].Status);
																			}
																		if($scope.Allproductsperorder[0].Status == "Shipped")	
																		{
																			$scope.disp_not=false;
																		}
																		
																		if($scope.Allproductsperorder[0].Status == "Confirmed"	)
																		{
																			$scope.selectedItem = 'Change Status';
																		}
																			
																			
																			});	
									};	

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//get  products for select box
// below function will call a method getprodcts from the Requestdispatcher controller
//please go at that place you can find the inline documentation there


$scope.products = function()
{
	$http({
            url:baseurl+"Requestdispatcher/getprodcts",
            method:'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded'},        
            }).success(function(resp) 
                      {
                        	$scope.prdcts=resp;	
							$scope.srch.Product = $scope.prdcts[0];

							
                        });//success ends here		
}

///coded on 20-03-2017by sudhaker 
// to get the orders which has to be delivered today


$scope.getAllorderstobedelivered = function()
{
	// $scope.todaydelivered_orders= 
	
	$http({
			url:baseurl+"Requestdispatcher/getAllorderstobedelivered",
            method:'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded'},        
			}).success(function(resp){
										
										//console.log(resp.length);
										if(resp.length=="0")
										{
											$scope.todaydelivered_orders = {'nodata':'yes'};
											//console.log("hye"+$scope.todaydelivered_orders);
										}
				 						else
										{
												$scope.todaydelivered_orders= resp;
												//console.log("hey"+$scope.todaydelivered_orders);
										}
										
										});
	
}




$scope.sort = function(keyname){
        $scope.sortKey = keyname;   //set the sortKey to the param passed
        $scope.reverse = !$scope.reverse; //if true make it false and vice versa
    }


});//controller ends here