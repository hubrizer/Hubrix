@extends('layouts._default.backend.master')

@section('content')
    <div class="container-fluid p-0 m-0">
        <div class="container mt-3 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
            <div class="col-12 col-md-auto mb-2 mb-md-0">
                <button id="addContactBtn" class="btn btn-md btn-dark w-100 w-md-auto px-4 rounded-pill" data-bs-toggle="modal" data-bs-target="#addBattleModal">
                    <?php _e('create', 'text-domain'); ?>
                </button>
            </div>

            <div class="col-12 col-md-auto">
                <form class="d-flex w-100" role="search">
                    <input type="text" id="searchContacts" placeholder="<?php _e('Search contacts...', 'text-domain'); ?>" class="form-control rounded-pill">
                </form>
            </div>
        </div>

        <div class="container mt-3 border-top-1 border-bottom-1 border px-0">
            <div id="no-results-message" class="text-center mt-3" style="display: none;">
                There are no results for this search.
            </div>
            <div class="accordion accordion-flush" id="accordionContacts">
                <!-- Loader will be displayed here initially -->
                <div id="loaderRow" class="text-center py-3">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden"><?php _e('Loading...', 'text-domain'); ?></span>
                    </div>
                </div>
                <!-- Contacts will be dynamically loaded here -->
            </div>
        </div>
    </div>
@endsection