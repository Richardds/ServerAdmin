<template>
    <div>
        <sa-modal :visible="addTask"
                  @close="addTask = false"
                  title="Add task">
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="editIntervalMinute" class="col-md-3 control-label">Minute</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="editIntervalMinute" v-model="task.minute" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="editIntervalHour" class="col-md-3 control-label">Hour</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="editIntervalHour" v-model="task.hour" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="editIntervalDay" class="col-md-3 control-label">Day</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="editIntervalDay" v-model="task.day" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="editIntervalMonth" class="col-md-3 control-label">Month</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="editIntervalMonth" v-model="task.month" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="editIntervalWeekday" class="col-md-3 control-label">Weekday</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="editIntervalWeekday" v-model="task.weekday" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="taskUser" class="col-md-3 control-label">User</label>
                    <div class="col-md-8">
                        <select id="taskUser" class="form-control" v-model="task.uid">
                            <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="taskUser" class="col-md-3 control-label">Command</label>
                    <div class="col-md-8">
                        <input class="form-control" type="text" v-model="task.command" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="taskUser" class="col-md-3 control-label">Description</label>
                    <div class="col-md-8">
                        <textarea rows="2" class="form-control" v-model="task.description"></textarea>
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
        <table class="table table-striped table-controls table-cron-tasks">
            <thead>
            <tr>
                <th>Interval</th>
                <th>User</th>
                <th>Command</th>
                <th>Description</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <sa-cron-task v-for="task in this.tasks"
                          :key="task.id"
                          :task="task"
                          :users="users"
                          @destroy="destroy(task.id)" />
            </tbody>
            <tfoot>
            <tr>
                <td colspan="7" class="text-right">
                    <sa-button @click.native="addTask = true"
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
                //
                addTask: false,
                adding: false,
                //
                task: {
                    minute: '*',
                    hour: '*',
                    day: '*',
                    month: '*',
                    weekday: '*',
                    uid: -1,
                    command: '',
                    description: '',
                }
            };
        },
        mounted() {
            let self = this;
            axios.all([
                axios.get('/api/data/system_users'),
                axios.get('/api/cron/tasks')
            ]).then(axios.spread(function (system_users, tasks) {
                self.users = [];
                for (let user of system_users.data.data) {
                    self.users.push(user);
                }

                self.tasks = [];
                for (let task of tasks.data.data) {
                    self.tasks.push(task);
                }
            })).catch(error => {
                console.error(error);
            });
        },
        methods: {
            destroy(id) {
                this.tasks = _.remove(this.tasks, task => task.id !== id);
            },
            add() {
                let self = this;
                self.adding = true;
                axios.all([
                    axios.post('/api/cron/tasks', self.task),
                    axios.get('/api/cron/tasks')
                ]).then(axios.spread(function (created_task, tasks) {
                    self.tasks = [];
                    for (let task of tasks.data.data) {
                        self.tasks.push(task);
                    }
                    self.adding = false;
                })).catch(error => {
                    console.error(error);
                });
            }
        }
    }
</script>
