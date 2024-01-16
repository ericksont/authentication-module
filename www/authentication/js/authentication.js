class Authentication {
		
	login = async _ => {

		loading.show()
				
		const data = this.checkData()		

		if(data.status) {

			
			let obj = await request.load(API+"authentication/login", "POST", data)
			
			if(obj !== undefined && obj.type == "SUCCESS"){

				const cookieName = 'SSID_U';
				const cookieValue = obj.data;

				let myDate = new Date();
				myDate.setHours(myDate.getHours() + 12);

				document.cookie = cookieName +"=" + cookieValue + ";expires=" + myDate + ";domain=."+DOMAIN+";path=/";
				
				//window.location = DASHBOARD;
			} 
		}
	}

	checkData = _ => {

		let user = document.getElementById("user").value
		let pass = document.getElementById("pass").value 
		let result = {email:user, password:pass}

		if(user == '' || pass == ''){

			alert('Preencha corretamente os campos!')
			loading.hide()
			result.status = false
			return result
			
		} else {
			result.status = true
			return result
		}

	}

}

const authentication = new Authentication();