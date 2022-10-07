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
            BX('wait_comp_' + AJAX_ID).remove();
        }
    });
}
