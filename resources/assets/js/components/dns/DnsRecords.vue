<template>
    <div>
        <sa-modal :visible="createRecordForm.enabled"
                  @close="createRecordForm.close()"
                  title="Create record">
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="addRecordType" class="col-md-3 control-label">Type</label>
                    <div class="col-md-8">
                        <select class="form-control" id="addRecordType" v-model="createRecordForm.attributes.type" @change="resetAttrs">
                            <option v-for="type in availableRecordTypes">{{type}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="addRecordName" class="col-md-3 control-label">Name</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="addRecordName" v-model="createRecordForm.attributes.name" />
                    </div>
                </div>
                <template v-if="'A' === createRecordForm.attributes.type">
                    <div class="form-group">
                        <label for="addRecordAAttrIPv4" class="col-md-3 control-label">IPv4</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="addRecordAAttrIPv4" v-model="createRecordForm.attributes.attrs.ipv4" />
                        </div>
                    </div>
                </template>
                <template v-else-if="'AAAA' === createRecordForm.attributes.type">
                    <div class="form-group">
                        <label for="addRecordAAAAAttrIPv6" class="col-md-3 control-label">IPv6</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="addRecordAAAAAttrIPv6" v-model="createRecordForm.attributes.attrs.ipv6" />
                        </div>
                    </div>
                </template>
                <template v-else-if="'CNAME' === createRecordForm.attributes.type">
                    <div class="form-group">
                        <label for="addRecordCNAMEAttrHost" class="col-md-3 control-label">Host</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="addRecordCNAMEAttrHost" v-model="createRecordForm.attributes.attrs.host" />
                        </div>
                    </div>
                </template>
                <template v-else-if="'MX' === createRecordForm.attributes.type">
                    <div class="form-group">
                        <label for="addRecordMXAttrHost" class="col-md-3 control-label">Host</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="addRecordMXAttrHost" v-model="createRecordForm.attributes.attrs.host" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="addRecordMXAttrPriority" class="col-md-3 control-label">Priority</label>
                        <div class="col-md-8">
                            <input type="number" step="10" class="form-control" id="addRecordMXAttrPriority" v-model="createRecordForm.attributes.attrs.priority" />
                        </div>
                    </div>
                </template>
                <template v-else-if="'SRV' === createRecordForm.attributes.type">
                    <div class="form-group">
                        <label for="addRecordSRVAttrPriority" class="col-md-3 control-label">Priority</label>
                        <div class="col-md-8">
                            <input type="number" step="10" class="form-control" id="addRecordSRVAttrPriority" v-model="createRecordForm.attributes.attrs.priority" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="addRecordSRVAttrWeight" class="col-md-3 control-label">Weight</label>
                        <div class="col-md-8">
                            <input type="number" step="10" class="form-control" id="addRecordSRVAttrWeight" v-model="createRecordForm.attributes.attrs.weight" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="addRecordSRVAttrHost" class="col-md-3 control-label">Host</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="addRecordSRVAttrHost" v-model="createRecordForm.attributes.attrs.host" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="addRecordSRVAttrPort" class="col-md-3 control-label">Port</label>
                        <div class="col-md-8">
                            <input type="number" class="form-control" id="addRecordSRVAttrPort" v-model="createRecordForm.attributes.attrs.port" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="addRecordSRVAttrService" class="col-md-3 control-label">Service</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="addRecordSRVAttrService" v-model="createRecordForm.attributes.attrs.service" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="addRecordSRVAttrProtocol" class="col-md-3 control-label">Protocol</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="addRecordSRVAttrProtocol" v-model="createRecordForm.attributes.attrs.protocol" />
                        </div>
                    </div>
                </template>
                <template v-else-if="'TXT' === createRecordForm.attributes.type">
                    <div class="form-group">
                        <label for="addRecordTXTAttrContent" class="col-md-3 control-label">Content</label>
                        <div class="col-md-8">
                            <textarea rows="4" class="form-control input-sm"  id="addRecordTXTAttrContent" v-model="createRecordForm.attributes.attrs.content"></textarea>
                        </div>
                    </div>
                </template>
                <template v-else-if="'NS' === createRecordForm.attributes.type">
                    <div class="form-group">
                        <label for="addRecordNSAttrNameserver" class="col-md-3 control-label">Nameserver</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="addRecordNSAttrNameserver" v-model="createRecordForm.attributes.attrs.nameserver" />
                        </div>
                    </div>
                </template>
                <div class="form-group">
                    <label for="addRecordTTL" class="col-md-3 control-label">TTL</label>
                    <div class="col-md-8">
                        <input type="number" class="form-control" id="addRecordTTL" v-model="createRecordForm.attributes.ttl" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-3 col-md-8">
                        <sa-button @click.native="createRecord"
                                   icon="plus"
                                   :loading="createRecordForm.loading">Create</sa-button>
                    </div>
                </div>
            </div>
        </sa-modal>
        <table class="table table-striped table-controls table-dns-records">
            <thead>
            <tr>
                <th>Type</th>
                <th>Name</th>
                <th>Value</th>
                <th>TTL</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <sa-dns-record v-for="record in this.orderedRecords"
                           :key="record.id"
                           :record="record"
                           @destroyRecord="loadRecords()" />
            </tbody>
            <tfoot>
            <tr>
                <td colspan="5" class="text-right">
                    <sa-button @click.native="createRecordForm.open()"
                               icon="plus"
                               size="sm" />
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['zone'],
        data() {
            return {
                records: [],
                availableRecordTypes: ['A', 'AAAA', 'CNAME', 'MX', 'SRV', 'TXT', 'NS'],
                createRecordForm: new ServerAdmin.ModalForm({
                    zone_id: this.zone,
                    type: 'A',
                    name: '',
                    attrs: {},
                    ttl: 300
                }),
            };
        },
        mounted() {
            this.loadRecords();
            this.resetAttrs();
        },
        methods: {
            loadRecords() {
                axios.get('/api/dns/records?zone=' + this.zone).then(response => {
                    this.records = [];
                    for (let record of response.data.data) {
                        this.records.push(record);
                    }
                }).catch(error => {
                    console.error(error);
                });
            },
            createRecord() {
                this.createRecordForm.start();
                axios.post('/api/dns/records', this.createRecordForm.attributes).then(() => {
                    this.createRecordForm.finish();
                    this.resetAttrs();
                    this.loadRecords();
                }).catch(error => {
                    this.createRecordForm.crash(error);
                });
            },
            resetAttrs() {
                this.createRecordForm.attributes.attrs = {};
                switch (this.createRecordForm.attributes.type) {
                    case 'A':
                        this.createRecordForm.attributes.attrs.ipv4 = '127.0.0.1';
                        break;
                    case 'AAAA':
                        this.createRecordForm.attributes.attrs.ipv6 = '::1';
                        break;
                    case 'CNAME':
                        this.createRecordForm.attributes.attrs.host = 'www.example.com';
                        break;
                    case 'MX':
                        this.createRecordForm.attributes.attrs.host = 'mail.example.com';
                        this.createRecordForm.attributes.attrs.priority = 10;
                        break;
                    case 'SRV':
                        this.createRecordForm.attributes.attrs.priority = 10;
                        this.createRecordForm.attributes.attrs.weight = 10;
                        this.createRecordForm.attributes.attrs.host = 'sip.example.com';
                        this.createRecordForm.attributes.attrs.port = 5060 ;
                        this.createRecordForm.attributes.attrs.service = '_sip';
                        this.createRecordForm.attributes.attrs.protocol = '_tcp';
                        break;
                    case 'TXT':
                        this.createRecordForm.attributes.attrs.content = 'v=spf1 mx a -all';
                        break;
                    case 'NS':
                        this.createRecordForm.attributes.attrs.nameserver = 'ns.example.com';
                        break;
                }
            },
        },
        computed: {
            orderedRecords() {
                return _.sortBy(this.records, ['type', 'name']);
            }
        }
    }
</script>
