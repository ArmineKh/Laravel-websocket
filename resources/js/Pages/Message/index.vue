<template>
    <div class="w-1/2 mx-auto py-6">
        <div class="flex">
            <div class="mb-4">
                <input v-model="body" type="text" class="rounded-full border-gray-400" placeholder="Your message">
            </div>
            <div class="mx-2">
                <a @click.prevent="store" href="#" class="rounded-lg block w-40 bg-sky-400 text-white text-center py-2">Send</a>
            </div>
        </div>

        <div v-if="messages.length" class="mb-4">
            <h3>Messages</h3>
            <div class="pt-4">
                <div class="text-sm pb-2 mb-6 border-b border-gray-300" v-for="message in messages">
                    <p>{{message.id}}</p>
                    <p>{{message.body}}</p>
                    <p class="text-right">{{message.time}}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: 'Index',
    props: [
        'messages'
    ],
    data(){
        return {
            body: ''
        }
    },
    created() {
        window.Echo.channel('store_message')
            .listen('.store_message', res =>{

                this.messages.unshift(res.message);
            })
    },
    methods: {
        store(){
            axios.post('/messages', {body: this.body})
                .then(res =>{
                    console.log(res.data)
                    this.messages.unshift(res.data);
                    this.body = '';
                })
        }
    }
}

</script>

<style scoped>

</style>
