<template>

    <div>
        <lap-settings @start="start" :startExercise="start" v-if="isSettings"></lap-settings>

        <!--        <div id="timer1"></div>-->
        <!--        <div id="timer2"></div>-->

        <!--        <iframe width="560" height="315" src="https://www.youtube.com/embed/mD3QwerSmLs"-->
        <!--                title="YouTube video player" frameborder="0"-->
        <!--                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"-->
        <!--                allowfullscreen></iframe>-->


        <div class="canvas" v-else>
            <inhale-exhale :settings="laps"></inhale-exhale>
        </div>

<!--        <button @click="isSettings = !isSettings">Переключить</button>-->
    </div>

</template>

<script>
import LapSettings from "./LapSettings";
import InhaleExhale from "./InhaleExhale";

export default {
    components: {InhaleExhale, LapSettings},
    data      : () => ({
        isSettings: true,
        laps: {
            breaths : 0,
            waitingTime : 0
        }
    }),
    methods   : {
        start(lapsSettings) {
            console.log('app start', lapsSettings);
            this.isSettings = false;
            //
            // this.settings.breaths.forEach()
            // setTimeout(() => {}, )

        },
    }
}
</script>