@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">MariaDB service</div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-9">
                                <sa-service-controls service="database"></sa-service-controls>
                            </div>
                            <div class="col-sm-3">
                                <a class="btn btn-default pull-right" href="{{ route('database_users') }}">
                                    <i class="fa fa-users" aria-hidden="true"></i> Manage users
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Databases</div>

                    <sa-databases></sa-databases>
                </div>
            </div>
        </div>
    </div>
@endsection
