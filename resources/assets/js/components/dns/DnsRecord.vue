<template>
    <tr :class="[record.enabled ? '' : 'disabled', 'type-' + lowercaseType]">
        <td class="record-type">{{ record.type }}</td>

        <template v-if="editMode">
            <td class="record-name">
                <input @input="onChange" class="form-control input-sm" type="text" v-model="record.name">
            </td>
            <td class="record-value">
                <template v-if="'A' === record.type">
                    <div class="input-group">
                        <span class="input-group-addon">IPv4</span>
                        <input type="text" @input="onChange" class="form-control input-sm" v-model="record.attrs.ipv4" />
                    </div>
                </template>
                <template v-else-if="'AAAA' === record.type">
                    <div class="input-group">
                        <span class="input-group-addon">IPv6</span>
                        <input type="text" @input="onChange" class="form-control input-sm" v-model="record.attrs.ipv6" />
                    </div>
                </template>
                <template v-else-if="'CNAME' === record.type">
                    <div class="input-group">
                        <span class="input-group-addon">Host</span>
                        <input type="text" @input="onChange" class="form-control input-sm" v-model="record.attrs.host" />
                    </div>
                </template>
                <template v-else-if="'MX' === record.type">
                    <div class="row">
                        <div class="col-md-7 small-gaps">
                            <div class="input-group">
                                <span class="input-group-addon">Host</span>
                                <input type="text" @input="onChange" class="form-control input-sm" v-model="record.attrs.host" />
                            </div>
                        </div>
                        <div class="col-md-5 small-gaps">
                            <div class="input-group">
                                <span class="input-group-addon">Priority</span>
                                <input type="number" step="10" @input="onChange" class="form-control input-sm" v-model="record.attrs.priority" />
                            </div>
                        </div>
                    </div>
                </template>
                <template v-else-if="'SRV' === record.type">
                    <div class="row">
                        <div class="col-md-6 small-gaps">
                            <div class="input-group">
                                <span class="input-group-addon">Priority</span>
                                <input type="number" step="10" @input="onChange" class="form-control input-sm" v-model="record.attrs.priority" />
                            </div>
                        </div>
                        <div class="col-md-6 small-gaps">
                            <div class="input-group">
                                <span class="input-group-addon">Weight</span>
                                <input type="number" step="10" @input="onChange" class="form-control input-sm" v-model="record.attrs.weight" />
                            </div>
                        </div>
                    </div>
                    <div class="row top-buffer">
                        <div class="col-md-7 small-gaps">
                            <div class="input-group">
                                <span class="input-group-addon">Host</span>
                                <input type="text" @input="onChange" class="form-control input-sm" v-model="record.attrs.host" />
                            </div>
                        </div>
                        <div class="col-md-5 small-gaps">
                            <div class="input-group">
                                <span class="input-group-addon">Port</span>
                                <input type="number" @input="onChange" class="form-control input-sm" v-model="record.attrs.port" />
                            </div>
                        </div>
                    </div>
                    <div class="row top-buffer">
                        <div class="col-md-6 small-gaps">
                            <div class="input-group">
                                <span class="input-group-addon">Service</span>
                                <input type="text" @input="onChange" class="form-control input-sm" v-model="record.attrs.service" />
                            </div>
                        </div>
                        <div class="col-md-6 small-gaps">
                            <div class="input-group">
                                <span class="input-group-addon">Protocol</span>
                                <input type="text" @input="onChange" class="form-control input-sm" v-model="record.attrs.protocol" />
                            </div>
                        </div>
                    </div>
                </template>
                <template v-else-if="'TXT' === record.type">
                    <div class="input-group">
                        <span class="input-group-addon">Content</span>
                        <textarea @input="onChange" rows="4" class="form-control input-sm" v-model="record.attrs.content"></textarea>
                    </div>
                </template>
                <template v-else-if="'NS' === record.type">
                    <div class="input-group">
                        <span class="input-group-addon">Nameserver</span>
                        <input type="text" @input="onChange" class="form-control input-sm" v-model="record.attrs.nameserver" />
                    </div>
                </template>
            </td>
            <td class="record-ttl">
                <input @input="onChange" class="form-control input-sm" type="number" v-model="record.ttl">
            </td>
        </template>

        <template v-else>
            <td class="record-name">
                <template v-if="'SRV' === record.type">
                    {{ record.attrs.service }}.{{ record.attrs.protocol }}.{{ record.name }}
                </template>
                <template v-else>{{ record.name}}</template>
            </td>
            <td class="record-value">
                <template v-if="'A' === record.type"><span class="lighter">points to</span> {{ record.attrs.ipv4}}</template>
                <template v-else-if="'AAAA' === record.type"><span class="lighter">points to</span> {{ record.attrs.ipv6 }}</template>
                <template v-else-if="'CNAME' === record.type"><span class="lighter">is an alias of</span> {{ record.attrs.host }}</template>
                <template v-else-if="'MX' === record.type">
                    <span class="lighter">mail handled by</span> {{ record.attrs.host }} <span class="lighter">with priority</span> {{ record.attrs.priority }}
                </template>
                <template v-else-if="'SRV' === record.type">
                    {{ record.attrs.priority }} {{ record.attrs.weight }} {{ record.attrs.port }} {{ record.attrs.host }}
                </template>
                <template v-else-if="'TXT' === record.type">{{ record.attrs.content }}</template>
                <template v-else-if="'NS' === record.type"><span class="lighter">managed by</span> {{ record.attrs.nameserver }}</template>
            </td>
            <td class="record-ttl">{{ record.ttl }}</td>
        </template>

        <td class="fit">
            <sa-button @click.native="editRecord()"
                       :type="editButtonType"
                       :icon="editButtonIcon"
                       size="sm"
                       :loading="updating" />
            <sa-button @click.native="toggleRecord()"
                       :icon="record.enabled ? 'toggle-on' : 'toggle-off'"
                       size="sm"
                       :loading="toggleRecordForm.loading" />
            <sa-button @click.native="destroyRecord()"
                       type="danger"
                       icon="trash"
                       size="sm"
                       :loading="destroyRecordForm.loading" />
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['record'],
        data() {
            return {
                editMode: false,
                updating: false,
                changed: false,
                //
                toggleRecordForm: new ServerAdmin.ToggleForm(),
                destroyRecordForm: new ServerAdmin.Form({
                    'id': -1
                }),
            };
        },
        methods: {
            onChange() {
                this.changed = true;
            },
            editRecord() {
                if (this.editMode && this.changed) {
                    this.updating = true;
                    axios.put('/api/dns/records/' + this.record.id, this.record).then(response => {
                        ServerAdmin.Utils.updateAttributes(this.record, response.data.data);
                        this.updating = false;
                        this.changed = false;
                    }).catch(error => {
                        this.updating = false;
                        console.error(error);
                    });
                }
                this.editMode = !this.editMode;
            },
            destroyRecord() {
                this.destroyRecordForm.start();
                axios.delete('/api/dns/records/' + this.record.id).then(() => {
                    this.destroyRecordForm.finish();
                    this.$emit('destroy');
                }).catch(error => {
                    this.destroyRecordForm.crash(error);
                });
            },
            toggleRecord() {
                this.toggleRecordForm.start();
                this.toggleRecordForm.switch(this.record.enabled);
                axios.patch('/api/dns/records/' + this.record.id, this.toggleRecordForm.attributes).then(response => {
                    ServerAdmin.Utils.updateAttributes(this.record, response.data.data);
                    this.toggleRecordForm.finish();
                }).catch(error => {
                    this.toggleRecordForm.crash(error);
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
            },
            lowercaseType() {
                return this.record.type.toLowerCase();
            }
        }
    }
</script>
