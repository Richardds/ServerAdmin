<template>
    <div class="form-horizontal">
        <table class="table table-striped table-controls">
            <tbody>
            <tr v-for="user in orderedGrantedUsers" v-if="user.required">
                <td>{{ user.user }}@{{ user.host }}</td>
                <td class="fit">
                    <sa-button @click.native="revokePrivileges(user)"
                               type="danger"
                               icon="trash"
                               :loading="userForm.loading" />
                </td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <td>
                    <select class="form-control" id="schemaCollation" v-model="userForm.attributes.user">
                        <option v-for="user in users">{{ user.user }}@{{ user.host }}</option>
                    </select>
                </td>
                <td class="fit">
                    <sa-button @click.native="grantPrivileges()"
                               type="default"
                               icon="plus"
                               :loading="userForm.loading" />
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
                userForm: new ServerAdmin.Form({
                    name: this.schema,
                    user: -1,
                }),
            };
        },
        mounted() {
            this.loadPrivileges();
        },
        methods: {
            loadPrivileges() {
                axios.get('/api/database/schemas/' + this.schema).then(response => {
                    this.grantedUsers = [];
                    for (let user of response.data.data.access) {
                        this.grantedUsers.push(user);
                    }
                }).catch(error => {
                    console.error(error);
                });
            },
            grantPrivileges() {
                this.userForm.start();
                axios.patch('/api/database/grant', this.userForm.attributes).then(() => {
                    this.userForm.finish();
                    this.loadPrivileges();
                }).catch(error => {
                    this.userForm.crash(error);
                });
            },
            revokePrivileges(user) {
                this.userForm.start();
                this.userForm.attributes.user = user.user + '@' + user.host;
                axios.patch('/api/database/revoke', this.userForm.attributes).then(() => {
                    this.userForm.finish();
                    this.loadPrivileges();
                }).catch(error => {
                    this.userForm.crash(error);
                });
            }
        },
        computed: {
            orderedGrantedUsers() {
                return _.sortBy(this.grantedUsers, ['user', 'host']);
            }
        },
    }
</script>
