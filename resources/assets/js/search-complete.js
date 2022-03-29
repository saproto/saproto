export default class SearchComplete {
    constructor(el, route, optionTemplate, selectedTemplate, sorter) {
        this.el = el
        this.route = route
        this.optionTemplate = optionTemplate
        this.selectedTemplate = selectedTemplate
        this.sorter = sorter
        this.multiple = el.hasAttribute('multiple')

        // Search result container
        this.searchResults = document.createElement('div')
        this.searchResults.className = 'search-results form-control p-0'
        this.searchResults.id = el.id + '-search-results'

        // Input template
        this.input = document.createElement('input')
        this.input.type = 'hidden'
        this.input.name = el.name
        this.input.value = el.value
        el.name = ''
        el.value = el.placeholder

        // Selected item container
        this.selected = document.createElement('div')
        this.selected.className = 'selected-items form-control bg-dark border-top-0 p-1 d-none'

        // Selected item template
        this.selectedItem = document.createElement('span')
        this.selectedItem.className = 'selected-item d-block-inline badge bg-success ps-1 my-1 mx-2'

        // Append results and hidden inputs
        el.parentNode.append(this.searchResults)
        if (this.multiple) el.parentNode.append(this.selected)
        else el.parentNode.append(this.input)

        this.search()
        el.addEventListener('keyup', this.search)
    }

    search = () => {
        this.searchResults.innerHTML = ''

        // Search input must be at least 3 characters
        if (this.el.value.length < 3) return this.searchResults.innerHTML = '<span>type at least 3 characters</span>'
        else this.searchResults.innerHTML = '<span>searching...</span>'

        // Get search results
        get( this.route,{q: this.el.value})
        .then((data) => {

            // Check if there are any results
            if (data.length === 0) return this.searchResults.innerHTML = '<span>no results</span>'
            else this.searchResults.innerHTML = ''

            // Sort data if sorter is defined
            if (this.sorter === 'function') data.sort(this.sorter)

            data.forEach((item) => {
                // For each result create an option in the search results container
                let option = document.createElement('option')
                if (typeof this.optionTemplate === 'function') this.optionTemplate(option, item)
                else option.innerHTML = item.name

                // Add onclick eventListener to option to be able to select one
                option.addEventListener('click', _ => {
                    // Check if input accepts multiple selections
                    if (this.multiple) {
                        this.selected.classList.remove('d-none')
                        this.el.required = false

                        // Create new selected item
                        let newSelectedItem = this.selectedItem.cloneNode()
                        newSelectedItem.innerHTML = this.selectedTemplate?.(item) ?? item.id
                        newSelectedItem.addEventListener('click', _ => {
                            newSelectedItem.remove()
                            if (this.selected.children.length === 0) {
                                this.el.required = true
                                this.selected.classList.add('d-none')
                            }
                        })

                        // Create new hidden input
                        let multipleInput = this.input.cloneNode()
                        multipleInput.value = item.id

                        // append selection to selected items container
                        newSelectedItem.append(multipleInput)
                        this.selected.append(newSelectedItem)

                        this.el.value = ''
                        this.searchResults.innerHTML = ''
                        // In case only one selection is allowed
                    } else {
                        // set the hidden input value
                        this.input.value = item.id
                        this.el.value = this.selectedTemplate?.(item) ?? item.name ?? item.id
                        this.searchResults.innerHTML = ''
                        this.searchResults.append(option)
                    }

                    this.el.dispatchEvent(new Event('keyup'))
                })
                this.searchResults.append(option)
            })
            // Log and return error to user
        })
        .catch((err) => {
            this.searchResults.innerHTML = '<span class="text-danger"> there was an error</span>'
            console.error(err)
        })
    }
}