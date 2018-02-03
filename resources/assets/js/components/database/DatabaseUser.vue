<template>
    <tr>
        <td>{{ user.user }}@{{ user.host }}</td>
        <td class="fit">
            <sa-button @click.native="deleteUser(user)"
                       type="danger"
                       icon="trash"
                       size="sm"
                       :loading="deleting" />
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['user'],
        data() {
            return {
                deleting: false,
            };
        },
        methods: {
            add() {
                this.adding = true;
                axios.post('/api/database/users', this.user).then(response => {
                    this.adding = false;
                }).catch(error => {
                    this.deleting = false;
                    console.error(error);
                });
            },
            deleteUser(user) {
                this.deleting = true;
                axios.delete('/api/database/users/' + user.user + '@' + user.host).then(response => {
                    this.$emit('destroy');
                }).catch(error => {
                    this.deleting = false;
                    console.error(error);
                });
            }
        },
        computed: {

        }
    }
</script>
