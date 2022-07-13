<template>
    <div>
        <div class="row">
            <div class="col">Количество дыханий</div>
            <div class="col">Задержка дыхания, сек</div>
        </div>
        <div class="row lap" v-for="(lap, index) in laps">

            <div class="col">
                <input type="text" class="form-control" v-model="lap.breaths"
                       placeholder="Количество дыханий" aria-label="Количество дыханий">
            </div>
            <div class="col">
                <input type="text" class="form-control" v-model="lap.waitingTime"
                       placeholder="Задержка дыхания, сек" aria-label="Задержка дыхания, сек">
            </div>
        </div>

        <div
            v-for="error of v$.$errors"
            :key="error.$uid"
        >
            <!--сообщения об ошибках-->
            <strong>{{ error.$message }}</strong>
        </div>

        <div class="row">
            <button class="btn" @click="addLap">Добавить круг</button>
            <button class="btn btn-primary" @click="start">Старт</button>
        </div>


    </div>
</template>

<script>

import useVuelidate from '@vuelidate/core'
import { helpers, noEmptyLapSettings  } from '../classes/Vuelidate/Validators'

export default {
    setup () {
        return { v$: useVuelidate() }
    },
    props: [
        'startExercise'
    ],
    data: () => ({
        laps    : [
            {
                breaths : 30,
                waitingTime : 30
            },
            {
                breaths : 30,
                waitingTime : 60
            },
            {
                breaths : 30,
                waitingTime : 90
            }
        ],
    }),
    validations () {
        return {
            laps : {
                noEmptyLapSettings : helpers.withMessage('Заполните настройки дыханий', noEmptyLapSettings)
            },
        }
    },
    methods: {
        addLap() {
            this.laps.push({
                breaths : '',
                waitingTime : ''
            });
        },
        async start () {
            const isFormCorrect = await this.v$.$validate();
            if (!isFormCorrect) {
                return;
            }

            this.startExercise(this.laps);
        }
    }
}
</script>