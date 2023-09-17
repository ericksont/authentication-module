class  Authentication {
		
	login = () => {
		
		$('.loading_login_form').show();
		
		var user = $("#user").val();
		var pass = $("#pass").val();
		
		/*if(user == '' || pass == ''){
			objUtils.message('Aviso!', 'Preencha corretamente os campos!', '');
			$('.loading_login_form').hide();
		} else {
			$.post(ROOT+'request.php', {class:"UserAjaxController", method:"authentication", user:user, pass:pass}, function(data){
				var obj = jQuery.parseJSON( data );
				if(obj.type == "SUCCESS"){
					
					localStorage.setItem("user_code",obj.data.code);
					localStorage.setItem("user_name",obj.data.user);
					localStorage.setItem("group",obj.data.group);

					window.location = ROOT;
				} else if(obj.type == "ALERT" && obj.message == "Espere!"){
					//do nothing 
				} else {
					objUtils.message('Aviso!', 'Verifique se o usuário e senha estão corretos!', '');
					$('.loading_login_form').hide();
				}
			});
		}*/
		
	}

	
}

const authentication = new Authentication();
