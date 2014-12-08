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
                        <div id="action-list">
                            <button type="button" class="btn btn-primary orbitron" data-toggle="modal" data-target="#myModal">
                              Create Room
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="roomlist">
                <div class="container"> 
                    <div class="row">
						<div class="row">
							<div class="col-sm-4">
								<h2 class="orbitron title">Room List</h2>
							</div>
							<div class="col-sm-8 text-right">
								<form method="get" id="formfilter">
								<div class="col-sm-4 col-sm-offset-4"><h2 class="orbitron title">Filter Difficulty</h2></div>
								<div class="col-sm-4">
									<select name="d" class="form-control" id="selectfilter">
										<option value="" <?php echo ($topic_difficulty=="")?'selected="selected"':"";?>>All Difficulties</option>
										<option value="easy" <?php echo ($topic_difficulty=="easy")?'selected="selected"':"";?>>Easy</option>
										<option value="medium" <?php echo ($topic_difficulty=="medium")?'selected="selected"':"";?>>Medium</option>
										<option value="hard" <?php echo ($topic_difficulty=="hard")?'selected="selected"':"";?>>Hard</option>
									</select>
								</div>
								</form>
							</div>
                        </div>
                        <?php 
                            if (isset($room)) {
                                foreach ($room as $roomlist) {
                                    ?>
                                    <div class="col-sm-3">
                                        <div class="room-box">
                                            <div class="room-title orbitron text-truncate"><strong><?php echo $roomlist['room_name'] ?></strong></div>
                                            <div class="room-text">

                                                <p>By: <a href="<?php echo site_url('user/profile/'.$roomlist['user_id']);?>" target="_blank"><?php echo $roomlist['name']; ?></a></p>
                                                <!-- <p>Total Players: 0/8</p> -->
                                                <p><?php echo $roomlist['topic_name']; ?></p>
												<p><?php echo $roomlist['topic_difficulty']; ?></p>
                                                <?php 
                                                    if ($roomlist['status']=='S') {
                                                        echo 'game on progress';
                                                    }
                                                    else{
                                                    ?>
                                                      <div class="text-right">
                                                        <a href="<?php echo site_url('game/in_room/'.$roomlist['guid']); ?>" class="btn btn-primary">Join</a>
                                                      </div>
                                                    <?php }
                                                 ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        ?>
                    </div>
                    <div class="row">
                        <nav>
                          <?php echo $pagination; ?>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal -->
		<?php $profile = Auth::getLoggedInUserInfo(); ?>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?php echo site_url('game/createroom') ?>" method="post" id="form_createroom">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Room Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Room Name" value="<?php echo $profile['name'] ?>'s Room">
                        </div>
                        <div class="form-group">
                            <label for="topic">Topic</label>
                            <select name="topic_id" id="topic" class="form-select" style="width: 100%;">
                                <?php 
                                    if (isset($topic)) {
                                        foreach ($topic as $topiclist) {
                                            ?>
                                                <option value="<?php echo $topiclist['topic_id'] ?>"><?php echo $topiclist['topic_name'] ?></option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <input type="submit" value="Create Room" class="btn btn-primary">
                    </div>
              </form>
            </div>
          </div>
        </div>

		<?php $this->load->view('general/javascript');?>
		<?php $this->load->view('general/dotgraph');?>
        <script>
            $(document).ready(function(){
                $('#form_createroom').ajaxForm({ 
                    // dataType identifies the expected content type of the server response 
                    dataType:  'json', 
             
                    // success identifies the function to invoke when the server response 
                    // has been received 
                    success:   processJson 
                });

                function processJson(data) { 
                    // 'data' is the json object returned from the server 
                    if(data.type =='success'){
                        window.location.replace("<?php echo site_url('game/in_room') ?>/"+data.message);
                    }
                    else{
                        $('.errMsg').html(data.message)
                    }
                }
				$("#selectfilter").change(function(){
					$("form#formfilter").submit();
				});
            });
        </script>
<?php $this->load->view('general/footer');?>
