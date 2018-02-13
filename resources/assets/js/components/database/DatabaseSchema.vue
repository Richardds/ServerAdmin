<template>
    <tr>
        <td class="schema-name">{{ schema.name }}</td>
        <td class="schema-character-set">{{ schema.character_set }}</td>
        <td class="schema-collation">{{ schema.collation }}</td>
        <td class="schema-tables">{{ schema.tables_count }}</td>
        <td class="schema-size" :title="schema.size">{{ schemaSizeText }}</td>

        <td class="fit">
            <sa-modal :visible="editUsersModal.enabled"
                      @close="editUsersModal.close()"
                      title="Schema privileges">
                <sa-database-schema-users :schema="schema.name" :users="users" />
            </sa-modal>
            <sa-button @click.native="editUsersModal.open()"
                       type="default"
                       icon="users"
                       size="sm" />
            <sa-button @click.native="destroySchema()"
                       :disabled="schema.protected"
                       type="danger"
                       icon="trash"
                       size="sm"
                       :loading="destroySchemaForm.loading" />
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['schema', 'users'],
        data() {
            return {
                editUsersModal: new ServerAdmin.ModalForm(),
                destroySchemaForm: new ServerAdmin.Form({
                    'id': -1
                }),
            };
        },
        methods: {
            destroySchema() {
                this.destroySchemaForm.start();
                axios.delete('/api/database/schemas/' + this.schema.name).then(() => {
                    this.destroySchemaForm.finish();
                    this.$emit('destroySchema');
                }).catch(error => {
                    this.destroySchemaForm.crash(error);
                });
            },
        },
        computed: {
            schemaSizeText() {
                if (this.schema.size > 1073741824) {
                    return _.round(this.schema.size / 1073741824, 2) + ' GB';
                } else if (this.schema.size > 1048576) {
                    return _.round(this.schema.size / 1048576, 2) + ' MB';
                } else if (this.schema.size > 1024) {
                    return _.round(this.schema.size / 1024, 2) + ' KB';
                } else {
                    return this.schema.size + ' B';
                }
            }
        }
    }
</script>
