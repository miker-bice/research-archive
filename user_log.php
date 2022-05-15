<?php
require 'config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;
require ISLOGIN;// check kung nakalogin
$page_title ="USER LOG";

// kung pareho user admin at registrar ang magaccess
if(!($g_user_role[0] == "ADMIN")){ 
    header("Location: ".BASE_URL); //balik sa login then sa login aalamain kung anung role at saang page landing dapat
    exit();
}

//kung gusto na admin lang page ito ang gamitin.
/*
if(!($g_user_role[0] != "ADMIN")){ 
    header("Location: ".BASE_URL); //balik sa login then sa login aalamain kung anung role at saang page landing dapat
    exit();
}
*/

?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
    include DOMAIN_PATH."/app/global/meta_data.php";
    include DOMAIN_PATH."/app/global/include_top.php";

?>

</head>

<body data-layout="detached">
    <!-- HEADER -->
  <?php include DOMAIN_PATH."/app/global/top_bar.php"; ?>     <!--topbar -->
    <div class="container-fluid active">
        <div class="wrapper in">
            <!-- BEGIN CONTENT -->
            <!-- SIDEBAR -->
            <?php include DOMAIN_PATH."/app/global/sidebar.php"; ?>
            <!--END SIDEBAR-->
            <!-- PAGE CONTAINER-->
            <div class="content-page">
                <div class="content">
                    <!-- BEGIN PlACE PAGE CONTENT HERE -->
                   
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo $page_title; ?></h4>
                                        <div id="example-table"></div>
                                         <button id="download-csv">Download CSV</button>
                                                        <button id="download-json">Download JSON</button>
                                                        <button id="download-xlsx">Download XLSX</button>
                                                        <button id="print-table">Print</button>
                                    </div>
                                </div>

                            </div> <!-- end col-->
                        </div>



                    <!-- END PLACE PAGE CONTENT HERE -->
                </div>
            </div>
            <!-- END CONTENT -->
        </div>
    </div>
    <!-- all the js files -->
    <!-- bundle -->
<?php  include FOOTER_PATH; ?>
</body>
<?php include DOMAIN_PATH."/app/global/include_bottom.php"; ?>
<script>

(function(){ 
var total_record =0;
function record_details(values, data, calcParams) { 
	if (values && values.length) {
       
	
      return values.length + ' of '+total_record;
	}
 }
var table = new Tabulator("#example-table", {
     ajaxSorting:true,  
    ajaxFiltering:true,
    height:"500px",
    tooltips:true,
    printAsHtml:true,
    headerFilterPlaceholder:"",
    layout:"fitColumns",
    placeholder:"No Data Found",
    movableColumns:true,
    selectable:false, 
    ajaxURL:"<?php echo BASE_URL;?>app/user_log_table.php", 
    ajaxProgressiveLoad:"scroll",
    ajaxProgressiveLoadScrollMargin:1,
	ajaxLoaderLoading: 'Fetching data from Database..',
    printConfig:{
        columnGroups:false, 
        rowGroups:false,
    },

    columns:[
		{title:"DATE LOGIN", field:"login_date", bottomCalc:record_details, titlePrint:"Login", sorter:"string",headerFilter:"input",headerFilterLiveFilter: false},
        {title:"DATE LOGOUT", field:"logout_date", titlePrint:"Logout", sorter:"string",headerFilter:"input",headerFilterLiveFilter: false},
        {title:"NAME", field:"name", titlePrint:"Name", sorter:"string",headerFilter:"input",headerFilterLiveFilter: false},
        {title:"IP", field:"ip_address", titlePrint:"IP address", sorter:"string",headerFilter:"input",headerFilterLiveFilter: false},
        {title:"DEVICE", field:"device",  titlePrint:"Device", sorter:"string",headerFilter:"input",formatter:"textarea",headerFilterLiveFilter: false},
		
       
 
    ],ajaxResponse:function(url, params, response){    
		if(response.total_record){
			total_record = response.total_record;
		}
        return response; 
	},ajaxRequesting: function (url, params) {
		if(typeof this.modules.ajax.showLoader() != "undefined" ){
			this.modules.ajax.showLoader();
		}
	},
});

addListener(document.getElementById('download-csv'), "click", function() {
        table.download("csv", "activity_log_"+getFormattedTime()+".csv");
});
addListener(document.getElementById('download-json'), "click", function() {
        table.download("json", "activity_log_"+getFormattedTime()+".json");
});
addListener(document.getElementById('download-xlsx'), "click", function() {
        table.download("xlsx", "activity_log_"+getFormattedTime()+".xlsx");
});
addListener(document.getElementById('print-table'), "click", function() {
         table.print(false, true);

});

function add_overlay(){
	var body = document.querySelector('body');	
	var overlay = document.querySelector('.overlay');	
	if(overlay){
	}else{
		var div = document.createElement('div');
		div.className = "overlay";
		body.appendChild(div);
	}
}
add_overlay();
$(document).on({
	ajaxStart: function(){
		addClass(document.querySelector('body'),'loading');
		isPaused = true;
	},
	ajaxStop: function(){ 
		removeClass(document.querySelector('body'),"loading");
		isPaused = false;
	}    
});

})();
addClass(document.getElementById('sub_admin_log'),'sub_active_menu');
</script>
</html>