<template>
    <div class="card" id="wim-exercise">
        <div class="row row-bordered g-0">
            <div class="col-md-6">
                <h5 class="card-header m-0 me-2 pb-3">Упражнение</h5>

                <div class="px-2 text-center">
                    <div class="canvas" v-if="isExercise">
                        <inhale-exhale
                            :counter="!defaultSetting"
                            v-if="isBreathingPhase"></inhale-exhale>

                        <div v-show="!isBreathingPhase" class="breathing-phase">
                            <div id="timer"></div>
                        </div>
                    </div>
                    <div v-else-if="isExerciseDone">
                        <img src="/assets/img/elements/fi-success.png"
                             alt="You did it" class="rounded mb-5">
                    </div>
                    <div v-else>
                        <speech>
                            Удели 15 минут, что бы тебя никто не отвлекал и попробуй сейчас
                        </speech>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img src="/assets/img/icons/unicons/chart.png" alt="Credit Card" class="rounded">
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6" style="">
                                <a class="dropdown-item" :class="{'active' : defaultSetting}"
                                   @click="defaultSetting = true">Стандарт</a>
                                <a class="dropdown-item" :class="{'active' : !defaultSetting}"
                                   @click="defaultSetting = false">Настроить</a>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div v-if="defaultSetting">
                            <default-settings @start="start" :startExercise="start" v-if="isSettings">
                            </default-settings>
                            <div v-else>
                                <p>
                                    Следуй командам Вима для выполнения дыхательного упражнения<br>
                                    Если вы зарегистрированы результат выполнения будет сохранен в персональный аккаунт
                                </p>
                                <mini-audio
                                    ref="audioplayer"
                                    :loop="true"
                                    :preload="true"
                                    :autoplay="true"
                                    :audio-source="audio.default"
                                ></mini-audio>
                            </div>

                        </div>
                        <div v-else>
                            <lap-settings @start="start" :startExercise="start" v-if="isSettings"></lap-settings>
                            <div v-else>
                                <speech>{{ message }}</speech>
                                <mini-audio
                                    ref="audioplayer"
                                    :loop="true"
                                    :preload="true"
                                    :autoplay="true"
                                    :audio-source="audio.trek"
                                ></mini-audio>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import LapSettings from "./LapSettings";
import DefaultSettings from "./DefaultSettings";
import InhaleExhale from "./InhaleExhale";
import {Timer} from "../classes/Timer"
import NoSleep from 'nosleep.js';
import Speech from "./Simple/Speech";

const axios = require('axios').default;
const INHALE_TIME = 15;

export default {
    components: {Speech, InhaleExhale, LapSettings, DefaultSettings},
    data      : () => ({
        isSettings      : true,
        isExercise      : false,
        isExerciseDone  : false,
        laps            : [
            {
                number     : 0,
                breaths    : 0,
                waitingTime: 0,
                inhaleHold : 0
            }
        ],
        currentLap      : {
            breaths    : 0,
            waitingTime: 0
        },
        isBreathingPhase: true,
        flag            : false,
        n               : 0,
        noSleepLock     : new NoSleep(),
        message         : '',
        intervalObject  : null,
        //Время задержки дыхания на вдохе
        INHALE_TIME: INHALE_TIME,
        audio      : {
            trek   : '/assets/audio/medifon/Ян-душа.mp3',
            default: '/assets/audio/wim/default-ru.mp3'
        },
        //стандартные настройки
        defaultSetting: true
    }),
    methods   : {
        start(laps) {
            this.laps = laps;

            this.isSettings = false;
            this.isExercise = true;
            this.isBreathingPhase = true;

            this.noSleepStart();

            this.runLap(this.laps[this.n]);
        },
        runLap(lap) {
            let that = this;
            that.currentLap = lap;
            that.needBreathingPhaseTimer = true;
            that.needHoldTimer = false;
            that.needInhaleTimer = false;
            that.message = 'Вдох-выдох';

            // цикл, пока идет упражнение
            // done - очищать память после завершения (clear interval)
            that.intervalObject = setInterval(function () {

                    if (
                        true === that.isBreathingPhase
                        && true === that.needBreathingPhaseTimer
                    ) {
                        //Фаза дыхания
                        that.needBreathingPhaseTimer = false;

                        setTimeout(function () {
                                that.isBreathingPhase = false;
                                that.needHoldTimer = true;
                                that.message = 'Задержка на выдохе'
                            },
                            //4,5 секунды на дыхание * на количество дыханий
                            4500 * that.currentLap.breaths
                        );

                    } else if (true === that.needHoldTimer) {
                        //Фаза задержки дыхания на выдохе
                        that.needHoldTimer = false;

                        let timer = new Timer('timer', that.currentLap.waitingTime);
                        timer.startTimer();

                        setTimeout(function () {
                                that.needInhaleTimer = true;
                                that.message = 'Глубокий вдох и небольшая задержка'
                            },
                            that.currentLap.waitingTime * 1000
                        );

                    } else if (true === that.needInhaleTimer) {
                        that.needInhaleTimer = false;
                        let it = that.INHALE_TIME;
                        //Фаза задержки дыхания на вдохе
                        let timer = new Timer('timer', it);
                        timer.startTimer();
                        setTimeout(function () {
                            that.next();
                        }, that.INHALE_TIME * 1000)
                    }
                },
                10
            );
        },
        next() {
            this.n++;

            //всегда очищаем интервал предыдущего круга, для избежания утечки памяти на клиенте
            this.stopInterval();

            if (this.n < this.laps.length) {
                this.isBreathingPhase = true;
                this.runLap(this.laps[this.n]);
            } else {
                //упражнение закончено
                this.noSleepEnd();
                this.isExercise = false;
                this.isExerciseDone = true;
                this.addResult();

                this.message = 'Молодец!';
            }
        },
        noSleepStart() {
            let that = this;
            // Enable wake lock.
            // (must be wrapped in a user input event handler e.g. a mouse or touch handler)
            document.addEventListener('click', function enableNoSleep() {
                document.removeEventListener('click', enableNoSleep, false);
                that.noSleepLock.enable();
            }, false);
        },
        noSleepEnd() {
            // Disable wake lock at some point in the future.
            // (does not need to be wrapped in any user input event handler)
            this.noSleepLock.disable();
        },
        stopInterval() {
            clearInterval(this.intervalObject);
        },
        addResult() {
            let data = new FormData();
            data.append('laps', JSON.stringify(this.laps));

            axios.post(
                '/breath/add',
                data
            )
                .then(function (response) {
                    // handle success
                    console.log(response);
                })
        },
    }
}
</script>
