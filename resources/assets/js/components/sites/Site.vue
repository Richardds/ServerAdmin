<template>
    <tr>

        <td class="site-name">{{ uppercaseName }}</td>
        <td class="site-pho">{{ site.php_enabled }}</td>
        <td class="site-ssl">FUCC</td>

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
        },
    }
</script>
