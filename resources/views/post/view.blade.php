@extends('adminlte')

@section('content')
    <div class='row'>
        
            

        
        <div class='col-md-6'>
            @foreach($posts as $post)
                <h1>{{ $post->title }}</h1>
                <p> {{ $post->content }}</p>
            @endforeach
        </div>

    </div><!-- /.row -->
@endsection