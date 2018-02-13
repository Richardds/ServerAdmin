<template>
    <tr>
        <td class="domain-name">
            <a :href="'/mail/domains/' + domain.id" :title="'Edit domain ' + domain.name + ' users'">{{ domain.name }}</a>
        </td>
        <td class="fit">
            <sa-button @click.native="deleteDomain"
                       type="danger"
                       icon="trash"
                       size="sm"
                       :loading="destroyDomainForm.loading" />
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['domain'],
        data() {
            return {
                destroyDomainForm: new ServerAdmin.Form({
                    'id': -1
                }),
            };
        },
        methods: {
            deleteDomain() {
                this.destroyDomainForm.start();
                axios.delete('/api/mail/domains/' + this.domain.id).then(() => {
                    this.destroyDomainForm.finish();
                    this.$emit('deleteDomain');
                }).catch(error => {
                    this.destroyDomainForm.crash(error);
                });
            }
        }
    }
</script>
