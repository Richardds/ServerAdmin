<template>
    <tr :class="[user.enabled ? '' : 'disabled']">
        <td class="user-name">{{ user.name }}</td>
        <td class="user-username">{{ user.username }}<span class="lighter">@{{ domain.name }}</span></td>
        <td class="fit">

            <sa-modal :visible="passwordForm.enabled"
                      @close="passwordForm.close()"
                      title="Change password">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label for="password" class="col-md-3 control-label">Password</label>
                        <div class="col-md-8">
                            <input type="password" class="form-control" id="password" v-model="passwordForm.attributes.password" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-8">
                            <sa-button @click.native="updateUserPassword"
                                       type="default"
                                       icon="check"
                                       :loading="passwordForm.loading">Change</sa-button>
                        </div>
                    </div>
                </div>
            </sa-modal>

            <sa-modal :visible="aliasModal.enabled"
                      @close="aliasModal.close()"
                      title="User aliases">
                <sa-mail-user-aliases :domain="domain" :user="user" />
            </sa-modal>

            <sa-button @click.native="passwordForm.open()"
                       icon="key"
                       size="sm" />
            <sa-button @click.native="aliasModal.open()"
                       icon="users"
                       size="sm" />
            <sa-button @click.native="toggleEnabled"
                       :icon="user.enabled ? 'toggle-on' : 'toggle-off'"
                       size="sm"
                       :loading="toggleForm.loading" />
            <sa-button @click.native="deleteUser"
                       type="danger"
                       icon="trash"
                       size="sm"
                       :loading="deleting" />
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['domain', 'user'],
        data() {
            return {
                deleting: false,
                //
                toggleForm: new ServerAdmin.ToggleForm(),
                passwordForm: new ServerAdmin.ModalForm({
                    'password': ''
                }),
                aliasModal: new ServerAdmin.ModalForm(),
            };
        },
        methods: {
            deleteUser() {
                this.deleting = true;
                axios.delete('/api/mail/user/' + this.user.id).then(response => {
                    this.$emit('destroy');
                }).catch(error => {
                    this.deleting = false;
                    console.error(error);
                });
            },
            toggleEnabled() {
                this.toggleForm.start();
                this.toggleForm.switch(this.user.enabled);
                axios.patch('/api/mail/users/' + this.user.id, this.toggleForm.attributes).then(response => {
                    ServerAdmin.Utils.updateAttributes(this.user, response.data.data);
                    this.toggleForm.finish();
                }).catch(error => {
                    this.toggleForm.crash(error);
                });
            },
            updateUserPassword() {
                this.passwordForm.start();
                axios.patch('/api/mail/users/' + this.user.id, this.passwordForm.attributes).then(response => {
                    ServerAdmin.Utils.updateAttributes(this.user, response.data.data);
                    this.passwordForm.finish();
                }).catch(error => {
                    this.passwordForm.crash(error);
                });
            },
        }
    }
</script>
