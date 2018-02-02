// Elements
Vue.component('sa-status', require('./components/Status.vue'));
Vue.component('sa-modal', require('./components/Modal.vue'));
Vue.component('sa-button', require('./components/Button.vue'));

// Core
Vue.component('sa-service-controls', require('./components/core/ServiceControls.vue'));

// DNS
Vue.component('sa-dns-zones', require('./components/dns/DnsZones.vue'));
Vue.component('sa-dns-zone', require('./components/dns/DnsZone.vue'));
Vue.component('sa-dns-records', require('./components/dns/DnsRecords.vue'));
Vue.component('sa-dns-record', require('./components/dns/DnsRecord.vue'));

// Cron
Vue.component('sa-cron-tasks', require('./components/cron/CronTasks'));
Vue.component('sa-cron-task', require('./components/cron/CronTask'));

// Database
Vue.component('sa-database-schemas', require('./components/database/DatabaseSchemas'));
Vue.component('sa-database-schema', require('./components/database/DatabaseSchema'));
Vue.component('sa-database-schema-users', require('./components/database/DatabaseSchemaUsers'));
