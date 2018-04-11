<template>
    <div class="form-horizontal">
        <table class="table table-striped table-controls">
            <tbody>
            <sa-database-privilege v-for="user in orderedGrantedUsers"
                                     v-if="user.required"
                                     :key="user.id"
                                     :database="database"
                                     :user="user"
                                     @revokePrivileges="loadPrivileges()"/>
            </tbody>
            <tfoot>
            <tr>
                <td>
                    <select class="form-control" id="databaseCollation" v-model="grantPrivilegesForm.attributes.user">
                        <option v-for="user in users">{{ user.user }}@{{ user.host }}</option>
                    </select>
                </td>
                <td class="fit">
                    <sa-button @click.native="grantPrivileges()"
                               type="default"
                               icon="plus"
                               :loading="grantPrivilegesForm.loading" />
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['database', 'users'],
        data() {
            return {
                grantedUsers: [],
                grantPrivilegesForm: new ServerAdmin.Form({
                    name: this.database,
                    user: -1,
                }),
            };
        },
        mounted() {
            this.loadPrivileges();
        },
        methods: {
            loadPrivileges() {
                axios.get('/api/database/databases/' + this.database).then(response => {
                    this.grantedUsers = [];
                    for (let user of response.data.data.access) {
                        this.grantedUsers.push(user);
                    }
                }).catch(error => {
                    console.error(error);
                });
            },
            grantPrivileges() {
                this.grantPrivilegesForm.start();
                axios.patch('/api/database/grant', this.grantPrivilegesForm.attributes).then(() => {
                    this.grantPrivilegesForm.finish();
                    this.loadPrivileges();
                }).catch(error => {
                    this.grantPrivilegesForm.crash(error);
                });
            },
        },
        computed: {
            orderedGrantedUsers() {
                return _.sortBy(this.grantedUsers, ['user', 'host']);
            }
        },
    }
</script>
