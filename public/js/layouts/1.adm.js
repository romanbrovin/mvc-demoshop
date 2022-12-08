$(function () {

    uri = $('#uri').val();

    $("#form").submit(function () {
        event.preventDefault();
    });

    $('.btn__save').click(function () {
        actionItem('save');
    });

    $('.btn__create').click(function () {
        actionItem('create');
    });

    $('.btn__mark').click(function () {
        event.preventDefault();
        let itemId = $(this).closest('.item').attr('id');
        setAction('mark', itemId);
    });

    $('.btn__soon').click(function () {
        event.preventDefault();
        let itemId = $(this).closest('.item').attr('id');
        setAction('soon', itemId);
    });

    $('.btn__password-generate').click(function () {
        event.preventDefault();
        number = getRandomInt(100000, 999999);
        $('#password').val(number);
    });

    $('.btn__hidden').click(function () {
        event.preventDefault();
        let itemId = $(this).closest('.item').attr('id');
        setAction('hidden', itemId);
    });

    $('.btn__delete').click(function () {
        event.preventDefault();
        let itemId = $(this).closest('.item').attr('id');
        str =
            '<div class="modal-header border-bottom-0">' +
            '    <h4 class="modal-title">Удалить?</h4>' +
            '    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>' +
            '</div>' +
            '<div class="modal-footer border-top-0">' +
            '    <div class="modal-footer-id">ID ' + itemId + '</div>' +
            '    <button onclick="deleteItem(' + itemId + ')" class="btn btn-danger btn-sm" type="button">' +
            '       Да, удалить' +
            '    </button>' +
            '</div>';

        $('.notification .modal-content').html(str);
        new bootstrap.Modal('.notification', {}).show();
    });

    $('.btn__comment').click(function () {
        event.preventDefault();
        let itemId = $(this).closest('.item').attr('id');
        getComment(itemId);
    });

    $('.btn__sort').click(function () {
        event.preventDefault();
        let itemId = $(this).closest('.item').attr('id');
        getSortOrder(itemId);
    });

    $('.btn__upload-photo').change(function () {
        event.preventDefault();
        let itemId = $(this).closest('.item').attr('id');
        uploadPhotoToItem(itemId);
    });

    $('.btn__delete-photo').click(function () {
        event.preventDefault();
        let itemId = $(this).closest('.item').attr('id');
        deletePhotoFromItem(itemId);
    });

    $('.btn__split').click(function () {
        event.preventDefault();
        let itemId = $(this).closest('.item').attr('id');

        str =
            '<div class="modal-header border-bottom-0">' +
            '    <h4 class="modal-title">Разделить</h4>' +
            '    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>' +
            '</div>' +
            '<div class="modal-body py-0">' +
            '   <div class="form-floating">' +
            '       <input class="form-control" id="amount" type="number" min="0" value="1">' +
            '       <label for="amount">Кол-во отделяемого товара</label>' +
            '       <div class="invalid-feedback">Введите кол-во товара меньше текущего</div>' +
            '   </div>' +
            '   <div class="mt-3 text-secondary">' +
            '       Разделение этой позиции на несколько других с сохранением основных характеристик' +
            '   </div>' +
            '</div>' +
            '<div class="modal-footer border-top-0 mt-2">' +
            '    <button onclick="setSplit(' + itemId + ')" class="btn btn-primary btn-sm" type="button">' +
            '       Сохранить' +
            '    </button>' +
            '</div>';

        $('.notification .modal-content').html(str);
        new bootstrap.Modal('.notification', {}).show();

        $('#amount').keydown(function (e) {
            if (e.keyCode === 13) {
                setSplit(itemId);
            }
        });
    });

    tinymce.init({
        selector: 'textarea',
        menubar: false,
        plugins: 'anchor autolink charmap code emoticons link lists visualblocks wordcount',
        toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright | " +
            "bullist numlist | link code | forecolor backcolor removeformat",
    });

    tinymce.init({
        selector: 'textarea#name',
        height: 500,
        auto_focus: "name",
    });

    tinymce.init({
        selector: 'textarea#preview',
        height: 250,
    });

    tinymce.init({
        selector: 'textarea#description',
        height: 500,
    });

});

