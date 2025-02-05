<x-app-layout>
    <x-slot name="breadcrumb">
        Update Role
    </x-slot>
    <x-slot name="head">
    </x-slot>
    <div class="col-lg-12">
        <div class="card m-b-30">
            <div class="card-body">
                <!-- h6 class="card-subtitle">Basic form validation.</h6 -->
                <form class="form-validate" id="create-role" action="" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{$data->id}}" />
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="role_name">Role Name<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="role_name" name="role_name"
                                placeholder="Enter Role Name" value="{{$data->role_name}}">
                            <div class="invalid-feedback">Please enter role name</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="permission_id">Select Available Permission<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control select2-multi-select" id="permission_id" name="permission_id[]"
                                style="width:200px;" multiple="multiple">
                                @foreach ($permissions as $value)
                                <option value="{{ $value->id }}" {{ in_array($value->id, $roles_permissions) ? 'selected' : '' }}>{{ $value->permission_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="">Role Status<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="role_status" id="role_status1"
                                    value="1" {{ $data->role_status == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="role_status1">Active</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="role_status" id="role_status2"
                                    value="0" {{ $data->role_status == '0' ? 'checked' : '' }}>
                                <label class="form-check-label" for="role_status2">Inactive</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"></label>
                        <div class="col-lg-8">
                            <button type="submit" class="btn btn-primary" id="submitBtn">Save</button>
                        </div>
                    </div>
                </form>
                <div id="back" type="button" class="btn btn-success">Back to Role List</div>
            </div>
        </div>
    </div>
    <x-slot name="script">
        <!-- <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> -->
        <script src="{{ asset('assets/js/custom/custom-role.js') }}"></script>
    </x-slot>
</x-app-layout>