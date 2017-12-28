<template>
    <div>
        <sa-modal :visible="addRecordModalVisible"
                  @close="addRecordModalVisible = false"
                  title="Add Record">
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="addRecordType" class="col-md-3 control-label">Type</label>
                    <div class="col-md-8">
                        <select class="form-control" id="addRecordType" v-model="addRecord.type" @change="resetAttrs">
                            <option v-for="type in availableRecordTypes">{{type}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="addRecordName" class="col-md-3 control-label">Name</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="addRecordName" v-model="addRecord.name" />
                    </div>
                </div>
                <template v-if="'A' === addRecord.type">
                    <div class="form-group">
                        <label for="addRecordAAttrIPv4" class="col-md-3 control-label">IPv4</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="addRecordAAttrIPv4" v-model="addRecord.attrs.ipv4" />
                        </div>
                    </div>
                </template>
                <template v-else-if="'AAAA' === addRecord.type">
                    <div class="form-group">
                        <label for="addRecordAAAAAttrIPv6" class="col-md-3 control-label">IPv6</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="addRecordAAAAAttrIPv6" v-model="addRecord.attrs.ipv6" />
                        </div>
                    </div>
                </template>
                <template v-else-if="'CNAME' === addRecord.type">
                    <div class="form-group">
                        <label for="addRecordCNAMEAttrHost" class="col-md-3 control-label">Host</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="addRecordCNAMEAttrHost" v-model="addRecord.attrs.host" />
                        </div>
                    </div>
                </template>
                <template v-else-if="'MX' === addRecord.type">
                    <div class="form-group">
                        <label for="addRecordMXAttrHost" class="col-md-3 control-label">Host</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="addRecordMXAttrHost" v-model="addRecord.attrs.host" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="addRecordMXAttrPriority" class="col-md-3 control-label">Priority</label>
                        <div class="col-md-8">
                            <input type="number" step="10" class="form-control" id="addRecordMXAttrPriority" v-model="addRecord.attrs.priority" />
                        </div>
                    </div>
                </template>
                <template v-else-if="'SRV' === addRecord.type">
                    <div class="form-group">
                        <label for="addRecordSRVAttrPriority" class="col-md-3 control-label">Priority</label>
                        <div class="col-md-8">
                            <input type="number" step="10" class="form-control" id="addRecordSRVAttrPriority" v-model="addRecord.attrs.priority" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="addRecordSRVAttrWeight" class="col-md-3 control-label">Weight</label>
                        <div class="col-md-8">
                            <input type="number" step="10" class="form-control" id="addRecordSRVAttrWeight" v-model="addRecord.attrs.weight" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="addRecordSRVAttrHost" class="col-md-3 control-label">Host</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="addRecordSRVAttrHost" v-model="addRecord.attrs.host" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="addRecordSRVAttrPort" class="col-md-3 control-label">Port</label>
                        <div class="col-md-8">
                            <input type="number" class="form-control" id="addRecordSRVAttrPort" v-model="addRecord.attrs.port" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="addRecordSRVAttrService" class="col-md-3 control-label">Service</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="addRecordSRVAttrService" v-model="addRecord.attrs.service" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="addRecordSRVAttrProtocol" class="col-md-3 control-label">Protocol</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="addRecordSRVAttrProtocol" v-model="addRecord.attrs.protocol" />
                        </div>
                    </div>
                </template>
                <template v-else-if="'TXT' === addRecord.type">
                    <div class="form-group">
                        <label for="addRecordTXTAttrContent" class="col-md-3 control-label">Content</label>
                        <div class="col-md-8">
                            <textarea rows="4" class="form-control input-sm"  id="addRecordTXTAttrContent" v-model="addRecord.attrs.content"></textarea>
                        </div>
                    </div>
                </template>
                <template v-else-if="'NS' === addRecord.type">
                    <div class="form-group">
                        <label for="addRecordNSAttrNameserver" class="col-md-3 control-label">Nameserver</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="addRecordNSAttrNameserver" v-model="addRecord.attrs.nameserver" />
                        </div>
                    </div>
                </template>
                <div class="form-group">
                    <label for="addRecordTTL" class="col-md-3 control-label">TTL</label>
                    <div class="col-md-8">
                        <input type="number" class="form-control" id="addRecordTTL" v-model="addRecord.ttl" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-3 col-md-8">
                        <sa-button @click.native="add" icon="plus" :loading="adding">Add</sa-button>
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
                           @destroy="destroy(record.id)" />
            </tbody>
            <tfoot>
            <tr>
                <td colspan="5" class="text-right">
                    <sa-button @click.native="addRecordModalVisible = true" icon="plus" size="sm" />
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
                addRecordModalVisible: false,
                addRecord: {
                    zone_id: 0,
                    type: '',
                    name: '',
                    attrs: {},
                    ttl: 0
                },
                adding: false
            };
        },
        mounted() {
            this.reset();
            this.load();
        },
        methods: {
            load() {
                axios.get('/api/dns/records?zone=' + this.zone).then(response => {
                    this.records = [];
                    for (let record of response.data.data) {
                        this.records.push(record);
                    }
                }).catch(error => {
                    console.error(error);
                });
            },
            destroy(id) {
                this.records = _.remove(this.records, record => record.id !== id);
            },
            add() {
                this.adding = true;
                axios.post('/api/dns/records', this.addRecord).then(response => {
                    this.reset();
                    this.load();
                    this.adding = false;
                }).catch(error => {
                    this.adding = false;
                    console.error(error);
                });
            },
            reset() {
                this.addRecord.zone_id = this.zone;
                this.addRecord.type = 'A';
                this.addRecord.name = '';
                this.addRecord.ttl = 300;
                this.resetAttrs();
            },
            resetAttrs() {
                this.addRecord.attrs = {};
                switch (this.addRecord.type) {
                    case 'A':
                        this.addRecord.attrs.ipv4 = '127.0.0.1';
                        break;
                    case 'AAAA':
                        this.addRecord.attrs.ipv6 = '::1';
                        break;
                    case 'CNAME':
                        this.addRecord.attrs.host = 'www.example.com';
                        break;
                    case 'MX':
                        this.addRecord.attrs.host = 'mail.example.com';
                        this.addRecord.attrs.priority = 10;
                        break;
                    case 'SRV':
                        this.addRecord.attrs.priority = 10;
                        this.addRecord.attrs.weight = 10;
                        this.addRecord.attrs.host = 'sip.example.com';
                        this.addRecord.attrs.port = 5060 ;
                        this.addRecord.attrs.service = '_sip';
                        this.addRecord.attrs.protocol = '_tcp';
                        break;
                    case 'TXT':
                        this.addRecord.attrs.content = 'v=spf1 mx a -all';
                        break;
                    case 'NS':
                        this.addRecord.attrs.nameserver = 'ns.example.com';
                        break;
                }
            }
        },
        computed: {
            orderedRecords() {
                return _.sortBy(this.records, 'type');
            }
        }
    }
</script>
