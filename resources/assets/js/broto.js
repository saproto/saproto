window.broto = () => {
    console.log('BROTO')
    document.querySelectorAll('img').forEach((el) => {
        if (el.classList.contains('rounded-circle'))
            el.src = '/images/default-avatars/cookiemonster.webp'
        else if (el.src.includes('images/logo/inverse.webp'))
            el.src = '/images/logo/broto-inverse.webp'
        else if (el.src.includes('images/logo/regular.webp'))
            el.src = '/images/logo/broto-regular.webp'
    })

    document.querySelectorAll('*').forEach((el) => {
        el.childNodes.forEach((child) => {
            if (child.nodeType === 3)
                child.nodeValue = child.nodeValue.replace(
                    /(Proto)(.?)\b/g,
                    'Broto$2'
                )
        })
    })
}
