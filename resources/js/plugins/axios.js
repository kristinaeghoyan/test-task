import axios from 'axios';
import Vue from 'vue';


axios.create({
    baseURL: '/',
    headers: {
    'Content-Type': 'application/json',
        'Accept': 'application/json'
    },
});

Vue.prototype.$http = axios
