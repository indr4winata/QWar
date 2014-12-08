var host_url_gameresult = "http://indr4winata.koding.io/qwar/node/reconcile";
var gameresult = {
	reconcile : function(console, connection, io, request, guid){
		console.log("reconcile");
		
		connection.query("update gameroom set status='E' where guid=?",[guid], function(err4, rows4)
		{
			console.log("update success!");
	  
			if (err4)
			{
				console.log("Error select question : %s ",err4 );
				io.emit('error', "Error select question");
			}
			else{
				request({
					url : host_url_gameresult,
					method : "POST", //post atau get.
					form: {
						guid : guid
						}			
				},
				function(error,response,body){
					io.emit('game_finish');
				});
			}
		});		
		
	}
	
};

exports.gameresult = gameresult;