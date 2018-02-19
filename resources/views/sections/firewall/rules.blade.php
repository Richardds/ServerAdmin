@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Firewall</div>

                    <div class="panel-body">
                        <sa-service-controls service="firewall"></sa-service-controls>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Rules</div>

                    <sa-firewall-rules></sa-firewall-rules>
                </div>
            </div>
        </div>
    </div>
@endsection
