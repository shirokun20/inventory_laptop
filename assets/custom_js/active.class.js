$(() => {
    var url = window.location.toString();
    // Will only work if string in href matches with location
    $('.pcoded-item li a[href="' + url + '"]').addClass('active');
    // Will also work for relative and absolute hrefs
    $('.pcoded-hasmenu li a').filter(function() {
       var data = url.match(this.href);
       return this.href == (data !== null ? data.toString() : null);
    }).parent().addClass('active');
    $('.pcoded-hasmenu li a').filter(function() {
       var data = url.match(this.href);
       return this.href == (data !== null ? data.toString() : null);
    }).parent().parent().parent().addClass('pcoded-trigger');
    $('.pcoded-hasmenu li a').filter(function() {
       var data = url.match(this.href);
       return this.href == (data !== null ? data.toString() : null);
    }).parent().parent().parent().addClass('active');
   
});