@extends('main')

@section('title','| Homepage')




@section('content')
      <div class="row">
        <div class="col-md-12">
          @component('pages.jumbotron')
          @slot('title')
          Welcome Noobs !
          @endslot
          @slot('description')
          Thank you so much for visiting. This is my test website built with Laravel. Please read my popular post!
          @endslot
          @slot('button')
            Click Like !
          @endslot
          @endcomponent
        </div>
      </div>
      <!-- end of header .row -->

      <div class="row">
        <div class="col-md-8">

        @foreach($posts as $post)
          <div class="post">
            <h3>{{ $post->title }}</h3>
            <p>{{ substr(strip_tags($post->body), 0, 300) }} {{ strlen(strip_tags($post->body)) > 300 ? "..." : ""}}</p>
            <a href="{{ url('blog/'.$post->slug) }}" class="btn btn-primary">Read More</a>
          </div>

          <hr>

          @endforeach

        </div>

        <div class="col-md-3 col-md-offset-1">
          <h2>Sidebar</h2>
        </div>
      </div>
      @endsection

      @section('scripts')
        <script>
            //confirm('I loaded up some JS');
        </script>
      @endsection