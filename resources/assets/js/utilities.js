// Find CSRF token in page meta tags
const token = document.head.querySelector('meta[name="csrf-token"]').content
if (token === undefined) console.error("X-CSRF token could not be found!")

// Global wrapper methods for the native fetch api
function request (method, url, params, options) {
    options.method = method
    options.headers = options.headers ?? {}
    if (method === 'GET') {
        url += `?${(new URLSearchParams(params))}`
    } else {
        if(!(params instanceof FormData)){
            options.headers["Content-Type"] = "application/json"
            params = JSON.stringify(params)
        }
        options.body = params
        options.headers["X-Requested-With"] = "XMLHttpRequest"
        options.headers["X-CSRF-TOKEN"] = token
        options.credentials = "same-origin"
    }
    const result = fetch(url, options)
    return result.then(response => {
        if (!response.ok || (options.parse !== undefined && options.parse === false)) return response
        return response.json()
    })
}

global.get = (url, params = {}, options = {}) => request('GET', url, params, options)
global.post = (url, params = {}, options = {}) => request('POST', url, params, options)

// Method to debounce function calls
global.debounce = (callback, timeout = 300) => {
    let timer
    return (...args) => {
        clearTimeout(timer)
        timer = setTimeout(_ => {
            callback.apply(this, args)
        }, timeout)
    }
}