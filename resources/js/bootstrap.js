window._ = require('lodash');


try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    require('overlayscrollbars');
    require('../../vendor/almasaeed2010/adminlte/dist/js/adminlte');
    require('bootstrap');
    require('datatables.net');
    require('datatables.net-bs4');
    require('datatables.net-buttons');
    require('datatables.net-buttons-bs4');
    require('datatables.net-fixedheader');
    require('datatables.net-responsive');
    require('datatables.net-responsive-bs4');
    require('datatables.net-scroller');
    window.Swal = require('sweetalert2')
    window.axios = require('axios');

    require('icheck');

} catch (e) {
    alert(e.toString());
}

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
