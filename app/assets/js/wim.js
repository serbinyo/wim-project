import '../css/wim.css';
import Vue from "vue";
import App from "./wim/App";
import {Timer} from "./classes/Timer"

new Vue({
    render: h => h(App)
}).$mount('#app');

let timer1 = new Timer('timer1', 5);
let timer2 = new Timer('timer2', 10);
timer1.startTimer();
timer2.startTimer();