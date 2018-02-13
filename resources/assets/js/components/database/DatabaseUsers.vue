<template>
    <div>
        <sa-modal :visible="createUserForm.enabled"
                  @close="createUserForm.close()"
                  title="Create user">
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="user" class="col-md-3 control-label">User</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="user" v-model="createUserForm.attributes.user">
                    </div>
                </div>
                <div class="form-group">
                    <label for="host" class="col-md-3 control-label">Host</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="host" v-model="createUserForm.attributes.host">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-md-3 control-label">Password</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" v-model="createUserForm.attributes.password" />
                            <span class="input-group-btn">
                                <sa-button data-clipboard-target="#password" icon="copy" />
                                <sa-button @click.native="createUserForm.attributes.password = password()" icon="arrow-left" />
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-3 col-md-8">
                        <sa-button @click.native="createUser()"
                                   type="default"
                                   icon="plus"
                                   :loading="createUserForm.loading">Create</sa-button>
                    </div>
                </div>
            </div>
        </sa-modal>

        <table class="table table-striped table-controls table-database-users">
            <thead>
            <tr>
                <th>User</th>
                <th>Host</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <sa-database-user v-for="user in orderedUsers"
                              :key="user.user + '@' + user.host"
                              :user="user"
                              @destroyUser="loadUsers()" />
            </tbody>
            <tfoot>
            <tr>
                <td colspan="7" class="text-right">
                    <sa-button @click.native="createUserForm.open()"
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
                users: [],
                createUserForm: new ServerAdmin.ModalForm({
                    user: '',
                    host: 'localhost',
                    password: '',
                }),
            };
        },
        mounted() {
            this.loadUsers();
        },
        methods: {
            loadUsers() {
                axios.get('/api/database/users').then(response => {
                    this.users = [];
                    for (let user of response.data.data) {
                        this.users.push(user);
                    }
                    this.$emit('updateUsers', this.users);
                }).catch(error => {
                    this.deleting = false;
                    console.error(error);
                });
            },
            createUser() {
                this.createUserForm.start();
                axios.post('/api/database/users', this.createUserForm.attributes).then(() => {
                    this.createUserForm.finish();
                    this.loadUsers();
                }).catch(error => {
                    this.createUserForm.crash(error);
                });
            },
            password() {
                return ServerAdmin.Utils.generatePassword();
            },
        },
        computed: {
            orderedUsers() {
                return _.sortBy(this.users, ['user', 'host']);
            }
        },
    }
</script>
