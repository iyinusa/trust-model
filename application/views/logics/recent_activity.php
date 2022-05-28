<?php
    $ra_obj =& get_instance();
	$ra_obj->load->model('users');
	
	$ra_indicator = '';
	$ra_item = '';
	$ra_count = 0;
	$r_act = $ra_obj->users->query_activity();
	if(!empty($r_act)){
		foreach($r_act as $ract){
			if($ra_count<10){
				$ra_type = $ract->type;
				$ra_fan_id = $ract->fan_id;
				$ra_p_id = $ract->p_id;
				$ra_s_id = $ract->s_id;
				$ra_content = $ract->content;
				$ra_reg_date = $ract->reg_date;
				
				$ra_reg_date_ago = timespan(strtotime($ra_reg_date), time());
				$ra_reg_date_ago = explode(', ',$ra_reg_date_ago);
				$ra_reg_date_ago = $ra_reg_date_ago[0];
				
				//get fan details
				$r_gf = $ra_obj->users->query_single_user_id($ra_fan_id);
				foreach($r_gf as $rf){
					$ra_fan_nicename = $rf->user_nicename;
					$ra_fan_display_name = $rf->display_name;
					$ra_fan_pics_small = $rf->pics_small;
					if($ra_fan_pics_small=='' || file_exists(FCPATH.$ra_fan_pics_small)==FALSE){$ra_fan_pics_small='img/avatar.jpg';}		
				}
				
				//check type
				if($ra_type=='moot' || $ra_type=='moot reply'){
					if($ra_type=='moot'){
						$ra_content = '<a href="'.base_url('moot/'.$ra_p_id).'">Started new moot: '.character_limiter($ra_content,50).'</a>';
					} else {
						$ra_content = '<a href="'.base_url('moot/'.$ra_p_id.'#'.$ra_s_id).'">Replied a moot: '.character_limiter($ra_content,50).'</a>';
					}
				} else if($ra_type=='join club'){
					$ra_content = '<a href="'.base_url('moot/'.$ra_p_id).'">New Fan: '.character_limiter($ra_content,50).'</a>';
				} else if($ra_type=='leave club'){
					$ra_content = '<a href="'.base_url('moot/'.$ra_p_id).'">Decamped: '.character_limiter($ra_content,50).'</a>';
				}
				
				//layout recent activity
				if($ra_count==0){$ra_active='active';}else{$ra_active='';}
				$ra_indicator .= '<li data-target="#quote-carousel" data-slide-to="'.$ra_count.'" class="'.$ra_active.'"></li>';
				
				$ra_item .= '
					<div class="item '.$ra_active.'">
						<div class="row">
							<div class="col-sm-3 text-center">
								<img class="img-circle avatar avatar-md" src="'.base_url($ra_fan_pics_small).'" alt="">
							</div>
							<div class="col-sm-9">
								<p>'.$ra_content.'</p>
								<small>
									<a href="'.base_url('fan/'.$ra_fan_nicename).'">'.$ra_fan_display_name.'</a> - <span class="text-muted">'.$ra_reg_date_ago.' ago</span>
								</small>
							</div>
						</div>
					</div>
				';
				
				$ra_count += 1;
			}
		}
	}
?>