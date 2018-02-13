<template>
    <tr :class="[task.enabled ? '' : 'disabled']">
        <template v-if="editMode">
            <td class="cron-interval edit-mode" @click="editTaskIntervalVisible = true">
                {{ task.minute }} {{ task.hour }} {{ task.day }} {{ task.month }} {{ task.weekday }}
            </td>
            <td class="cron-user">
                <select @change="onChange()" class="form-control input-sm" v-model="task.uid">
                    <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
                </select>
            </td>
            <td class="cron-command">
                <input @input="onChange()" class="form-control input-sm" type="text" v-model="task.command" />
            </td>
            <td class="cron-description">
                <textarea @input="onChange()" rows="2" class="form-control input-sm" v-model="task.description"></textarea>
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

            <sa-modal :visible="editTaskIntervalVisible"
                      @close="editTaskIntervalVisible = false"
                      title="Edit interval">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label for="editIntervalMinute" class="col-md-3 control-label">Minute</label>
                        <div class="col-md-8">
                            <input @input="onChange()" type="text" class="form-control" id="editIntervalMinute" v-model="task.minute" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="editIntervalHour" class="col-md-3 control-label">Hour</label>
                        <div class="col-md-8">
                            <input @input="onChange()" type="text" class="form-control" id="editIntervalHour" v-model="task.hour" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="editIntervalDay" class="col-md-3 control-label">Day</label>
                        <div class="col-md-8">
                            <input @input="onChange()" type="text" class="form-control" id="editIntervalDay" v-model="task.day" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="editIntervalMonth" class="col-md-3 control-label">Month</label>
                        <div class="col-md-8">
                            <input @input="onChange()" type="text" class="form-control" id="editIntervalMonth" v-model="task.month" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="editIntervalWeekday" class="col-md-3 control-label">Weekday</label>
                        <div class="col-md-8">
                            <input @input="onChange()" type="text" class="form-control" id="editIntervalWeekday" v-model="task.weekday" />
                        </div>
                    </div>
                </div>
            </sa-modal>

            <sa-button @click.native="editTask()"
                       :type="editButtonType"
                       :icon="editButtonIcon"
                       size="sm"
                       :loading="updating" />
            <sa-button @click.native="toggleTask()"
                       :icon="task.enabled ? 'toggle-on' : 'toggle-off'"
                       size="sm"
                       :loading="toggleTaskForm.loading" />
            <sa-button @click.native="destroyTask()"
                       type="danger"
                       icon="trash"
                       size="sm"
                       :loading="destroyTaskForm.loading" />
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['task', 'users'],
        data() {
            return {
                editTaskIntervalVisible: false,
                //
                editMode: false,
                updating: false,
                changed: false,
                //
                toggleTaskForm: new ServerAdmin.ToggleForm(),
                destroyTaskForm: new ServerAdmin.Form({
                    'id': -1
                }),
            };
        },
        methods: {
            onChange() {
                this.changed = true;
            },
            editTask() {
                if (this.editMode && this.changed) {
                    this.updating = true;
                    axios.put('/api/cron/tasks/' + this.task.id, this.task).then(response => {
                        ServerAdmin.Utils.updateAttributes(this.task, response.data.data);
                        this.updating = false;
                        this.changed = false;
                    }).catch(error => {
                        this.updating = false;
                        console.error(error);
                    });
                }
                this.editMode = !this.editMode;
            },
            destroyTask() {
                this.destroyTaskForm.start();
                axios.delete('/api/cron/tasks/' + this.task.id).then(response => {
                    this.destroyTaskForm.finish();
                    this.$emit('destroy');
                }).catch(error => {
                    this.destroyTaskForm.crash(error);
                });
            },
            toggleTask() {
                this.toggleTaskForm.start();
                this.toggleTaskForm.switch(this.task.enabled);
                axios.patch('/api/cron/tasks/' + this.task.id, this.toggleTaskForm.attributes).then(response => {
                    ServerAdmin.Utils.updateAttributes(this.task, response.data.data);
                    this.toggleTaskForm.finish();
                }).catch(error => {
                    this.toggleTaskForm.crash(error);
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
