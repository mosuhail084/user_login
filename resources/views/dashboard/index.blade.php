@extends('layouts.app')

@section('content')
   


    <div class="body-content">
        <div class="card mb-4">
            <div class="card-header">
                <h1>Hello! {{Auth::user()->name}}</h1>
            </div>
            {{--<div class="card-body">

                 @component('backEnd.components.alert')
                @endcomponent


                
            </div> --}}
        </div>

    </div>
    
@endsection
