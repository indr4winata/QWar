<?php $this->load->view("general/header");?>
<script>
$(function(){
	var guid = 1;
	var uid = 3;
	var topicid = 1;
	$(".sendchat").click(function(){
		var message = $("#boxchat").val();
		socket.emit('sendchat',guid,uid,message);
	});
	socket.on('chat_received',function(message){
		// parse the message and print it
	});
	function refresh_room(){
		$.post($("#base_url").attr("alt")+"game/refresh_room/"+guid,{},function(data){
		});
	}
	socket.emit('joinroom',guid,uid);
	socket.on('error',function(data){
		alert(data);
	});
	socket.on('new_user_join',function(user_id){
		refresh_room();
	});
	$(".startgame").click(function(){
		socket.emit('startgame',guid,topicid);
	});
	$(".cancelroom").click(function(){
		socket.emit('cancelroom',guid);
		window.location.href = $("#base_url").attr("alt")+"game/roomlist";
	});
	$(".leaveroom").click(function(){
		socket.emit('leaveroom',guid,uid);
		window.location.href = $("#base_url").attr("alt")+"game/roomlist";
	});
	socket.on('room_leave',function(user_id){
		alert(user_id + " leave");
		//call ajax to reload the content
		refresh_room();
	});
	socket.on('room_cancel',function(){
		alert("host room canceled");
		// redirect to room list
		window.location.href = $("#base_url").attr("alt")+"game/roomlist";
	});
	socket.on('game_start',function(){
		alert("game started");
		$("#boxanswer").attr("disabled","disabled");
		$(".answer").attr("disabled","disabled");
		$("#boxanswer").val('');
		//change the canvas
	});
	
	
	// ready to play
	$(".readytoplay").click(function(){
		socket.emit('readytoplay',guid,uid);
	});
	socket.on('question',function(question){
		// stop animation, close popup, clear question..
		$("#boxanswer").removeAttr("disabled");
		$(".answer").removeAttr("disabled");
		$("#boxanswer").val('');
		//set timer
	});
	$(".answer").click(function(){
		var answer = $("#boxanswer").val();
		socket.emit('answer',guid,uid,answer);
	});
	socket.on('incorrect_result',function(result){
		//incorrect
		// show animation incorrect answer
		$("#boxanswer").val('');
	});
	
	socket.on('correct_answer',function(data){
		// disable the textbox, show correct answer, clear timer, for several minutes
		// data.question_answer
		if(uid == data.user_id){
			//display text/image that your answer is correct
		}else if(data.user_id == 0){
			// no one get correct answer
		}else{
			//display text/image that someone has correct answer
		}
		$("#boxanswer").attr("disabled","disabled");
		$(".answer").attr("disabled","disabled");
		$("#boxanswer").val('');
		//run animation
		//update the players health point using game/refresh_room
		
	});
	socket.on('game_finish',function(data){
		//redirect to result page
	});
});
</script>
<input type="text" id="boxchat"> 
<input type="button" class="sendchat" value="send chat">
<br/><br/>
<input type="button" class="startgame" value="start">
<input type="button" class="cancelroom" value="cancel">
<input type="button" class="leaveroom" value="leave">
<input type="button" class="readytoplay" value="ready to play">

<br><br>
<input type="text" id="boxanswer"> <input type="button" class="answer" value="answer">
<?php $this->load->view("general/footer");?>