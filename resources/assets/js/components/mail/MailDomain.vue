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
                       :loading="deleting" />
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['domain'],
        data() {
            return {
                deleting: false,
            };
        },
        methods: {
            deleteDomain() {
                this.deleting = true;
                axios.delete('/api/mail/domains/' + this.domain.id).then(response => {
                    this.$emit('destroy');
                }).catch(error => {
                    this.deleting = false;
                    console.error(error);
                });
            }
        }
    }
</script>
