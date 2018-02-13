<template>
    <table class="table table-striped table-controls">
        <tbody>
        <sa-database-user v-for="user in orderedUsers"
                          :key="user.user + '@' + user.host"
                          :user="user"
                          @destroy="destroyUser(user)" />
        </tbody>
        <tfoot>
        <tr>
            <td>
                <div class="form-horizontal">
                    <div class="form-group form-group-sm">
                        <label for="user" class="col-md-2 control-label">User</label>
                        <div class="col-md-10">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" id="user" placeholder="User" v-model="createUserForm.attributes.user">
                                <span class="input-group-addon"><i class="fa fa-at" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" placeholder="Host" v-model="createUserForm.attributes.host">
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <label for="password" class="col-md-2 control-label">Password</label>
                        <div class="col-md-10">
                            <div class="input-group input-group-sm">
                                <input type="password" class="form-control" id="password" placeholder="Password" v-model="createUserForm.attributes.password" />
                                <span class="input-group-btn">
                                    <sa-button data-clipboard-target="#password" icon="copy" />
                                    <sa-button @click.native="createUserForm.attributes.password = password()" icon="arrow-left" />
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
            <td class="fit">
                <sa-button @click.native="createUser()"
                           type="default"
                           icon="plus"
                           size="sm"
                           :loading="createUserForm.loading" />
            </td>
        </tr>
        </tfoot>
    </table>
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
            destroyUser(user) {
                this.users = _.remove(this.users, aUser => (aUser.user + '@' + aUser.host) !== (user.user + '@' + user.host));
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
