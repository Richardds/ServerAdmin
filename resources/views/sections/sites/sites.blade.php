@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Nginx service</div>

                    <div class="panel-body">
                        <sa-service-controls service="www"></sa-service-controls>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Sites</div>

                    <sa-sites></sa-sites>
                </div>
            </div>
        </div>
    </div>
@endsection
