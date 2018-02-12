@auth
    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li><a href="#">Sites</a></li>
    <li><a href="{{ route('database') }}">Database</a></li>
    <li><a href="{{ route('dns_zones') }}">DNS</a></li>
    <li><a href="{{ route('mail_domains') }}">Mail</a></li>
    <li><a href="#">Firewall</a></li>
    <li><a href="{{ route('cron') }}">Cron</a></li>
@endauth