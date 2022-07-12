<template>

    <div>
        <lap-settings @start="start" :startExercise="start"></lap-settings>

<!--        <div id="timer1"></div>-->
<!--        <div id="timer2"></div>-->

<!--        <iframe width="560" height="315" src="https://www.youtube.com/embed/mD3QwerSmLs"-->
<!--                title="YouTube video player" frameborder="0"-->
<!--                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"-->
<!--                allowfullscreen></iframe>-->

    </div>

</template>

<script>
import LapSettings from "./LapSettings";
export default {
    components: {LapSettings},
    data: () => ({
    }),
    methods: {
        start(data) {
            console.log('app start', data)
        },
    }
}
</script>