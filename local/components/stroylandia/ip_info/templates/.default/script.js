function highLoadBLockFormSubmit(form) {
    const AJAX_ID = BX.message('AJAX_ID');
    const AJAX_CONTAINER = BX('comp_' + AJAX_ID);

    $.ajax({
        url: form.getAttribute('action') ? form.getAttribute('action') : window.location.pathname,
        data: new FormData(form),
        type: 'post',
        processData: false,
        contentType: false,
        success: function(data){
            AJAX_CONTAINER.innerHTML = data;
            const WAIT_ICON = BX('wait_comp_' + AJAX_ID);
            if (WAIT_ICON) {
                WAIT_ICON.remove();
            }
        }
    });
}
