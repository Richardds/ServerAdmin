<template>
    <div>
        <sa-modal :visible="createDomainForm.enabled"
                  @close="createDomainForm.close()"
                  title="Create domain">
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="domainName" class="col-md-3 control-label">Name</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="domainName" v-model="createDomainForm.attributes.name" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-3 col-md-8">
                        <sa-button @click.native="createDomain()"
                                   type="default"
                                   icon="plus"
                                   :loading="createDomainForm.loading">Create</sa-button>
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
            <sa-mail-domain v-for="domain in orderedDomains"
                            :key="domain.id"
                            :domain="domain"
                            @destroyDomain="loadDomains()" />
            </tbody>
            <tfoot>
            <tr>
                <td colspan="7" class="text-right">
                    <sa-button @click.native="createDomainForm.open()"
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
                createDomainForm: new ServerAdmin.ModalForm({
                    'name': ''
                }),
            };
        },
        mounted() {
            this.loadDomains();
        },
        methods: {
            loadDomains() {
                axios.get('/api/mail/domains').then(response => {
                    this.domains = [];
                    for (let domain of response.data.data) {
                        this.domains.push(domain);
                    }
                }).catch(error => {
                    console.error(error);
                });
            },
            createDomain() {
                this.createDomainForm.start();
                axios.post('/api/mail/domains', this.createDomainForm.attributes).then(() => {
                    this.createDomainForm.finish();
                    this.loadDomains();
                }).catch(error => {
                    this.createDomainForm.crash(error);
                });
            },
        },
        computed: {
            orderedDomains() {
                return _.sortBy(this.domains, 'name');
            }
        }
    }
</script>
