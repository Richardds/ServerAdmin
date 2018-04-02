<template>
    <tr :class="'type-' + rule.type">

        <td class="rule-type">{{ uppercaseType }}</td>
        <td class="rule-protocol">{{ uppercaseProtocol }}</td>

        <template v-if="editMode">
            <td class="rule-destination">
                <input type="text" @input="onChange" class="form-control input-sm" v-model="rule.destination" />
            </td>
            <td class="rule-source">
                <input type="text" @input="onChange" class="form-control input-sm" v-model="rule.source" />
            </td>
            <td class="rule-port">
                <div class="input-group input-group-sm">
                    <input type="number" @input="onChange" class="form-control" min="1" max="65535" v-model="rule.port" />
                    <span class="input-group-addon">-</span>
                    <input type="number" @input="onChange" class="form-control" min="1" max="65535" v-model="rule.portTo" />
                </div>
            </td>
        </template>

        <template v-else>
            <td class="rule-destination">{{ optionalDestination }}</td>
            <td class="rule-source">{{ optionalSource }}</td>
            <td class="rule-port">{{ rangedPort }}</td>
        </template>

        <td class="fit">
            <sa-button @click.native="editRule()"
                       :type="editButtonType"
                       :icon="editButtonIcon"
                       size="sm"
                       :loading="updating" />
            <sa-button @click.native="toggleRule()"
                       :icon="rule.enabled ? 'toggle-on' : 'toggle-off'"
                       size="sm"
                       :loading="toggleRuleForm.loading" />
            <sa-button @click.native="destroyRule()"
                       type="danger"
                       icon="trash"
                       size="sm"
                       :loading="destroyRuleForm.loading" />
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['rule'],
        data() {
            return {
                editMode: false,
                updating: false,
                changed: false,
                toggleRuleForm: new ServerAdmin.ToggleForm(),
                destroyRuleForm: new ServerAdmin.Form({
                    'id': -1
                }),
            };
        },
        methods: {
            onChange() {
                this.changed = true;
            },
            editRule() {
                if (this.editMode && this.changed) {
                    this.updating = true;
                    axios.put('/api/firewall/rules/' + this.rule.id, ServerAdmin.Utils.stripUnfilled(this.rule)).then(response => {
                        ServerAdmin.Utils.updateAttributes(this.rule, response.data.data);
                        this.updating = false;
                        this.changed = false;
                    }).catch(error => {
                        this.updating = false;
                        console.error(error);
                    });
                }
                this.editMode = !this.editMode;
            },
            destroyRule() {
                this.destroyRuleForm.start();
                axios.delete('/api/firewall/rules/' + this.rule.id).then(() => {
                    this.destroyRuleForm.finish();
                    this.$emit('destroyRule');
                }).catch(error => {
                    this.destroyRuleForm.crash(error);
                });
            },
            toggleRule() {
                this.toggleRuleForm.start();
                this.toggleRuleForm.switch(this.rule.enabled);
                axios.patch('/api/firewall/rules/' + this.rule.id, this.toggleRuleForm.attributes).then(response => {
                    ServerAdmin.Utils.updateAttributes(this.rule, response.data.data);
                    this.toggleRuleForm.finish();
                }).catch(error => {
                    this.toggleRuleForm.crash(error);
                });
            },
        },
        computed: {
            editButtonIcon() {
                if (this.editMode) {
                    return this.changed ? 'check' : 'times';
                }
                return 'pencil';
            },
            editButtonType() {
                if (this.editMode) {
                    return this.changed ? 'success' : 'danger';
                }
                return 'default';
            },
            uppercaseType() {
                return this.rule.type.toUpperCase();
            },
            uppercaseProtocol() {
                return this.rule.protocol.toUpperCase();
            },
            rangedPort() {
                if (this.rule.portTo == null) {
                    return this.rule.port;
                }

                return this.rule.port + ' - ' + this.rule.portTo;
            },
            optionalDestination() {
                return this.rule.destination == null ? '0.0.0.0/0' : this.rule.destination;
            },
            optionalSource() {
                return this.rule.source == null ? '0.0.0.0/0' : this.rule.source;
            },
        },
    }
</script>
