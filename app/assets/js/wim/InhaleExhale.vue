<template>
    <div id="inhale-exhale">
        <div class="pano">

            <div class="circle">
            <div class="count" id="haleCounter">{{breathCounter}}</div></div>

<!--            <speech>Вдох-Выдох!</speach>-->

        </div>
    </div>
</template>

<script>

import Speech from "./Simple/Speech";
export default {
    components: {Speech},
    data: () => ({
        breathCounter : 1,
        inhaleExhaleTime: 4500
    }),
    methods: {
        beginBreathing() {
            setInterval(() => {
                this.breathCounter++;
            }, this.inhaleExhaleTime);
        }
    },
    mounted() {
        this.beginBreathing();
    }
}
</script>

<style>

/*region circle animation*/

.pano {
    position: fixed;
    overflow: auto;
}

.pano .count {
    z-index: 100;
    font-size: 3em;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);

}

.circle {
    background-image: url("../../../public/assets/img/meditation/mandala.jpg");
    content: "background-image";
    border-radius: 100%;
    width: 300px;
    height: 300px;
    -webkit-animation: pulsing 4500ms infinite;
    animation: pulsing 4500ms infinite;

}

@-webkit-keyframes pulsing {
    0% {
        -webkit-transform: scale(0.5, 0.5);
        transform: scale(0.5, 0.5)
    }
    50% {
        background-image: url("../../../public/assets/img/meditation/mandala.jpg");
        content: "background-image";
        -webkit-transform: scale(1.0, 1.0);
        transform: scale(1.0, 1.0);
    }
    100% {
        -webkit-transform: scale(0.5, 0.5);
        transform: scale(0.5, 0.5);
    }
}

@keyframes pulsing {
    0% {
        -webkit-transform: scale(0.5, 0.5);
        transform: scale(0.5, 0.5)
    }
    50% {
        background-image: url("../../../public/assets/img/meditation/mandala.jpg");
        content: "background-image";
        -webkit-transform: scale(1.0, 1.0);
        transform: scale(1.0, 1.0);
    }
    100% {
        -webkit-transform: scale(0.5, 0.5);
        transform: scale(0.5, 0.5);
    }
}
/*endregion circle animation*/

.speaker {
    padding-top: 320px;
}

/* speech bubble */
p.speech {
    position: relative;
    width: 200px;
    height: 100px;
    text-align: center;
    line-height: 100px;
    background-color: #fff;
    border: 8px solid #666;
    -webkit-border-radius: 30px;
    -moz-border-radius: 30px;
    border-radius: 30px;
    -webkit-box-shadow: 2px 2px 4px #888;
    -moz-box-shadow: 2px 2px 4px #888;
    box-shadow: 2px 2px 4px #888;
}

</style>