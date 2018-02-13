@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Database</div>

                    <div class="panel-body">
                        <sa-service-controls service="database"></sa-service-controls>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Users</div>

                    <sa-database-users></sa-database-users>
                </div>
            </div>
        </div>
    </div>
@endsection
