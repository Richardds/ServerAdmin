<template>
    <tr>
        <td>{{ user.user }}@{{ user.host }}</td>
        <td class="fit">
            <sa-button @click.native="revokePrivileges()"
                       type="danger"
                       icon="trash"
                       :loading="revokePrivilegesForm.loading" />
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['schema', 'user'],
        data() {
            return {
                grantedUsers: [],
                revokePrivilegesForm: new ServerAdmin.Form({
                    name: this.schema,
                    user: this.user.user + '@' + this.user.host,
                }),
            };
        },
        methods: {
            revokePrivileges() {
                this.revokePrivilegesForm.start();
                axios.patch('/api/database/revoke', this.revokePrivilegesForm.attributes).then(() => {
                    this.revokePrivilegesForm.finish();
                    this.$emit('revokePrivileges');
                }).catch(error => {
                    this.revokePrivilegesForm.crash(error);
                });
            }
        },
    }
</script>
