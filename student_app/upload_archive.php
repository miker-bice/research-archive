<?php
require '../config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;
require VALIDATOR_PATH; // library for form validation
require ISLOGIN;// check kung nakalogin


$g_user_role = $session_class->getValue('role_id');

$csrf = new CSRF($session_class); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        include DOMAIN_PATH."/app/global/meta_data.php";
        include DOMAIN_PATH."/app/global/include_top.php";
    ?>

</head>
<link href="<?php echo BASE_URL;?>js/fine-uploader/fine-uploader-gallery.min.css?v=<?php echo FILE_VERSION;?>" rel="stylesheet">
<script src="<?php echo BASE_URL;?>js/fine-uploader/fine-uploader.min.js?v=<?php echo FILE_VERSION;?>"></script>
    <script type="text/template" id="qq-template">
        <div class="qq-uploader-selector qq-uploader qq-gallery" qq-drop-area-text="Drop files here">
            <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
                <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
            </div>
            <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                <span class="qq-upload-drop-area-text-selector"></span>
            </div>
            <div class="qq-upload-button-selector qq-upload-button">
                <div>Select a file</div>
            </div>
            <div>

            </div>
            <span class="qq-drop-processing-selector qq-drop-processing">
                <span>Processing dropped files...</span>
                <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
            </span>
            <ul class="qq-upload-list-selector qq-upload-list" role="region" aria-live="polite" aria-relevant="additions removals">
                <li>
                    <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
                    <div class="qq-progress-bar-container-selector qq-progress-bar-container">
                        <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                    </div>
                    <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                    <div class="qq-thumbnail-wrapper">
                        <img class="qq-thumbnail-selector" qq-max-size="120" qq-server-scale>
                    </div>
                    <button type="button" class="qq-upload-cancel-selector qq-upload-cancel">X</button>
                    <button type="button" class="qq-upload-retry-selector qq-upload-retry">
                        <span class="qq-btn qq-retry-icon" aria-label="Retry"></span>
                        Retry
                    </button>

                    <div class="qq-file-info">
                        <div class="qq-file-name">
                            <span class="qq-upload-file-selector qq-upload-file"></span>
                            <span class="qq-edit-filename-icon-selector qq-btn qq-edit-filename-icon" aria-label="Edit filename"></span>
                        </div>
                        <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
                        <span class="qq-upload-size-selector qq-upload-size"></span>
                        <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">
                            <span class="qq-btn qq-delete-icon" aria-label="Delete"></span>
                        </button>
                        <button type="button" class="qq-btn qq-upload-pause-selector qq-upload-pause">
                            <span class="qq-btn qq-pause-icon" aria-label="Pause"></span>
                        </button>
                        <button type="button" class="qq-btn qq-upload-continue-selector qq-upload-continue">
                            <span class="qq-btn qq-continue-icon" aria-label="Continue"></span>
                        </button>
                    </div>
                </li>
            </ul>

            <dialog class="qq-alert-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Close</button>
                </div>
            </dialog>

            <dialog class="qq-confirm-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">No</button>
                    <button type="button" class="qq-ok-button-selector">Yes</button>
                </div>
            </dialog>

            <dialog class="qq-prompt-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <input type="text">
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Cancel</button>
                    <button type="button" class="qq-ok-button-selector">Ok</button>
                </div>
            </dialog>
        </div>
    </script>
<body class="bg-white py-0">
    <!-- insert here the topbar -->
    <?php include DOMAIN_PATH."/app/global/top_bar.php"; ?>     <!--topbar -->

    <!-- insert here the navbar -->
    <?php  include MAIN_NAVBAR; ?>

    <!-- insert here the main content of the page -->
    <div class="main-content mt-3 container">
        <?php  include UPLOAD_ARCHIVE; ?>
    </div>
    
    <!-- insert here the footer -->
    <?php  include BOTTOM_BAR; ?>
    
</body>
<?php include DOMAIN_PATH."/app/global/include_bottom.php"; ?>
</html>