function actionItem(method) {
    let vars = new Object();
    vars['token2'] = token2;

    $.each($('#form').serializeArray(), function (i, field) {
        vars[field.name] = field.value;
    });

    $('input:checkbox:checked').each(function () {
        vars[$(this).attr('name')] = 1;
    });

    $('textarea').each(function () {
        vars[this.name] = '';
        if ($(this).length) {
            vars[this.name] = tinymce.get(this.name).getContent();
        }
    });

    let button = $('.btn__' + method);
    button.prop('disabled', true);

    loader();

    $.ajax({
        type: "POST",
        url: "/adm/" + uri + "/" + method,
        data: vars
    }).done(function (response) {

        let data = JSON.parse(response);

        $('.is-invalid').removeClass('is-invalid');

        if (data == 'ok') {
            $('.toast').removeClass('text-bg-danger');
            $('.toast').addClass('text-bg-success');

            if (method == 'create') {
                txt = 'Запись создана';
                redirectUrl = '/adm/' + uri;
            } else if (method == 'save') {
                txt = 'Запись изменена';
                redirectUrl = getCookie('referrer') + '#' + vars['id'];
            }

            $('.toast-body').html('<i class="fa-solid fa-check"></i>&nbsp;&nbsp;' + txt);
            toast.show();

            setTimeout(function () {
                location.href = redirectUrl;
            }, toastTimeout);

        } else if (data == 'non-unique-email') {
            $('#email').addClass('is-invalid');
            $('.toast').addClass('text-bg-danger');
            $('.toast-body').html('Введите другую электронную почту (эта уже занята)');
            toast.show();

            button.prop('disabled', false);
            loader(0);
        } else if (data == 'non-unique-name') {
            $('#name').addClass('is-invalid');
            $('.toast').addClass('text-bg-danger');
            $('.toast-body').html('Введите другое название (это уже занято)');
            toast.show();

            button.prop('disabled', false);
            loader(0);
        } else if (data == 'non-unique-article') {
            $('#article').addClass('is-invalid');
            $('.toast').addClass('text-bg-danger');
            $('.toast-body').html('Введите другой артикул (этот уже занят)');
            toast.show();

            button.prop('disabled', false);
            loader(0);
        } else {
            if (data.length > 0) {
                let errorHead = '<strong><i class="fa-solid fa-triangle-exclamation"></i>' +
                    '&nbsp;&nbsp;Необходимо ввести:</strong>';
                let errorStr = '';

                for (let key in data) {
                    errorStr += '<br>&mdash;&nbsp;&nbsp;' + $('#' + data[key] + '~ .feedback-short').html();
                    $('#' + data[key]).addClass('is-invalid');
                }

                errorStr = errorHead + errorStr;

                $('.toast').addClass('text-bg-danger');
                $('.toast-body').html(errorStr);
                toast.show();
            }

            button.prop('disabled', false);
            loader(0);
        }

    });
}

function deleteItem(itemId) {
    let vars = new Object();
    vars['token2'] = token2;
    vars['id'] = itemId;

    loader();

    $.ajax({
        type: "POST",
        url: "/adm/" + uri + "/delete",
        data: vars
    }).done(function () {

        $('.notification').hide();
        $('.toast').addClass('text-bg-secondary');
        $('.toast-body').html('<i class="fa-solid fa-check"></i>&nbsp;&nbsp;Запись удалена');
        toast.show();

        setTimeout(function () {
            location.reload();
        }, toastTimeout);

    });
}

function getComment(itemId) {
    let vars = new Object();
    vars['token2'] = token2;
    vars['id'] = itemId;

    $.ajax({
        type: "POST",
        url: "/adm/" + uri + "/get-data",
        data: vars
    }).done(function (msg) {

        let data = JSON.parse(msg);

        str =
            '<div class="modal-header border-bottom-0">' +
            '    <h4 class="modal-title">Заметка</h4>' +
            '    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>' +
            '</div>' +
            '<div class="modal-body py-0">' +
            '   <div class="form-floating">' +
            '       <input class="form-control" id="comment" maxlength="90" placeholder="Текст" ' +
            '           type="text" value="' + data['comment_admin'] + '">' +
            '       <label for="comment">Текст</label>' +
            '   </div>' +
            '</div>' +
            '<div class="modal-footer border-top-0 mt-2">' +
            '    <div class="modal-footer-id">ID ' + data['id'] + '</div>' +
            '    <button onclick="setComment(' + itemId + ')" class="btn btn-primary btn-sm" type="button">' +
            '       Сохранить' +
            '    </button>' +
            '</div>';

        $('.notification .modal-content').html(str);
        new bootstrap.Modal('.notification', {}).show();

        $('#comment').on("input", function (ev) {
            let placeholder = $(this).attr('placeholder');
            let maxlength = $(this).attr('maxlength');
            let lenght = $(this).val().length;

            if (maxlength && lenght > 0) {
                placeholder = placeholder + ' ' + lenght + '/' + maxlength;
            }

            $(this).next('label').html(placeholder);

        });

        $('#comment').keydown(function (e) {
            if (e.keyCode === 13) {
                setComment(itemId);
            }
        });

    });
}

function setComment(itemId) {
    let vars = new Object();
    vars['token2'] = token2;
    vars['id'] = itemId;
    vars['comment'] = $('#comment').val();

    loader();

    $.ajax({
        type: "POST",
        url: "/adm/" + uri + "/set-comment",
        data: vars
    }).done(function () {

        $('.notification').hide();
        $('.toast').addClass('text-bg-success');
        $('.toast-body').html('<i class="fa-solid fa-check"></i>&nbsp;&nbsp;Заметка изменена');
        toast.show();

        setTimeout(function () {
            location.reload();
        }, toastTimeout);

    });
}

