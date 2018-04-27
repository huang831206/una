<template>
    <div class="message-card" @click="messageClicked">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header"><v-icon>warning</v-icon>Alert</div>

                    <div class="card-body">
                        發送時間：{{pageData.message.date}}<br>
                        持有人：<br>
                        裝置編號：{{pageData.message.device}}<br>
                        緯度：{{pageData.message.lat}}<br>
                        經度：{{pageData.message.lng}}

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            pageData:{

            }
        },

        mounted() {
            console.log('Component mounted.')
        },

        data() {
            return {
                msg: 'i am data'
            };
        },

        methods: {
            messageClicked(){
                console.log('before emot');
                console.log(this.pageData);
                Bus.$emit('messageClicked', this.pageData);
            }
        }
    }
</script>

<style lang="scss" scoped>
    .message-card{
        padding:2px;

        .card{
            padding-left: 1.5em;

            .card-header{
                color: red;
            }

            .icon{
                color: red;
            }
        }
    }
</style>
