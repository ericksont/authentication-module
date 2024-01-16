class Request {

    load = async (url, method, data) => {  

        let headers = this.headers();
        let result

        await fetch(url, {
            method: method,
            headers: headers,
            body: JSON.stringify(data)
        }).then(function(response) {

            if (response.ok) return response.json()
            else throw new Error(response.status)
            
        }).then(function(data) {

            result = data;
            
        }).catch(() => {
            alert('Falha ao conectar com o sistema! \n Aguarde alguns instantes e tente novamente!')
            loading.hide()
        })

        return result
    }

    headers = _ => {        
        let headers = new Headers()
		headers.append("Content-Type", "application/json")
        return headers
    }
	
}

const request = new Request();