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

    $('#react-aria5170489316-1').click(function () {
        if ($('#react-aria5170489316-1').attr('aria-expanded') === 'false') {
            $('#react-aria5170489316-1').attr('aria-expanded', 'true');
            $('#react-aria5170489316-1').attr('class', 'nav-link nav-icon dropdown-toggle dropdown-toggle show');
            $(this).parent().attr('class', 'me-2 nav-item show dropdown');
            $(this).parent().children().last().attr('class', 'dropdown-menu-lg py-0 dropdown-menu show dropdown-menu-end');
        } else {
            $('#react-aria5170489316-1').attr('aria-expanded', 'false');
            $('#react-aria5170489316-1').attr('class', 'nav-link nav-icon dropdown-toggle dropdown-toggle');
            $(this).parent().attr('class', 'me-2 nav-item dropdown');
            $(this).parent().children().last().attr('class', 'dropdown-menu-lg py-0 dropdown-menu dropdown-menu-end');
        }
    });
});
