<?php
	$uri = 'http://api.football-data.org/alpha/fixtures/?timeFrame=n1';
	$reqPrefs['http']['method'] = 'GET';
	$reqPrefs['http']['header'] = 'Auth-Token: 2f7f714b442f40d7ae23339fb63aa1ef';
	$stream_context = stream_context_create($reqPrefs);
	$response = file_get_contents($uri, false, $stream_context);
	$fixtures = json_decode($response, true);
	
	$i = 1;
	$fix_list = '';
	for($i <= 0; $i < (count($fixtures)-1); $i++){
		if(!empty($fixtures['fixtures'][$i-1]['date'])){$date=$fixtures['fixtures'][$i-1]['date'];}else{$date='';}
	  	if(!empty($fixtures['fixtures'][$i-1]['homeTeamName'])){$homeTeamName=$fixtures['fixtures'][$i-1]['homeTeamName'];}else{$homeTeamName='';}
	  	if(!empty($fixtures['fixtures'][$i-1]['awayTeamName'])){$awayTeamName=$fixtures['fixtures'][$i-1]['awayTeamName'];}else{$awayTeamName='';}
	  	if(!empty($fixtures['fixtures'][$i-1]['result']['goalsHomeTeam'])){$goalsHomeTeam=$fixtures['fixtures'][$i-1]['result']['goalsHomeTeam'];}else{$goalsHomeTeam='';}
	  	if(!empty($fixtures['fixtures'][$i-1]['result']['goalsAwayTeam'])){$goalsAwayTeam=$fixtures['fixtures'][$i-1]['result']['goalsAwayTeam'];}else{$goalsAwayTeam='';}
	  	
		if($date!=''){$date=date('H:m',strtotime($date));}
		
	  	if($goalsHomeTeam<=0){$goalsHomeTeam='?';}
	  	if($goalsAwayTeam<=0){$goalsAwayTeam='?';}
	  
	  	$fix_list .= $date.' | '.$homeTeamName.' (<strong>'.$goalsHomeTeam.'</strong> - <strong>'.$goalsAwayTeam.'</strong>) '.$awayTeamName.'<hr />';
	}
	
	$fix_list = '
	  <div class="panel">
		  <div class="panel-body">'.$fix_list.'</div>
	  </div>
	';
?>