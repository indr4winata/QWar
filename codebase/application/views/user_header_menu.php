<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<div class="profile-block orbitron clearfix">
				<?php $profile = Auth::getLoggedInUserInfo(); ?>
				<div class="pull-left" style="margin-top:10px">
					<a href="<?php echo site_url();?>"><h1 class=""><strong>Q-WAR</strong></h1></a>
				</div>
				<div class="pull-right relativepos">
					<div  type="button" data-toggle="dropdown" class="profile-image" style="background-image: url(<?php 
						echo site_url("profilepicture/get/".$profile['user_id']."");
					?>);">
					</div>
					<!-- <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						Action <span class="caret"></span>
					  </button> -->
					  <ul class="dropdown-menu" role="menu">
						<li><a href="<?php echo site_url('user/profile/'.$profile['user_id']);?>" target="_blank">Profile</a></li>
						<li><a href="<?php echo site_url('home/logout') ?>">Logout</a></li>
					  </ul>
				</div>
				<div class="pull-right" style="margin-right:20px;">
					 <h3 style="margin-bottom: 0;"><?php echo $profile["name"] ?></h3>
					 <p class="text-right" style="margin-bottom: 0;margin-top:0;"><small>Lv: <?php echo convert_exptolevel($profile['experience']); ?></small></p>
					 <div class="relativepos">
						<div class="progress">
								<!-- <span class="sr-only">45% Complete</span> -->
							<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?php echo percentage_user_exp($profile['experience']); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo percentage_user_exp($profile['experience']); ?>%">
							</div>
						</div>
					 </div>
				</div>
			</div>
		</div>
	</div>
</div>
