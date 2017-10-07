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
            <td class="zone-admin">{{ zone_admin }}</td>
            <td class="zone-refresh">{{ zone.refresh }}</td>
            <td class="zone-retry">{{ zone.retry }}</td>
            <td class="zone-expire">{{ zone.expire }}</td>
            <td class="zone-ttl">{{ zone.ttl }}</td>
        </template>

        <td class="fit">
            <sa-button @click.native="toggleEdit" :type="editMode ? 'success' : 'default'"
                       :icon="editMode ? 'check' : 'pencil'" size="sm" :loading="processing"></sa-button>
            <sa-button @click.native="toggleEnabled" :icon="zone.enabled ? 'toggle-on' : 'toggle-off'" size="sm"
                       :loading="processing"></sa-button>
            <sa-button @click.native="deleteZone" type="danger" icon="trash" size="sm"
                       :loading="processing"></sa-button>
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['zone'],
        data() {
            return {
                interactionDisabled: true,
                processing: false,
                editMode: false
            };
        },
        methods: {
            deleteZone() {
                this.processing = true;
                axios.delete('/api/dns_zones/' + this.zone.id).then(response => {
                    this.$emit('onZoneDestroy', this.zone);
                    console.log('Success!');
                    // call bind config reload
                }).catch(error => {
                    console.error(error);
                });
            },
            toggleEnabled() {
                this.zone.enabled = !this.zone.enabled;
            },
            toggleEdit() {
                if (this.editMode) {
                    // submit form
                }

                this.editMode = !this.editMode;
            }
        },
        computed: {
            zone_admin() {
                return this.zone.admin.replace('.', '@');
                // TODO: Mutators, Accessors
            }
        }
    }
</script>
