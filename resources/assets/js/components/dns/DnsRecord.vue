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
                    <textarea @input="onChange" class="form-control input-sm" v-model="record.attrs.content" placeholder="Content"></textarea>
                </template>
                <template v-else-if="'NS' === record.type">
                    <input type="text" @input="onChange" class="form-control input-sm" v-model="record.attrs.nameserver" placeholder="Nameserver" />
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
            <sa-button @click.native="editRecord"
                       :type="editButtonType"
                       :icon="editButtonIcon"
                       size="sm"
                       :loading="updating" />
            <sa-button @click.native="toggleEnabled"
                       :icon="record.enabled ? 'toggle-on' : 'toggle-off'"
                       size="sm"
                       :loading="toggling" />
            <sa-button @click.native="deleteRecord"
                       type="danger"
                       icon="trash"
                       size="sm"
                       :loading="deleting" />
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
                toggling: false,
                deleting: false,
                changed: false
            };
        },
        methods: {
            onChange() {
                this.changed = true;
            },
            updateAttributes(record) {
                _.forOwn(this.record, (value, key) => {
                    this.record[key] = record[key];
                });
            },
            editRecord() {
                if (this.editMode && this.changed) {
                    this.updating = true;
                    axios.put('/api/dns/records/' + this.record.id, this.record).then(response => {
                        this.updateAttributes(response.data.data);
                        this.updating = false;
                        this.changed = false;
                    }).catch(error => {
                        this.updating = false;
                        console.error(error);
                    });
                }
                this.editMode = !this.editMode;
            },
            deleteRecord() {
                this.deleting = true;
                axios.delete('/api/dns/records/' + this.record.id).then(response => {
                    this.$emit('destroy-record');
                }).catch(error => {
                    this.deleting = false;
                    console.error(error);
                });
            },
            toggleEnabled() {
                this.toggling = true;
                let nextStatus = !this.record.enabled;
                axios.patch('/api/dns/records/' + this.record.id, {enabled: nextStatus}).then(response => {
                    this.updateAttributes(response.data.data);
                    this.toggling = false;
                }).catch(error => {
                    this.toggling = false;
                    console.error(error);
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
