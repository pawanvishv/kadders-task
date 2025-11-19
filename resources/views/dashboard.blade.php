<x-guest-layout>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Contacts</h4>
                            <a href="{{ url('contacts/create') }}"
                                class="btn btn-outline-primary rounded-pill mt-2 btn-with-icon right">
                                <i class="ri-heart-line"></i>
                                Create
                            </a>
                            <button type="button"
                            class="btn btn-primary ounded-pill mt-2 btn-with-icon right" data-toggle="modal" data-target="#mergeModal">
                                <i class="ri-heart-line"></i>
                                Merge
                            </button>
                        </div>
                    </div>
                    <div class="justify-content-between" style="margin-top: 15px; margin-left:10px">
                        <form class="form-horizontal" action="#" method="POST" id="table-filter-form">
                            <div class="box-body">

                                <div class="form-group">
                                    <div class="row">

                                        <div class="col-sm-1">
                                            <input type="text" class="form-control form-control-sm" id="filter-name"
                                                name="name" placeholder="Name">
                                        </div>

                                        <div class="col-sm-2">
                                            <input type="text" class="form-control form-control-sm" id="filter-phone"
                                                name="phone" placeholder="Phone">
                                        </div>

                                        <div class="col-sm-2">
                                            <select class="form-select form-select-sm" id="filter-gender"
                                                name="gender">
                                                <option value="">Select</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </div>

                                        <div class="col-sm-2">
                                            <select class="form-select form-select-sm" id="filter-status"
                                                name="status">
                                                <option value="">Select</option>
                                                <option value="Active">Active</option>
                                                <option value="Inactive">In Active</option>
                                                 <option value="Merged">Merged</option>
                                            </select>
                                        </div>

                                        <div class="col-sm-2">
                                            <input type="text" class="form-control form-control-sm" id="filter-field"
                                                name="custom_field" placeholder="Field Name">
                                        </div>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control form-control-sm" id="filter-value"
                                                name="custom_value" placeholder="Value">
                                        </div>

                                       <div class="col-sm-2 d-flex justify-content-end align-items-center">
                                            <button type="submit" class="filter-btn-contact btn btn-success btn-sm w-100 pt-6">
                                                Filter
                                            </button>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card-body">

                        <div class="collapse" id="datatable-2">
                            <div class="card">

                            </div>
                        </div>
                        <table id="datatable" class="table data-table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="pr-0">
                                    </th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Gender</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    {{-- @include('crm.partials.merge-modal') --}}
</x-guest-layout>
