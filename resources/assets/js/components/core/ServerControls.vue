<template>
    <div>
        <sa-button @click.native="shutdownServer()" type="danger" icon="power-off"
                   :disabled="pending" :loading="shutdowning">Shutdown</sa-button>
        <sa-button @click.native="restartServer()" type="warning" icon="bolt"
                   :disabled="pending" :loading="restarting">Restart</sa-button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                shutdowning: false,
                restarting: false,
            };
        },
        methods: {
            shutdownServer() {
                this.shutdowning = true;
                axios.post('/api/server/shutdown').then(response => {
                    //
                }).catch(error => {
                    this.shutdowning = false;
                    console.error(error);
                });
            },
            restartServer() {
                this.restarting = true;
                axios.post('/api/server/restart').then(response => {
                    //
                }).catch(error => {
                    this.restarting = false;
                    console.error(error);
                });
            },
        },
        computed: {
            pending() {
                return this.restarting || this.shutdowning;
            }
        }
    }
</script>
