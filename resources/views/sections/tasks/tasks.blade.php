@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Cron service</div>

                    <div class="panel-body">
                        <sa-service-controls service="tasks"></sa-service-controls>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Tasks</div>

                    <sa-tasks></sa-tasks>
                </div>
            </div>
        </div>
    </div>
@endsection
