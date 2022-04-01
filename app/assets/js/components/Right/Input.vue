<template>
    <!-- Typing area -->
    <form class="bg-light">
        <div class="input-group">
            <input type="text" placeholder="Напишите сообщение" id="chat-input"
                   v-model="content"
                   @keydown.enter.prevent
                   @keyup.enter.prevent="sendMessage"
                   aria-describedby="button-addon2" class="form-control rounded-0 border-0 py-4 bg-light">
            <div class="input-group-append">
                <button id="button-addon2" type="submit"
                        class="btn btn-link"> <i @click.prevent="sendMessage" class="fa fa-paper-plane"></i></button>
            </div>
        </div>
    </form>
</template>

<script>
    export default {
        data: () => ({
            content: ''
        }),
        methods: {
            sendMessage() {
                if ('' !== this.content) {

                    //Блокируем инпут и кнопку
                    const input = document.querySelector("#chat-input");
                    input.disabled = true;
                    const button = document.querySelector("#button-addon2");
                    button.disabled = true;

                    this.$store.dispatch("POST_MESSAGE", {
                        conversationId: this.$route.params.id,
                        content: this.content
                    }).
                    then(() => {
                        //Разблокируем инпут и кнопку
                        this.content = '';
                        input.disabled = false;
                        button.disabled = false;
                        input.focus();
                    })
                }
            }
        }
    }
</script>
