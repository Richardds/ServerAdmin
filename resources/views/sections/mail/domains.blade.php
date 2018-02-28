@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Postfix & Dovecot services</div>

                    <div class="panel-body">
                        <sa-service-controls service="mail"></sa-service-controls>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Domains</div>

                    <sa-mail-domains></sa-mail-domains>
                </div>
            </div>
        </div>
    </div>
@endsection
