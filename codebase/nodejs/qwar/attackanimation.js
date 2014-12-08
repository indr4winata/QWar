var attackanimation = {
	init : function(console, connection, io, socket){
	},
	attack : function(console, connection, io, guid, attacker_user_id,onSuccess){
		if(attacker_user_id == 0){
			//reduce all players' health
			connection.query("update usergame set hp=hp-ceil(maxhp*10/100) where guid=?",[guid], function(err, rows){
				if (err){
					console.log("Error update usergame : %s ",err);
					io.emit('error', "Error update usergame");
				}else{
					onSuccess();
				}
			});
		}else{
			//only reduce the other players' except attacker_user_id. get the attack point of attacker_user_id
			
			//retreive attacker_user_id
			connection.query("select * from usergame where guid=? and user_id=?",[guid,attacker_user_id], function(err, rows){  
				if (err){
					console.log("Error select question : %s ",err);
					io.emit('error', "Error select question");
				}else{
					if(rows.length>0){
						var attacker = rows[0];
						var damage = attacker.attack;
						connection.query("update usergame set hp=hp-? where guid=? and user_id!=?",[damage,guid,attacker_user_id], function(err2, rows2){  
							if (err2){
								console.log("Error select question : %s ",err2);
								io.emit('error', "Error select question");
							}else{
								onSuccess();
							}
						});
						
					}else{
						console.log("usergame is not found");
						io.emit('error', "usergame is not found");
					}
				}
			});
		}		
	}
	
};

exports.attackanimation = attackanimation;