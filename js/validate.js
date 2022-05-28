/* <![CDATA[ */

/// Jquery validate moot
jQuery(document).ready(function(){
		
	  $('#postmoot').submit(function(){
		  var action = $(this).attr('action');
  
		  $("#moot-msg").slideUp(750,function() {
		  $('#moot-msg').hide();
  
		  $('#submit-moot')
			  .after('<i class="icon-spin4 animate-spin loader"></i>')
			  .attr('disabled','disabled');
			  
		  $.post(action, {
			  moot: $('#moot').val(),
			  //lastname_contact: $('#lastname_contact').val(),
			  //email_contact: $('#email_contact').val(),
			  //phone_contact: $('#phone_contact').val(),
			  //message_contact: $('#message_contact').val(),
			  //verify_contact: $('#verify_contact').val()
		  },
			  function(data){
				  document.getElementById('moot-msg').innerHTML = data;
				  $('#moot-msg').slideDown('slow');
				  $('#postmoot .loader').fadeOut('slow',function(){$(this).remove()});
				  $('#submit-moot').removeAttr('disabled');
				  if(data.match('success') != null){ 
				  	$('#postmoot').slideUp('slow');
				  }
	
			  }
		  );
		  
		  document.getElementById('moot').value = '';
  
		  });
  
		  return false;
  
	  });

});

/// Jquery validate newsletter
jQuery(document).ready(function(){

	$('#newsletter').submit(function(){

		var action = $(this).attr('action');

		$("#message-newsletter").slideUp(750,function() {
		$('#message-newsletter').hide();
		
		$('#submit-newsletter')
			.after('<i class="icon-spin4 animate-spin loader"></i>')
			.attr('disabled','disabled');

		$.post(action, {
			email_newsletter: $('#email_newsletter').val()
		},
			function(data){
				document.getElementById('message-newsletter').innerHTML = data;
				$('#message-newsletter').slideDown('slow');
				$('#newsletter .loader').fadeOut('slow',function(){$(this).remove()});
				$('#submit-newsletter').removeAttr('disabled');
				if(data.match('success') != null) $('#newsletter').slideUp('slow');

			}
		);

		});

		return false;

	});

});

		

  /* ]]> */