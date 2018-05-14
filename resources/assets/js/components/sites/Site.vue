<template>
    <tr>
        <td class="site-name">
            <a :href="(site.ssl_enabled ? 'https' : 'http') + '://' + site.name" target="_blank">{{ uppercaseName }}</a>
        </td>
        <td class="site-php">
            <div @click="togglePhpEnabled()">
                <template v-if="this.site.php_enabled">
                    <span class="label label-badge label-php"><sa-icon icon="puzzle-piece" /> PHP Enabled</span>
                </template>
                <template v-else>
                    <span class="label label-badge label-default"><sa-icon icon="puzzle-piece" /> PHP Disabled</span>
                </template>
            </div>
        </td>
        <td class="site-ssl">
            <div @click="editSiteSslVisible = true">
                <template v-if="site.ssl_enabled">
                    <span class="label label-badge label-success"><sa-icon icon="lock" /> SSL Enabled</span>
                </template>
                <template v-else>
                    <span class="label label-badge label-default"><sa-icon icon="unlock" /> SSL Disabled</span>
                </template>
            </div>
        </td>

        <td class="fit">

            <sa-modal :visible="editSiteSslVisible"
                      @close="editSiteSslVisible = false"
                      title="Edit SSL">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label for="addSiteSSL" class="col-md-3 control-label">Enable SSL</label>
                        <div class="col-md-8">
                            <input type="checkbox" id="addSiteSSL" @click="toggleSslEnabled()" :checked="site.ssl_enabled">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="addSiteCertificate" class="col-md-3 control-label">Certificate</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="addSiteCertificate" v-model="site.ssl_certificate" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="addSiteKey" class="col-md-3 control-label">Key</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="addSiteKey" v-model="site.ssl_key" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-8">
                            <sa-button @click.native="editSsl()"
                                       type="default"
                                       icon="pencil"
                                       :loading="updatingSsl">Edit</sa-button>
                        </div>
                    </div>
                </div>
            </sa-modal>

            <sa-button @click.native="toggleSite()"
                       :icon="site.enabled ? 'toggle-on' : 'toggle-off'"
                       size="sm"
                       :loading="toggleSiteForm.loading" />
            <sa-button @click.native="destroySite()"
                       type="danger"
                       icon="trash"
                       size="sm"
                       :loading="destroySiteForm.loading" />
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['site'],
        data() {
            return {
                editSiteSslVisible: false,
                editMode: false,
                updatingSsl: false,
                changed: false,
                toggleSiteForm: new ServerAdmin.ToggleForm(),
                toggleSitePhpEnabledForm: new ServerAdmin.ToggleAttributeForm('php_enabled'),
                destroySiteForm: new ServerAdmin.Form({
                    'id': -1
                }),
            };
        },
        methods: {
            onChange() {
                this.changed = true;
            },
            destroySite() {
                this.destroySiteForm.start();
                axios.delete('/api/sites/' + this.site.id).then(() => {
                    this.destroySiteForm.finish();
                    this.$emit('destroySite');
                }).catch(error => {
                    this.destroySiteForm.crash(error);
                });
            },
            toggleSite() {
                this.toggleSiteForm.start();
                this.toggleSiteForm.switch(this.site.enabled);
                axios.patch('/api/sites/' + this.site.id, this.toggleSiteForm.attributes).then(response => {
                    ServerAdmin.Utils.updateAttributes(this.site, response.data.data);
                    this.toggleSiteForm.finish();
                }).catch(error => {
                    this.toggleSiteForm.crash(error);
                });
            },
            togglePhpEnabled() {
                this.toggleSitePhpEnabledForm.start();
                this.toggleSitePhpEnabledForm.switch(this.site.php_enabled);
                axios.patch('/api/sites/' + this.site.id, this.toggleSitePhpEnabledForm.attributes).then(response => {
                    ServerAdmin.Utils.updateAttributes(this.site, response.data.data);
                    this.toggleSitePhpEnabledForm.finish();
                }).catch(error => {
                    this.toggleSitePhpEnabledForm.crash(error);
                });
            },
            toggleSslEnabled() {
                this.site.ssl_enabled = !this.site.ssl_enabled;
            },
            editSsl() {
                this.updatingSsl = true;
                axios.patch('/api/sites/' + this.site.id, this.site).then(response => {
                    ServerAdmin.Utils.updateAttributes(this.site, response.data.data);
                    this.updatingSsl = false;
                    this.editSiteSslVisible = false;
                    this.$emit('editSite');
                }).catch(error => {
                    this.updatingSsl = false;
                    console.log(error);
                });
                this.editSiteSslVisible = !this.editSiteSslVisible;
            },
        },
        computed: {
            uppercaseName() {
                return this.site.name.toUpperCase();
            },
        },
    }
</script>
