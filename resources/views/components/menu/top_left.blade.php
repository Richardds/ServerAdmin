@auth
    <li><a href="{{ route('dashboard') }}"><sa-icon icon="dashboard"></sa-icon> Dashboard</a></li>
    {{-- <li><a href="#">Sites</a></li> --}}
    <li><a href="{{ route('database_schemas') }}"><sa-icon icon="database"></sa-icon> Database</a></li>
    <li><a href="{{ route('dns_zones') }}"><sa-icon icon="server"></sa-icon> DNS</a></li>
    <li><a href="{{ route('mail_domains') }}"><sa-icon icon="envelope"></sa-icon> Mail</a></li>
    <li><a href="{{ route('firewall_rules') }}"><sa-icon icon="fire"></sa-icon> Firewall</a></li>
    <li><a href="{{ route('cron_tasks') }}"><sa-icon icon="list"></sa-icon> Cron</a></li>
@endauth