<x-app-layout>
    <x-slot name="breadcrumb">
        Create Social Media and Marketplace
    </x-slot>
    <x-slot name="head"></x-slot>
    <div class="col-lg-12">
        <div class="card m-b-30">
            <div class="card-body">
                <!-- h6 class="card-subtitle">Basic form validation.</h6 -->
                <form class="form-validate" method="post">
                    @csrf
                    <h4 class="m-b-30">Social Media</h4>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="instagram">Instagram Link</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="instagram" name="instagram"
                                placeholder="Enter Link">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="facebook">Facebook Link</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="facebook" name="facebook"
                                placeholder="Enter Link">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="tiktok">Tiktok Link</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="tiktok" name="tiktok"
                                placeholder="Enter Link">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="youtube">Youtube Link</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="youtube" name="youtube"
                                placeholder="Enter Link">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="twitter">Twitter Link</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="twitter" name="twitter"
                                placeholder="Enter Link">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="linkedin">Linkedin Link</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="linkedin" name="linkedin"
                                placeholder="Enter Link">
                        </div>
                    </div>
                    <h4 class="m-b-30">Marketplace</h4>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="shopee">Shopee Link</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="shopee" name="shopee"
                                placeholder="Enter Link">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="tokopedia">Tokopedia Link</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="tokopedia" name="tokopedia"
                                placeholder="Enter Link">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="lazada">Lazada Link</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="lazada" name="lazada"
                                placeholder="Enter Link">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="tiktokshop">Tiktokshop Link</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="tiktokshop" name="tiktokshop"
                                placeholder="Enter Link">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"></label>
                        <div class="col-lg-8">
                            <button type="submit" class="btn btn-primary" id="submitBtn">Save</button>
                        </div>
                    </div>
                </form>
                <div id="back-socmed" type="button" class="btn btn-success m-r-10">Back to Social Media</div>
                <div id="back-marketplace" type="button" class="btn btn-info">Back to Marketplace</div>
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script src="{{ asset('assets/js/custom/custom-socmed-market.js') }}"></script>
    </x-slot>
</x-app-layout>