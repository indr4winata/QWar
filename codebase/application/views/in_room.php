<?php include('general/header.php') ?>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <canvas id="stage"></canvas>

        <div class="content-front">
          <div class="container">
            <div class="row inroom">
              <div class="col-sm-9">
                <div class="player-list-panel ov-auto row">
                  <h2 class="orbitron">Player list</h2>

                  <ul class="loader">
                    <li></li>
                    <li></li>
                    <li></li>
                  </ul>

                  <div id="playerlist">
          					<?php /* foreach($user_game as $ug){ ?>
                              <div class="col-sm-4 <?php echo $ug['is_creator']?"creator":"";?>">
          						<a href="<?php echo site_url('user/profile/'.$ug['user_id']);?>" target="_blank"><div class="pull-left profile-image" style="background-image: url(<?php echo site_url('profilepicture/get/'.$ug['user_id']); ?>)"></div></a>
          						<div class="pull-left">
          						  <h3 class="orbitron player-name"><a href="<?php echo site_url('user/profile/'.$ug['user_id']);?>" target="_blank"><?php echo $ug['name'];?></a></h3>
          						  <p class="player-info"><small>Lv. <?php echo $ug['level'];?></small></p>
          						</div>
          					</div>
          					<?php } */ ?>
                  </div> 
                </div>
                <div class="chat-panel ov-auto row">
                </div>
                <div class="chat-action row">
                    <input type="text" id="boxchat" class="form-control">
                    <input type="button" class="sendchat btn btn-warning" value="Send">
                </div>
              </div>
              <div class="col-sm-3">
                <div class="info-panel">
                  <div class="vertical-align text-center">
                    <img src="<?php echo site_url('assets/images/icon_'.strtolower($room['topic_name']).'.png') ?>" alt="">
                    <h3 class="text-left">Topic:</h3>
                    <h2 class="orbitron text-left"><strong><?php echo ucfirst($room['topic_name']);?></strong></h2>
                    <h3 class="text-left">Creator:</h3>
                    <h2 class="orbitron text-left"><strong><?php echo $room['name'];?></strong></h2>
                  </div>
                </div>
                <div class="action-panel">
				  <?php if($room['user_id'] == $this->session->userdata("user_id")){ ?>
                  <a href="javascript:void(0)" class="btn btn-primary center-block orbitron startgame"><strong>Start Game</strong></a>
                  <a href="javascript:void(0)" class="btn btn-danger center-block orbitron cancelroom"><strong>Abort Game</strong></a>
				  <?php }else{ ?>
				  <a href="#" class="btn btn-danger center-block orbitron leaveroom"><strong>Leave Room</strong></a>
				  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary btn-lg btn-correct hidden" data-toggle="modal" data-target="#correct-modal">
          Launch demo modal
        </button>

        <!-- Modal -->
        <div class="modal fade" id="correct-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Correct</h4>
              </div>
              <div class="modal-body">
                Congrats! You've got the answer!
              </div>
            </div>
          </div>
        </div>

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary btn-lg btn-fail hidden" data-toggle="modal" data-target="#fail-modal">
          Launch demo modal
        </button>

        <!-- Modal -->
        <div class="modal fade" id="fail-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Oh no!</h4>
              </div>
              <div class="modal-body">
                <div class="">Someone already answer or no one answer the question!</div>
                <div class="mt30">Answer:</div>
                <h3 class="orbitron jawaban"></h3>
              </div>
            </div>
          </div>
        </div>

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary btn-lg btn-noanswer hidden" data-toggle="modal" data-target="#noanswer-modal">
          Launch demo modal
        </button>

        <!-- Modal -->
        <div class="modal fade" id="noanswer-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Oh no!</h4>
              </div>
              <div class="modal-body">
                <div class="">Someone already answer or no one answer the question!</div>
                <div class="mt30">Answer:</div>
                <h3 class="orbitron jawaban"></h3>
              </div>
            </div>
          </div>
        </div>

        <div class="container" id="gamestart">
          <div class="row">
            <div class="col-sm-12">
              <div class="game-panel">
                <div class="row">
                  <div class="col-sm-9 text-center game-left">
                    <div class="top-panel text-left clearfix">
                      <div class="profile-image" style="background-image: url(<?php echo site_url('profilepicture/get/'.$this->session->userdata('user_id'));?>);"></div>
                      <div class="health orbitron"><strong>HP: <span><?php echo $usergame_info['hp'];?></span></strong></div>
                      <div class="score pull-right orbitron"><strong>Score: <span>0</span></strong></div>
                      <div class="timer">00:<span class="second">00</span></div>
                    </div>
                    <div class="question-panel orbitron text-center"></div>
                    <div class="wrong-answer"></div>
                    <input type="text" id="boxanswer">
                    <div class="clearfix"></div>
                    <input type="button" class="answer orbitron" value="submit">
                  </div>
                  <div class="col-sm-3 mh80">
                    <h3 class="orbitron" style="margin-top: 30px;">Player List</h3>
                    <div id="enemy-panel">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      <input type="hidden" id="roomstate" value="N">
      <input type="hidden" id="roomguid" value="<?php echo $room['guid'];?>">
        <?php   include('general/javascript.php') ?>
		<?php $this->load->view('general/javascript');?>
		<?php $this->load->view('general/dotgraph');?>

        <script>
			
            $(function(){
				var intervalquestion;
				var ajax = null;
				$("#boxchat").keypress(function(evt){
					var charCode = (evt.which) ? evt.which : evt.keyCode;
					if (charCode == 13){
						$(".sendchat").trigger('click');
					}
				});
                function refreshroom(){
					if($("#roomstate").val() == "N"){
						if(ajax != null) ajax.abort();
						$("#playerlist").fadeOut();
						$(".loader").fadeIn();
						$("#playerlist").html('');
						ajax = $.get( "<?php echo site_url('game/refresh_room/'.$room['guid']) ?>", function( rawdata ) {
							if(rawdata == "redirect"){
								window.location.href = "<?php echo site_url('game/roomlist');?>";
							}else{
								var data = $.parseJSON(rawdata);
								var html = '';
                var text = '';
								var creator = '';
								for(i in data){
									var d = data[i];
									creator = '';
									if(d.is_creator) creator = 'creator';
									html = html + '<div class="col-sm-4 '+creator+'">\
									<a href="<?php echo site_url('user/profile');?>/'+d.user_id+'" target="_blank"><div class="pull-left profile-image" style="background-image: url(<?php echo site_url('profilepicture/get/'); ?>/'+d.user_id+');"></div></a>\
									<div class="pull-left">\
									  <h3 class="orbitron player-name"><a href="<?php echo site_url('user/profile');?>/'+d.user_id+'" target="_blank">'+d.name+'</a></h3>\
									  <p class="player-info"><small>Lv. '+d.level+'</small></p>\
									</div>\
									</div>';

                  text = text + '<div class="enemy-list clearfix">\
                  <div class="pic pull-left style="background-image: url(<?php echo site_url('profilepicture/get/'); ?>/'+d.user_id+');""></div><div class="pull-left">'+d.name+'</div>\
                  <div class="pull-right" id="enemylist_'+d.user_id+'">HP : <span>'+d.hp+'</span></div>\
                      </div>';

								}
                $('#enemy-panel').html(text);
								$("#playerlist").html(html);
								$(".loader").fadeOut();
								$("#playerlist").fadeIn();
							}
						});
					}
                }
				<?php if(!isset($no_node) ){ ?>
				<?php $creator = ($room['created_by_user_id']==$this->session->userdata('user_id'))?1:0; ?>
				<?php if($creator == 1){ ?>
				$(".startgame").click(function(){
					socket.emit('startgame',$("#roomguid").val(),<?php echo $room['topic_id'];?>);
				});
				<?php } ?>
				socket.emit('joinroom',$("#roomguid").val(),<?php echo $this->session->userdata('user_id');?>,<?php echo $creator;?>);
				socket.on('error',function(data){
					console.log(data);
				});
				socket.on('new_user_join',function(user_id){
					refreshroom();
				});
				$(".sendchat").click(function(){
					var message = $("#boxchat").val();
					socket.emit('sendchat',$("#roomguid").val(),<?php echo $this->session->userdata('user_id');?>,message);
					$("#boxchat").val('');
				});
				socket.on('room_cancel',function(data){
					alert("Room Has Been Aborted.\n You will be redirected to room list to choose another one.");
					window.location.href = $("#base_url").attr("alt")+"game/roomlist";
				});
				socket.on('room_leave',function(data){
					refreshroom();
				});
				socket.on('chat_received',function(data){
					// parse the message and print it
					var html = "";
					html = html + '<div class="chat-name"><a href="<?php echo site_url('user/profile');?>/'+data.userdata.user_id+'" target="_blank">'+data.userdata.name+'</a></div>';
					html = html + '<div class="chat-message">: '+data.message+'</div><div class="clearfix"></div>';
					$(".chat-panel").append(html);
					$(".chat-panel").scrollTop($('.chat-panel')[0].scrollHeight);
				});
				$(".cancelroom").click(function(e){
					e.preventDefault();
					e.stopPropagation();
					socket.emit('cancelroom',$("#roomguid").val());
					window.location.href = $("#base_url").attr("alt")+"game/roomlist";
				});
				$(".leaveroom").click(function(e){
					e.preventDefault();
					e.stopPropagation();
					socket.emit('leaveroom',$("#roomguid").val(),<?php echo $this->session->userdata('user_id');?>);
					window.location.href = $("#base_url").attr("alt")+"game/roomlist";
				});
				
				var focusoutanswer = function(){
					$('#boxanswer').focus();
				};
					
				//game play
				socket.on('game_start',function(){
					$(".cancelroom").attr('disabled','disabled');
					$(".leaveroom").attr('disabled','disabled');
					$("#roomstate").val("S");
					$("#boxanswer").attr("disabled","disabled");
					$(".answer").attr("disabled","disabled");
					$("#boxanswer").val('');
					$('#boxanswer').unbind('focusout');
					var time = 5;
					var myVar = setInterval(function(){
						$('.chat-panel').append('<div class="timer">The game will start in '+time+' second. </div>');
						if(time==0){
							clearInterval(myVar);
							$('.content-front').hide();
							$('#gamestart').fadeIn();
						}
						time--;
					}, 1000);
					//change the canvas
				});
				socket.on('question',function(question){
					// stop animation, close popup
					
					// clear question..
					$('.question-panel').html('');
          $('.wrong-answer').html('');
          $('.game-panel').removeClass('shake animated');

					//check if user can answer..
					var hp = $(".health span").text();
					if(hp > 0){
						$("#boxanswer").removeAttr("disabled");
						$(".answer").removeAttr("disabled");
						$("#boxanswer").val('');
						$('#boxanswer').focus();
						$('#boxanswer').bind('focusout',focusoutanswer);
					}
					$('.question-panel').html(question.question_title);
					$('.second').html(question.question_time_second);
					$('.timer').fadeIn();
					var time = question.question_time_second;
					intervalquestion = setInterval(function(){
						$('.second').html(time);
						if(time<10){
							$('.second').html('0'+time);
						}
						if(time==0){
							clearInterval(intervalquestion);
							$('.timer').hide();
						}
						time--;
					}, 1000);
					//set new question timer and display the question
				});
				
				$(".answer").click(function(){
					//check if user can answer..
					var hp = $(".health span").text();
					if(hp > 0){
						var answer = $("#boxanswer").val();
						socket.emit('answer',$("#roomguid").val(),<?php echo $this->session->userdata('user_id');?>,answer);
					}
				});
				$("#boxanswer").keypress(function(evt){
					var charCode = (evt.which) ? evt.which : evt.keyCode;
					if (charCode == 13){
						$(".answer").trigger('click');
					}
				});
				socket.on('incorrect_result',function(result){
					//incorrect
					// show animation incorrect answer
					// console.log(result);
          // $('#yourElement').addClass('animated bounceOutLeft');
          $('.wrong-answer').html('<i class="fa fa-times-circle"></i><span class="red"> Wrong Answer</span>');
          $('.game-panel').addClass('shake animated');
          $('.game-panel').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
            $('.game-panel').removeClass('shake animated');
          });
					$("#boxanswer").val('');
					$('#boxanswer').focus();
				});
				
				socket.on('correct_answer',function(data){
					// disable the textbox, clear timer, hide time
					clearInterval(intervalquestion);

          var hp = $(".health span").text();

					$("#boxanswer").attr("disabled","disabled");
					$(".answer").attr("disabled","disabled");
					$("#boxanswer").val('');
					$('#boxanswer').unbind('focusout');
					$('.timer').hide();
					// use data.question_answer
					//check if user can answer..
					if(<?php echo $this->session->userdata('user_id');?> == data.user_id && hp > 0){
            $('.btn-correct').trigger('click');
            var time = 3;
            intervalpopup = setInterval(function(){
              if(time==0){
                clearInterval(intervalpopup);
                $('#correct-modal').modal('hide');
                $('#boxanswer').focus();
              }
              time--;
            }, 1000);

					}else if(data.user_id == 0){
            $('.jawaban').text(data.question_answer);
            $('.btn-fail').trigger('click');
            var time = 3;
            intervalpopup = setInterval(function(){
              if(time==0){
                clearInterval(intervalpopup);
                $('#fail-modal').modal('hide');
                $('#boxanswer').focus();
              }
              time--;
            }, 1000);
              // console.log(data.question_answer);
					}else{
            $('.jawaban').text(data.question_answer);
            $('.btn-noanswer').trigger('click');
            var time = 3;
            intervalpopup = setInterval(function(){
              if(time==0){
                clearInterval(intervalpopup);
                $('#noanswer-modal').modal('hide');
                $('#boxanswer').focus();
              }
              time--;
            }, 1000);
              // console.log(data.question_anwer);
					}
					//show correct answer and animation for 5 seconds (break etc)
					
					//update the players health point using game/refresh_room ajax
					$.get("<?php echo site_url('game/refresh_room/'.$room['guid']);?>",function(rawdata){
						var data2 = $.parseJSON(rawdata);

						for(index in data2){
							if(data2[index].user_id == <?php echo $this->session->userdata("user_id");?>){
								$(".health span").html(data2[index].hp);
								$(".score span").html(data2[index].exp_gained);
							}
              $(".health span").html(data2[index].hp);
              $(".score span").html(data2[index].exp_gained);
							if($("#enemylist_"+data2[index].user_id).length > 0){
                $("#enemylist_"+data2[index].user_id).find('span').html(data2[index].hp);
              }
						}
					});
				});
				socket.on('game_finish',function(data){
					//redirect to result page
					$('#boxanswer').unbind('focusout');
					window.location.href = "<?php echo site_url('game/result/'.$room['guid'].'/'.$this->session->userdata("user_id"));?>";
				});

				
				
				
				<?php } ?>
            });
        </script>
<?php include('general/footer.php') ?>
