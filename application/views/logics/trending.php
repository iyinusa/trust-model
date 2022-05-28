<?php
    $t_obj =& get_instance();
	$t_obj->load->model('users');
	$t_obj->load->model('m_moots');
	$t_obj->load->model('m_clubs');
	$trending_club = '';
	$trending_fan = '';
	$trending_moot = '';
	$trending = '';
	
	//tranding clubs
	$lqc = mysql_query("SELECT * FROM sfh_moot GROUP BY club_id ORDER BY COUNT(club_id) DESC LIMIT 8");
	while($lrc = mysql_fetch_assoc($lqc)){
		$qc = $t_obj->m_clubs->query_single_club_id($lrc['club_id']);
		if(!empty($qc)){
			foreach($qc as $qcitem){
				$t_club_id = $qcitem->id;
				$t_club_slug = $qcitem->slug;
				$t_club_name = $qcitem->name;
				$t_club_pics_square = $qcitem->pics_square;
				
			}
			
		}
		
		$trending_club .= '
			<div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
				<a href="'.base_url('club/'.$t_club_slug).'">
					<img alt="" src="'.base_url($t_club_pics_square).'" class="avatar img-circle" />
					<div>
						<b>'.ucwords($t_club_name).'</b>
					</div>
				</a>
			</div>
		';	
	}
	
	//trending fans
	//$lqf = mysql_query("SELECT * FROM sfh_moot_reply GROUP BY fan_id ORDER BY COUNT(fan_id) DESC LIMIT 8");
	$lqf = mysql_query("SELECT * FROM sfh_quota GROUP BY user_id ORDER BY SUM(point) DESC LIMIT 10");
	while($lrf = mysql_fetch_assoc($lqf)){
		$qf = $t_obj->users->query_single_user_id($lrf['user_id']);
		if(!empty($qf)){
			foreach($qf as $qfitem){
				$t_fan_nicename = $qfitem->user_nicename;
				$t_fan_display_name = $qfitem->display_name;
				$t_fan_country = $qfitem->country;
				$t_fan_pics_small = $qfitem->pics_small;
				if($t_fan_pics_small=='' || file_exists(FCPATH.$t_fan_pics_small)==FALSE){$t_fan_pics_small='img/avatar.jpg';}
				
				//get club
				if($qfitem->club_id == 0){
					$t_fan_club_name = 'No Club';
				} else {
					$qcc = $t_obj->m_clubs->query_single_club_id($qfitem->club_id);
					foreach($qcc as $cc){
						$t_fan_club_name = $cc->name;
					}
				}
			}
			
		}
		
		$trending_fan .= '
			<div class="media">
				<a class="pull-left" href="'.base_url('fan/'.$t_fan_nicename).'">
					<img class="media-object avatar avatar-sm img-circle" src="'.base_url($t_fan_pics_small).'" alt="">
				</a>
				<div class="comment">
					<a class="pull-left" href="'.base_url('fan/'.$t_fan_nicename).'">
						<b>'.$t_fan_display_name.'&nbsp;<small class="text-muted">'.$t_fan_club_name.'</small></b><br />
						<span class="text-muted pull-left">'.$t_fan_country.'</span>
					</a>
				</div>
			</div><hr />
		';	
	}
	
	//trending moots
	$t_club_info = '';
	$lqm = mysql_query("SELECT * FROM sfh_moot_reply GROUP BY moot_id ORDER BY COUNT(moot_id) DESC LIMIT 5");
	while($lrm = mysql_fetch_assoc($lqm)){
		$qm = $t_obj->m_moots->query_moot_id($lrm['moot_id']);
		if(!empty($qm)){
			foreach($qm as $qmitem){
				$t_moot_id = $qmitem->id;
				$t_moot_fan_id = $qmitem->fan_id;
				$t_moot_club_id = $qmitem->club_id;
				$t_moot_moot = $qmitem->moot;
				$t_moot_reg_date = $qmitem->reg_date;
				
				$t_moot_reg_date = timespan(strtotime($t_moot_reg_date), time());
				
				//get post fan details
				$tgf = $t_obj->users->query_single_user_id($t_moot_fan_id);
				foreach($tgf as $tf){
					$t_f_nicename = $tf->user_nicename;
					$t_f_display_name = $tf->display_name;
					$t_f_club_id = $tf->club_id;
					$t_f_club_ban = $tf->club_ban;
					$t_f_pics_small = $tf->pics_small;
					if($t_f_pics_small=='' || file_exists(FCPATH.$t_f_pics_small)==FALSE){$t_f_pics_small='img/avatar.jpg';}		
				}
				
				//get post club details
				$tgc = $this->m_clubs->query_single_club_id($t_moot_club_id);
				foreach($tgc as $tc){
					$t_c_name = ucwords($tc->name);
					//check if fan has decamped
					if($t_f_club_id!=$tc->id){$t_club_info = '| Formally';}else{$t_club_info = '';}
				}
			}
			
		}
		
		$trending_moot .= '
			<div class="media">
				<a class="pull-left" href="'.base_url('fan/'.$t_f_nicename).'">
					<img class="media-object avatar avatar-sm img-circle" src="'.base_url($t_f_pics_small).'" alt="">
				</a>
				<div class="comment">
					<div class="comment-author h6 no-m">
						<a href="'.base_url('fan/'.$t_f_nicename).'"><b>'.$t_f_display_name.'</b> <small class="text-muted">'.$t_c_name.' '.$t_club_info.'</small></a>
					</div>
					<div class="comment-meta small text-muted">('.$t_moot_reg_date.' ago)</div>
					<p>
						<a href="'.base_url('moot/'.$t_moot_id).'">'.$t_moot_moot.'</a>
					</p>
				</div>
			</div><hr />
		';	
	}
	
	//structure all trending
	$trending = '
		<div>
			<div class="box-tab">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab_tr_club" data-toggle="tab"><i class="ti-cup"></i> Clubs</a>
					</li>
					<li><a href="#tab_tr_fan" data-toggle="tab"><i class="fa fa-users"></i> Fans</a>
					</li>
					<li><a href="#tab_tr_moot" data-toggle="tab"><i class="ti-thought"></i> Moots</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane fade text-center active in" id="tab_tr_club">
						'.$trending_club.'
					</div>
					<div class="tab-pane fade text-center" id="tab_tr_fan">
						'.$trending_fan.'
						<div class="text-muted text-center"><a href="'.base_url('fans').'"><i class="fa fa-users"></i> All Fans</a></div>
					</div>
					<div class="tab-pane fade" id="tab_tr_moot">
						'.$trending_moot.'
						<div class="text-muted text-center"><a href="'.base_url('moots').'"><i class="ti-thought"></i> All Moots</a></div>
					</div>
				</div>
			</div>
		</div>
	';
?>