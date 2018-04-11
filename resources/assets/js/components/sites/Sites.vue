<template>
    <div>
        <sa-modal :visible="createSiteForm.enabled"
                  @close="createSiteForm.close()"
                  title="Create site">
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="addSiteName" class="col-md-3 control-label">Name</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="addSiteName" v-model="createSiteForm.attributes.name" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="addSitePHP" class="col-md-3 control-label">Enable PHP</label>
                    <div class="col-md-8">
                        <input type="checkbox" id="addSitePHP" @click="togglePHPAttributes()">
                    </div>
                </div>
                <div class="form-group">
                    <label for="addSiteSSL" class="col-md-3 control-label">Enable SSL</label>
                    <div class="col-md-8">
                        <input type="checkbox" id="addSiteSSL" @click="toggleSSLAttributes()">
                    </div>
                </div>
                <div v-show="createSiteFormSSL">
                    <div class="form-group">
                        <label for="addSiteCertificate" class="col-md-3 control-label">Certificate</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="text" class="form-control" id="addSiteCertificate" v-model="createSiteForm.attributes.ssl_certificate" />
                                <span class="input-group-btn">
                                    <sa-button @click.native="browse()" icon="ellipsis-h" />
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="addSiteKey" class="col-md-3 control-label">Key</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="text" class="form-control" id="addSiteKey" v-model="createSiteForm.attributes.ssl_key" />
                                <span class="input-group-btn">
                                    <sa-button @click.native="browse()" icon="ellipsis-h" />
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-offset-3 col-md-8">
                        <sa-button @click.native="createSite()"
                                   type="default"
                                   icon="plus"
                                   :loading="createSiteForm.loading">Create</sa-button>
                    </div>
                </div>
            </div>
        </sa-modal>

        <table class="table table-striped table-controls table-sites">
            <thead>
            <tr>
                <th>Name</th>
                <th>PHP</th>
                <th>SSL</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <sa-site v-for="site in orderedSites"
                         :key="site.id"
                         :site="site"
                         @destroySite="loadSites()" />
            </tbody>
            <tfoot>
            <tr>
                <td colspan="7" class="text-right">
                    <sa-button @click.native="createSiteForm.open()"
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
                sites: [],
                createSiteFormSSL: false,
                createSiteForm: new ServerAdmin.ModalForm({
                    name: '',
                    php_enabled: false,
                    ssl_certificate: '',
                    ssl_key: '',
                }),
            };
        },
        mounted() {
            this.loadSites();
        },
        methods: {
            loadSites() {
                axios.get('/api/sites').then(response => {
                    this.sites = [];
                    for (let site of response.data.data) {
                        this.sites.push(site);
                    }
                }).catch(error => {
                    console.error(error);
                });
            },
            createSite() {
                this.createSiteForm.start();
                axios.post('/api/sites', ServerAdmin.Utils.stripUnfilled(this.createSiteForm.attributes)).then(() => {
                    this.createSiteForm.finish();
                    this.loadSites();
                }).catch(error => {
                    this.createSiteForm.crash(error);
                });
            },
            togglePHPAttributes() {
                this.createSiteForm.php_enabled = !this.createSiteForm.php_enabled;
            },
            toggleSSLAttributes() {
                this.createSiteFormSSL = !this.createSiteFormSSL;
            },
            browse() {
                // TODO
            },
        },
        computed: {
            orderedSites() {
                return _.sortBy(this.sites, 'name');
            }
        },
    }
</script>
