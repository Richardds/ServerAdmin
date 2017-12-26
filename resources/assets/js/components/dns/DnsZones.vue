<template>
    <table class="table table-striped table-controls table-dns-zones">
        <thead>
        <tr>
            <th>Name</th>
            <th>Admin</th>
            <th>Refresh</th>
            <th>Retry</th>
            <th>Expire</th>
            <th>TTL</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <sa-dns-zone v-for="zone in this.zones"
                     :key="zone.id"
                     :zone="zone"
                     @destroy-zone="destroy(zone.id)">
        </sa-dns-zone>
        </tbody>
    </table>
</template>

<script>
    export default {
        data() {
            return {
                zones: []
            };
        },
        mounted() {
            axios.get('/api/dns/zones').then(response => {
                for (let zone of response.data.data) {
                    this.zones.push(zone);
                }
            }).catch(error => {
                console.error(error);
            });
        },
        methods: {
            destroy(id) {
                this.zones = _.remove(this.zones, zone => zone.id !== id);
            }
        }
    }
</script>
