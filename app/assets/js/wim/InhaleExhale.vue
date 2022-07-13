<template>
    <div id="inhale-exhale">
        <div class="pano">
            <div class="count" id="haleCounter">{{breathCounter}}</div>
            <div class="circle"></div>
        </div>
    </div>
</template>

<script>

export default {
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
        console.log('mounted')
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

</style>