<template>
    <tr :class="[zone.enabled ? '' : 'disabled']">
        <td class="zone-name">
            <a :href="'/dns/zones/' + zone.id" :title="'Edit zone ' + zone.name + ' records'">{{ zone.name }}</a>
        </td>

        <template v-if="editMode">
            <td class="zone-admin">
                <input @input="onChange" class="form-control input-sm" type="text" v-model="zone.admin" />
            </td>
            <td class="zone-refresh">
                <input @input="onChange" class="form-control input-sm" type="number" v-model="zone.refresh" />
            </td>
            <td class="zone-retry">
                <input @input="onChange" class="form-control input-sm" type="number" v-model="zone.retry" />
            </td>
            <td class="zone-expire">
                <input @input="onChange" class="form-control input-sm" type="number" v-model="zone.expire" />
            </td>
            <td class="zone-ttl">
                <input @input="onChange" class="form-control input-sm" type="number" v-model="zone.ttl" />
            </td>
        </template>

        <template v-else>
            <td class="zone-admin">{{ zone.admin }}</td>
            <td class="zone-refresh">{{ zone.refresh }}</td>
            <td class="zone-retry">{{ zone.retry }}</td>
            <td class="zone-expire">{{ zone.expire }}</td>
            <td class="zone-ttl">{{ zone.ttl }}</td>
        </template>

        <td class="fit">
            <sa-button @click.native="editZone"
                       :type="editButtonType"
                       :icon="editButtonIcon"
                       size="sm"
                       :loading="updating" />
            <sa-button @click.native="toggleEnabled"
                       :icon="zone.enabled ? 'toggle-on' : 'toggle-off'"
                       size="sm"
                       :loading="toggleForm.loading" />
            <sa-button @click.native="deleteZone"
                       type="danger"
                       icon="trash"
                       size="sm"
                       :loading="deleting" />
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
                deleting: false,
                changed: false,
                //
                toggleForm: new ServerAdmin.ToggleForm(),
            };
        },
        methods: {
            onChange() {
                this.changed = true;
            },
            editZone() {
                if (this.editMode && this.changed) {
                    this.updating = true;
                    axios.put('/api/dns/zones/' + this.zone.id, this.zone).then(response => {
                        ServerAdmin.Utils.updateAttributes(this.zone, response.data.data);
                        this.updating = false;
                        this.changed = false;
                    }).catch(error => {
                        this.updating = false;
                        console.error(error);
                    });
                }
                this.editMode = !this.editMode;
            },
            deleteZone() {
                this.deleting = true;
                axios.delete('/api/dns/zones/' + this.zone.id).then(response => {
                    this.$emit('destroy');
                }).catch(error => {
                    this.deleting = false;
                    console.error(error);
                });
            },
            toggleEnabled() {
                this.toggleForm.start();
                this.toggleForm.switch(this.zone.enabled);
                axios.patch('/api/dns/zones/' + this.zone.id, this.toggleForm.attributes).then(response => {
                    ServerAdmin.Utils.updateAttributes(this.zone, response.data.data);
                    this.toggleForm.finish();
                }).catch(error => {
                    this.toggleForm.crash(error);
                });
            },
        },
        computed: {
            editButtonIcon() {
                if (this.editMode) {
                    return this.changed ? 'check' : 'times';
                }
                return 'pencil';
            },
            editButtonType() {
                if (this.editMode) {
                    return this.changed ? 'success' : 'danger';
                }
                return 'default';
            }
        }
    }
</script>
