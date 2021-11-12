const userSearchList = [].slice.call(document.getElementsByClassName('user-search'))
userSearchList.map((el) => searchAutocomplete(
    el,
    config.routes.api_search_user,
    (option, item) => {
        option.innerHTML = `#${item.id} ${item.name}`
    },
    (item) => { return item.name }
))

const eventSearchList = [].slice.call(document.getElementsByClassName('event-search'))
eventSearchList.map((el) => searchAutocomplete(
    el,
    config.routes.api_search_event,
    (option, item) => {
        option.className = item.is_future ? '' : 'text-muted'
        option.innerHTML = `${item.title} (${item.formatted_date.simple})`
    },
    (item) => { return item.title },
    (a, b) => {
        if (a.start < b.start) return 1;
        else if (a.start > b.start) return -1;
        else return 0;
    }
))

const productSearchList = [].slice.call(document.getElementsByClassName('product-search'))
productSearchList.map((el) => searchAutocomplete(
    el,
    config.routes.api_search_product,
    (option, item) => {
        option.className = item.is_visible ? '' : 'text-muted'
        option.innerHTML = `${item.name} (€${item.price.toFixed(2)}; ${item.stock} in stock)`
    },
    (item) => { return item.name + (el.multiple ? ' (€' + item.price.toFixed(2) + ')' : '') },
    (a, b) => {
        if (a.is_visible === 0 && b.is_visible === 1) return 1
        else if (a.is_visible === 1 && b.is_visible === 0) return -1
        else return 0
    }
))

const committeeSearchList = [].slice.call(document.getElementsByClassName('committee-search'))
committeeSearchList.map((el) => searchAutocomplete(
    el,
    config.routes.api_search_committee,
))

function searchAutocomplete(el, route, optionTemplate, selectedTemplate, sorter) {
    const multiple = el.hasAttribute('multiple')

    const searchResults = document.createElement('div')
    searchResults.className = 'search-results form-control p-0'
    searchResults.id = el.id + '-search-results'
    searchResults.innerHTML = '<span>type at least 3 characters</span>'

    const input = document.createElement('input')
    input.type = 'hidden'
    input.name = el.name
    input.value = el.value
    el.value = el.placeholder
    el.name = ''

    const selected = document.createElement('div')
    selected.className = 'selected-items form-control p-0'

    const selectedItem = document.createElement('span')
    selectedItem.className = 'selected-item d-block-inline badge bg-success px-2 my-1 mx-2'

    // Append results and hidden inputs
    el.parentNode.append(searchResults)
    if (multiple) el.parentNode.append(selected)
    else el.parentNode.append(input)

    search()
    el.addEventListener('keyup', search)

    function search() {
        searchResults.innerHTML = ''

        // Search input must be at least 3 characters
        if (el.value.length < 3) return searchResults.innerHTML = '<span>type at least 3 characters</span>'
        else searchResults.innerHTML = '<span>searching...</span>'

        // Get search results
        window.axios.get(
            route,
            {
                responseType: 'json',
                params: {q: el.value}
            }
            // On success handle search results
        ).then((res) => {
            const data = res.data

            // Check if there are any results
            if (data.length === 0) return searchResults.innerHTML = '<span>no results</span>'
            else searchResults.innerHTML = ''

            // Sort data if sorter is defined
            if (sorter === 'function') data.sort(sorter)

            data.forEach((item) => {
                // For each result create an option in the search results container
                let option = document.createElement('option')
                if (typeof optionTemplate === 'function') optionTemplate(option, item)
                else option.innerHTML = item.name

                // Add onclick eventListener to option to be able to select one
                option.addEventListener('click', (e) => {
                    // Check if input accepts multiple selections
                    if (multiple) {
                        // Create new selected item
                        let newSelectedItem = selectedItem.cloneNode()
                        newSelectedItem.innerHTML = selectedTemplate?.(item) ?? item.id
                        newSelectedItem.addEventListener('click', (e) => {
                            newSelectedItem.remove()
                        })

                        // Create new hidden input
                        let multipleInput = input.cloneNode()
                        multipleInput.value = item.id

                        // append selection to selected items container
                        newSelectedItem.append(multipleInput)
                        selected.append(newSelectedItem)
                        // In case only one selection is allowed
                    } else {
                        // set the hidden input value
                        input.value = item.id
                        el.value = selectedTemplate?.(item) ?? item.name ?? item.id
                        searchResults.innerHTML = ''
                        searchResults.append(option)
                    }

                    el.dispatchEvent(new Event('change'))
                })
                searchResults.append(option)
            })
            // Log and return error to user
        }).catch((err) => {
            searchResults.innerHTML = '<span class="text-danger"> there was an error</span>'
            console.error(err)
        })
    }
}