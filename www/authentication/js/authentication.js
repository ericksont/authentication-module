class  Authentication {
		
	login = _ => {
		
		let loading = document.getElementsByClassName('loading')
		for (let item of loading) {
			item.style.display = 'block'
		}
		
		var user = document.getElementById("user").value
		var pass = document.getElementById("pass").value 
		
		if(user == '' || pass == ''){

			alert('Preencha corretamente os campos!')
			/*new PNotify({
				title: 'Aviso!',
				text: 'Preencha corretamente os campos!',
				styling: 'bootstrap3'
			});*/
			for (let item of loading) {
				item.style.display = 'none'
			}
			
		} else {

			var data = {
				email: user,
				password: pass
			};
			
			var headers = new Headers();
			headers.append("Content-Type", "application/json");

			fetch(API+"authentication/login", {
				method: "POST",
				headers: {
					Accept: 'application/json',
					'Content-Type': 'application/json',
				},
				body: JSON.stringify(data)
			}).then(function(response) {
				if (response.ok) {
					return response.json();
				} else {
					throw new Error(response.status);
				}
			}).then(function(data) {

				obj = data;
				
				if(obj.type == "SUCCESS"){

					var cookieName = 'SSID_U';
					var cookieValue = obj.data;
					var myDate = new Date();
					myDate.setHours(myDate.getHours() + 12);
					document.cookie = cookieName +"=" + cookieValue + ";expires=" + myDate + ";domain=."+DOMAIN+";path=/";
					
					window.location = DASHBOARD;
				} else {
					objUtils.message('Aviso!', obj.message, '');
					$('.loading_login_form').hide();
				}
			}).catch(() => {
				new PNotify({
					title: 'Aviso!',
					text: 'Falha ao conectar com o sistema! \n Aguarde alguns instantes e tente novamente!',
					styling: 'bootstrap3'
				});
				$('.loading_login_form').hide()
			})
			
		}
	}

}

const authentication = new Authentication();