<template>
    <tr :class="[user.enabled ? '' : 'disabled']">
        <td class="user-name">{{ user.name }}</td>
        <td class="user-username">{{ user.username }}<span class="lighter">@{{ domain.name }}</span></td>
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
                            <sa-button @click.native="updateUserPassword"
                                       type="default"
                                       icon="check"
                                       :loading="changePasswordForm.loading">Change</sa-button>
                        </div>
                    </div>
                </div>
            </sa-modal>

            <sa-modal :visible="editAliasesModal.enabled"
                      @close="editAliasesModal.close()"
                      title="User aliases">
                <sa-mail-user-aliases :domain="domain" :user="user" />
            </sa-modal>

            <sa-button @click.native="changePasswordForm.open()"
                       icon="key"
                       size="sm" />
            <sa-button @click.native="editAliasesModal.open()"
                       icon="users"
                       size="sm" />
            <sa-button @click.native="toggleEnabled"
                       :icon="user.enabled ? 'toggle-on' : 'toggle-off'"
                       size="sm"
                       :loading="toggleUserForm.loading" />
            <sa-button @click.native="deleteUser"
                       type="danger"
                       icon="trash"
                       size="sm"
                       :loading="destroyUserForm.loading" />
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['domain', 'user'],
        data() {
            return {
                toggleUserForm: new ServerAdmin.ToggleForm(),
                changePasswordForm: new ServerAdmin.ModalForm({
                    password: ''
                }),
                editAliasesModal: new ServerAdmin.ModalForm(),
                destroyUserForm: new ServerAdmin.Form({
                    'id': -1
                }),
            };
        },
        methods: {
            deleteUser() {
                this.destroyUserForm.start();
                axios.delete('/api/mail/users/' + this.user.id).then(() => {
                    this.destroyUserForm.finish();
                    this.$emit('destroy');
                }).catch(error => {
                    this.destroyUserForm.crash(error);
                });
            },
            toggleEnabled() {
                this.toggleUserForm.start();
                this.toggleUserForm.switch(this.user.enabled);
                axios.patch('/api/mail/users/' + this.user.id, this.toggleUserForm.attributes).then(response => {
                    ServerAdmin.Utils.updateAttributes(this.user, response.data.data);
                    this.toggleUserForm.finish();
                }).catch(error => {
                    this.toggleUserForm.crash(error);
                });
            },
            updateUserPassword() {
                this.changePasswordForm.start();
                axios.patch('/api/mail/users/' + this.user.id, this.changePasswordForm.attributes).then(response => {
                    ServerAdmin.Utils.updateAttributes(this.user, response.data.data);
                    this.changePasswordForm.finish();
                }).catch(error => {
                    this.changePasswordForm.crash(error);
                });
            },
            password() {
                return ServerAdmin.Utils.generatePassword();
            },
        }
    }
</script>
