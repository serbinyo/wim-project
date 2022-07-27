<template>
    <p class="speech"><slot></slot></p>
</template>

<script>

export default {
    data: () => ({
    }),
    methods: {
    },
    mounted() {
    }
}
</script>

<style>

/* speech bubble */
.speech {
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

p.speech {
    /*margin-top: 320px;*/
}

</style>