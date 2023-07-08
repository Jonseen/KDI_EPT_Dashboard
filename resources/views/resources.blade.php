@extends('layouts.base')

@section('title', 'Resources')

@section('content')
<div class="resources">
    @forelse($resources as $resource)    
    <div class="document">
        <img src="/assets/images/pdf-icon.webp" alt="">
        <h3>{{$resource->name}}</h3>
        <a href="{{route('resources.download', $resource->id)}}">Download Here</a>
        @if(Auth::check() && Auth::user()->role != 'user')        
        <form id="resourceDelForm{{$resource->id}}" method="post"
            action="{{route('admin.resources.delete')}}"
            style="display: none">
            @csrf
            <input type="hidden" name="id" value="{{$resource->id}}"/>
        </form>
        
        <a onclick="document.forms['resourceDelForm{{$resource->id}}'].submit()" href="#">Delete</a>
        @endif
    </div>
    @empty
        <div class="no-resources">
            <h3 class="primary">There are no resources at the moment, please check back in coming days.</h3>
        </div>
    @endforelse
</div>

{{--
@if(count($resources) > 0)
<div class="center">
    <div class="pagination">
        <a href="#">&laquo;</a>
        <a href="#" class="active">1</a>
        <a href="#">2</a>
        <a href="#">3</a>
        <a href="#">4</a>
        <a href="#">5</a>
        <a href="#">6</a>
        <a href="#">&raquo;</a>
    </div>
</div>
@endif
--}}


<!-- ==============  ADD NEW RESOURCE ======================== -->

<div class="resources-modal" id="resources-modal">
  <div data-close-button3 class="close-btn">&times;</div>
    <h2><span class="material-icons-sharp">web_stories</span>  Add New Resources</h2>
    <form id="addResourceForm" method="post" action="{{route('admin.resources.add')}}" enctype="multipart/form-data">
        @csrf
        <div class="file-name">
            <input type="text" name="name" id="resouce-name" placeholder="Enter File Name">
        </div>
        <div class="ept-resource-file-field">
            <input type="file" name="resource_doc" id="ept-resource" accept=".pdf">
        </div>
        <div class="submit-resources" onclick="document.forms['addResourceForm'].submit()">
            <a>Upload</a>
        </div>
    </form>
</div>


<!-- ==============  ADD NEW EPT STORY ======================== -->
<div class="stories-modal" id="stories-modal">
  <div data-close-button4 class="close-btn">&times;</div>
    <h2><span class="material-icons-sharp">web_stories</span>  Add New EPT Story</h2>
    <form id="addStoryForm" method="post" action="{{route('admin.stories.add')}}" enctype="multipart/form-data">
        @csrf
        <div class="story-title-field">
            <input type="text" name="title" id="story-title" placeholder="Enter Title of Story">
        </div><br>
        <div class="reporter-field">
            <input type="text" name="reporter" id="reporter" placeholder="Enter Name of Reporter">
        </div><br>

        <div class="storythumbnail-field">
            <h3>Select Thumbnail</h3>
            <input type="file" name="image" id="storythumbnail" accept=".jpg,.png,.jpeg">
        </div><br>
        <textarea id="story-paragraph" rows="6" cols="94" name="paragraph1" 
            placeholder="Enter Blog Content Here [Paragraph One]"></textarea>
         <br/>
        <textarea id="story-paragraph" rows="6" cols="94" name="paragraph2" 
            placeholder="Enter Blog Content Here [Paragraph Two]"></textarea>
         <br/>
        <textarea id="story-paragraph" rows="6" cols="94" name="paragraph3" 
            placeholder="Enter Blog Content Here [Paragraph Three]"></textarea>
         <br/>
        <div class="submit-story" onclick="document.forms['addStoryForm'].submit()">
            <a>Upload</a>
        </div>
    </form>
</div>
<div class="" id="overlay"></div>
    
@endsection