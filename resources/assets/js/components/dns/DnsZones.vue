<template>
    <table class="table table-striped table-controls table-dns-zone">
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
        <sa-dns-zone v-for="zone in manager.zones"
                     :key="zone.id"
                     :zone="zone"
                     @destroy-zone="manager.destroy(zone)">
        </sa-dns-zone>
        </tbody>
    </table>
</template>

<script>
    class Zones {
        constructor() {
            this.zones = [];
        }

        add(zone) {
            this.zones.push(zone);
        }

        destroy(zone) {
            this.zones.splice(this.zones.indexOf(zone), 1);
        }

    }

    export default {
        mounted() {
            axios.get('/api/dns/zones').then(response => {
                for (let zone of response.data.data) {
                    this.manager.add(zone);
                }
            }).catch(error => {
                console.error(error);
            });
        },
        data() {
            return {
                manager: new Zones()
            };
        }
    }
</script>
