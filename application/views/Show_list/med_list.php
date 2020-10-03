<!DOCTYPE html>
<html lang="en">
<head>
  <title>Website</title>

  <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/css/stylesheet.css")?>">
  <style type="text/css">
  	body, html {
		  height: 100%;
		}

	* {
	  box-sizing: border-box;
	}
	.box-item{
	position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 2;
}
	.form-control {
        min-height: 41px;
		background: #fff;
		box-shadow: none !important;
		border-color: #e3e3e3;
	}
	.form-control:focus {
		border-color: #70c5c0;
	}
    .form-control, .btn {        
        border-radius: 2px;
    }
	.login-form {
		width: 350px;
		margin: 0 auto;
		padding: 100px 0 30px;		
	}
	.login-form .fix-box {
		color: #7a7a7a;
		border-radius: 2px;
    	margin-bottom: 15px;
    	height:600px;
    			overflow-y:scroll;
        font-size: 13px;
        background: #ececec;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;	
        position: relative;	
    }
	.login-form h2 {
		font-size: 22px;
        margin: 35px 0 25px;
    }
	.login-form .avatar {
		position: absolute;
		margin: 0 auto;
		left: 0;
		right: 0;
		top: -50px;
		width: 95px;
		height: 95px;
		border-radius: 50%;
		z-index: 9;
		background:#2481BF;
		padding: 15px;
		box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
	}
	.login-form .avatar img {
		width: 100%;
	}	
    .login-form input[type="checkbox"] {
        margin-top: 2px;
    }
    .login-form .btn {        
        font-size: 16px;
        font-weight: bold;
		background: #2481BF;
		border: none;
		margin-bottom: 20px;
    }
	.login-form .btn:hover, .login-form .btn:focus {
		background: #2591BF;
        outline: none !important;
	}    
	.login-form a {
		color: #fff;
		text-decoration: underline;
	}
	.login-form a:hover {
		text-decoration: none;
	}
	.login-form fix-box a {
		color: #7a7a7a;
		text-decoration: none;
	}
	.login-form fix-box a:hover {
		text-decoration: underline;
	}
  	.bg-image {
	  /* The image used */
	  background-image: url("<?php echo base_url("assets/images/background.jpeg");?>");

	  /* Add the blur effect */
	  filter: blur(2px);
	  -webkit-filter: blur(2px);

	  /* Full height */
	  height: 100%;

	  /* Center and scale the image nicely */
	  background-position: center;
	  background-repeat: no-repeat;
	  background-size: cover;
	}
	.root_design{
        width:100%;
		position: relative;
		margin-bottom: 10px;

	}
	.text-box{

		
		width:200px;
		margin-bottom: 0px;
	}
	.text-box dt{
		font-size: 15px;

	}
	.text-box dd{
		font-size: 12px;
		margin-left:10px;
		
	}
	hr{
	    width:100%;
	    background-color:white;
	    margin: !important;
	    height:2px;
	    
	}
	.root_design button{
		position: absolute;
		top:0;
		right: 10;
		float: right;
	}
  </style>
</head>
<body>
	<div class="bg-image"></div>
    	<div class="login-form box-item">
		
        <div class="fix-box" >
		<form action="<?php echo base_url('index.php/Otp/Remove')?>" method="POST">
	        
    	        <b style="color:green;text-align: center;width: 100%;"><?php echo $this->session->userdata('success_message');?></b>
    	        <?php $this->session->unset_userdata('success_message');?>
    	    	<h2 class="text-center">Medicine Schedule</h2>
                <?php 
    			foreach($med_name as $m){
    			echo "<hr>";
    	    	echo "<div class='root_design'>
        	    	    <dl class='text-box'>
            	    	    <dt>".strtoupper($m['medication_name'])."</dt>
            	    	    <dd>Dose: ".strtoupper($m['dosage'])."</dd>
        	    	    </dl>
        	    	    <b style='margin:0px;'>Time(s) Per Day</b>
        	    	    <dd style='margin-left:10px;'>".strtoupper($m['time'])."</dd>
        	    	    <b style='margin:0px;'>Recurrence</b>
        	    	    <dd style='margin-left:10px;'>".$m['recurrence']."</dd>
        	    	    <button style='width:35px;height:35px;' name='delete' class='btn btn-primary' value='".$m['Id']."'>X</button>
    	    	    </div>"; 
        	    }; ?>
    		    <hr>
    		    
    		    
	    	
	    	 </form>
	    	 <a href="<?php echo base_url("index.php/Otp/main_menu");?>"><button style="text-align:center;width:100%;" name='delete' class='btn btn-primary' >Add Medication</button></a>
	    	  </div> 
	    	 
		</div>
		
	</div>	

	?>


</body>
</html>
