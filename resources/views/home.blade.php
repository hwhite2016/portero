@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body text-center">
                    {{-- See resources/assets/js/components/NotificationsDemo.vue --}}
                    <notifications-demo></notifications-demo>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="/js/app.js"></script>
@endsection
