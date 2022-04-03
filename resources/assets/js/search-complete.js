export default class SearchComplete {
    constructor(el, route, optionTemplate, selectedTemplate, sorter) {
        this.el = el
        this.route = route
        this.optionTemplate = optionTemplate
        this.selectedTemplate = selectedTemplate
        this.sorter = sorter
        this.multiple = el.hasAttribute('multiple')

        this.resultsContainer = this.createResultsContainer(el.id)
        this.inputElement = this.createInputElement(el.name, el.value)
        this.selectedContainer = this.createSelectedContainer(el.id)
        this.selectedElement = this.createSelectedElement()

        el.name = ''
        el.value = el.placeholder

        el.parentNode.append(this.resultsContainer)
        if (this.multiple) el.parentNode.append(this.selectedContainer)
        else el.parentNode.append(this.inputElement)

        this.search()
        el.addEventListener('keyup', this.search.bind(this))
    }

    createInputElement(name, value) {
        let input = document.createElement('input')
        input.type = 'hidden'
        input.name = name
        input.value = value
        return input
    }

    createResultsContainer(id) {
        let resultsContainer = document.createElement('div')
        resultsContainer.className = 'search-results form-control p-0'
        resultsContainer.id = id + '-search-results'
        return resultsContainer
    }

    createSelectedContainer(id) {
        let selectedContainer = document.createElement('div')
        selectedContainer.className = 'selected-items form-control border-top-0 p-1 d-none'
        selectedContainer.id = id + '-selected-items'
        return selectedContainer
    }

    createSelectedElement() {
        let selectedElement = document.createElement('span')
        selectedElement.className = 'selected-item d-block-inline badge bg-success ps-1 my-1 mx-2'
        return selectedElement
    }

    createOptionElement(item) {
        let option = document.createElement('option')
        if (typeof this.optionTemplate === 'function') this.optionTemplate(option, item)
        else option.innerHTML = item.name
        option.addEventListener('click', _ => {
            if (this.multiple) this.appendSelected(item)
            else this.setSelected(item)
            this.el.dispatchEvent(new Event('keyup'))
        })
        this.resultsContainer.append(option)
    }

    setSelected(item) {
        this.inputElement.value = item.id
        this.el.value = this.selectedTemplate?.(item) ?? item.name ?? item.id
        this.resultsContainer.innerHTML = ''
        this.resultsContainer.append(option)
    }

    appendSelected(item) {
        this.selectedContainer.classList.remove('d-none')
        this.el.required = false

        let newSelectedItem = this.selectedElement.cloneNode()
        newSelectedItem.innerHTML = this.selectedTemplate?.(item) ?? item.id
        newSelectedItem.addEventListener('click', _ => {
            newSelectedItem.remove()
            if (this.selectedContainer.children.length === 0) {
                this.el.required = true
                this.selectedContainer.classList.add('d-none')
            }
        })

        let multipleInput = this.inputElement.cloneNode()
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
            data.forEach(item => this.createOptionElement(item))
        })
        .catch(err => {
            this.resultsContainer.innerHTML = '<span class="text-danger">there was an error!</span>'
            console.error(err)
        })
    }
}