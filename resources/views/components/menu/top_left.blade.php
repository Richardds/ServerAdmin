@auth
    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
    {{-- <li><a href="#">Sites</a></li> --}}
    <li><a href="{{ route('database_schemas') }}">Database</a></li>
    <li><a href="{{ route('dns_zones') }}">DNS</a></li>
    <li><a href="{{ route('mail_domains') }}">Mail</a></li>
    <li><a href="{{ route('firewall_rules') }}">Firewall</a></li>
    <li><a href="{{ route('cron_tasks') }}">Cron</a></li>
@endauth