class Loading {

    loading;

    show = id => {        
        this.loading = this.getLoading(id)
        this.action('block')
    }

    hide = id => {        
        this.loading = this.getLoading(id)
        this.action('none')
    }

    getLoading = id => {
        return id != null ? document.getElementById(id) : document.getElementsByClassName('loading')
    }

    action = act => {
        if(this.loading.style === undefined) {
            for (let item of this.loading) {
                item.style.display = act
            }
        } else this.loading.style.display = act
    };
	
}

const loading = new Loading();