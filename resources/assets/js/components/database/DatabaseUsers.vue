<template>
    <table class="table table-striped table-controls">
        <tbody>
        <sa-database-user v-for="user in users"
                          :key="user.user + '@' + user.host"
                          :user="user"
                          @destroy="destroy(user)" />
        </tbody>
        <tfoot>
        <tr>
            <td>
                <div class="form-horizontal">
                    <div class="form-group form-group-sm">
                        <label for="user" class="col-md-2 control-label">User</label>
                        <div class="col-md-10">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" id="user" placeholder="User" v-model="user.user">
                                <span class="input-group-addon"><i class="fa fa-at" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" placeholder="Host" v-model="user.host">
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <label for="password" class="col-md-2 control-label">Password</label>
                        <div class="col-md-10">
                            <div class="input-group input-group-sm">
                                <input type="password" class="form-control" id="password" placeholder="Password" v-model="user.password" />
                                <span class="input-group-btn">
                                    <sa-button @click.native="user.password = generatePassword()" icon="arrow-left" />
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
            <td class="fit">
                <sa-button @click.native="add"
                           type="default"
                           icon="plus"
                           size="sm"
                           :loading="adding" />
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
                user: {
                    user: '',
                    host: 'localhost',
                    password: '',
                },
                //
                adding: false,
                destroying: false,
            };
        },
        mounted() {
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
        methods: {
            add() {
                this.adding = true;
                axios.post('/api/database/users', this.user).then(response => {
                    this.adding = false;
                }).catch(error => {
                    this.adding = false;
                    console.error(error);
                });
            },
            destroy(user) {
                this.users = _.remove(this.users, aUser => (aUser.user + '@' + aUser.host) !== (user.user + '@' + user.host));
            },
            generatePassword() {
                // TODO: Move to utils.
                // Generates password of 24 alphanumeric characters.
                return _.times(24, () => _.random(35).toString(36)).join('');
            }
        }
    }
</script>
