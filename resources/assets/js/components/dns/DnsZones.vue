<template>
    <div>
        <sa-modal :visible="addZoneModalVisible"
                  @close="addZoneModalVisible = false"
                  title="Add Zone">
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="addZoneName" class="col-md-3 control-label">Name</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="addZoneName" v-model="addZone.name" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="addZoneAdmin" class="col-md-3 control-label">Admin</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input type="text" class="form-control" id="addZoneAdmin" v-model="addZone.admin" />
                            <span class="input-group-btn">
                                <sa-button @click.native="addZone.admin = generateAdmin()" icon="arrow-left" />
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="addZoneSerial" class="col-md-3 control-label">Serial</label>
                    <div class="col-md-8">
                        <div class="input-group">
                        <input type="number" class="form-control" id="addZoneSerial" v-model="addZone.serial" />
                        <span class="input-group-btn">
                            <sa-button @click.native="addZone.serial = generateSerial()" icon="arrow-left" />
                        </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="addZoneRefresh" class="col-md-3 control-label">Refresh</label>
                    <div class="col-md-8">
                        <input type="number" class="form-control" id="addZoneRefresh" v-model="addZone.refresh" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="addZoneRetry" class="col-md-3 control-label">Retry</label>
                    <div class="col-md-8">
                        <input type="number" class="form-control" id="addZoneRetry" v-model="addZone.retry" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="addZoneExpire" class="col-md-3 control-label">Expire</label>
                    <div class="col-md-8">
                        <input type="number" class="form-control" id="addZoneExpire" v-model="addZone.expire" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="addZoneTTL" class="col-md-3 control-label">TTL</label>
                    <div class="col-md-8">
                        <input type="number" class="form-control" id="addZoneTTL" v-model="addZone.ttl" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-3 col-md-8">
                        <sa-button @click.native="add"
                                   type="default"
                                   icon="plus"
                                   :loading="adding">Add</sa-button>
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
            <sa-dns-zone v-for="zone in this.zones"
                         :key="zone.id"
                         :zone="zone"
                         @destroy="destroy(zone.id)" />
            </tbody>
            <tfoot>
            <tr>
                <td colspan="7" class="text-right">
                    <sa-button @click.native="addZoneModalVisible = true"
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
                addZoneModalVisible: false,
                addZone: {
                    name: '',
                    admin: '',
                    serial: 0,
                    refresh: 0,
                    retry: 0,
                    expire: 0,
                    ttl: 0
                },
                adminChanged: false,
                adding: false
            };
        },
        mounted() {
            this.reset();
            this.load();
        },
        methods: {
            load() {
                axios.get('/api/dns/zones').then(response => {
                    this.zones = [];
                    for (let zone of response.data.data) {
                        this.zones.push(zone);
                    }
                }).catch(error => {
                    console.error(error);
                });
            },
            destroy(id) {
                this.zones = _.remove(this.zones, zone => zone.id !== id);
            },
            add() {
                this.adding = true;
                axios.post('/api/dns/zones', this.addZone).then(response => {
                    this.reset();
                    this.load();
                    this.adding = false;
                }).catch(error => {
                    this.adding = false;
                    console.error(error);
                });
            },
            reset() {
                this.addZone.name = '';
                this.addZone.admin = '';
                this.addZone.serial = this.generateSerial();
                this.addZone.refresh = 43200;
                this.addZone.retry = 3600;
                this.addZone.expire = 1209600;
                this.addZone.ttl = 1209600;
                this.adminChanged = false;
            },
            generateAdmin() {
                return this.addZone.name ? 'admin.' + this.addZone.name : '';
            },
            generateSerial(i) {
                let date = new Date();
                return ((date.getFullYear() * 100 + date.getMonth() + 1) * 100 + date.getDate()) * 100 + _.min([(i || 1), 99])

            }
        }
    }
</script>
