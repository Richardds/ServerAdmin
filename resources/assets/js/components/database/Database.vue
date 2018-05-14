<template>
    <tr>
        <td class="database-name">{{ database.name }}</td>
        <td class="database-character-set">{{ database.character_set }}</td>
        <td class="database-collation">{{ database.collation }}</td>
        <td class="database-tables">{{ database.tables_count }}</td>
        <td class="database-size" :title="database.size">{{ databaseSizeText }}</td>

        <td class="fit">
            <sa-modal :visible="editPrivilegesModal.enabled"
                      @close="editPrivilegesModal.close()"
                      title="Database privileges">
                <sa-database-privileges :database="database.name" :users="users" />
            </sa-modal>
            <sa-button @click.native="editPrivilegesModal.open()"
                       type="default"
                       icon="key"
                       size="sm" />
            <sa-button @click.native="destroyDatabase()"
                       :disabled="database.protected"
                       type="danger"
                       icon="trash"
                       size="sm"
                       :loading="destroyDatabaseForm.loading" />
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['database', 'users'],
        data() {
            return {
                editPrivilegesModal: new ServerAdmin.ModalForm(),
                destroyDatabaseForm: new ServerAdmin.Form({
                    'id': -1
                }),
            };
        },
        methods: {
            destroyDatabase() {
                this.destroyDatabaseForm.start();
                axios.delete('/api/database/databases/' + this.database.name).then(() => {
                    this.destroyDatabaseForm.finish();
                    this.$emit('destroyDatabase');
                }).catch(error => {
                    this.destroyDatabaseForm.crash(error);
                });
            },
        },
        computed: {
            databaseSizeText() {
                if (this.database.size > 1073741824) {
                    return _.round(this.database.size / 1073741824, 2) + ' GB';
                } else if (this.database.size > 1048576) {
                    return _.round(this.database.size / 1048576, 2) + ' MB';
                } else if (this.database.size > 1024) {
                    return _.round(this.database.size / 1024, 2) + ' KB';
                } else {
                    return this.database.size + ' B';
                }
            }
        }
    }
</script>
