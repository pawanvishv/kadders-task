<x-guest-layout>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Contacts</h4>
                            <a href="{{ url('parents/create') }}"
                                class="btn btn-outline-primary rounded-pill mt-2 btn-with-icon right">
                                <i class="ri-heart-line"></i>
                                Create
                            </a>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="collapse" id="datatable-2">
                            <div class="card">

                            </div>
                        </div>
                        <table id="parents-table" class="display table data-table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="pr-0">
                                        <label><input class="row-checkbox" type="checkbox"> Select All</label>
                                    </th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    {{-- @include('crm.partials.merge-modal') --}}
</x-guest-layout>

<script src="{{ asset('resources/js/parent-index.js') }}"></script>
