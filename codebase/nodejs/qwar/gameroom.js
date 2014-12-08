var gameroom = {
	init : function(console, connection, io, socket){
		 socket.on('joinroom', function(guid, user_id,creator){
			console.log('joinroom: '+guid);
		
			try {
			
			var room_id = guid;
			
			console.log("room_id: "+room_id);
			console.log("user_id: "+user_id);
							  
			connection.query("select * from gameroom where guid=?",[room_id], function(err, rows)
				{
				console.log("query success!");
			  
						if (err)
						{
							console.log("Error select gameroom : %s ",err );
							io.emit('error', "Error select gameroom");
						}
						else{
							
							console.log("rows.length: "+rows.length);
							
							if(rows.length > 0){
								socket.room = room_id;
								socket.user_id = user_id;
								socket.creator = creator;
								socket.join(room_id);
								io.sockets.in(room_id).emit('new_user_join',user_id);

							} else {					
								io.emit('error', "GUID is not found");
							}										
						}
				});			
			}catch (ex) {
				io.emit('error', ex);
			}	
		});
		
		socket.on('cancelroom', function(guid){
		var room_id = guid;
		console.log('cancelroom');
		io.sockets.in(room_id).emit('room_cancel');
		
		connection.query("delete from usergame where guid=?",[guid], function(err2, rows2){
		});
		connection.query("update gameroom set status='D' where guid=?",[guid], function(err4, rows4)
		{
		});

	  });
	  
	  socket.on('leaveroom', function(guid,user_id){
		var room_id = guid;
		console.log('leaveroom');
		
		connection.query("delete from usergame where guid=? and user_id = ?",[guid,user_id], function(err2, rows2)
						{
							if (err2)
							{
								console.log("Error delete usergame : %s ",err2);
								io.emit('error', "Error delete usergame");
							}
							else{						
								socket.leave(room_id);
								io.sockets.in(room_id).emit('room_leave',user_id);
							}
						});		
	  });
	}
	
};

exports.gameroom = gameroom;