<script>
    // initialize summernote for ehader
    var div_header = document.getElementById('header_text');
    var div_header_editor = $(div_header).summernote({
        height: 200,
        dialogsFade: true,
        prettifyHtml: true,
        width: '100%',	
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['backcolor','forecolor']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert',['picture','link','video','hr','math']],
            ['table', ['table']],
            ['view', [ 'undo','redo','help']],
            ['height', ['height']]
        ]
    });	
    var header_text = $(div_header).summernote('code');
  //  $.post("url/to/process.php",{header:header_text,date:variable},function(){

    //});

    var manualUploader = new qq.FineUploader({
        element: document.getElementById("traditional-uploader"),
        autoUpload: false,
        warnBeforeUnload: true,
        validation: {
               allowedExtensions: ['pdf'],
               itemLimit: 1,
            },
        request: {
            endpoint: "<?php echo BASE_URL;?>app/research/research_action.php", 
        
        },
        chunking: {
            enabled: true,
            concurrent: {
                enabled: false
            },
            success: {
                endpoint: "<?php echo BASE_URL;?>app/research/research_action.php?done"
            }
        },
		cors:{
			sendCredentials:true
		},
        resume: {
            enabled: false
        },
        retry: {
            enableAuto: false,
            showButton: false,
			preventRetryResponseProperty:'preventRetry'
        },
        callbacks: {
        onError: function(id, name, errorReason, xhrOrXdr) {
            error_notif("Error :"+ errorReason);
			qq(manualUploader.getItemByFileId(id)).remove();
        },
		// onValidate: function(data) {
		// 	if (totalSizeSoFar + data.size > totalAllowedSize) {
		// 		error_notif("Error : Exceed Allowable File Size to Upload 20MB");
		// 		return false;
		// 	}
		// 	totalSizeSoFar += data.size;
		// },
        onAllComplete: function() {
			
			var tempA = manualUploader.getUploads({status: [qq.status.UPLOAD_SUCCESSFUL]});
			if(tempA.length > 0){
					success_notif("Successfully Saved");
					// setTimeout(function(){ refresh_aftersave(); }, 1000);
			}
			removeClass(document.querySelector('body'),"loading");
			//setTimeout(function(){ window.location.reload() }, 1000);
		},onSubmit: function (id, fileName) {
			
		},
		onManualRetry: function (id, fileName) {
			
		},
		onProgress: function(id, name, uploadedBytes, totalBytes) {
			 addClass(document.querySelector('body'),'loading');
		},
        }
    });

    const btnUpload = document.getElementById("submit-research");
    addListener(btnUpload, "click", function() {

        var research_title = (document.getElementById('research-title')) ? document.getElementById('research-title').value.trim() : '';
        var research_year = (document.getElementById('research-year')) ? document.getElementById('research-year').value.trim() : "";
        var research_abstract = div_header_editor.summernote('code');
        var research_abstact_text = $("<p>" + research_abstact_text + "</p>").text();
        var research_authors = (document.getElementById('research-authors')) ? document.getElementById('research-authors').value.trim() : "";

        var tempA = manualUploader.getUploads({status: [qq.status.SUBMITTED]});

        if (tempA.length <= 0) {
            warning_notif("please upload file");
            return;
        }
        if (research_title.trim() == ""){
            warning_notif("title upload file");
            return;
        }
        if (research_abstact_text.trim() == "") {
            warning_notif("body upload file");
            return;
        }


        manualUploader.setParams({
            "research-title": research_title, 'research-year': research_year, 'research-abstract':research_abstract, 'research-authors': research_authors, 'action': 'save'
        });
		manualUploader.uploadStoredFiles();
        
        // var g_title = document.getElementById('exam_title');
        // var g_instruc = document.getElementById('content_exam');
        
        // var action = parseInt(select.options[select.selectedIndex].value);
        // if(orig_examtype!="" && update_me ==true){
        //     action = orig_examtype;
        // }
        // var error = false;	
        // var error_msg ="";
        
        // var class_ids = $('#class_select').val();
        // if(class_ids ==  ""){
        //     error =true;
        //     error_msg += "Select Class!<br>";
        // }
        
        // if(!isNaN(action)){
        // }else{
        //     error =true;
        //     error_msg += "Select Type of Exam!<br>";
        // }
        
        // if(g_title.value.trim() == ""){
        //     error = true;
        //     error_msg += "Input Title is Required<br>";
        // }
        // if(g_instruc.value.trim() == ""){
        //     error = true;
        //     error_msg += "Input Instruction is Required<br>";
        // }
        
        // var send_title = g_title.value.trim();
        // var send_instruc = g_instruc.value.trim();
        
        // var i_startDate = $('#content_time').data('daterangepicker').startDate._d;
        // var i_endDate = $('#content_time').data('daterangepicker').endDate._d;
        

        // var limit_time = document.getElementById('limit_time').value;
        
        // if(i_startDate =="" || i_endDate==""){
        //     error =true;
        //     error_msg += "Select Start - End Date<br>";
        // }
        
        // var startDate= moment(i_startDate).format('YYYY-MM-DD HH:mm:ss'); 
        // var endDate= moment(i_endDate).format('YYYY-MM-DD HH:mm:ss'); 
        
        // if(i_startDate == "" || i_endDate ==""){
        //     error =true;
        //     error_msg += "Start and End date is Required!<br>";
        // }
	
	
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
        },
        ajaxStop: function(){ 
            removeClass(document.querySelector('body'),"loading");
        }    
    });
</script>