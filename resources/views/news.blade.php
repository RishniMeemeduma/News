@extends('layouts.app')
<style>
    main {
        background: linear-gradient(rgba(83, 80, 80, 0.75), rgba(63, 57, 57, 0.75)),url({{ asset('resources/background-2.jpg')}}) no-repeat fixed center;
    }
    .card {
            box-sizing: content-box;
        /* width: 300px; */
        /* padding: 20px; */
        background: #444 !important;
        color: white;
        /* border: 10px solid red; */
        background-clip: content-box;
        /* height: 500px !important;
        max-height: 500px; */
        position: relative;

    }
    .card a{
        /* position: absolute;
        right: 6%;
        bottom: 6%; */
    }
</style>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if ($news && count($news) > 0)
            {{-- If news available --}}
            @foreach ($news as $data )
                @php 
                    $image = $data['image'] ? $data['image'] : URL::to('/').'/resources/default.jpg'; 
                @endphp

                <div class="col-md-4 mb-4 d-flex">
                    <div class="card flex-fill">
                        <div>
                            <img class="card-img-top" src="{{ $image }}" alt="Card image cap" onerror="this.src='{{ URL::to('/').'/resources/default.jpg' }}';">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{$data['title']}}</h5>
                            <p class="card-text">{{$data['date']}}</p>
                            <a href="{{$data['link']}}" class="btn btn-primary mt-auto">More details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @elseif(!empty($error))
            <div class="col-md-12">
                <div class="card">
                    <h3>{{ $error }}</h3>
                </div>
            </div>
        @else
            {{-- If news not available --}}
            <div class="col-md-12">
                <div class="card">
                    <h3>No any news reported yet !!</h3>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
