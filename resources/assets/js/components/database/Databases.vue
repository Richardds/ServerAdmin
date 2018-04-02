<template>
    <div>
        <sa-modal :visible="createDatabaseForm.enabled"
                  @close="createDatabaseForm.close()"
                  title="Create database">
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="databaseName" class="col-md-3 control-label">Name</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="databaseName" v-model="createDatabaseForm.attributes.name" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="databaseCharacterSet" class="col-md-3 control-label">Character set</label>
                    <div class="col-md-8">
                        <select class="form-control" id="databaseCharacterSet" v-model="createDatabaseForm.attributes.character_set">
                            <option v-for="character_set in character_sets">{{ character_set }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="databaseCollation" class="col-md-3 control-label">Collation</label>
                    <div class="col-md-8">
                        <select class="form-control" id="databaseCollation" v-model="createDatabaseForm.attributes.collation">
                            <option v-for="collation in collations">{{ collation }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-3 col-md-8">
                        <sa-button @click.native="createDatabase()"
                                   type="default"
                                   icon="plus"
                                   :loading="createDatabaseForm.loading">Create</sa-button>
                    </div>
                </div>
            </div>
        </sa-modal>

        <table class="table table-striped table-controls table-database-databases">
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
            <sa-database v-for="database in orderedDatabases"
                         :key="database.name"
                         :database="database"
                         :users="users"
                         @destroyDatabase="loadDatabases()" />
            </tbody>
            <tfoot>
            <tr>
                <td colspan="7" class="text-right">
                    <sa-button @click.native="createDatabaseForm.open()"
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
                databases: [],
                character_sets: [],
                collations: [],
                users: [],
                createDatabaseForm: new ServerAdmin.ModalForm({
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

                // Load databases
                self.loadDatabases();
            })).catch(error => {
                console.error(error);
            });
        },
        methods: {
            loadDatabases() {
                axios.get('/api/database/databases').then(response => {
                    this.databases = [];
                    for (let database of response.data.data) {
                        this.databases.push(database);
                    }
                }).catch(error => {
                    console.error(error);
                });
            },
            createDatabase() {
                this.createDatabaseForm.start();
                axios.post('/api/database/databases', ServerAdmin.Utils.stripUnfilled(this.createDatabaseForm.attributes)).then(() => {
                    this.createDatabaseForm.finish();
                    this.loadDatabases();
                }).catch(error => {
                    this.createDatabaseForm.crash(error);
                });
            },
        },
        computed: {
            orderedDatabases() {
                return _.sortBy(this.databases, 'name');
            }
        },
    }
</script>
