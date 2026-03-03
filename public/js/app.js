// public/js/app.js

import './bootstrap';

// Tom Select — повний відносний шлях від node_modules
import TomSelect from '../node_modules/tom-select/dist/js/tom-select.complete.js';
window.TomSelect = TomSelect;

// Якщо Vue потрібен
import Vue from 'vue';
window.Vue = Vue;

// Компонент
import ExampleComponent from './components/ExampleComponent.vue';
Vue.component('example-component', ExampleComponent);

const app = new Vue({
    el: '#app',
});

console.log('TomSelect імпортовано:', TomSelect);
console.log('window.TomSelect доступний:', !!window.TomSelect);
