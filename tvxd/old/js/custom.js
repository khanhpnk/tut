jQuery(document).ready(function($) {
    var popup_shown = Cookies.get('popup_shown');
    var expired_on = new Date(new Date().getTime() + 1000 * 60 * 60 * 24);
    if (popup_shown != '1') {
        setTimeout(function(){
            $.colorbox({
                html: $('#popup_content').html(),
                maxWidth: '95%',
                maxHeight: '95%',
                opacity: 0.5
            });
            Cookies.set('popup_shown', '1', { expires: expired_on, path: '' });
        }, 3000);
    }
});