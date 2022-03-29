$("#cc-country").select2({
	templateResult: function (data) {
        // var $span = $("<span><img src='https://www.free-country-flags.com/countries/"+idioma.id+"/1/tiny/" + idioma.id + ".png'/> " + idioma.text + "</span>");
        // return $span;
        var $span = '';
        if(!data.disabled) {
            if(data.element.dataset.icon) {
                $span = $("<span>" + data.element.dataset.icon + data.text + "</span>");
            }else {
                $span = $("<span>" + data.text + "</span>");
            }
        }
        return $span;
    },
	templateSelection: function (data) {
        var $span = '';
        if(!data.disabled) {
            if(data.element.dataset.icon) {
                $span = $("<span>" + data.element.dataset.icon + data.text + "</span>");
            }else {
                $span = $("<span>" + data.text + "</span>");
            }
        }
        return $span;
    }
});