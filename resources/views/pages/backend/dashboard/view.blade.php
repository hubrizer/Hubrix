@extends('layouts._default.backend.master')

@section('content')
<div class="container-fluid m-0">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 bg-dark min-vh-100 d-flex flex-column">
            <div class="card bg-dark p-2 border border-1">
                <div class="card-body text-white">
                    <h3 class="card-title">Dashboard (banner)</h3>
                    <p class="card-text">This is another card with title and supporting text below. This card has some additional content to make it slightly taller overall.</p>
                    <p class="card-text"><small class="text-white-50">Last updated 3 mins ago</small></p>
                </div>
            </div>
            <div class="card p-2">
                <div class="card-body">
                    <h5 class="card-title">Current Battle</h5>
                    <p class="card-text">This is another card with title and supporting text below. This card has some additional content to make it slightly taller overall.</p>
                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                </div>
            </div>
            <div class="card p-2">
                <div class="card-body">
                    <h5 class="card-title">Upcoming Battles</h5>
                    <p class="card-text">This is another card with title and supporting text below. This card has some additional content to make it slightly taller overall.</p>
                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                </div>
            </div>
        </DIV>

        <!-- Main content -->
        <div class="col-md-9 bg-light min-vh-100 d-flex flex-column">
            <div class="row">
                <div class="col-md-4">
                    <div class="card pt-3">
                        <div class="card-body">
                            <h5 class="card-title">Top 5 Voters</h5>
                            <p class="card-text">This is another card with title and supporting text below. This card has some additional content to make it slightly taller overall.</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card pt-3">
                        <div class="card-body">
                            <h5 class="card-title">Recent Winners</h5>
                            <p class="card-text">This is another card with title and supporting text below. This card has some additional content to make it slightly taller overall.</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card pt-3">
                        <div class="card-body">
                            <h5 class="card-title">Top Products</h5>
                            <p class="card-text">This is another card with title and supporting text below. This card has some additional content to make it slightly taller overall.</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card pt-3 vh-100 mw-100">
                        <div class="card-body">
                            <h5 class="card-title">Engagement Analysis</h5>
                            <p class="card-text">This is another card with title and supporting text below. This card has some additional content to make it slightly taller overall.</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card pt-3 vh-100 mw-100">
                        <div class="card-body">
                            <h5 class="card-title">Marketing Analysis</h5>
                            <p class="card-text">This is another card with title and supporting text below. This card has some additional content to make it slightly taller overall.</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection