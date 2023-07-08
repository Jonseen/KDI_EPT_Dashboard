@extends('layouts.base')

@section('title', 'Blog')

@section('content') 
    <br>
    <div class="blog">
        <h1 style="width: 60rem;">{{$story->title}}</h1>
        <small class="primary"> {{$story->reporter}} | {{date('h:mA | F d, Y', strtotime($story->created_at))}}</small><br><br>
        <img src="/storage/{{$story->image}}" alt="thumbnail">
        
         @foreach($story->paragraphs as $text)
         <p>{{$text}}</p>
         @endforeach
          
          <br /><br />

          <textarea id="userComment" rows="6" cols="100" name="comment">Enter comment here...</textarea>

          <br />
          <a href="#"><div class="submit-comment">Submit</div></a>
         
          <h2>READER'S COMMENTS</h2><br>

          <div>
            <h3>Bayo Leyin</h3><small class="primary">07:25pm | 12th March, 2023</small>
            <p>It does not in any way prove bias against the appellant.</p>
          </div><br>
          <div>
    </div>
@endsection