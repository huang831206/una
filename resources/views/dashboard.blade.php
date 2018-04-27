@extends('layouts.app')


@section('content')
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
<dashboard-layout :page-data="{{ $data }}" :user="{{Auth::user()}}" source="123"></dashboard-layout>
{{-- <message v-for="item of arr" :page-data="{item}" @gg="add"></message> --}}
@endsection



@section('script')
<script src="//{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>
<script src="{{asset('js/dashboard.js')}}"></script>
@endsection
