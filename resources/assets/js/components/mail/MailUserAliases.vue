<template>
    <div class="form-horizontal">
        <table class="table table-striped table-controls">
            <tbody>
            <tr v-for="alias in aliases">
                <td>{{ alias.alias }}@{{ domain.name }}</td>
                <td class="fit">
                    <sa-button @click.native="destroyAlias(alias.id)"
                               type="danger"
                               icon="trash"
                               :loading="destroyAliasForm.loading" />
                </td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <td>
                    <input type="text" class="form-control" id="username" v-model="createAliasForm.attributes.alias" />
                </td>
                <td class="fit">
                    <sa-button @click.native="createAlias"
                               type="default"
                               icon="plus"
                               :loading="createAliasForm.loading" />
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['domain', 'user'],
        data() {
            return {
                aliases: [],
                createAliasForm: new ServerAdmin.Form({
                    'domain_id': this.domain.id,
                    'user_id': this.user.id,
                    'alias': '',
                }),
                destroyAliasForm: new ServerAdmin.Form({
                    'id': -1
                }),
            };
        },
        mounted() {
            this.loadAliases();
        },
        methods: {
            loadAliases() {
                axios.get('/api/mail/aliases?user=' + this.user.id).then(response => {
                    this.aliases = [];
                    for (let alias of response.data.data) {
                        this.aliases.push(alias);
                    }
                }).catch(error => {
                    console.error(error);
                });
            },
            createAlias() {
                this.createAliasForm.start();
                axios.post('/api/mail/aliases', this.createAliasForm.attributes).then(() => {
                    this.createAliasForm.finish();
                    this.loadAliases();
                }).catch(error => {
                    this.createAliasForm.crash(error);
                });
            },
            destroyAlias(id) {
                this.destroyAliasForm.start();
                axios.delete('/api/mail/aliases/' + id).then(() => {
                    this.destroyAliasForm.finish();
                    this.loadAliases();
                }).catch(error => {
                    this.destroyAliasForm.crash(error);
                });
            },
        },
    }
</script>
