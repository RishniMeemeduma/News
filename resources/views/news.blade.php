@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if ($news && count($news) > 0)
            {{-- If news available --}}
            @foreach ($news as $data )
                @php 
                    $image = $data['image'] ? $data['image'] : URL::to('/').'/resources/default.jpg'; 
                @endphp

                <div class="col-md-6 mb-4">
                    <div class="card">
                        <img class="card-img-top" src="{{ $image }}" alt="Card image cap" onerror="this.src='{{ URL::to('/').'/resources/default.jpg' }}';">
                        <div class="card-body">
                        <h5 class="card-title">{{$data['title']}}</h5>
                        <p class="card-text">{{$data['date']}}.</p>
                        <a href="{{$data['link']}}" class="btn btn-primary">More details</a>
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
