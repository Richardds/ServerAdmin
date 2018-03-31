<template>
    <div>
        <sa-button @click.native="toggleService()" :type="running ? 'danger' : 'success'"
                   :icon="running ? 'stop' : 'play'" :disabled="pending"
                   :loading="toggling">{{ running ? 'Stop' : 'Start' }}</sa-button>
        <sa-button @click.native="restartService()" type="warning" icon="bolt"
                   :disabled="!running || pending" :loading="restarting">Restart</sa-button>
        <sa-button @click.native="reloadService()" type="warning" icon="refresh"
                   :disabled="!running || pending" :loading="reloading">Reload</sa-button>
        <sa-button @click.native="reconfigureService()" v-show="configurable" type="info" icon="retweet"
                   :disabled="pending" :loading="reconfiguring">Reconfigure</sa-button>
    </div>
</template>

<script>
    export default {
        props: ['service'],
        data() {
            return {
                running: false,
                configurable: false,
                //
                toggling: true,
                restarting: false,
                reloading: false,
                reconfiguring: false,
            };
        },
        mounted() {
            this.loadStatus();
        },
        methods: {
            loadStatus() {
                this.toggling = true;
                axios.post('/api/service/status', {service: this.service}).then(response => {
                    this.handleStatus(response.data.data);
                    this.toggling = false;
                }).catch(error => {
                    this.toggling = false;
                    console.error(error);
                });
            },
            handleStatus(status) {
                this.running = status.running;
                this.configurable = status.configurable;
            },
            toggleService() {
                this.toggling = true;
                if (this.running) {
                    axios.post('/api/service/stop', {service: this.service}).then(response => {
                        this.handleStatus(response.data.data);
                        this.toggling = false;
                    }).catch(error => {
                        this.toggling = false;
                        console.error(error);
                    });
                } else {
                    axios.post('/api/service/start', {service: this.service}).then(response => {
                        this.handleStatus(response.data.data);
                        this.toggling = false;
                    }).catch(error => {
                        this.toggling = false;
                        console.error(error);
                    });
                }
            },
            restartService() {
                this.restarting = true;
                axios.post('/api/service/restart', {service: this.service}).then(response => {
                    this.handleStatus(response.data.data);
                    this.restarting = false;
                }).catch(error => {
                    this.restarting = false;
                    console.error(error);
                });
            },
            reloadService() {
                this.reloading = true;
                axios.post('/api/service/reload', {service: this.service}).then(response => {
                    this.handleStatus(response.data.data);
                    this.reloading = false;
                }).catch(error => {
                    this.reloading = false;
                    console.error(error);
                });
            },
            reconfigureService() {
                this.reconfiguring = true;
                axios.post('/api/service/reconfigure', {service: this.service}).then(response => {
                    this.handleStatus(response.data.data);
                    this.reconfiguring = false;
                }).catch(error => {
                    this.reconfiguring = false;
                    console.error(error);
                });
            }
        },
        computed: {
            pending() {
                return this.toggling || this.restarting || this.reloading || this.reconfiguring;
            }
        }
    }
</script>
