<template>
    <div>
        <sa-modal :visible="createSchemaForm.enabled"
                  @close="createSchemaForm.close()"
                  title="Create schema">
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="schemaName" class="col-md-3 control-label">Name</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="schemaName" v-model="createSchemaForm.attributes.name" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="schemaCharacterSet" class="col-md-3 control-label">Character set</label>
                    <div class="col-md-8">
                        <select class="form-control" id="schemaCharacterSet" v-model="createSchemaForm.attributes.character_set">
                            <option v-for="character_set in character_sets">{{ character_set }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="schemaCollation" class="col-md-3 control-label">Collation</label>
                    <div class="col-md-8">
                        <select class="form-control" id="schemaCollation" v-model="createSchemaForm.attributes.collation">
                            <option v-for="collation in collations">{{ collation }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-3 col-md-8">
                        <sa-button @click.native="createSchema()"
                                   type="default"
                                   icon="plus"
                                   :loading="createSchemaForm.loading">Create</sa-button>
                    </div>
                </div>
            </div>
        </sa-modal>

        <table class="table table-striped table-controls table-database-schemas">
            <thead>
            <tr>
                <th>Name</th>
                <th>Character set</th>
                <th>Collation</th>
                <th>Tables</th>
                <th>Size</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <sa-database-schema v-for="schema in orderedSchemas"
                         :key="schema.name"
                         :schema="schema"
                         :users="users"
                         @destroySchema="loadSchemas()" />
            </tbody>
            <tfoot>
            <tr>
                <td colspan="7" class="text-right">
                    <sa-button @click.native="createSchemaForm.open()"
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
                schemas: [],
                character_sets: [],
                collations: [],
                users: [],
                createSchemaForm: new ServerAdmin.ModalForm({
                    name: '',
                    character_set: 'utf8mb4',
                    collation: 'utf8mb4_general_ci',
                }),
            };
        },
        mounted() {
            let self = this;
            // Load data
            axios.all([
                axios.get('/api/data/database_available_character_sets'),
                axios.get('/api/data/database_available_collations'),
                axios.get('/api/data/database_users'),
            ]).then(axios.spread(function (character_sets, collations, users) {
                self.character_sets = [];
                for (let character_set of character_sets.data.data) {
                    self.character_sets.push(character_set);
                }
                self.collations = [];
                for (let collation of collations.data.data) {
                    self.collations.push(collation);
                }
                self.users = [];
                for (let user of users.data.data) {
                    self.users.push(user);
                }

                // Load schemas
                self.loadSchemas();
            })).catch(error => {
                console.error(error);
            });
        },
        methods: {
            loadSchemas() {
                axios.get('/api/database/schemas').then(response => {
                    this.schemas = [];
                    for (let schema of response.data.data) {
                        this.schemas.push(schema);
                    }
                }).catch(error => {
                    console.error(error);
                });
            },
            createSchema() {
                this.createSchemaForm.start();
                axios.post('/api/database/schemas', this.createSchemaForm.attributes).then(() => {
                    this.createSchemaForm.finish();
                    this.loadSchemas();
                }).catch(error => {
                    this.createSchemaForm.crash(error);
                });
            },
        },
        computed: {
            orderedSchemas() {
                return _.sortBy(this.schemas, 'name');
            }
        },
    }
</script>
