<template>
    <div class="card">
        <div class="row row-bordered g-0">
            <div class="col-md-6">
                <h5 class="card-header m-0 me-2 pb-3">Упражнение</h5>

                <div class="px-2 text-center">
                    <div class="canvas mb-2" v-if="isExercise && defaultSetting">
                        <iframe width="560" height="315"
                                src="https://www.youtube-nocookie.com/embed/mD3QwerSmLs?autoplay=1"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write;
                                encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                        </iframe>
                    </div>
                    <div class="canvas" v-else-if="isExercise">
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
                        <p class="fw-semibold">Результат сохранен</p>
                    </div>
                    <div v-else v-html="display"></div>
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
                                   @click="switchSettings('default')">Стандарт</a>
                                <a class="dropdown-item" :class="{'active' : !defaultSetting}"
                                   @click="switchSettings('settings')">Настроить</a>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div v-if="defaultSetting">
                            <default-settings :startExercise="start" v-if="isSettings">
                            </default-settings>
                            <div v-else-if="!isSettings && isSaveWindow">
                                <p>Если нужно уточните данные или добавьте круги,
                                    в соответствии с выполненным упражнением, после этого нажмите Сохранить</p>
                                <lap-settings
                                    :startExercise="start"
                                    :saveResult="addResult"
                                >
                                </lap-settings>
                            </div>
                            <div v-else-if="!isSettings">
                                <p>
                                    Следуй командам Вима для выполнения дыхательного упражнения
                                </p>
                                <p class="mt-2">
                                    Когда вы закончите,
                                    <button
                                        @click="goSave"
                                        class="btn
                                    btn-outline-warning mt-2">
                                        Перейдите к сохранению результата
                                    </button>
                                </p>
                            </div>

                        </div>
                        <div v-else>
                            <lap-settings :startExercise="start" v-if="isSettings"></lap-settings>
                            <div v-show="!isSettings">
                                <speech v-html="message"></speech>
                                <mini-audio
                                    ref="audioplayer"
                                    :loop="true"
                                    :preload="true"
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
        isSaveWindow    : false,
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
        display         : '<p>Удели 15 минут, что бы тебя никто не отвлекал и попробуй сейчас</p>',
        intervalObject  : null,
        //Время задержки дыхания на вдохе
        INHALE_TIME: INHALE_TIME,
        audio      : {
            trek   : '/assets/audio/medifon/Ян-душа.mp3',
            default: '/assets/audio/wim/default-ru.mp3'
        },
        //стандартные настройки
        defaultSetting : true,
        user_authorized: false
    }),
    mounted() {
        let that = this;

        axios.get(
            '/user/check'
        )
            .then(function (response) {
                // handle success
                if (200 === response.status) {
                    that.user_authorized = response.data.result;
                } else {
                    console.error()
                }
            })
    },
    methods: {
        start(laps) {
            this.laps = laps;

            this.isSettings = false;
            this.isExercise = true;
            this.isBreathingPhase = true;

            this.noSleepStart();

            this.playAudio();

            this.runLap(this.laps[this.n]);
        },
        reset() {
            this.stopInterval();
            this.isSettings = true;
            this.isExercise = false;
            this.isExerciseDone = false;
            this.isSaveWindow = false;
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

                //Сообщение о завершении упражнения
                if (this.user_authorized) {
                    this.message = 'Отлично! Результат сохранен.';
                } else {
                    this.message = 'Упражнение выполнено. ' +
                        '<a href="/registration">Зарегистрируйтесь</a>, если вы хотите ' +
                        'что бы ваши результаты сохранялись.';
                }
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
        //region settings tabs
        switchSettings(tab) {
            this.reset();
            this.defaultSetting = 'default' === tab;
        },
        playAudio() {
            if (!this.defaultSetting) {
                this.$refs.audioplayer.play();
            }
        },
        goSave() {
            this.isSettings = false;
            this.isSaveWindow = true;
        },
        //endregion settings tabs
        addResult() {
            let that = this;

            if (this.user_authorized) {
                let data = new FormData();
                data.append('laps', JSON.stringify(this.laps));
                axios.post(
                    '/breath/add',
                    data
                )
                    .then(function (response) {
                        // handle success
                        that.reset();
                        that.isExerciseDone = true;
                        that.display = '<p>Результат сохранен</p>'
                    })
            } else {
                that.display = '<p>Зарегистрируйтесь, что бы ваш прогресс сохранялся</p>';
            }
        },
    }
}
</script>
