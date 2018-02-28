<template>
    <div>
        <sa-modal :visible="createTaskForm.enabled"
                  @close="createTaskForm.close()"
                  title="Create task">
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="editIntervalMinute" class="col-md-3 control-label">Minute</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="editIntervalMinute" v-model="createTaskForm.attributes.minute" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="editIntervalHour" class="col-md-3 control-label">Hour</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="editIntervalHour" v-model="createTaskForm.attributes.hour" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="editIntervalDay" class="col-md-3 control-label">Day</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="editIntervalDay" v-model="createTaskForm.attributes.day" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="editIntervalMonth" class="col-md-3 control-label">Month</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="editIntervalMonth" v-model="createTaskForm.attributes.month" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="editIntervalWeekday" class="col-md-3 control-label">Weekday</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="editIntervalWeekday" v-model="createTaskForm.attributes.weekday" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="taskUser" class="col-md-3 control-label">User</label>
                    <div class="col-md-8">
                        <select id="taskUser" class="form-control" v-model="createTaskForm.attributes.uid">
                            <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="taskUser" class="col-md-3 control-label">Command</label>
                    <div class="col-md-8">
                        <input class="form-control" type="text" v-model="createTaskForm.attributes.command" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-3 col-md-8">
                        <sa-button @click.native="createTask()"
                                   type="default"
                                   icon="plus"
                                   :loading="createTaskForm.loading">Create</sa-button>
                    </div>
                </div>
            </div>
        </sa-modal>
        <table class="table table-striped table-controls table-cron-tasks">
            <thead>
            <tr>
                <th>Interval</th>
                <th>User</th>
                <th>Command</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <sa-task v-for="task in orderedTasks"
                          :key="task.id"
                          :task="task"
                          :users="users"
                          @destroyTask="loadTasks()" />
            </tbody>
            <tfoot>
            <tr>
                <td colspan="7" class="text-right">
                    <sa-button @click.native="createTaskForm.open()"
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
                tasks: [],
                users: [],
                createTaskForm: new ServerAdmin.ModalForm({
                    minute: '*',
                    hour: '*',
                    day: '*',
                    month: '*',
                    weekday: '*',
                    uid: -1,
                    command: '',
                }),
            };
        },
        mounted() {
            // Load system users
            axios.get('/api/data/system_users').then(response => {
                this.users = [];
                for (let user of response.data.data) {
                    this.users.push(user);
                }

                // Load tasks
                this.loadTasks();
            }).catch(error => {
                console.error(error);
            });
        },
        methods: {
            loadTasks() {
                axios.get('/api/tasks').then(response => {
                    this.tasks = [];
                    for (let task of response.data.data) {
                        this.tasks.push(task);
                    }
                }).catch(error => {
                    console.error(error);
                });
            },
            createTask() {
                this.createTaskForm.start();
                axios.post('/api/tasks', ServerAdmin.Utils.stripObjectNulls(this.createTaskForm.attributes)).then(response => {
                    this.createTaskForm.finish();
                    this.loadTasks();
                }).catch(error => {
                    this.createTaskForm.crash(error);
                });
            },
        },
        computed: {
            orderedTasks() {
                return _.sortBy(this.tasks, 'uid');
            }
        },
    }
</script>
