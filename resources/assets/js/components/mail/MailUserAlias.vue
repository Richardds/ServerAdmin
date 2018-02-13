<template>
    <tr>
        <td>{{ alias.alias }}@{{ domain.name }}</td>
        <td class="fit">
            <sa-button @click.native="destroyAlias()"
                       type="danger"
                       icon="trash"
                       :loading="destroyAliasForm.loading" />
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['alias', 'domain'],
        data() {
            return {
                destroyAliasForm: new ServerAdmin.Form(),
            };
        },
        methods: {
            destroyAlias() {
                this.destroyAliasForm.start();
                axios.delete('/api/mail/aliases/' + this.alias.id).then(() => {
                    this.destroyAliasForm.finish();
                    this.$emit('destroyAlias');
                }).catch(error => {
                    this.destroyAliasForm.crash(error);
                });
            },
        },
    }
</script>
