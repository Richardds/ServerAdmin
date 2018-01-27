<template>
    <tr>
        <td class="schema-name">{{ schema.name }}</td>
        <td class="schema-character-set">{{ schema.character_set }}</td>
        <td class="schema-collation">{{ schema.collation }}</td>
        <td class="schema-tables">{{ schema.tables_count }}</td>
        <td class="schema-size" :title="schema.size">{{ schemaSizeText }}</td>

        <td class="fit">
            <sa-button @click.native="editPermissions"
                       type="default"
                       icon="users"
                       size="sm"
                       :loading="updating" />
            <sa-button @click.native="deleteSchema"
                       :disabled="schema.protected"
                       type="danger"
                       icon="trash"
                       size="sm"
                       :loading="deleting" />
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['schema'],
        data() {
            return {
                updating: false,
                toggling: false,
                deleting: false,
                changed: false
            };
        },
        methods: {
            onChange() {
                this.changed = true;
            },
            updateAttributes(schema) {
                _.forOwn(this.schema, (value, key) => {
                    this.schema[key] = schema[key];
                });
            },
            editPermissions() {
                // Permissions modal
            },
            deleteSchema() {
                this.deleting = true;
                axios.delete('/api/database/schemas/' + this.schema.name).then(response => {
                    this.$emit('destroy');
                }).catch(error => {
                    this.deleting = false;
                    console.error(error);
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
