jQuery(document).ready(function($){    

	// Ajax localized variables - ajax_object.ajax_url, ajax_object.frontpage, ajax_object.postspage

	if(ajax_object.display_edit_link){

		if(ajax_object.frontpage != 0){
			$( "#front-static-pages ul li:first-child").append("<span id='frontpage_edit'> <a href='/wp-admin/post.php?post="+ ajax_object.frontpage + "&action=edit'>edit</a></span>");
		}else{
			$( "#front-static-pages ul li:first-child").append("<span id='frontpage_edit'>&nbsp;</span>");
		}
		if(ajax_object.postspage != 0){
			$( "#front-static-pages ul li:nth-child(2)").append("<span id='postspage_edit'> <a href='/wp-admin/post.php?post="+ ajax_object.postspage + "&action=edit'>edit</a></span>");
		}else{
			$( "#front-static-pages ul li:nth-child(2)").append("<span id='postspage_edit'> &nbsp;</span>");
		}

	$("#page_on_front").change(function() {
		$( "#frontpage_edit").html(" Loading...");
		var seloption = $(this).val(); //get currently selected page id
			$.ajax({
     			url : ajax_object.ajax_url,
				type : 'post',
				data :  {
					'action' : 'append_link',
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
     			url : ajax_object.ajax_url,
				type : 'post',
				data :  {
					'action' : 'append_link',
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