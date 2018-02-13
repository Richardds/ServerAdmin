@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">DNS</div>

                    <div class="panel-body">
                        <sa-service-controls service="dns"></sa-service-controls>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Records of zone <strong>{{ $zone->name }}</strong></div>

                    <sa-dns-records zone="{{ $zone->id }}"></sa-dns-records>
                </div>
            </div>
        </div>
    </div>
@endsection
