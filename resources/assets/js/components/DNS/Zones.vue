<template>
    <table class="table table-striped table-dns">
        <thead>
        <tr>
            <th colspan="2">Name</th>
            <th colspan="3">Options</th>
        </tr>
        </thead>
        <tbody>
        <dns_zone v-for="zone in manager.zones"
                  :key="zone.id"
                  :zone="zone"
                  @onZoneDestroy="manager.remove(zone)">
        </dns_zone>
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

        remove(zone) {
            this.zones.splice(this.zones.indexOf(zone), 1);
        }

    }

    export default {
        mounted() {
            axios.get('/api/dns_zones').then(response => {
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
