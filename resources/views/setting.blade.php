@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Settings</h3>
        </div>
        <div class="section-body">
            <div class="row">
                @include('app_settings::_settings')
            </div>
        </div>
    </section>
@endsection

