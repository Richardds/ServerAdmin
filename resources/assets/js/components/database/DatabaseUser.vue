<template>
    <tr>
        <td class="user-user">{{ user.user }}</td>
        <td class="user-host">{{ user.host }}</td>
        <td class="fit">

            <sa-modal :visible="changePasswordForm.enabled"
                      @close="changePasswordForm.close()"
                      title="Change password">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label for="password" class="col-md-3 control-label">Password</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" v-model="changePasswordForm.attributes.password" />
                                <span class="input-group-btn">
                                    <sa-button data-clipboard-target="#password" icon="copy" />
                                    <sa-button @click.native="changePasswordForm.attributes.password = password()" icon="arrow-left" />
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-8">
                            <sa-button @click.native="changePassword()"
                                       type="default"
                                       icon="check"
                                       :loading="changePasswordForm.loading">Change</sa-button>
                        </div>
                    </div>
                </div>
            </sa-modal>

            <sa-button @click.native="changePasswordForm.open()"
                       icon="key"
                       size="sm" />
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
                changePasswordForm: new ServerAdmin.ModalForm({
                    user: this.user.user + '@' + this.user.host,
                    password: '',
                }),
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
                    this.$emit('destroyUser');
                }).catch(error => {
                    this.destroyUserForm.crash(error);
                });
            },
            changePassword() {
                this.changePasswordForm.start();
                axios.patch('/api/database/userPassword', this.changePasswordForm.attributes).then(response => {
                    ServerAdmin.Utils.updateAttributes(this.user, response.data.data);
                    this.changePasswordForm.finish();
                }).catch(error => {
                    this.changePasswordForm.crash(error);
                });
            },
            password() {
                return ServerAdmin.Utils.generatePassword();
            },
        },
    }
</script>
