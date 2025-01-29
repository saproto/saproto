import axios from 'axios'

window.axios = axios

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

const token = document.head
    .querySelector('meta[name="csrf-token"]')
    ?.getAttribute('content')
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token
} else {
    console.error(
        'CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token'
    )
}
