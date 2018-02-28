@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        <sa-server-controls></sa-server-controls>

                        <br>

                        OS: {{ $os }}<br>
                        Uptime:
                        @if($uptime->getDayPart() > 0)
                        <b>{{ $uptime->getDayPart() }}</b> {{ str_plural('day', $uptime->getDayPart()) }}
                        @endif
                        @if($uptime->getHourPart() > 0)
                        <b>{{ $uptime->getHourPart() }}</b> {{ str_plural('hour', $uptime->getDayPart()) }}
                        @endif
                        @if($uptime->getMinutePart() > 0)
                        <b>{{ $uptime->getMinutePart() }}</b> {{ str_plural('minute', $uptime->getMinutePart()) }}
                        @endif
                        <b>{{ $uptime->getSecondPart() }}</b> {{ str_plural('second', $uptime->getSecondPart()) }}
                        <br>
                        Last offline: {{ formatDatetime($uptime->getLastOffline()) }}<br>
                        User: {{ $user->getName() }}<br>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
