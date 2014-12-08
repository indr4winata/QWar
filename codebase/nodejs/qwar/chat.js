var chat = {
	init : function(console, connection, io, socket){
		socket.on('sendchat', function(guid,user_id,message){
			console.log('sendchat');
			connection.query("select user_id, name from user where user_id = ?",[user_id], function(err2, rows2){
				if (err2){
					console.log("Error delete usergame : %s ",err2);
					io.emit('error', "Error delete usergame");
				}else{						
					var messagesent = {userdata:rows2[0],message:message};
					io.sockets.in(guid).emit('chat_received',messagesent);
				}
			});
		});
	}
	
};

exports.chat = chat;