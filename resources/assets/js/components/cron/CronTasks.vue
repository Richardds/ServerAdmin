<template>
    <div>
        <sa-modal :visible="editTaskIntervalVisible"
                  @close="closeIntervalEditor"
                  title="Edit interval">
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="editIntervalMinute" class="col-md-3 control-label">Minute</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="editIntervalMinute" v-model="editTaskInterval.minute" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="editIntervalHour" class="col-md-3 control-label">Hour</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="editIntervalHour" v-model="editTaskInterval.hour" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="editIntervalDay" class="col-md-3 control-label">Day</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="editIntervalDay" v-model="editTaskInterval.day" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="editIntervalMonth" class="col-md-3 control-label">Month</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="editIntervalMonth" v-model="editTaskInterval.month" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="editIntervalWeekday" class="col-md-3 control-label">Weekday</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="editIntervalWeekday" v-model="editTaskInterval.weekday" />
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
                          @editInterval="openIntervalEditor"
                          @destroy="destroy(task.id)" />
            </tbody>
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
                editTaskIntervalIndex: -1,
                editTaskInterval: {
                    minute: 0,
                    hour: 0,
                    day: 0,
                    month: 0,
                    weekday: 0,
                }
            };
        },
        mounted() {
            this.loadUsers();
        },
        methods: {
            loadUsers() {
                axios.get('/api/data/system_users').then(response => {
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
                axios.get('/api/cron/tasks').then(response => {
                    this.tasks = [];
                    for (let task of response.data.data) {
                        this.tasks.push(task);
                    }
                }).catch(error => {
                    console.error(error);
                });
            },
            destroy(id) {
                this.tasks = _.remove(this.tasks, task => task.id !== id);
            },

            // Interval editor
            openIntervalEditor(id) {
                this.editTaskIntervalIndex = _.findIndex(this.tasks, {'id': id});

                let task = this.tasks[this.editTaskIntervalIndex];
                this.editTaskInterval.minute = task.minute;
                this.editTaskInterval.hour = task.hour;
                this.editTaskInterval.day = task.day;
                this.editTaskInterval.month = task.month;
                this.editTaskInterval.weekday = task.weekday;
            },
            closeIntervalEditor() {
                let task = this.tasks[this.editTaskIntervalIndex];
                task.minute = this.editTaskInterval.minute;
                task.hour = this.editTaskInterval.hour;
                task.day = this.editTaskInterval.day;
                task.month = this.editTaskInterval.month;
                task.weekday = this.editTaskInterval.weekday;

                this.editTaskIntervalIndex = -1;
                this.editTaskInterval.minute = 0;
                this.editTaskInterval.hour = 0;
                this.editTaskInterval.day = 0;
                this.editTaskInterval.month = 0;
                this.editTaskInterval.weekday = 0;
            }
        },
        computed: {
            editTaskIntervalVisible() {
                return -1 !== this.editTaskIntervalIndex;
            }
        }
    }
</script>
