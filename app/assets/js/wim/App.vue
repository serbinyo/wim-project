<template>

    <div>
        <lap-settings @start="start" :startExercise="start" v-if="isSettings"></lap-settings>

        <div class="canvas" v-else>
            <inhale-exhale v-if="isBreathingPhase"></inhale-exhale>
            <div v-show="!isBreathingPhase" id="timer"></div>
        </div>

    </div>

</template>

<script>
import LapSettings from "./LapSettings";
import InhaleExhale from "./InhaleExhale";
import {Timer} from "../classes/Timer"
import NoSleep from 'nosleep.js';

export default {
    components: {InhaleExhale, LapSettings},
    data      : () => ({
        isSettings      : true,
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
        domains         : ['localhost', 'wetGrundy.com', 'overflow.com'],
        n               : 0,
        noSleepLock : new NoSleep()
    }),
    methods   : {
        start(laps) {
            console.log('app start', laps);
            this.laps = laps;

            this.isSettings = false;
            this.isBreathingPhase = true;

            this.noSleepStart();

            this.runLap(this.laps[this.n]);
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
        runLap(lap) {
            let that = this;
            that.currentLap = lap;
            that.needBreathingPhaseTimer = true;
            that.needHoldTimer = false;
            that.needInhaleTimer = false;

            // какие-то действия, что-бы дождаться выполнения условий

            setInterval(function () {

                    if (
                        true === that.isBreathingPhase
                        && true === that.needBreathingPhaseTimer
                    ) {
                        console.log('setTimeoutBreathingPhase');
                        console.log(that.currentLap.breaths)
                        that.needBreathingPhaseTimer = false;

                        setTimeout(function () {
                                that.isBreathingPhase = false;
                                that.needHoldTimer = true;
                            },
                            //4,5 секунды на вдох
                            4500 * that.currentLap.breaths)

                    } else if (true === that.needHoldTimer) {
                        console.log('needHoldTimer');
                        that.needHoldTimer = false;

                        let timer = new Timer('timer', that.currentLap.waitingTime);
                        timer.startTimer();

                        setTimeout(function () {
                            that.needInhaleTimer = true;
                        }, that.currentLap.waitingTime * 1000)

                    } else if (true === that.needInhaleTimer) {
                        that.needInhaleTimer = false;
                        console.log('needInhaleTimer');
                        let timer = new Timer('timer', 15);
                        timer.startTimer();
                        setTimeout(function () {
                            that.next();
                        }, 15 * 1000)
                    }
                },
                10
            );
        },
        next() {
            this.n++;
            if (this.n < this.laps.length) {
                this.isBreathingPhase = true;
                this.runLap(this.laps[this.n]);
            } else {
                this.noSleepEnd()
            }
        },
    }
}
</script>