const changeAlunos = (obj) => {
    let parent = $('#turma').parent('div').parent('form').get(0)
    $(parent).attr('action', '/nota/' + $(obj).val())
    parent.submit()
}

const changeNota = (event, obj) => {
    if (event.keyCode == 13) {
        $(obj).parent('form').get(0).submit()
    }
}

$(document).ready(function () {
    $('input[name ="nota"]').on('focusout', function () {
        $(this).parent('form').get(0).submit();
    });
})