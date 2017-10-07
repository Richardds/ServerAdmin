<template>
    <tr :class="[zone.enabled ? '' : 'zone-disabled']">
        <td class="zone-name">
            {{ zone.name }}
        </td>

        <template v-if="editMode">
            <td class="zone-admin"><input class="form-control input-sm" type="text" v-model="zone.admin"></td>
            <td class="zone-refresh"><input class="form-control input-sm" type="number" v-model="zone.refresh"></td>
            <td class="zone-retry"><input class="form-control input-sm" type="number" v-model="zone.retry"></td>
            <td class="zone-expire"><input class="form-control input-sm" type="number" v-model="zone.expire"></td>
            <td class="zone-ttl"><input class="form-control input-sm" type="number" v-model="zone.ttl"></td>
        </template>

        <template v-else>
            <td class="zone-admin">{{ zone.admin }}</td>
            <td class="zone-refresh">{{ zone.refresh }}</td>
            <td class="zone-retry">{{ zone.retry }}</td>
            <td class="zone-expire">{{ zone.expire }}</td>
            <td class="zone-ttl">{{ zone.ttl }}</td>
        </template>

        <td class="fit">
            <sa-button @click.native="editZone" :type="editMode ? 'success' : 'default'"
                       :icon="editMode ? 'check' : 'pencil'" size="sm" :loading="updating"></sa-button>
            <sa-button @click.native="toggleEnabled" :icon="zone.enabled ? 'toggle-on' : 'toggle-off'" size="sm"
                       :loading="toggling"></sa-button>
            <sa-button @click.native="deleteZone" type="danger" icon="trash" size="sm"
                       :loading="deleting"></sa-button>
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['zone'],
        data() {
            return {
                editMode: false,

                updating: false,
                toggling: false,
                deleting: false
            };
        },
        methods: {
            editZone() {
                if (this.editMode) {
                    this.updating = true;
                    axios.put('/api/dns_zones/' + this.zone.id, this.zone).then(response => {
                        this.$emit('onZoneUpdate', response.data.data);
                        this.updating = false;
                    }).catch(error => {
                        this.updating = false;
                        console.error(error);
                    });
                }

                this.editMode = !this.editMode;
            },
            deleteZone() {
                this.deleting = true;
                axios.delete('/api/dns_zones/' + this.zone.id).then(response => {
                    this.$emit('onZoneDestroy', this.zone);
                }).catch(error => {
                    this.deleting = false;
                    console.error(error);
                });
            },
            toggleEnabled() {
                // TODO
            },
        }
    }
</script>
