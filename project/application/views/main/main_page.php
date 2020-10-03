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
	.login-form form {
		color: #7a7a7a;
		border-radius: 2px;
    	margin-bottom: 15px;
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
		background:#2481BF;
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
	.login-form form a {
		color: #7a7a7a;
		text-decoration: none;
	}
	.login-form form a:hover {
		text-decoration: underline;
	}
	hr{
	    background-color:white;
	    width:100%;
	    height:2px;
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
  </style>
</head>
<body>
	<div class="bg-image"></div>
	<div class="login-form box-item">
	    <form action="<?php echo base_url("index.php/Otp/add_med"); ?>" method="post">
	    	<h2 class="text-center">Add Your Medication</h2>
	    	<div class="form-group">
	       		<b>Medication</b>
	        	<input type="text" class="form-control" name="m_name" placeholder="Medication name" required="required">
	        </div>
	       <div class="form-group">
	       		<b>Dosage</b>
	        	<input type="text" class="form-control" name="dosage" placeholder="Dosage" required="required">
	        </div>
	        <div class="form-group">
	        	<label class="checkbox-inline"><input type="checkbox" name="intake" value="meal">Take With Meal</label>
	        </div>
	        <div class="form-group">
	      	<b>Time(s) per day</b>
		        <div>
				  <select id="days" name="intake_in_day">
				    <option value="1">1</option>
				    <option value="2">2</option>
				    <option value="3">3</option>
				    <option value="4">4</option>
				    <option value="5">5</option>
				  </select>
  				</div>
			</div>
			<script type="text/javascript">
				$(document).ready(function(){
					$("#days").mouseup(function(){
						$('.dest').remove();
						var i = $("#days option:selected").val();
						for(var j = 0;j < i;j++){
							$("#dynamic").append('<div style="margin-top:5px;" class="dest" id="row'+j+'"><input type="time" id="'+j+'" name="appt[]" value="time'+j+'" required></div>');
						}
					})
				})
			</script>
			<b>Recurrence</b>
			<div id="dynamic" class="form-group">
		        
			</div>
			<div class="form-group">
				<label class="radio-inline m"><input type="radio" name="optradio" value="onceevery">Once every</label>
				<select name="once_day" class="">
				    <option value="1">1</option>
				    <option value="2">2</option>
				    <option value="3">3</option>
				    <option value="4">4</option>
				    <option value="5">5</option>
				    <option value="6">6</option>
				    <option value="7">7</option>
			  	</select>
			  	<label class="inline">Day</label>
			</div>
            <hr>
			<div class="form-group">
				<label class="radio-inline m"><input type="radio" name="optradio" value="weekly" checked>Once per day</label>
			</div>
			<div style="margin-left:15px;" class="form-group">
				<label class="checkbox-inline"><input name=week[] type="checkbox" value="mon">Mon</label>
				<label class="checkbox-inline"><input name=week[] type="checkbox" value="tues">Tues</label>
				<label class="checkbox-inline"><input name=week[] type="checkbox" value="wed">Weds</label>
				<label class="checkbox-inline"><input name=week[] type="checkbox" value="thurs">Thurs</label>
				
				

			</div>
			<div style="margin-left:15px;" class="form-group">
			    <label class="checkbox-inline"><input name=week[] type="checkbox" value="fri">Fri</label>
				<label class="checkbox-inline"><input name=week[] type="checkbox" value="sat">Sat</label>
				<label class="checkbox-inline"><input name=week[] type="checkbox" value="sun">Sun</label>
			</div>
			<hr>
			<div class="form-group">
				<label class="radio-inline m"><input type="radio" name="optradio"  value="oncemonth">Once a month</label>
			</div>	
			<div class="form-group">
	            <button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
	        </div>
	        
	    </form>
	</div>




</body>
</html>
