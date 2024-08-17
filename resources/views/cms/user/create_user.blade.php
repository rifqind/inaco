<x-app-layout>
    <x-slot name="breadcrumb">
        Create User
    </x-slot>
    <x-slot name="head">
    </x-slot>
    <div class="col-lg-12">
        <div class="card m-b-30">
            <div class="card-body">
                <!-- h6 class="card-subtitle">Basic form validation.</h6 -->
                <form class="form-validate" id="create-user" action="" method="post">
                    @csrf
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="email">Email<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="email" name="email"
                                placeholder="Enter Email">
                            <div class="invalid-feedback">Please enter role name</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="name">Name<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter Name">
                            <div class="invalid-feedback">Please enter role name</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="role_id">Select Role<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control select2-single" id="role_id" name="role_id"
                                style="width:200px;">
                                <option value="" disabled selected>Please Select</option>
                                @foreach ($roles as $value)
                                <option value="{{ $value->id }}">{{ $value->role_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="">User Status<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="user_status" id="user_status1"
                                    value="1" checked>
                                <label class="form-check-label" for="user_status1">Active</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="user_status" id="user_status2"
                                    value="0">
                                <label class="form-check-label" for="user_status2">Inactive</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="password">Password<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Enter Password">
                            <div class="invalid-feedback">Please enter role name</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="password_confirmation">Password Confirmation<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                                placeholder="Enter Password Confirmation">
                            <div class="invalid-feedback">Please enter role name</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"></label>
                        <div class="col-lg-8">
                            <button type="submit" class="btn btn-primary" id="submitBtn">Save</button>
                        </div>
                    </div>
                </form>
                <div id="back" type="button" class="btn btn-success">Back to User List</div>
            </div>
        </div>
    </div>
    <x-slot name="script">
        <!-- <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> -->
        <script src="{{ asset('assets/js/custom/custom-user.js') }}"></script>
    </x-slot>
</x-app-layout>