function getSortOrder(itemId) {
    let vars = new Object();
    vars['token2'] = token2;
    vars['id'] = itemId;

    $.ajax({
        type: "POST",
        url: "/adm/" + uri + "/get-data",
        data: vars
    }).done(function (msg) {

        let data = JSON.parse(msg);

        str =
            '<div class="modal-header border-bottom-0">' +
            '    <h4 class="modal-title">Порядок сортировки</h4>' +
            '    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>' +
            '</div>' +
            '<div class="modal-body py-0">' +
            '   <div class="form-floating">' +
            '       <input class="form-control" id="sort" type="number" min="0" max="99" ' +
            '           value="' + data['sort_order'] + '">' +
            '       <label for="sort_order">Число / от 0 до 99</label>' +
            '   </div>' +
            '   <div class="mt-3 text-secondary">' +
            '       Чем больше это значение, тем выше эта позиция в общем списке' +
            '   </div>' +
            '</div>' +
            '<div class="modal-footer border-top-0 mt-2">' +
            '    <div class="modal-footer-id">ID ' + data['id'] + '</div>' +
            '    <button onclick="setSortOrder(' + itemId + ')" class="btn btn-primary btn-sm" type="button">' +
            '       Сохранить' +
            '    </button>' +
            '</div>';

        $('.notification .modal-content').html(str);
        new bootstrap.Modal('.notification', {}).show();

        $('#sort').keydown(function (e) {
            if (e.keyCode === 13) {
                setSortOrder(itemId);
            }
        });

    });
}

function setSortOrder(itemId) {
    let vars = new Object();
    vars['token2'] = token2;
    vars['id'] = itemId;
    vars['sort'] = $('#sort').val();

    loader();

    $.ajax({
        type: "POST",
        url: "/adm/" + uri + "/set-sort-order",
        data: vars
    }).done(function () {

        $('.notification').hide();
        $('.toast').addClass('text-bg-success');
        $('.toast-body').html('<i class="fa-solid fa-check"></i>&nbsp;&nbsp;Порядок сортировки изменен');
        toast.show();

        setTimeout(function () {
            location.reload();
        }, toastTimeout);

    });
}

function uploadPhotoToItem(itemId) {
    let data = new FormData();
    let countPhoto = 0;

    $.each($('#files_' + itemId)[0].files, function (key, file) {
        data.append(key, file);
        countPhoto++;
    });

    data.append('token2', token2);
    data.append('id', itemId);

    loader();

    $.ajax({
        type: "POST",
        url: "/adm/" + uri + "/upload-photo",
        data: data,
        cache: false,
        contentType: false,
        processData: false
    }).done(function () {

        if (countPhoto == 1) str = 'Фотография загружена';
        else str = 'Фотографии загружены';

        $('.notification').hide();
        $('.toast').addClass('text-bg-success');
        $('.toast-body').html('<i class="fa-solid fa-check"></i>&nbsp;&nbsp;' + str);
        toast.show();

        setTimeout(function () {
            location.reload();
        }, toastTimeout);

    });
}

function deletePhotoFromItem(itemId) {
    let vars = new Object();
    vars['token2'] = token2;
    vars['id'] = itemId;

    loader();

    $.ajax({
        type: "POST",
        url: "/adm/" + uri + "/delete-photo",
        data: vars
    }).done(function () {

        $('.notification').hide();
        $('.toast').addClass('text-bg-secondary');
        $('.toast-body').html('<i class="fa-solid fa-check"></i>&nbsp;&nbsp;Фотография удалена');
        toast.show();

        setTimeout(function () {
            location.reload();
        }, toastTimeout);

    });
}

function setSplit(itemId) {
    let vars = new Object();
    vars['token2'] = token2;
    vars['id'] = itemId;
    vars['amount'] = $('#amount').val();

    loader();

    $.ajax({
        type: "POST",
        url: "/adm/" + uri + "/set-split",
        data: vars
    }).done(function (msg) {

        let data = JSON.parse(msg);

        $('.is-invalid').removeClass('is-invalid');

        if (data == 'ok') {
            $('.toast').removeClass('text-bg-danger');
            $('.toast').addClass('text-bg-success');
            $('.toast-body').html('<i class="fa-solid fa-check"></i>&nbsp;&nbsp;Товар разделен');
            toast.show();

            setTimeout(function () {
                location.reload();
            }, toastTimeout);
        } else {
            $('#amount').addClass('is-invalid');

            loader(0);
        }

    });
}

function setAction(setAction, itemId) {
    let vars = new Object();
    vars['token2'] = token2;
    vars['id'] = itemId;

    loader();

    $.ajax({
        type: "POST",
        url: "/adm/" + uri + "/set-" + setAction,
        data: vars
    }).done(function () {

        setTimeout(function () {
            location.reload();
        }, toastTimeout);

    });
}
