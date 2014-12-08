<?php include('general/header.php') ?>
<div id="fb-root"></div>
<script>
window.fbAsyncInit = function() {
    FB.init({
      appId      : '<?php echo FB_APP_ID;?>', // App ID
      status     : true, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      xfbml      : true  // parse XFBML
    });
};
// Load the SDK Asynchronously
(function(d){
    var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement('script'); js.id = id; js.async = true;
    js.src = "//connect.facebook.net/pt_PT/all.js";
    ref.parentNode.insertBefore(js, ref);
}(document));
function shareFB(){
    var obj = {
        method: 'feed',
        name: 'QWar by Thinker',
        caption: 'QWar by Thinker',
        description: 'QWar by Thinker is a fun quiz game to test your knowledge',
        link: '<?php echo site_url('game/result/'.$room['guid'].'/'.$user['user_id']);?>'
    };

    function share(response){
    }
    FB.ui(obj, share);
};
var popup_share_twitter_window;
function shareTwitter(){
	if(popup_share_twitter_window != null || popup_share_twitter_window != undefined) popup_share_twitter_window.close();
	popup_share_twitter_window = window.open("https://twitter.com/share?url=<?php echo site_url('game/result/'.$room['guid'].'/'.$user['user_id']);?>","popup_share_twitter","width=550px,height=420px",true);
	popup_share_twitter_window.focus();
}
</script>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <canvas id="stage"></canvas>

        <div class="content-front">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="profile-page" style="height:90vh;">
                            <div class="row">
                                <div class="col-sm-4 profile-left">
                                    <h1 class="orbitron text-center">Game Result</h1>
                                    <div class="profile-big" style="background-image: url(<?php 
                                        echo site_url("profilepicture/get/".$user['user_id']."");
                                    ?>);">
                                    </div>
                                    <h2 class="text-center"><?php echo $user['name']; ?></h2>
                                    <p class="text-center">Lv. <?php echo convert_exptolevel($user['experience']); ?></p>
                                    <div class="boxing">
                                        <div>Exp: <span style="font-size:10px;color:#31708f">+<?php echo number_format($user['exp_gained']); ?> points</span></div>
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
									<div class="row sharediv">
										<div class="col-sm-6">
											<a href="#" class="btn-share-facebook" onclick="shareFB();return false;"><i class="fa fa-facebook"></i> Share</a>
										</div>
										<div class="col-sm-6">
											<a href="#" class="btn-share-twitter" onclick="shareTwitter();return false;"><i class="fa fa-twitter"></i> Tweet</a>
										</div>
									</div>
                                </div>
                                <div class="col-sm-8 profile-right">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <h4 class="text-center">Your Rank</h4>
                                            <h1 class="text-center"><strong><?php echo numberToPlace($user['rank_in_game']);?></strong></h1>
											<div class="text-center" style="font-size:12px;color:#31708f;">of <?php echo number_format(count($user_game));?> players</div>
                                        </div>
                                        <div class="col-sm-6">
                                            <h4 class="text-center">Topic</h4>
                                            <h1 class="text-center"><strong><?php echo ucfirst($room['topic_name']);?></strong></h1>
                                        </div>
                                        <div class="clearfix"></div>
                                        <hr>
                                        <div class="panel panel-info">
                                          <!-- Default panel contents -->
                                          <div class="panel-heading">Players Ranks</div>

                                          <!-- Table -->
										  <div style="height:280px;overflow:auto;">
                                          <table class="table table-striped">
                                              <tr>
                                                 <th>Rank</th>
                                                 <th>Player Name</th>
                                                 <th>Score</th> 
                                              </tr>
											  <?php foreach($user_game as $ug){ ?>
                                              <tr class="<?php echo ($ug['user_id']==$this->session->userdata("user_id"))?"highlight":"";?>">
                                                  <td><?php echo numberToPlace($ug['rank_in_game']);?></td>
                                                  <td><a href="<?php echo site_url("user/profile/".$ug['user_id']);?>" target="_blank"><?php echo $ug['name'];?></a></td>
                                                  <td><?php echo number_format($ug['exp_gained']);?></td>
                                              </tr>
											  <?php } ?>
                                          </table>
										  </div>
                                        </div>
                                    </div>
									<?php if(Auth::isLoggedIn() ){ ?>
									<div class="row">
										<div class="col-sm-12 text-right">
											<a href="<?php echo site_url('game/roomlist');?>" class="btn btn-primary">Back to Room List</a>
										</div>
									</div>
									<?php } ?>
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
