@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Mail</div>

                    <div class="panel-body">
                        <sa-service-controls service="mail"></sa-service-controls>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Mail users of domain <strong>{{ $domain->name }}</strong></div>

                    <sa-mail-users domain_id="{{ $domain->id }}"></sa-mail-users>
                </div>
            </div>
        </div>
    </div>
@endsection
