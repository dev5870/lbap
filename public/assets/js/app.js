$(document).ready(function() {
    //side nav swipe action
    $('#hamburger').click(function () {
        $('body').attr(
            'data-sidebar-behavior',
            $('body').attr('data-sidebar-behavior') ===  'sticky' ? 'compact' : 'sticky'
        );
    });

    $('.sidebar-toggle.d-flex').click(function () {
        $('nav.sidebar').attr(
            'class',
            $('nav.sidebar').attr('class') ===  'sidebar' ? 'sidebar collapsed' : 'sidebar'
        );
    });

    $("select.roles").select2({
        theme: "classic"
    });
});
