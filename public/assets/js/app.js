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
        const link = $('#react-aria5170489316-1');

        if (link.attr('aria-expanded') === 'false') {
            link.attr('aria-expanded', 'true');
            link.attr('class', 'nav-link nav-icon dropdown-toggle dropdown-toggle show');
            $(this).parent().attr('class', 'me-2 nav-item show dropdown');
            $(this).parent().children().last().attr('class', 'dropdown-menu-lg py-0 dropdown-menu show dropdown-menu-end');
        } else {
            link.attr('aria-expanded', 'false');
            link.attr('class', 'nav-link nav-icon dropdown-toggle dropdown-toggle');
            $(this).parent().attr('class', 'me-2 nav-item dropdown');
            $(this).parent().children().last().attr('class', 'dropdown-menu-lg py-0 dropdown-menu dropdown-menu-end');
        }
    });

    $('#react-aria5170489316-2').click(function () {
        const link = $('#react-aria5170489316-2');

        if (link.attr('aria-expanded') === 'false') {
            link.attr('aria-expanded', 'true');
            link.attr('class', 'nav-link nav-icon dropdown-toggle dropdown-toggle show');
            $(this).parent().attr('class', 'me-2 nav-item show dropdown');
            $(this).parent().children().last().attr('class', 'dropdown-menu-lg py-0 dropdown-menu show dropdown-menu-end');
        } else {
            link.attr('aria-expanded', 'false');
            link.attr('class', 'nav-link nav-icon dropdown-toggle dropdown-toggle');
            $(this).parent().attr('class', 'me-2 nav-item dropdown');
            $(this).parent().children().last().attr('class', 'dropdown-menu-lg py-0 dropdown-menu dropdown-menu-end');
        }
    });

    $('#react-aria5170489316-3').click(function () {
        const link = $('#react-aria5170489316-3');

        if (link.attr('aria-expanded') === 'false') {
            link.attr('aria-expanded', 'true');
            link.attr('class', 'nav-link nav-flag dropdown-toggle show');
            $(this).parent().attr('class', 'me-2 nav-item show dropdown');
            $(this).parent().children().last().attr('class', 'dropdown-menu show dropdown-menu-end');
        } else {
            link.attr('aria-expanded', 'false');
            link.attr('class', 'nav-link nav-flag dropdown-toggle');
            $(this).parent().attr('class', 'me-2 nav-item dropdown');
            $(this).parent().children().last().attr('class', 'dropdown-menu dropdown-menu-end');
        }
    });

    $('#react-aria5170489316-4').click(function () {
        const link = $('#react-aria5170489316-4');

        if (link.attr('aria-expanded') === 'false') {
            link.attr('aria-expanded', 'true');
            link.attr('class', 'nav-link dropdown-toggle show');
            $(this).parent().parent().attr('class', 'nav-item show dropdown');
            $(this).parent().parent().children().last().attr('class', 'dropdown-menu show dropdown-menu-end');
        } else {
            link.attr('aria-expanded', 'false');
            link.attr('class', 'nav-link dropdown-toggle');
            $(this).parent().parent().attr('class', 'nav-item dropdown');
            $(this).parent().parent().children().last().attr('class', 'dropdown-menu dropdown-menu-end');
        }
    });
});
