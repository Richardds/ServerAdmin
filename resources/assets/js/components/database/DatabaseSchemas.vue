<template>
    <div>
        <sa-modal :visible="addSchema"
                  @close="addSchema = false"
                  title="Add database">
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="schemaName" class="col-md-3 control-label">Name</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="schemaName" v-model="schema.name" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="schemaCharacterSet" class="col-md-3 control-label">Character set</label>
                    <div class="col-md-8">
                        <select class="form-control" id="schemaCharacterSet" v-model="schema.character_set">
                            <!-- <option v-for="user in users">{{ user }}</option> -->
                            <option>utf8mb4</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="schemaCollation" class="col-md-3 control-label">Collation</label>
                    <div class="col-md-8">
                        <select class="form-control" id="schemaCollation" v-model="schema.collation">
                            <!-- <option v-for="user in users">{{ user }}</option> -->
                            <option>utf8mb4_general_ci</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-3 col-md-8">
                        <sa-button @click.native="add"
                                   type="default"
                                   icon="plus"
                                   :loading="adding">Add</sa-button>
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
            <sa-database-schema v-for="schema in this.schemas"
                         :key="schema.name"
                         :schema="schema"
                         @destroy="destroy(schema.name)" />
            </tbody>
            <tfoot>
            <tr>
                <td colspan="7" class="text-right">
                    <sa-button @click.native="addSchema = true"
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
                users: [],
                data: [],
                //
                addSchema: false,
                adding: false,
                //
                schema: {
                    name: '',
                    character_set: 'utf8mb4',
                    collation: 'utf8mb4_general_ci',
                },
            };
        },
        mounted() {
            this.loadScreenData([
                'database_available_character_sets',
                'database_available_collations',
                'database_users',
            ], (name) => {
                console.log(name);
            });

            this.loadUsers();
        },
        methods: {
            loadScreenData(names, after) {
                for (let name of names) {
                    axios.get('/api/data/' + name).then(response => {
                        this.data[name] = response.data.data;
                        after(name);
                    }).catch(error => {
                        console.error(error);
                    });
                }
            },

            loadUsers() {
                axios.get('/api/data/database_users').then(response => {
                    this.users = [];
                    for (let user of response.data.data) {
                        this.users.push(user);
                    }
                    this.load();
                }).catch(error => {
                    console.error(error);
                });
            },
            load() {
                axios.get('/api/database/schemas').then(response => {
                    this.schemas = [];
                    for (let schema of response.data.data) {
                        this.schemas.push(schema);
                    }
                }).catch(error => {
                    console.error(error);
                });
            },
            destroy(name) {
                this.schemas = _.remove(this.schemas, schema => schema.name !== name);
            },
            add() {
                this.adding = true;
                axios.post('/api/database/schemas', this.schema).then(response => {
                    this.load();
                    this.adding = false;
                }).catch(error => {
                    this.adding = false;
                    console.error(error);
                });
            }
        }
    }
</script>
