<template>
    <div class="form-horizontal">
        <table class="table table-striped table-controls">
            <tbody>
            <sa-mail-user-alias v-for="alias in orderedAliases"
                                :key="alias.id"
                                :alias="alias"
                                :domain="domain"
                                @destroyAlias="loadAliases()" />
            </tbody>
            <tfoot>
            <tr>
                <td>
                    <div class="input-group">
                        <input type="text" class="form-control" id="username" v-model="createAliasForm.attributes.alias" />
                        <span class="input-group-addon">@{{ domain.name }}</span>
                    </div>
                </td>
                <td class="fit">
                    <sa-button @click.native="createAlias()"
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
                    domain_id: this.domain.id,
                    user_id: this.user.id,
                    alias: '',
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
        },
        computed: {
            orderedAliases() {
                return _.sortBy(this.aliases, 'alias');
            }
        },
    }
</script>
