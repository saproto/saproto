export default class SearchComplete {
    constructor(el, route, optionTemplate, selectedTemplate, sorter) {
        this.el = el
        this.name = el.name
        this.value = el.value
        this.required = el.required
        this.id = el.id === '' ? el.name : el.id
        this.route = route
        this.optionTemplate = optionTemplate
        this.selectedTemplate = selectedTemplate
        this.sorter = sorter
        this.multiple = el.hasAttribute('multiple')

        this.resultsContainer = this.createResultsContainer()
        this.inputElement = this.createInputElement()
        this.selectedContainer = this.createSelectedContainer()
        this.selectedElement = this.createSelectedElement()

        el.name = ''
        el.value = el.placeholder
        el.required = false

        el.parentNode.append(this.resultsContainer)
        if (this.multiple) el.parentNode.append(this.selectedContainer)
        else el.parentNode.append(this.inputElement)

        this.search()
        el.addEventListener('keyup', debounce(this.search.bind(this), 500))
    }

    createInputElement() {
        let input = document.createElement('input')
        input.type = 'hidden'
        input.name = this.name
        input.value = this.value
        input.required = this.required
        return input
    }

    createResultsContainer() {
        let resultsContainer = document.createElement('div')
        resultsContainer.className = 'search-results form-control p-0'
        resultsContainer.id = this.id + '-search-results'
        return resultsContainer
    }

    createSelectedContainer() {
        let selectedContainer = document.createElement('div')
        selectedContainer.className = 'selected-items form-control border-top-0 p-1 d-none'
        selectedContainer.id = this.id + '-selected-items'
        return selectedContainer
    }

    createSelectedElement() {
        let selectedElement = document.createElement('span')
        selectedElement.className = 'selected-item d-block-inline badge bg-success ps-1 my-1 mx-2'
        return selectedElement
    }

    createOptionElement(item) {
        let optionElement = document.createElement('option')
        if (typeof this.optionTemplate === 'function') this.optionTemplate(optionElement, item)
        else optionElement.innerHTML = item.name
        optionElement.addEventListener('click', _ => {
            if (this.multiple) this.appendSelected(item)
            else this.setSelected(item)
            this.el.dispatchEvent(new Event('keyup'))
        })
        return optionElement
    }

    setSelected(item) {
        this.inputElement.value = item.id
        this.el.value = this.selectedTemplate?.(item) ?? item.name ?? item.id
        this.resultsContainer.innerHTML = ''
        this.resultsContainer.append(this.createOptionElement(item))
    }

    appendSelected(item) {
        this.selectedContainer.classList.remove('d-none')
        this.el.required = false

        let newSelectedItem = this.createSelectedElement()
        newSelectedItem.innerHTML = this.selectedTemplate?.(item) ?? item.id
        newSelectedItem.addEventListener('click', _ => {
            newSelectedItem.remove()
            if (this.selectedContainer.children.length === 0) {
                this.el.required = true
                this.selectedContainer.classList.add('d-none')
            }
        })

        let multipleInput = this.createInputElement()
        multipleInput.value = item.id

        newSelectedItem.append(multipleInput)
        this.selectedContainer.append(newSelectedItem)

        this.el.value = ''
        this.resultsContainer.innerHTML = ''
    }

    search()  {
        this.resultsContainer.innerHTML = ''

        if (this.el.value.length < 3) return this.resultsContainer.innerHTML = '<span>type at least 3 characters</span>'
        else this.resultsContainer.innerHTML = '<span>searching...</span>'

        get( this.route,{q: this.el.value})
        .then(data => {
            if (data.length === 0) return this.resultsContainer.innerHTML = '<span>no results</span>'
            else this.resultsContainer.innerHTML = ''
            if (this.sorter === 'function') data.sort(this.sorter)
            data.forEach(item => this.resultsContainer.append(this.createOptionElement(item)))
        })
        .catch(err => {
            this.resultsContainer.innerHTML = '<span class="text-danger">there was an error!</span>'
            console.error(err)
        })
    }
}