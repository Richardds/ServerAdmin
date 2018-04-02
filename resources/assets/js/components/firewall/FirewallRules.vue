<template>
    <div>
        <sa-modal :visible="createRuleForm.enabled"
                  @close="createRuleForm.close()"
                  title="Create rule">
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="ruleType" class="col-md-3 control-label">Type</label>
                    <div class="col-md-8">
                        <select class="form-control" id="ruleType" v-model="createRuleForm.attributes.type">
                            <option value="allow" selected>Allow</option>
                            <option value="deny">Deny</option>
                            <option value="reject">Reject</option>
                            <option value="limit">Limit</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="ruleProtocol" class="col-md-3 control-label">Protocol</label>
                    <div class="col-md-8">
                        <select class="form-control" id="ruleProtocol" v-model="createRuleForm.attributes.protocol">
                            <option value="tcp" selected>TCP</option>
                            <option value="udp">UDP</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="ruleDestination" class="col-md-3 control-label">Destination</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="ruleDestination" placeholder="192.0.2.123" v-model="createRuleForm.attributes.destination" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="ruleSource" class="col-md-3 control-label">Source</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="ruleSource" placeholder="192.0.2.0/24" v-model="createRuleForm.attributes.source" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="rulePort" class="col-md-3 control-label">Port range</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input type="number" class="form-control" id="rulePort" min="1" max="65535" placeholder="5000" v-model="createRuleForm.attributes.port" />
                            <span class="input-group-addon">-</span>
                            <input type="number" class="form-control" min="1" max="65535" placeholder="5050" v-model="createRuleForm.attributes.portTo" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-3 col-md-8">
                        <sa-button @click.native="createRule()"
                                   type="default"
                                   icon="plus"
                                   :loading="createRuleForm.loading">Create</sa-button>
                    </div>
                </div>
            </div>
        </sa-modal>
        <table class="table table-striped table-controls table-firewall-rules">
            <thead>
            <tr>
                <th>Type</th>
                <th>Protocol</th>
                <th>Destination</th>
                <th>Source</th>
                <th>Port</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <sa-firewall-rule v-for="rule in orderedRules"
                            :key="rule.id"
                            :rule="rule"
                            @destroyRule="loadRules()" />
            </tbody>
            <tfoot>
            <tr>
                <td colspan="7" class="text-right">
                    <sa-button @click.native="createRuleForm.open()"
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
                rules: [],
                createRuleForm: new ServerAdmin.ModalForm({
                    'type': 'allow',
                    'protocol': 'tcp',
                    'destination': '',
                    'source': '',
                    'port': '',
                    'portTo': '',
                }),
            };
        },
        mounted() {
            this.loadRules();
        },
        methods: {
            loadRules() {
                axios.get('/api/firewall/rules').then(response => {
                    this.rules = [];
                    for (let rule of response.data.data) {
                        this.rules.push(rule);
                    }
                }).catch(error => {
                    console.error(error);
                });
            },
            createRule() {
                this.createRuleForm.start();
                axios.post('/api/firewall/rules', ServerAdmin.Utils.stripUnfilled(this.createRuleForm.attributes)).then(() => {
                    this.createRuleForm.finish();
                    this.loadRules();
                }).catch(error => {
                    this.createRuleForm.crash(error);
                });
            },
        },
        computed: {
            orderedRules() {
                return _.sortBy(this.rules, ['type', 'destination', 'source', 'protocol', 'port']);
            }
        }
    }
</script>
