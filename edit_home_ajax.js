jQuery(document).ready(function($){    

	// Ajax localized variables - ehpl_obj.ajax_url, ehpl_obj.frontpage, ehpl_obj.postspage

	if(ehpl_obj.display_edit_link){

		if(ehpl_obj.frontpage != 0){
			$( "#front-static-pages ul li:first-child").append("<span id='frontpage_edit'> <a href='/wp-admin/post.php?post="+ ehpl_obj.frontpage + "&action=edit'>edit</a></span>");
		}else{
			$( "#front-static-pages ul li:first-child").append("<span id='frontpage_edit'>&nbsp;</span>");
		}
		if(ehpl_obj.postspage != 0){
			$( "#front-static-pages ul li:nth-child(2)").append("<span id='postspage_edit'> <a href='/wp-admin/post.php?post="+ ehpl_obj.postspage + "&action=edit'>edit</a></span>");
		}else{
			$( "#front-static-pages ul li:nth-child(2)").append("<span id='postspage_edit'> &nbsp;</span>");
		}

	$("#page_on_front").change(function() {
		$( "#frontpage_edit").html(" Loading...");
		var seloption = $(this).val(); //get currently selected page id
			$.ajax({
     			url : ehpl_obj.ajax_url,
				type : 'post',
				data :  {
					'action' : 'append_link',
					'security' : ehpl_obj.wp_nonce,
					'postid' : seloption					
				},
     			success: function(msg){     				
       				$( "#frontpage_edit").html( " <a href="+ msg +">edit</a>");
     			}
   			});
  		}); 		

	$("#page_for_posts").change(function() {
		$( "#postspage_edit").html(" Loading...");
		var seloption = $(this).val();//get currently selected page id	
    		$.ajax({
     			url : ehpl_obj.ajax_url,
				type : 'post',
				data :  {
					'action' : 'append_link',
					'security' : ehpl_obj.wp_nonce,
					'postid' : seloption					
				},
     			success: function(msg){     				
       				$( "#postspage_edit").html( " <a href="+ msg +">edit</a>");
     			}
   			});
  		});
	}
	else{
			$( "#front-static-pages ul li:first-child").append("<span id='frontpage_edit'>&nbsp;</span>");
			$( "#front-static-pages ul li:nth-child(2)").append("<span id='postspage_edit'> &nbsp;</span>");
		}
});
