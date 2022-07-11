<template>
    <div>
        <div class="row">
            <div class="col">Количество Вдохов</div>
            <div class="col">Задержка дыхания, сек</div>
        </div>
        <div class="row lap" v-for="(number, index) in laps">

            <div class="col">
                <input type="text" class="form-control" v-model="breaths[index]"
                       placeholder="Количество Вдохов" aria-label="Количество Вдохов">
            </div>
            <div class="col">
                <input type="text" class="form-control" v-model="waitingTime[index]"
                       placeholder="Задержка дыхания, сек" aria-label="Задержка дыхания, сек">
            </div>
        </div>
        <div class="row">
            <button class="btn" @click="addLap">Добавить круг</button>
            <button class="btn btn-primary" @click="start">Старт</button>
        </div>
    </div>
</template>

<script>

export default {
    data: () => ({
        laps       : [1, 2, 3],
        breaths    : [
            30,
            30,
            30
        ],
        waitingTime: [
            30,
            60,
            90
        ]
    }),
    mounted() {
        console.log(this.lap)
    },
    methods: {
        addLap() {
            this.laps.push(this.laps.length + 1);
        },
        start() {
            console.log('Старт')
        }
    }
}
</script>