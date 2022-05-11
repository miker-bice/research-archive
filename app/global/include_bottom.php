<?php
/** 
==================================================================
 File name   : include_bottom.php
 Version     : 1.2
 Begin       : 2021-01-15
 Last Update : 2022-04-07
 Author      : Alvin M. Montiano
 Description : include all javascript need to load.
 =================================================================
**/
?>

<script type='text/javascript' src="<?php echo BASE_URL;?>js/app.js?v=<?php echo FILE_VERSION;?>"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/sweetalert2.js?v=<?php echo FILE_VERSION;?>"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/polyfill.min.js?v=<?php echo FILE_VERSION;?>"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/daterangepicker.js?v=<?php echo FILE_VERSION;?>"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/summernote-bs4.js?v=<?php echo FILE_VERSION;?>"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/katex.min.js?v=<?php echo FILE_VERSION;?>"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/summernote-math.js?v=<?php echo FILE_VERSION;?>"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/tabulator.min.js?v=<?php echo FILE_VERSION;?>"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/excel.js?v=<?php echo FILE_VERSION;?>"></script>
<script type='text/javascript' src='<?php echo BASE_URL;?>js/fullcalendar.js?v=<?php echo FILE_VERSION;?>'></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/selectize.js?v=<?php echo FILE_VERSION;?>"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/validate_mod.js?v=<?php echo FILE_VERSION;?>"></script>
<script type='text/javascript' src='<?php echo BASE_URL;?>js/main.js?v=<?php echo FILE_VERSION;?>'></script>
<script>
function msg_modal(title,msg,type){
  Swal.fire(title,msg,type);
}
const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  onOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

function error_notif(value="",options){
	opt = {position:'top-end',timer:3000,confirm:false,progress:true,bg:"#bd362f"};
	if(!jQuery.isEmptyObject(options)){ // true)
	    for (var prop in opt) {
	        // skip loop if the property is from prototype
	        if (!opt.hasOwnProperty(prop)) continue;
	        if(options.hasOwnProperty(prop)){
	        	opt[prop] = options[prop];
	        }
	       
	    }
	}

	Toast.fire({
	  icon: 'error',
	  position: opt.position,
	  showConfirmButton: opt.confirm,
	  timer: opt.timer,
	  timerProgressBar: opt.progress,
	  background:opt.bg,
	  title: value
	})
}


function success_notif(value="",options){
	opt = {position:'top-end',timer:3000,confirm:false,progress:true,bg:"#51a351"};
	if(!jQuery.isEmptyObject(options)){ // true)
	    for (var prop in opt) {
	        // skip loop if the property is from prototype
	        if (!opt.hasOwnProperty(prop)) continue;
	        if(options.hasOwnProperty(prop)){
	        	opt[prop] = options[prop];
	        }
	       
	    }
	}

	Toast.fire({
	  icon: 'success',
	  position: opt.position,
	  showConfirmButton: opt.confirm,
	  timer: opt.timer,
	  timerProgressBar: opt.progress,
	  background:opt.bg,	  title: value
	})
}

function warning_notif(value="",options){

	opt = {position:'top-end',timer:3000,confirm:false,progress:true,bg:"#f89406"};
	if(!jQuery.isEmptyObject(options)){ // true)
	    for (var prop in opt) {
	        // skip loop if the property is from prototype
	        if (!opt.hasOwnProperty(prop)) continue;
	        if(options.hasOwnProperty(prop)){
	        	opt[prop] = options[prop];
	        }
	       
	    }
	}
	Toast.fire({
	  icon: 'warning',
	  position: opt.position,
	  showConfirmButton: opt.confirm,
	  timer: opt.timer,
	  timerProgressBar: opt.progress,
	  background:opt.bg,
	  title: value
	})
}


function info_notif(value="",options){

	opt = {position:'top-end',timer:3000,confirm:false,progress:true,bg:"#2f96b4"};
	if(!jQuery.isEmptyObject(options)){ // true)
	    for (var prop in opt) {
	        // skip loop if the property is from prototype
	        if (!opt.hasOwnProperty(prop)) continue;
	        if(options.hasOwnProperty(prop)){
	        	opt[prop] = options[prop];
	        }
	       
	    }
	}
	Toast.fire({
	  icon: 'info',
	  position: opt.position,
	  showConfirmButton: opt.confirm,
	  timer: opt.timer,
	  timerProgressBar: opt.progress,
	  background:opt.bg,
	  title: value
	})
}

</script>