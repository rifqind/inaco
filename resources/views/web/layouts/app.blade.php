<!DOCTYPE html>
<html lang="{{$code}}" dir="{{$code == 'ar' ? 'rtl' : ''}}">
@include('web.layouts.head')
{{ $head }}

<body>
    @if ($code == 'ar')
    @include('web.layouts.header-arabic')
    @else
    @include('web.layouts.header')
    @endif

    {{ $slot }}

    @include('web.layouts.footer')
    @include('web.layouts.script')
    {{ $script }}
    <!-- Start js -->
    <!-- End js -->
</body>

</html>