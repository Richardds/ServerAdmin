@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        <sa-server-controls></sa-server-controls>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading"><sa-icon icon="info-circle"></sa-icon> Info</div>

                    <table class="table table-striped table-parameters">
                        <tbody>
                        <tr>
                            <th class="name">OS</th>
                            <td class="value">{{ $os }}</td>
                        </tr>
                        <tr>
                            <th class="name">Uptime</th>
                            <td class="value">
                                @if($uptime->getDayPart() > 0)
                                    {{ $uptime->getDayPart() }} {{ str_plural('day', $uptime->getDayPart()) }}
                                @endif
                                @if($uptime->getHourPart() > 0)
                                    {{ $uptime->getHourPart() }} {{ str_plural('hour', $uptime->getDayPart()) }}
                                @endif
                                @if($uptime->getMinutePart() > 0)
                                    {{ $uptime->getMinutePart() }} {{ str_plural('minute', $uptime->getMinutePart()) }}
                                @endif
                                {{ $uptime->getSecondPart() }} {{ str_plural('second', $uptime->getSecondPart()) }}
                            </td>
                        </tr>
                        <tr>
                            <th class="name">Last offline</th>
                            <td class="value">{{ formatDatetime($uptime->getLastOffline()) }}</td>
                        </tr>
                        <tr>
                            <th class="name">Back-end user</th>
                            <td class="value">{{ $user->getName() }} ({{ $user->getUid() }})</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading"><sa-icon icon="info-circle"></sa-icon> Processor</div>

                    <table class="table table-striped table-parameters">
                        <tbody>
                        <tr>
                            <th class="name">Model</th>
                            <td class="value">{{ $processor->getModel() }}</td>
                        </tr>
                        <tr>
                            <th class="name">Cache</th>
                            <td class="value">{{ $processor->getCache() }} KB</td>
                        </tr>
                        <tr>
                            <th class="name">Current clock</th>
                            <td class="value">{{ $processor->getClock() }} Mhz</td>
                        </tr>
                        <tr>
                            <th class="name">Number of cores</th>
                            <td class="value">{{ $processor->getCores() }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading"><sa-icon icon="info-circle"></sa-icon> Memory</div>

                    <table class="table table-striped table-parameters">
                        <tbody>
                        <tr>
                            <th class="name">Total</th>
                            <td class="value">{{ $memory->getTotal() }} MB ({{ round($memory->getAvailablePercentage(), 1) }}% used)</td>
                        </tr>
                        <tr>
                            <th class="name">Used</th>
                            <td class="value">{{ $memory->getUsed() }} MB</td>
                        </tr>
                        <tr>
                            <th class="name">Free</th>
                            <td class="value">{{ $memory->getFree() }} MB</td>
                        </tr>
                        <tr>
                            <th class="name">Shared</th>
                            <td class="value">{{ $memory->getShared() }} MB</td>
                        </tr>
                        <tr>
                            <th class="name">Cache</th>
                            <td class="value">{{ $memory->getCache() }} MB</td>
                        </tr>
                        <tr>
                            <th class="name">Available</th>
                            <td class="value">{{ $memory->getAvailable() }} MB</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading"><sa-icon icon="info-circle"></sa-icon> Swap</div>

                    <table class="table table-striped table-parameters">
                        <tbody>
                        <tr>
                            <th class="name">Total</th>
                            <td class="value">{{ $swap->getTotal() }} MB ({{ round($swap->getAvailablePercentage(), 1) }}% used)</td>
                        </tr>
                        <tr>
                            <th class="name">Used</th>
                            <td class="value">{{ $swap->getUsed() }} MB</td>
                        </tr>
                        <tr>
                            <th class="name">Free</th>
                            <td class="value">{{ $swap->getFree() }} MB</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
