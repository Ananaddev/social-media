<?php require_once('config.php'); ?>

<?php

 require_once( "classes/Users.php");
 require_once('classes/sess_auth.php'); ?>



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
	
	
		
	<section>
		<div class="gap gray-bg">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<div class="row" id="page-contents">
							<div class="col-lg-3">
								<aside class="sidebar static">
									<div class="widget">
										<h4 class="widget-title">Shortcuts</h4>
										<ul class="naves">
											<li>
												<i class="ti-clipboard"></i>
												<a href="<?php echo base_url;?>" title="">News feed</a>
											</li>
											
											<li>
												<i class="ti-files"></i>
												<a href="<?php echo base_url.'user-profile.php'?>?userId=<?php echo $_settings->userdata('id');?>&&Token=<?php echo $_settings->test_cypher($_settings->userdata('id'));?>" title="">My Profile</a>
											</li>
											
											
											
											
											<li>
												<i class="ti-power-off"></i>
												<a href="<?php echo base_url;?>classes/login.php?f=user_logout" title="">Logout</a>
											</li>
										</ul>
									</div><!-- Shortcuts -->
									
									<div class="widget stick-widget">
										<h4 class="widget-title">Users</h4>
										<ul class="followers">
											<?php echo $users->follwer();?>
											
										</ul>
									</div><!-- who's following -->
								</aside>
							</div><!-- sidebar -->
							<div class="col-lg-6">
								<div class="central-meta">
									<div class="new-postbox">
										<figure>
											<img src="<?php echo validate_image($_settings->userdata('avtar'),$_settings->userdata('gender'));?>" alt="">
										</figure>
										<div class="newpst-input">
											<form method="post" id="SavePost" >
												<textarea rows="2" placeholder="write something" 
												name="caption"></textarea>
												<div class="attachments">
													<ul>
														
														<li>
															<i class="fa fa-image"></i>
															<label class="fileContainer">
																<input type="file" name="img">
															</label>
														</li>
														
														<li>
															<button type="submit">Post</button>
														</li>
													</ul>
												</div>
											</form>
										</div>
									</div>
								</div><!-- add post new box -->
								<div id="post"></div>
							</div><!-- centerl meta -->
							<div class="col-lg-3">
								<aside class="sidebar static">
									<!-- page like widget -->
								
									<div class="widget friend-list stick-widget">
										<h4 class="widget-title">FOLLOWNIG</h4>
										<div id="searchDir"></div>
										<ul id="people-list" class="followers">
											<?php echo $users->friends();?>
										</ul>
										
									</div><!-- friends list sidebar -->
								</aside>
							</div><!-- sidebar -->
						</div>	
					</div>
				</div>
			</div>
		</div>	
	</section>

	

</div>
			
	
	</script><script src="js/main.min.js"></script>
	<script src="js/script.js"></script>
	

	<script>
		
	$(document).ready(function(){

		$('#SavePost').submit(function(e){

			SlickLoader.enable();
			e.preventDefault();
            var _this = $(this)
			 //$('.err-msg').remove();
			//start_loader();
			$.ajax({
				url:"classes/Master.php?f=save_post",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					//end_loader();
				},
				success:function(resp){
					document.getElementById("SavePost").reset();
					load_post();
					
					
				}
			})
		})
		})
		function update_like(post_id, status){

		SlickLoader.enable();
		$.ajax({
			url:"classes/Master.php?f=update_like",
			method:'POST',
			data:{post_id : post_id, status:status},
			//dataType:'json',
			error:err=>{
				console.log(err)
				//alert_toast("Post Like has failed", 'error')
			},
			success:function(resp){

				load_post();
			}
		})
	}


function load_post()
 {

  

 
  $.ajax({
   url:"<?php echo base_url.'load-post.php';?>",
   type: 'GET',         // The HTTP method to use
   dataType: 'html',
 
   success:function(data)
   {
      //alert(data);
      SlickLoader.disable();
    $('#post').html(data);
       }
  });
 }
 load_post();
</script>

</body>	

</html>