@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">DNS Zones</div>

                    <div class="panel-body">
                        <sa-status v-if="showStatus" @close="showStatus = false" type="warning">
                            Birb nests where birb want!
                        </sa-status>
                    </div>
                    <sa-dns-zones></sa-dns-zones>
                </div>
            </div>
        </div>
    </div>
@endsection
