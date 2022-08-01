<template>

    <div>
        <lap-settings @start="start" :startExercise="start" v-if="isSettings"></lap-settings>

        <div v-else-if="isExercise">
            <div class="canvas">
                <inhale-exhale v-if="isBreathingPhase"></inhale-exhale>

                <div v-show="!isBreathingPhase" class="breathing-phase">
                    <div id="timer"></div>
                </div>
            </div>
            <speech>{{ message }}</speech>
        </div>

        <div v-else>
            <speech>{{ message }}</speech>
        </div>
    </div>


</template>

<script>
import LapSettings from "./LapSettings";
import InhaleExhale from "./InhaleExhale";
import {Timer} from "../classes/Timer"
import NoSleep from 'nosleep.js';
import Speech from "./Simple/Speech";

const axios = require('axios').default;

export default {
    components: {Speech, InhaleExhale, LapSettings},
    data      : () => ({
        isSettings      : true,
        isExercise      : false,
        laps            : [
            {
                breaths    : 0,
                waitingTime: 0
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
        INHALE_TIME: 15,
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

            // цикл, пока идет упражнение TODO очищать память после завершения (clear interval)
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
            console.log(this.laps)

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

<style>

.canvas {
    height: 300px;
}

</style>