<template>
    <div>
        <div class="row">
            <div class="col">Количество дыханий</div>
            <div class="col">Задержка дыхания, сек</div>
        </div>
        <div class="row lap" v-for="(number, index) in laps">

            <div class="col">
                <input type="text" class="form-control" v-model="breaths[index]"
                       placeholder="Количество дыханий" aria-label="Количество дыханий">
            </div>
            <div class="col">
                <input type="text" class="form-control" v-model="waitingTime[index]"
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
import { helpers } from '@vuelidate/validators'

const noEmptyElementsInArray = (array) => !array.includes('');

export default {
    setup () {
        return { v$: useVuelidate() }
    },
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
    validations () {
        return {
            breaths : {
                noEmptyElementsInArray : helpers.withMessage('Заполните количество дыханий', noEmptyElementsInArray)
            },
            waitingTime : {
                noEmptyElementsInArray : helpers.withMessage('Заполните время задержки дыхания', noEmptyElementsInArray)
            }
        }
    },
    methods: {
        addLap() {
            this.laps.push(this.laps.length + 1);
            this.breaths.push('');
            this.waitingTime.push('');
        },
        async start () {
            const isFormCorrect = await this.v$.$validate();
            if (!isFormCorrect) {
                return;
            }

            console.log('Старт')
        }
    }
}
</script>