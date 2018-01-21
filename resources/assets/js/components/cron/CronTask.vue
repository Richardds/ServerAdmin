<template>
    <tr :class="[task.enabled ? '' : 'disabled']">
        <template v-if="editMode">
            <td class="cron-interval edit-mode" @click="$emit('editInterval', task.id)">
                {{ task.minute }} {{ task.hour }} {{ task.day }} {{ task.month }} {{ task.weekday }}
            </td>
            <td class="cron-user">
                <select @change="onChange" class="form-control input-sm" v-model="task.uid">
                    <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
                </select>
            </td>
            <td class="cron-command">
                <input @input="onChange" class="form-control input-sm" type="text" v-model="task.command" />
            </td>
            <td class="cron-description">
                <textarea @input="onChange" rows="2" class="form-control input-sm" v-model="task.description"></textarea>
            </td>
        </template>

        <template v-else>
            <td class="cron-interval">
                {{ task.minute }} {{ task.hour }} {{ task.day }} {{ task.month }} {{ task.weekday }}
            </td>
            <td class="cron-user">{{ user(task.uid).name }}</td>
            <td class="cron-command">{{ task.command }}</td>
            <td class="cron-description">{{ task.description }}</td>
        </template>

        <td class="fit">
            <sa-button @click.native="editTask"
                       :type="editButtonType"
                       :icon="editButtonIcon"
                       size="sm"
                       :loading="updating" />
            <sa-button @click.native="toggleEnabled"
                       :icon="task.enabled ? 'toggle-on' : 'toggle-off'"
                       size="sm"
                       :loading="toggling" />
            <sa-button @click.native="deleteTask"
                       type="danger"
                       icon="trash"
                       size="sm"
                       :loading="deleting" />
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['task', 'users'],
        data() {
            return {
                editTaskInterval: false,
                //
                editMode: false,
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
            updateAttributes(task) {
                _.forOwn(this.task, (value, key) => {
                    this.task[key] = task[key];
                });
            },
            editTask() {
                if (this.editMode && this.changed) {
                    this.updating = true;
                    axios.put('/api/cron/tasks/' + this.task.id, this.task).then(response => {
                        this.updateAttributes(response.data.data);
                        this.updating = false;
                        this.changed = false;
                    }).catch(error => {
                        this.updating = false;
                        console.error(error);
                    });
                }
                this.editMode = !this.editMode;
            },
            deleteTask() {
                this.deleting = true;
                axios.delete('/api/cron/tasks/' + this.task.id).then(response => {
                    this.$emit('destroy');
                }).catch(error => {
                    this.deleting = false;
                    console.error(error);
                });
            },
            toggleEnabled() {
                this.toggling = true;
                let nextStatus = !this.task.enabled;
                axios.patch('/api/cron/tasks/' + this.task.id, {enabled: nextStatus}).then(response => {
                    this.updateAttributes(response.data.data);
                    this.toggling = false;
                }).catch(error => {
                    this.toggling = false;
                    console.error(error);
                });
            },
            user(id) {
                return _.find(this.users, {'id': id});
            }
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
            }
        }
    }
</script>
