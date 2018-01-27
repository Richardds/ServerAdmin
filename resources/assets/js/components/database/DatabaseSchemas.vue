<template>
    <div>
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
                <!-- TODO -->
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
                //
                adminChanged: false,
                adding: false
            };
        },
        mounted() {
            this.reset();
            this.load();
        },
        methods: {
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
                axios.post('/api/database/schemas', this.addSchema).then(response => {
                    this.reset();
                    this.load();
                    this.adding = false;
                }).catch(error => {
                    this.adding = false;
                    console.error(error);
                });
            },
            reset() {
                //
            },
        }
    }
</script>
