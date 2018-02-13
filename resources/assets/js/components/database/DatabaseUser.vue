<template>
    <tr>
        <td>{{ user.user }}@{{ user.host }}</td>
        <td class="fit">
            <sa-button @click.native="destroyUser(user)"
                       type="danger"
                       icon="trash"
                       size="sm"
                       :loading="destroyUserForm.loading" />
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['user'],
        data() {
            return {
                destroyUserForm: new ServerAdmin.Form({
                    'id': -1
                }),
            };
        },
        methods: {
            destroyUser(user) {
                this.destroyUserForm.start();
                axios.delete('/api/database/users/' + user.user + '@' + user.host).then(() => {
                    this.destroyUserForm.finish();
                    this.$emit('destroy');
                }).catch(error => {
                    this.destroyUserForm.crash(error);
                });
            }
        },
    }
</script>
