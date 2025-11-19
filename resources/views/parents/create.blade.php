<x-guest-layout>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Add Parents</h4>
                        </div>
                    </div>

                    <div class="card-body">
                        <form id="mainForm" enctype="multipart/form-data">
                            <div class="sections">
                                <div class="parent-hide">
                                    <div class="card">
                                        <div class="section-title">
                                            <i class="fas fa-users fa-lg"></i>
                                            <h2 class="h5 mb-0">Parents Information</h2>
                                        </div>
                                        <div id="parentList"></div>
                                       @if(request()->has('parent'))
                                            <button type="button" class="btn btn-add" onclick="app.addParent()">
                                                <i class="fas fa-plus-circle me-2"></i>Add Another Parent
                                            </button>
                                        @endif

                                    </div>
                                    <div class="text-center mt-3">
                                        <button type="button" class="btn btn-primary btn-lg btn-submit"
                                            onclick="app.submitParents()">
                                            <i class="fas fa-check-circle me-2"></i>Submit Parents
                                        </button>
                                    </div>
                                </div>

                                <div class="children-hide">
                                    <div class="card">
                                        <div class="section-title">
                                            <i class="fas fa-child fa-lg"></i>
                                            <h2 class="h5 mb-0">Children Information</h2>
                                        </div>
                                        <div id="childList"></div>
                                        @if(request()->has('children'))
                                           <button type="button" class="btn btn-add" onclick="app.addChild()">
                                                <i class="fas fa-plus-circle me-2"></i>Add Another Child
                                            </button>
                                        @endif


                                    </div>
                                    <div class="text-center mt-3">
                                        <input type="hidden" class="parent-id" name="parent_id" value="">
                                        <button type="button" class="btn btn-success btn-lg btn-submit"
                                            onclick="app.submitChildren()">
                                            <i class="fas fa-check-circle me-2"></i>Submit Children
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    {{-- @include('crm.partials.merge-modal') --}}
</x-guest-layout>

<script src="{{ asset('resources/js/parent-cu.js') }}"></script>
