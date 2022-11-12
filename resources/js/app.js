import Vue from "vue"
import IndexComponent from "./components/IndexComponent";


require('./bootstrap');

const app = new Vue({
    el: '#app',

    components: {
        IndexComponent,
    }
})
