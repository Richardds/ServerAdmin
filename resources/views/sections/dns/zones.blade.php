@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">DNS Zones</div>

                    <div class="panel-body">
                        <sa-service-controls service="dns"></sa-service-controls>
                    </div>
                    <sa-dns-zones></sa-dns-zones>
                </div>
            </div>
        </div>
    </div>
@endsection
