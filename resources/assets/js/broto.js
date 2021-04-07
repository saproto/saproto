function broto() {
    $('img').each(function() {
        if ($(this).hasClass('rounded-circle'))
            $(this).attr('src', '/images/default-avatars/cookiemonster.jpg')
        else if ($(this).attr('src').includes('images/logo/inverse.png'))
            $(this).attr('src',  '/images/logo/broto-inverse.png')
        else if ($(this).attr('src').includes('images/logo/regular.png'))
            $(this).attr('src', '/images/logo/broto-regular.png')
    })

    $("body").children().each(function () {
        $(this).html($(this).html().replace(/(Proto)(.?)\b/g, 'Broto$2'))
    })
}

window.broto = broto