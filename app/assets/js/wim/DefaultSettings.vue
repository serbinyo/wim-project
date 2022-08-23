<template>
    <div>
        <p>
            Стандартное упражнение с Ютуб
        </p>

        <div class="row">
            <button class="btn btn-primary" @click="start">Старт</button>
        </div>
    </div>
</template>

<script>

const INHALE_TIME = 15;

export default {
    props: [
        'startExercise'
    ],
    data : () => ({
        INHALE_TIME: INHALE_TIME,
        laps       : [
            {
                number     : 1,
                breaths    : 30,
                waitingTime: 30,
                inhaleHold : INHALE_TIME
            },
            {
                number     : 2,
                breaths    : 28,
                waitingTime: 60,
                inhaleHold : INHALE_TIME
            },
            {
                number     : 3,
                breaths    : 27,
                waitingTime: 90,
                inhaleHold : INHALE_TIME
            }
        ],
    }),
    methods: {
        addLap() {
            this.laps.push({
                number     : this.laps.length + 1,
                breaths    : '',
                waitingTime: '',
                inhaleHold : INHALE_TIME
            });
        },
        async start() {
            this.startExercise(this.laps);
        }
    }
}
</script>