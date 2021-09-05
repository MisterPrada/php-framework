import '../scss/app.scss';

import {createApp} from 'vue';

import AppComponent from '../js/components/AppComponent';

const App = window.App = createApp(AppComponent);
App.component('test-component', require('../js/components/TestComponent.vue').default);

App.mount('#app');