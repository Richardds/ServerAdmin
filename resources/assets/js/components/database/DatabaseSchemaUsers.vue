<template>
    <div class="form-horizontal">
        <table class="table table-striped table-controls">
            <tbody>
            <tr v-for="user in grantedUsers" v-if="user.required">
                <td>{{ user.user }}@{{ user.host }}</td>
                <td class="fit">
                    <sa-button @click.native="revokePermissions(user)"
                               type="danger"
                               icon="trash"
                               :loading="revoking" />
                </td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <td>
                    <select class="form-control" id="schemaCollation" v-model="selectedUser">
                        <option v-for="user in users">{{ user }}</option>
                    </select>
                </td>
                <td class="fit">
                    <sa-button @click.native="grantPermissions"
                               type="default"
                               icon="plus"
                               :loading="granting" />
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['schema', 'users'],
        data() {
            return {
                grantedUsers: [],
                selectedUser: null,
                //
                granting: false,
                revoking: false,
            };
        },
        mounted() {
            axios.get('/api/database/schemas/' + this.schema).then(response => {
                this.grantedUsers = [];
                for (let user of response.data.data.access) {
                    this.grantedUsers.push(user);
                }
            }).catch(error => {
                console.error(error);
            });
        },
        methods: {
            grantPermissions() {
                this.granting = true;
                axios.patch('/api/database/grant', {
                    name: this.schema,
                    user: this.selectedUser,
                }).then(response => {
                    this.grantedUsers.push(this.selectedUser); // TODO: Check
                    this.granting = false;
                }).catch(error => {
                    console.error(error);
                });
            },
            revokePermissions(user) {
                this.grantedUsers = _.remove(this.grantedUsers, grantedUser => grantedUser.name !== user.user);
                this.revoking = true;
                axios.patch('/api/database/revoke', {
                    name: this.schema,
                    user: user.user + '@' + user.host,
                }).then(response => {
                    // TODO: Check
                    this.grantedUsers = _.remove(this.grantedUsers, grantedUser => grantedUser.name !== user.user);
                    this.revoking = false;
                }).catch(error => {
                    console.error(error);
                });
            }
        },
        computed: {

        }
    }
</script>
