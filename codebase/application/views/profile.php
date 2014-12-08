<?php include('general/header.php') ?>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <canvas id="stage"></canvas>

        <div class="content-front">
			<?php $this->load->view('user_header_menu');?>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="profile-page">
                            <div class="row">
                                <div class="col-sm-4 profile-left">
                                    <h1 class="orbitron text-center">User Profile</h1>
                                    <div class="profile-big" style="background-image: url(<?php 
                                        echo site_url("profilepicture/get/".$user['user_id']."");
                                    ?>);">
                                    </div>
                                    <h2 class="text-center"><?php echo $user['name']; ?></h2>
                                    <p class="text-center">Lv. <?php echo convert_exptolevel($user['experience']); ?></p>
                                    <div class="boxing">
                                        <div>Exp: </div>
                                        <div class="progress" title="<?php echo percentage_user_exp($user['experience']); ?>%">
                                          <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?php echo percentage_user_exp($user['experience']); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo percentage_user_exp($user['experience']); ?>%">
                                            <span class="sr-only"><?php echo percentage_user_exp($user['experience']); ?>% Complete (warning)</span>
                                          </div>
                                        </div>
										<div class="row">
											<div class="col-sm-6">
												<div>Hp: </div>
												<h2><strong><?php echo $user['hp'] ?></strong></h2>
											</div>
											<div class="col-sm-6">
												<div>Atk damage: </div>
												<h2><strong><?php echo $user['attack'] ?></strong></h2>
											</div>
										</div>
                                    </div>
                                </div>
                                <div class="col-sm-8 profile-right">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <h4 class="text-center">Win Rate</h4>
                                            <h1 class="text-center"><strong><?php echo $percentage_rank1;?>%</strong></h1>
                                        </div>
                                        <div class="col-sm-6">
                                            <h4 class="text-center">Games Played</h4>
                                            <h1 class="text-center"><strong><?php echo number_format($count_play);?></strong></h1>
                                        </div>
                                        <div class="clearfix"></div>
                                        <hr>
                                        <div class="panel panel-info">
                                          <!-- Default panel contents -->
                                          <div class="panel-heading">Last 10 Played Games</div>
										  <div style="height:245px;overflow:auto;">
                                          <!-- Table -->
                                          <table class="table table-striped">
											<?php if(count($usergame) == 0){ ?>
												<tr>
													<td>You have not played yet</td>
												</tr>
											<?php }else{ ?>
                                              <tr>
                                                 <th>No.</th>
                                                 <th>Rank</th>
                                                 <th>Score</th>
                                                 <th>Play Time</th> 
                                                 <th style="width:20px;"></th> 
                                              </tr>
												  <?php 
												  $i = 0;
												  foreach($usergame as $ug) { 
													$i++;
												  ?>
												  <tr>
													  <td><?php echo $i;?>.</td>
													  <td><?php echo numberToPlace($ug['rank_in_game']);?></td>
													  <td><?php echo number_format($ug['exp_gained']);?></td>
													  <td><?php echo date("n/j/Y H:i",strtotime($ug['played_date']) );?></td>
													  <td><a title="View Result" href="<?php echo site_url('game/result/'.$ug['guid']);?>"><i class="fa fa-list-alt"></i></a></td>
												  </tr>
												  <?php } ?>
											  <?php } ?>
                                          </table>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

		<?php $this->load->view('general/javascript');?>
		<?php $this->load->view('general/dotgraph');?>
        <script>
            $(document).ready(function(){
            });
        </script>
<?php $this->load->view('general/footer');?>
