<template>
    <div>
        <sa-modal :visible="createZoneForm.enabled"
                  @close="createZoneForm.close()"
                  title="Create zone">
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="addZoneName" class="col-md-3 control-label">Name</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="addZoneName" v-model="createZoneForm.attributes.name" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="addZoneAdmin" class="col-md-3 control-label">Admin</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input type="text" class="form-control" id="addZoneAdmin" v-model="createZoneForm.attributes.admin" />
                            <span class="input-group-btn">
                                <sa-button @click.native="createZoneForm.attributes.admin = generateAdmin()" icon="arrow-left" />
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="addZoneSerial" class="col-md-3 control-label">Serial</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input type="number" class="form-control" id="addZoneSerial" v-model="createZoneForm.attributes.serial" />
                            <span class="input-group-btn">
                                <sa-button @click.native="createZoneForm.attributes.serial = generateSerial()" icon="arrow-left" />
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="addZoneRefresh" class="col-md-3 control-label">Refresh</label>
                    <div class="col-md-8">
                        <input type="number" class="form-control" id="addZoneRefresh" v-model="createZoneForm.attributes.refresh" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="addZoneRetry" class="col-md-3 control-label">Retry</label>
                    <div class="col-md-8">
                        <input type="number" class="form-control" id="addZoneRetry" v-model="createZoneForm.attributes.retry" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="addZoneExpire" class="col-md-3 control-label">Expire</label>
                    <div class="col-md-8">
                        <input type="number" class="form-control" id="addZoneExpire" v-model="createZoneForm.attributes.expire" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="addZoneTTL" class="col-md-3 control-label">TTL</label>
                    <div class="col-md-8">
                        <input type="number" class="form-control" id="addZoneTTL" v-model="createZoneForm.attributes.ttl" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-3 col-md-8">
                        <sa-button @click.native="createZone()"
                                   type="default"
                                   icon="plus"
                                   :loading="createZoneForm.loading">Create</sa-button>
                    </div>
                </div>
            </div>
        </sa-modal>

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
            <sa-dns-zone v-for="zone in orderedZones"
                         :key="zone.id"
                         :zone="zone"
                         @destroyZone="loadZones()" />
            </tbody>
            <tfoot>
            <tr>
                <td colspan="7" class="text-right">
                    <sa-button @click.native="createZoneForm.open()"
                               type="default"
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
        data() {
            return {
                zones: [],
                createZoneForm: new ServerAdmin.ModalForm({
                    name: '',
                    admin: '',
                    serial: this.generateSerial(),
                    refresh: 43200,
                    retry: 3600,
                    expire: 1209600,
                    ttl: 1209600
                }),
            };
        },
        mounted() {
            this.loadZones();
        },
        methods: {
            loadZones() {
                axios.get('/api/dns/zones').then(response => {
                    this.zones = [];
                    for (let zone of response.data.data) {
                        this.zones.push(zone);
                    }
                }).catch(error => {
                    console.error(error);
                });
            },
            createZone() {
                this.createZoneForm.start();
                axios.post('/api/dns/zones', ServerAdmin.Utils.stripUnfilled(this.createZoneForm.attributes)).then(() => {
                    this.createZoneForm.finish();
                    this.loadZones();
                }).catch(error => {
                    this.createZoneForm.crash(error);
                });
            },
            generateAdmin() {
                let name = this.createZoneForm.attributes.name;
                return name ? 'admin.' + name : '';
            },
            generateSerial() {
                return ServerAdmin.Utils.generateSerial();
            }
        },
        computed: {
            orderedZones() {
                return _.sortBy(this.zones, 'name');
            }
        },
    }
</script>
