<?php require_once('config.php'); ?>

<?php require_once( "classes/Users.php"); require_once('classes/sess_auth.php'); ?>

<?php
$id=$_GET['userId'];

$user=$users->getUser($id);

$userId=$_settings->userdata('id');
$edit=0;
if($id==$userId):
	$edit=1;
endif;
?>

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
		<div class="feature-photo">
			<figure><img src="<?php echo (!empty($user['cover']))?$user['cover']:'images/resources/timeline-1.jpg';?>" alt=""></figure>
			<div class="add-btn">
				<span><?php echo $users->GetFollwer($id);?> followers</span>
				<?php 
					if($edit){

					}else{

						if($users->checkFollwer($id))
						{
							echo '<a href="'.base_url.'classes/Users.php?f=follow_member&&userId='.$user['id'].''.'" title="" class="underline">UNFOLLOW</a>';

						}else
							{
								echo '<a href="'.base_url.'classes/Users.php?f=follow_member&&userId='.$user['id'].''.'" title="" class="underline">FOLLOW</a>';

							}
				?>
				
			<?php }?>
			</div>
			<?php if($edit):?>
			<form class="edit-phto" id="edit-coverFrm">
				<i class="fa fa-camera-retro"></i>
				<label class="fileContainer">
					Edit Cover Photo
				<input type="file" name="img" id="edit-cover"/>
				</label>
			</form>
			<?php endif;?>
			<div class="container-fluid">
				<div class="row merged">
					<div class="col-lg-2 col-sm-3">
						<div class="user-avatar">
							<figure>
								<img src="<?php echo validate_image($user['avatar'],$user['gender']);?> " alt="">
								<form class="edit-phto" id="edit-displayFrm">
									<?php if($edit):?>
									<i class="fa fa-camera-retro"></i>
									<label class="fileContainer">
										Edit Display Photo
										<input type="file" name="img" id="edit-display" />
									</label>
								</form>
							<?php endif;?>
							</figure>
						</div>
					</div>
					<div class="col-lg-10 col-sm-9">
						<div class="timeline-info">
							<ul>
								<li class="admin-name">
								  <h5><?php echo $user['firstname'].' '.$user['lastname'];?></h5>
								  
								</li>
								<li>
									<a class="active" href="time-line.html" title="" data-ripple="">time line</a>
									
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section><!-- top area -->
		
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
								<?php if($edit):?>
								<div class="">
									<div class="central-meta item">
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
									</div>
									<?php endif;?>
									<?php 
									$id=$_GET['userId'];
       $qry = $conn->query("SELECT p.*, concat(m.firstname, ' ', coalesce(concat(m.middlename,' '),''),m.lastname) as `name`, m.avatar, COALESCE((SELECT count(member_id) FROM `like_list` where post_id = p.id),0) as `likes`, COALESCE((SELECT count(member_id) FROM `comment_list` where post_id = p.id),0) as `comments` FROM post_list p inner join `users` m on p.user_id = m.id WHERE p.user_id='$id' order by unix_timestamp(p.date_updated) desc");

       //$row = $qry->fetch_assoc();
 


       ?>

<div class="loadMore">
									<?php 


									 while($row = $qry->fetch_assoc()) {
										 $qry_like = $conn->query("SELECT post_id FROM `like_list` where post_id = '{$row['id']}' and member_id = '{$_settings->userdata('id')}'")->num_rows > 0;
 ?>
								<div class="central-meta item">
									<div class="user-post">
										<div class="friend-info">

											<figure>
												<img src="<?php echo validate_image($row['avatar'],$row['gender']);?>" alt="" >
											</figure>
											<div class="friend-name">
												<ins><a href="<?php echo base_url.'user-profile.php'?>?userId=<?php echo $row['user_id'];?>&&Token=<?php echo $_settings->test_cypher($row['user_id']);?>" title=""><?php echo ucfirst($row['name']);?></a></ins>
												<span>published: <?php echo time_ago($row['date_updated']);?></span>
											</div>
											<div class="post-meta">
												<div class="description">
													
													<p>
														<?php echo htmlentities($row['caption']);?>
													</p>
												</div>
												<?php if(!empty($row['upload_path'])){?>
												<img src="<?php echo $row['upload_path'];?>" style="height: 500px !important; width: 700px !important;" alt="">
											<?php }?>
												<div class="we-video-info">
													<ul>
														
														
														<li>
															
																
																


																 <?php if(isset($qry_like) && !! $qry_like): ?>
																 	<span class="like" data-toggle="tooltip" title="like" >
            <a href="javascript:void(0)" onclick="update_like('<?php echo $row['id'];?>',0)" ><i class="ti-heart "></i></a><ins><?= format_num($row['likes']) ?></ins></span>
            <?php else: ?>
            	<span class="dislike" data-toggle="tooltip" title="like" >
            <a href="javascript:void(0)" onclick="update_like('<?php echo $row['id'];?>',1)" ><i class="ti-heart"></i></a><ins><?= format_num($row['likes']) ?></ins></span>
            <?php endif; ?>
															
														</li>
														
														
													</ul>
												</div>
												
											</div>
										</div>
										
									</div>
								</div>
						<?php }?>
								</div>
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

	<script type="text/javascript">
		$('#edit-display').on('change', function(e){

			SlickLoader.enable();
			e.preventDefault();
            var _this = $('#edit-displayFrm')
			 //$('.err-msg').remove();
			//start_loader();
			$.ajax({
				url:"classes/Master.php?f=update_picture",
				data: new FormData($('#edit-displayFrm')[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                
				error:err=>{
					console.log(err)
					//alert_toast("An error occured",'error');
					//end_loader();
				},
				success:function(resp){
					
					location.reload()
				}
			})
		})
$('#edit-cover').on('change', function(e){

			SlickLoader.enable();
			e.preventDefault();
            var _this = $('#edit-coverFrm')
			 //$('.err-msg').remove();
			//start_loader();
			$.ajax({
				url:"classes/Master.php?f=update_cover",
				data: new FormData($('#edit-coverFrm')[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                
				error:err=>{
					console.log(err)
					
					//end_loader();
				},
				success:function(resp){
					location.reload()
					
				}
			})
		})
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
					
					//end_loader();
				},
				success:function(resp){
					location.reload()
					
					
					
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

				location.reload();

			}
		})
	}
	</script>
	