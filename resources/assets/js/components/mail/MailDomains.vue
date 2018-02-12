<template>
    <div>
        <sa-modal :visible="domainForm.enabled"
                  @close="domainForm.close()"
                  title="Add domain">
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="domainName" class="col-md-3 control-label">Name</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="domainName" v-model="domainForm.attributes.name" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-3 col-md-8">
                        <sa-button @click.native="add"
                                   type="default"
                                   icon="plus"
                                   :loading="domainForm.loading">Add</sa-button>
                    </div>
                </div>
            </div>
        </sa-modal>
        <table class="table table-striped table-controls table-mail-domains">
            <thead>
            <tr>
                <th>Name</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <sa-mail-domain v-for="domain in this.domains"
                            :key="domain.id"
                            :domain="domain"
                            @destroy="destroy(domain.id)" />
            </tbody>
            <tfoot>
            <tr>
                <td colspan="7" class="text-right">
                    <sa-button @click.native="domainForm.open()"
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
                domains: [],
                domainForm: new ServerAdmin.ModalForm({
                    'name': ''
                }),
            };
        },
        mounted() {
            this.load();
        },
        methods: {
            load() {
                axios.get('/api/mail/domains').then(response => {
                    this.domains = [];
                    for (let domain of response.data.data) {
                        this.domains.push(domain);
                    }
                }).catch(error => {
                    console.error(error);
                });
            },
            destroy(id) {
                this.domains = _.remove(this.domains, domain => domain.id !== id);
            },
            add() {
                this.domainForm.start();
                axios.post('/api/mail/domains', this.domainForm.attributes).then(() => {
                    this.domainForm.finish();
                    this.load();
                }).catch(error => {
                    this.domainForm.crash(error);
                });
            },
        }
    }
</script>
