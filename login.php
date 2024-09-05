<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
	<title>Social Media Networking</title>
    <link rel="icon" href="images/fav.png" type="image/png" sizes="16x16"> 
    
    <link rel="stylesheet" href="css/main.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/color.css">
    <link rel="stylesheet" href="css/responsive.css">

     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      
 <script type="text/javascript" src='https://www.google.com/recaptcha/api.js'></script>
 <link rel="stylesheet" type="text/css" href="https://unpkg.com/slick-loader@1.1.20/slick-loader.min.css">
<script src="https://unpkg.com/slick-loader@1.1.20/slick-loader.min.js"></script>

</head>
<body>
<!--<div class="se-pre-con"></div>-->
<div class="theme-layout">
	<div class="container-fluid pdng0">
		<div class="row merged">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="land-featurearea">
					<div class="land-meta">
						<h1>Social Media </h1>
						<p>
							
						</p>
						<div class="friend-logo">
							<span><img src="images/wink.png" alt=""></span>
						</div>
						<a href="#" title="" class="folow-me">Follow Us on</a>
					</div>	
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="login-reg-bg">
					<div class="log-reg-area sign">
						<h2 class="log-title">Login</h2>
							
						<form method="post" id="login">
							<div class="form-group">	
							  <input type="text" id="input"  name="email" required="required"/>
							  <label class="control-label" for="input">Username</label><i class="mtrl-select"></i>
							</div>
							<div class="form-group">	
							  <input type="password" required="required" name="password" />
							  <label class="control-label" for="input">Password</label><i class="mtrl-select"></i>
							</div>
							
							<div class="submit-btns">
								<button class="mtr-btn signin" type="submit"><span>Login</span></button>
								<button class="mtr-btn signup" type="button"><span>Register</span></button>
							</div>
						</form>
					</div>
					<div class="log-reg-area reg">
						<h2 class="log-title">Register</h2>
							
						<form method="post" id="reg" >
							<div class="form-group">	
							  <input type="text" required="required" name="firstname" />
							  <label class="control-label" for="input">First  Name</label><i class="mtrl-select"></i>
							</div>
							<div class="form-group">	
							  <input type="text" required="required" name="lastname"/>
							  <label class="control-label" for="input">Last Name</label><i class="mtrl-select"></i>
							</div>
							<div class="form-group">	
							  <input type="text" required="required" name="email"/>
							  <label class="control-label" for="input">User Email</label><i class="mtrl-select"></i>
							</div>
							<div class="form-group">	
							  <input type="password" required="required" name="password" />
							  <label class="control-label" for="input">Password</label><i class="mtrl-select"></i>
							</div>
							<div class="form-radio">
							  <div class="radio">
								<label>
								  <input type="radio" name="gender" value="Male" checked="checked"/><i class="check-box"></i>Male
								</label>
							  </div>
							  <div class="radio">
								<label>
								  <input type="radio" name="gender" value="Female"/><i class="check-box"></i>Female
								</label>
							  </div>
							</div>
							
							<a href="#" title="" class="already-have">Already have an account</a>
							<div class="submit-btns">
								<button class="mtr-btn" type="submit"><span>Register</span></button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	<?php $root = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
$root .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);?>
	</script><script src="js/main.min.js"></script>
	<script src="js/script.js"></script>

	<script>
  
    var _base_url_='<?php echo $root;?>';
    $('#login').submit(function(e) {

    
        e.preventDefault()
        SlickLoader.enable();
        
        $.ajax({
            url: 'classes/Login.php?f=user_login',
            method: 'POST',
            data: $(this).serialize(),
            error: err => {
                console.log(err)

            },
            success: function(resp) {
            		SlickLoader.disable();
            	  var resp = JSON.parse(resp);
                if (resp) {
                    
                    if (resp.status == 'success') {
                        location.replace(_base_url_);
                    } else if (resp.status == 'incorrect') {
                        Swal.fire('Opps!','<div class="alert alert-danger text-center">Invalid Email OR Password</div>', 'error');
                        $('[name="email"]').focus();
                    }
                    //end_loader()
                }
            }
        })
    })


    $('#reg').submit(function(e) {

    	
        e.preventDefault()
        SlickLoader.enable();
        
        $.ajax({
            url: 'classes/Login.php?f=registration',
            method: 'POST',
            data: $(this).serialize(),
            error: err => {
                console.log(err)

            },
            success: function(resp) {
            	SlickLoader.disable();

            	  var resp = JSON.parse(resp);
                if (resp) {
                    
                    if (resp.status == 'success') {
                        location.replace(_base_url_);
                    } else if (resp.status == 'failed') {
                        Swal.fire('Opps!','<div class="alert alert-danger text-center">'+resp.msg+'</div>', 'error');
                        $('[name="email"]').focus()
                    }
                    //end_loader()
                }
            }
        })
    })
</script>

</body>	

</html>