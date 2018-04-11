// Elements
Vue.component('sa-status', require('./components/Status'));
Vue.component('sa-modal', require('./components/Modal'));
Vue.component('sa-button', require('./components/Button'));
Vue.component('sa-icon', require('./components/Icon'));

// Core
Vue.component('sa-service-controls', require('./components/core/ServiceControls'));
Vue.component('sa-server-controls', require('./components/core/ServerControls'));

// Sites
Vue.component('sa-sites', require('./components/sites/Sites'));
Vue.component('sa-site', require('./components/sites/Site'));

// DNS
Vue.component('sa-dns-zones', require('./components/dns/DnsZones'));
Vue.component('sa-dns-zone', require('./components/dns/DnsZone'));
Vue.component('sa-dns-records', require('./components/dns/DnsRecords'));
Vue.component('sa-dns-record', require('./components/dns/DnsRecord'));

// Cron
Vue.component('sa-tasks', require('./components/tasks/CronTasks'));
Vue.component('sa-task', require('./components/tasks/CronTask'));

// Database
Vue.component('sa-databases', require('./components/database/Databases'));
Vue.component('sa-database', require('./components/database/Database'));
Vue.component('sa-database-privileges', require('./components/database/DatabasePrivileges'));
Vue.component('sa-database-privilege', require('./components/database/DatabasePrivilege'));
Vue.component('sa-database-users', require('./components/database/DatabaseUsers'));
Vue.component('sa-database-user', require('./components/database/DatabaseUser'));

// Mail
Vue.component('sa-mail-domains', require('./components/mail/MailDomains'));
Vue.component('sa-mail-domain', require('./components/mail/MailDomain'));
Vue.component('sa-mail-users', require('./components/mail/MailUsers'));
Vue.component('sa-mail-user', require('./components/mail/MailUser'));
Vue.component('sa-mail-user-aliases', require('./components/mail/MailUserAliases'));
Vue.component('sa-mail-user-alias', require('./components/mail/MailUserAlias'));

// Firewall
Vue.component('sa-firewall-rules', require('./components/firewall/FirewallRules'));
Vue.component('sa-firewall-rule', require('./components/firewall/FirewallRule'));
