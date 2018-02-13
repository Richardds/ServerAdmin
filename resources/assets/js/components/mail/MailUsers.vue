<template>
    <div>
        <sa-modal :visible="createUserForm.enabled"
                  @close="createUserForm.close()"
                  title="Create user">
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="name" class="col-md-3 control-label">Name</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="name" v-model="createUserForm.attributes.name" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="col-md-3 control-label">Username</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="username" v-model="createUserForm.attributes.username" />
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
        <table class="table table-striped table-controls table-mail-users">
            <thead>
            <tr>
                <th>Name</th>
                <th>Login / E-Mail</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <sa-mail-user v-for="user in orderedUsers"
                            :key="user.id"
                            :domain="domain"
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
        props: ['domain_id'],
        data() {
            return {
                users: [],
                domain: {},
                createUserForm: new ServerAdmin.ModalForm({
                    domain_id: this.domain_id,
                    username: '',
                    password: '',
                }),
            };
        },
        mounted() {
            this.loadUsers();
        },
        methods: {
            loadUsers() {
                // Load domain info
                axios.get('/api/mail/domains/' + this.domain_id).then(response => {
                    this.domain = response.data.data;

                    // Load domains
                    axios.get('/api/mail/users?domain=' + this.domain_id).then(response => {
                        this.users = [];
                        for (let user of response.data.data) {
                            this.users.push(user);
                        }
                    }).catch(error => {
                        console.error(error);
                    });

                }).catch(error => {
                    console.error(error);
                });
            },
            createUser() {
                this.createUserForm.start();
                axios.post('/api/mail/users', this.createUserForm.attributes).then(() => {
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
                return _.sortBy(this.users, 'name');
            }
        }
    }
</script>
