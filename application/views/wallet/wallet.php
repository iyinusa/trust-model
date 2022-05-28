<?php include(APPPATH.'libraries/inc.php'); ?>
        <section class="layout">
            <!-- main content -->
            <section class="main-content">
                <!-- content wrapper -->
                <div class="content-wrap">
                    <!-- inner content wrapper -->
                    <div class="wrapper">
                    	<div class="row">
                            <div class="col-md-8">
                            	<div class="col-lg-12">
                                	<h2><i class="ti-wallet"></i> Wallet</h2>
                                </div>
                                
                                <div class="col-lg-12 mb25">
                                	<?php echo $err_msg; ?>
									<?php //echo form_open_multipart('wallet/prepare') ?>
                						<div class="panel">
                                        	<div class="panel-heading"><h3><i class="ti-wallet"></i> Fund Wallet</h3></div>
                                            <div class="panel-body">
                                            	<div class="form-inline">
                                                    <div class="input-group mb15">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span id="wcurrency">$</span> <span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <a href="javascript:;" onclick="set_currency(1);">$ - Dollar</a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:;" onclick="set_currency(0);">&#8358; - Naira</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <input type="text" name="amount" id="wamount" class="form-control" placeholder="1000" style="text-align:center; font-weight:bold;">
                                                        <span class="input-group-addon">.00</span>
                                                        <button type="submit" class="btn btn-info stepy-finish pull-left" onclick="prepare_wallet();"><i class="ti-wallet mr5"></i> Fund Wallet</button>
                                                        <span id="wcurr_type">
                                                        	<input type="hidden" id="curr_type" name="curr_type" value="$" />
                                                        </span>
                                                    </div>
                                                </div>
                                                <div id="prepare_reply"></div>
                                            </div>
                                        </div>
                                        
                                        <script type="text/javascript">
											function set_currency(type){
												var curr;
												if(type == 0){
													curr = '&#8358;';
												} else {
													curr = '$';
												}
												document.getElementById('wcurrency').innerHTML = curr;
												document.getElementById('wcurr_type').innerHTML = '<input type="hidden" id="curr_type" name="curr_type" value="'+curr+'" />';
											}
											
											function prepare_wallet(){
												var hr = new XMLHttpRequest();
												var wamount = document.getElementById("wamount").value;
												var wtype = document.getElementById("curr_type").value;
												var c_vars = "amount="+wamount+"&type="+wtype;
												hr.open("POST", "<?php echo base_url('wallet/prepare'); ?>", true);
												hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
												hr.onreadystatechange = function() {
													if(hr.readyState == 4 && hr.status == 200) {
														var return_data = hr.responseText;
														document.getElementById("prepare_reply").innerHTML = return_data;
												   }
												}
												hr.send(c_vars);
												document.getElementById("prepare_reply").innerHTML = "<i class=\"icon-spin4 animate-spin loader\"></i>";
											}
										</script>
                                    <?php //echo form_close() ?>
                                    
                                    <div class="panel">
                                    	<div class="panel-heading"><h3><i class="ti-wallet"></i> Wallet History</h3></div>
                                        <div class="panel-body">
                                        	<div class="category chart"></div>
                                        </div>
                                    </div>
                               	</div>
                                
                            </div>
                            
                            <div class="col-md-4">