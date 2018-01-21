@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Cron</div>

                    <sa-cron-tasks></sa-cron-tasks>
                </div>
            </div>
        </div>
    </div>
@endsection
