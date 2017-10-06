@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">DNS Zones</div>

                    <div class="panel-body">
                        <status v-if="showStatus" @close="showStatus = false" type="warning">Birb nests where birb want!</status>
                    </div>

                    <dns_zones></dns_zones>
                </div>
            </div>
        </div>
    </div>
@endsection
