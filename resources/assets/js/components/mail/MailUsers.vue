<template>
    <div>
        <sa-modal :visible="userForm.enabled"
                  @close="userForm.close()"
                  title="Add domain">
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="name" class="col-md-3 control-label">Name</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="name" v-model="userForm.attributes.name" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="col-md-3 control-label">Username</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="username" v-model="userForm.attributes.username" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-md-3 control-label">Password</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" v-model="userForm.attributes.password" />
                            <span class="input-group-btn">
                                <sa-button @click.native="userForm.attributes.password = password()" icon="arrow-left" />
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-3 col-md-8">
                        <sa-button @click.native="add"
                                   type="default"
                                   icon="plus"
                                   :loading="userForm.loading">Add</sa-button>
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
            <sa-mail-user v-for="user in this.users"
                            :key="user.id"
                            :domain="domain"
                            :user="user"
                            @destroy="destroy(user.id)" />
            </tbody>
            <tfoot>
            <tr>
                <td colspan="7" class="text-right">
                    <sa-button @click.native="userForm.open()"
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
                userForm: new ServerAdmin.ModalForm({
                    'domain_id': this.domain_id,
                    'username': '',
                    'password': '',
                }),
            };
        },
        mounted() {
            this.load();
        },
        methods: {
            load() {
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
            destroy(id) {
                this.users = _.remove(this.users, user => user.id !== id);
            },
            add() {
                this.userForm.start();
                axios.post('/api/mail/users', this.userForm.attributes).then(() => {
                    this.userForm.finish();
                    this.load();
                }).catch(error => {
                    this.userForm.crash(error);
                });
            },
            password() {
                return ServerAdmin.Utils.generatePassword();
            },
        }
    }
</script>
