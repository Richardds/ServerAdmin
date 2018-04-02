<template>
    <tr>
        <td class="site-name">
            <a :href="(ssl_enabled ? 'https' : 'http') + '://' + site.name" target="_blank">{{ uppercaseName }}</a>
        </td>
        <td class="site-php">
            <template v-if="php_enabled">
                <span class="label label-badge label-php"><sa-icon icon="puzzle-piece" /> PHP Enabled</span>
            </template>
            <template v-else>
                <span class="label label-badge label-default"><sa-icon icon="puzzle-piece" /> PHP Disabled</span>
            </template>
        </td>
        <td class="site-ssl">
            <template v-if="ssl_enabled">
                <span class="label label-badge label-success"><sa-icon icon="lock" /> SSL Enabled</span>
            </template>
            <template v-else>
                <span class="label label-badge label-default"><sa-icon icon="unlock" /> SSL Disabled</span>
            </template>
        </td>

        <td class="fit">
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
                editMode: false,
                updating: false,
                changed: false,
                toggleSiteForm: new ServerAdmin.ToggleForm(),
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
        },
        computed: {
            uppercaseName() {
                return this.site.name.toUpperCase();
            },
            php_enabled() {
                return this.site.php_enabled;
            },
            ssl_enabled() {
                return this.site.ssl_certificate && this.site.ssl_key;
            },
        },
    }
</script>
