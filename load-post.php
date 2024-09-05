
<?php require_once('config.php'); ?>

<?php require_once('classes/sess_auth.php'); ?>


 <?php 
       $qry = $conn->query("SELECT p.*, concat(m.firstname, ' ', coalesce(concat(m.middlename,' '),''),m.lastname) as `name`, m.avatar,m.gender, COALESCE((SELECT count(member_id) FROM `like_list` where post_id = p.id),0) as `likes`, COALESCE((SELECT count(member_id) FROM `comment_list` where post_id = p.id),0) as `comments` FROM post_list p inner join `users` m on p.user_id = m.id  WHERE user_id IN(SELECT friend_id FROM friends WHERE friend_id=p.user_id) OR user_id='{$_settings->userdata('id')}' order by unix_timestamp(p.date_updated) desc");

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