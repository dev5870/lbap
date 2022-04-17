$(document).ready(function() {

    //side nav compact if iPad and smaller
    if ($(window).width() < 821) {
        $('body').attr('data-sidebar-behavior', 'compact');
    }

    //for icons
    feather.replace()

    //alerts
    $('.toast').toast('show');
    $('.toast-static').toast('hide');

    //side nav toggle
    let collapseElementList = [].slice.call($('ul.collapse'))
    collapseElementList.map(function (collapseEl) {
        if ($(collapseEl).find('.sidebar-link').hasClass('active')) {
            return new bootstrap.Collapse(collapseEl)
        }
    })

    //side nav swipe action
    $('#hamburger').click(function () {
        $('body').attr(
            'data-sidebar-behavior',
            $('body').attr('data-sidebar-behavior') ===  'sticky' ? 'compact' : 'sticky'
        );
    });

    $('.needToSpin').click(function () {
        $(this).find('.feather').addClass('loading');
    });

    //tochka settings, get url
    $('#settingActionInitialize').click(function () {
        const el = $(this);
        let url = $(this).data('url');

        $.get(url, function (response) {
            el.parent().find('input').val(response.url)
        })
    });

    //tochka settings, copy url
    $('#copyToClipboard').click(function () {
        const val = $(this).parent().find('input').val();

        let $temp = $('<input>');
        $('body').append($temp);
        $temp.val(val).select();

        document.execCommand("copy");
        $temp.remove();
    });

    //clear filter's inputs
    $('.clearInputBtn').click(function () {
        $(this).closest('.input-group').find('input').val('');

        if ($(this).hasClass('dateFilter')) {
            $(this).closest('.input-group').find('span').html('<p class="placeholder">Process date</p>');
        }
    });

    //format balance
    let balanceFormat = new Intl.NumberFormat({
        style: 'currency',
        currency: 'USD',
    });

    for (const [key, value] of Object.entries($('.balance'))) {
        $(value).html(balanceFormat.format($(value).attr('data-balance')));
    }

    $('.ajax-form').on('submit', function (e) {
        e.preventDefault();

        sendAjax($(this), data => {
            console.log('Submission was successful.');
            console.log(data);
        });
    });

    $("select.roles").select2({
        theme: "classic"
    });

    //delete modal
    let deleteModal = document.getElementsByClassName('deleteModal');

    for (const [key, value] of Object.entries(deleteModal)) {
        value.addEventListener('show.bs.modal', function (event) {
            let button = event.relatedTarget;
            let recipient = button.getAttribute('data-bs-whatever');
        });
    }

    //loading rotate icon
    $('#getCardLimit').click(function () {
        const svg = '<line x1="12" y1="2" x2="12" y2="6"></line>' +
            '<line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line>' +
            '<line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line>' +
            '<line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line>' +
            '<line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line>';

        $(this).find('svg').addClass('loading').html(svg);
    });

    //ajax
    function sendAjax(form, success) {
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            success(response) {
                console.log(response);
            },
            error(response) {
                console.log(response.responseJSON.errors);
                $('#toast-div').append(
                    '<div class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">\n' +
                    '    <div class="d-flex">\n' +
                    '        <div class="toast-body">ERROR</div>\n' +
                    '        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Закрыть"></button>\n' +
                    '    </div>\n' +
                    '</div>'
                );
                $('#toast-div .toast').toast('show');

            },
        });
    }

});
