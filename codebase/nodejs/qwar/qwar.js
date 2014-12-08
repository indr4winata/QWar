express = require('express');
app = express();

http = require('http');
server = http.createServer(app);
server.listen(8081);
io = require('socket.io')(server);

var connection  = require('express-myconnection'); 
//var mysql = require('mysql');
var request = require('request');

var question_per_game = 10;
var validateReadyPlayer_time = 3000;
var animation_time = 3000;

var pool = require('./db/mysqlpool').pool;
var gameroom = require('./gameroom').gameroom;
var chat = require('./chat').chat;
var gameresult = require('./gameresult').gameresult;
var attackanimation = require('./attackanimation').attackanimation;

io.on('connection', function(socket){
	console.log('a user connected');
  
	pool.getConnection(function(err, connection) {
		// connected! (unless `err` is set)  
		gameroom.init(console, connection, io, socket);
		chat.init(console, connection, io, socket);
 
		socket.on('startgame', function(guid, topic_id){
			var room_id = guid;
			console.log("startgame");		
			connection.query("select question_id from question where topic_id=?",[topic_id], function(err, rows){
				console.log("query success!");
				if (err){
					console.log("Error select question : %s ",err );
					socket.emit('error_message', "Error select question");
				}else{
					console.log("rows.length: "+rows.length);
					if(rows.length > 0){
						function shuffle(o){ //v1.0
							for(var j, x, i = o.length; i; j = Math.floor(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
							return o;
						};
						var shuffledQuestion = shuffle(rows);
						var values = [];					
						for(var i=0;i<question_per_game;i++){		
							var value = [guid, i+1, shuffledQuestion[i].question_id];
							values.push(value);
						}
							
						connection.query("delete from gamequestion where guid=?",[guid], function(err3, rows3){
							if (err3){
								console.log("Error delete gamequestion : %s ",err3);
								socket.emit('error_message', "Error delete gamequestion");
							}else{
								console.log("insert to gamequestion: "+values.length);
								console.log(JSON.stringify(values));
								connection.query("insert into gamequestion (guid,question_no,question_id) values ?",[values], function(err2, rows2){			
									console.log("insert gamequestion success!");
									if (err2){
										console.log("Error insert game question : %s ",err2 );
									}else {
										connection.query("update gameroom set status='S', active_question_no=1 where guid=?",[guid], function(err4, rows4){
											console.log("update success!");								  
											if (err4){
												console.log("Error select question : %s ",err4 );
												socket.emit('error_message', "Error select question");
											}else{
												//validateReadyPlayer(guid,false);
												io.sockets.in(room_id).emit('game_start');
												setTimeout(function() { 
															//broadcast the question
															broadcastQuestion(room_id);
														}, animation_time);
											}
										});
									}
								});
							}
						});
					} else {
						socket.emit('error_message', "topic is not found");
					}										
				}
			});
		});
		function startGameRoom(guid, onSuccess){
			connection.query("update gameroom set status='S' where guid=?",[guid], function(err, rows){  
				if (err){
					console.log("Error update gameroom : %s ",err);
					socket.emit('error_message', "Error update gameroom");
				}else{
					onSuccess();
				}
			});
		}
	  
		//get the gameroom from database
		function retreiveGameRoom(guid, onSuccess){
			connection.query("select * from gameroom where guid=?",[guid], function(err, rows){  
				if (err){
					console.log("Error select question : %s ",err);
					socket.emit('error_message', "Error select question");
				}else{
					if(rows.length>0){
						onSuccess(rows[0]);
					}else{
						console.log("gameroom is not found");
						socket.emit("error_message", "gameroom is not found");
					}
				}
			});
		}
	  
		function nextQuestion(guid, onSuccess){
			connection.query("update gameroom set active_question_no=active_question_no+1 where guid=?",[guid], function(err, rows){  
				if (err){
					console.log("Error update gameroom : %s ",err);
					socket.emit('error_message', "Error update gameroom");
				}else{
					onSuccess();
				}
			});
		}
		
		function checkPlayerHP(guid, onSuccess, onWin){
			//check number of player that still alive
			connection.query("select * from usergame where guid=? and hp > 0",[guid], function(err, rows){  
				if (err){
					console.log("Error checkPlayerHP : %s ",err);
					socket.emit('error_message', "Error checkPlayerHP");
				}else{
					if(rows.length > 1){
						//game can continue
						onSuccess();
					}else{
					console.log("There is a winner!! "+rows.length);
						//there is a winner
						onWin();
					}
				}
			});
		}
		
		function validatePlayerHP(guid, user_id, onSuccess){
			//check player HP
			connection.query("select * from usergame where guid=? and user_id =?",[guid,user_id], function(err, rows){  
				if (err){
					console.log("Error checkPlayerHP : %s ",err);
					socket.emit('error_message', "Error checkPlayerHP");
				}else{
					if(rows.length > 0){
						if(rows[0].hp > 0){
							onSuccess();
						}else {
							console.log("Player HP is <= 0");						
						}
					}else{
						console.log("Player not found: "+guid+" "+user_id);
					}
				}
			});
		}
	  
		//send question to all
		function broadcastQuestion(room_id){
			var question;
			retreiveGameRoom(room_id, function(gameroom){
				var question_no = gameroom.active_question_no;
				if(question_no > question_per_game){
					gameresult.reconcile(console, connection, io,socket, request, room_id);
				}else {
				
					checkPlayerHP(room_id, function(){
					
						connection.query("select question.* from gamequestion gq, question where  gq.question_id=question.question_id and gq.guid=? and gq.question_no=?",[room_id,question_no], function(err, rows){  
							if (err){
								console.log("Error select question : %s ",err);
								socket.emit('error_message', "Error select question");
							}else{
								if(rows.length > 0){
									console.log("Question id: "+rows[0].question_id);
									question = { question_title:rows[0].question_title, question_time_second:rows[0].question_time_second };
									io.sockets.in(room_id).emit('question',question);
									setTimeout(function() { 
										retreiveGameRoom(room_id, function(gameroom2){
											if(question_no==gameroom2.active_question_no){
												//nobody correctly answer, trigger animation
												var data = { user_id:0, question_answer:rows[0].question_answer };
												io.sockets.in(room_id).emit('correct_answer',data);
												//set the health point
												//trigger new question
												nextQuestion(room_id, function(){
													//waiting for the animation..
													attackanimation.attack(console, connection, io, socket,room_id, 0, function(){
														setTimeout(function() { 
															//broadcast the question
															broadcastQuestion(room_id);
														}, animation_time);
													});
												});
											}
										});
									}, rows[0].question_time_second*1000);					
								}else {
									socket.emit('error_message', "Question is not found");
								}
							}
						});	
					
					},
					function (){
						gameresult.reconcile(console, connection, io, socket, request, room_id);
					});
				
					
				}
			});
		}
		
		socket.on('readytoplay', function(guid,user_id){
			var room_id = guid;
			console.log('readytoplay');
			var data = {            
				state    : 'ready'        
			};	
			connection.query("update usergame set ? where user_id=? and guid=?",[data, user_id,guid], function(err, rows){
				console.log("update success!");
				if (err){
					console.log("Error select question : %s ",err );
					socket.emit('error_message', "Error select question");
				}else{
					//check all ready or not..
					validateReadyPlayer(guid,false);
				}
			});
		});
	  
		socket.on('answer', function(guid,user_id, answer){
			var room_id = guid;
			console.log('answer');
			retreiveGameRoom(room_id, function(gameroom){
			
				validatePlayerHP(guid, user_id, function(){				
					var question_no=gameroom.active_question_no;
					connection.query("select question.* from gamequestion gq, question where gq.question_id=question.question_id and gq.guid=? and gq.question_no=? and gq.correct_replier_id is null",[room_id,question_no], function(err, rows){  
						if (err){
							console.log("Error select question : %s ",err);
							socket.emit('error_message', "Error select question");
						}else{
							if(rows.length > 0){
								if(rows[0].question_answer.toUpperCase() === answer.toUpperCase()){
									console.log('correct!');

									connection.query("update gamequestion set correct_replier_id=? ,question_closed_date=now() where guid=? and question_no=?",[user_id,guid,question_no], function(err2, rows2){
										if (err2){
											console.log("Error update usergame : %s ",err2);
											socket.emit('error_message', "Error update usergame");
										}else{
											var data = { user_id:user_id, question_answer:rows[0].question_answer };
											io.sockets.in(room_id).emit('correct_answer',data);
											nextQuestion(room_id, function(){
												//waiting for the animation..
												attackanimation.attack(console, connection,io,socket, room_id, user_id, function(){
													setTimeout(function() { 
														//broadcast the question
														broadcastQuestion(room_id);
													}, animation_time);
												});
											});									
										}
									});								
								}else {
									console.log('false!');
									socket.emit('incorrect_result');
								}
							}else {
								socket.emit('error_message', "Question is not found");
							}
						}
					});	
				
				});
			
				
			});
		});  
		
		socket.on('disconnect', function(){
//			console.log(socket.creator);
			try{
			retreiveGameRoom(socket.room, function(gameroom){
	//			console.log('gameroom.status: '+gameroom.status);
				if(gameroom.status=='N'){			
		//			console.log('check creator: '+socket.creator);

					if(socket.creator == 1){
						// cancel the room
						io.sockets.in(socket.room).emit('room_cancel');
						connection.query("update gameroom set status='D' where guid=?",[socket.room], function(err4, rows4){
						});
						connection.query("delete from usergame where guid=?",[socket.room], function(err2, rows2){
						});
					}else{
						connection.query("delete from usergame where guid=? and user_id = ?",[socket.room,socket.user_id], function(err2, rows2){
						});
					}
					socket.leave(socket.room);
				}
			});
			} catch(exx){
				console.log(exx);			
			}
			
			console.log('user disconnected');
			
			try{
			connection.release();
			} catch(ex){
				console.log(ex);
			}
		});
	});
});