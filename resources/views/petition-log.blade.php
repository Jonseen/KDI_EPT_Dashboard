@extends('layouts.base')

@section('title', 'Petition Log')

@section('content')
<div>
@if($errors->any())
  @foreach($errors->all() as $e)
    <div>{{$e}}</div>
  @endforeach
@endif
</div>
<div class="insights_3">
    @if(count($petitions) > 0)
    <table>
        <thead>
            <tr>
                <th>S/N</th>
                <th>Petition No</th>
                <th>Petitioner</th>
                <th>Respondent</th>
                <th>State</th>
                <th>Stage</th>
                <th>Election Type</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody id="tableBody">
            @foreach($petitions as $petition)
            <tr>
                <td>{{$sn[$loop->index]}}</td>
                <td>{{$petition->petition_number}}</td>
                <td>{{$petition->petitioners_name}}</td>
                <td>{{$petition->respondent_pol}}</td>
                <td>{{$petition->state}}</td>
                <td class="warning">{{$petition->stage}}</td>
                <td>{{$petition->election_type}}</td>
                <td>
                  <a href="{{route('petitions.download', $petition->sn)}}" class="details">Download</a>
                </td>

                {{-- admin buttons --}}
                @if(Auth::check() && Auth::user()->role != 'user')
                <td>
                  <button data-modal-target="#editPetitionModal"
                    class="edit"
                    onclick='onEdit(`{{$petition->sn}}`)'>Edit
                  </button>
                </td>
                <td>
                  <button data-modal-target2="#delete-modal" class="delete" onclick="onDelete({{$petition->sn}})">Delete</button>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div>
        <p>No Data Available</p>
    </div>
    @endif
</div>
<div class="center">
    <div class="pagination">
        <a id="prevLink" href="{{$pageLinks['prev']}}">&laquo;</a>
        <a style="border: none">Page </a>
        <select id="otherLinks" style="float: left; width: auto; margin:0px 10px" onchange="location='{{route('petitionLog')}}/'+ event.target.value">
            @foreach($pageLinks['otherLinks'] as $num => $link)
              <option {{($page == $num + 1)? "selected" : ""}}>{{$num + 1}}</option>
            @endforeach
        </select>
        <a id="pageCount" style="border: none;"> of {{$totalPages}}</a>
        <a id="nextLink" href="{{$pageLinks['next']}}">&raquo;</a>
    </div>
</div>

<!-- <div class="pop-center">
    <button id="show-login">Login</button>
</div> -->
{{-- add petition modal --}}
<div class="modal" id="modal">
    <div data-close-button class="close-btn">&times;</div>
    <div class="form">
        <h2><span class="material-icons-sharp">web_stories</span>  Add New Petition</h2>
        <form id="addPetitionForm" action="{{route('admin.petitions.add')}}"
            method="post" class="upload-petition-form"
            enctype="multipart/form-data">
            @csrf
            <!--- Nigeria states -->
            <div class="form-height">
             <div>
             <div>
                <select id="country-state" name="state" required>
                  <option selected value="" disabled>Select State</option>
                  @foreach(App\Models\PetitionLog::getStates() as $s)
                  <option value="{{$s}}">{{$s}} State</option>
                  @endforeach
                </select>
              </div>
              <div>
                <select id="country-geo" name="gpz">
                  <option value="" selected disabled>Select Geo-Political Zone</option>
                  @foreach(App\Models\PetitionLog::$geoPoliticalZones as $zone)
                  <option value="{{$zone}}">{{$zone}}</option>
                  @endforeach
                </select>
              </div>
              <div>
                <select id="ept-type" name="ept_type" required>
                  <option value="" selected disabled>Select EPT Type</option>
                  @foreach(App\Models\PetitionLog::$eptTypes as $t)
                  <option value="{{$t}}">{{$t}}</option>
                  @endforeach
                </select>
              </div>
              <div>
                <select id="election-type" name="election_type">
                  <option value="">Election Type</option>
                  @foreach(App\Models\PetitionLog::$electionTypes as $t)
                  <option value="{{$t}}">{{$t}}</option>
                  @endforeach
                </select>
              </div>
              <div>
                <select id="ground-of-petition" name="grounds_of_petition[]" multiple>
                  <option value="">Select Grounds of Petition</option>
                  @foreach(\App\Models\PetitionLog::$petitionGrounds as $code => $ground)
                    <option value="{{$code}}">{{$ground}}</option>
                  @endforeach
                </select>
              </div>
              <div>
                <select id="stage-of-petition" name="stage">
                  <option value="" selected disabled>Stage of Petition</option>
                  @foreach(App\Models\PetitionLog::$petitionStages as $s)
                  <option value="{{$s}}">{{$s}}</option>
                  @endforeach
                </select>
              </div>
             </div>
              <div>
              <div>
                <input type="text" name="petition_number" id="petition-num" placeholder="Petition No" required>
              </div>
              <div>
                <input type="text" name="petitioners_name" id="petitioners-name" placeholder="Name of Petitioners" required>
              </div>
              <div>
                <input type="text" name="respondent_pol" id="respodent-pol" placeholder="Name of Respondents" required>
              </div>

              <div>
                <select id="judgement-passed" name="judgement" required>
                  <option value="" selected disabled>Select Judgement Passed</option>
                  @foreach(App\Models\PetitionLog::$judgements as $j)
                  <option value="{{$j}}">{{$j}}</option>
                  @endforeach
                </select>
              </div>
              <div>
                <!-- <label for="upload-petition-document" >Upload Petition Document</label> -->
                <input type="file" name="petition_document" id="petition_document"/>
              </div>
              </div>

            </div>

            <div class="submit-petition" onclick="document.forms['addPetitionForm'].submit();">
              <!-- <input type="submit" value="Add New Petition"> -->
              <a>Submit</a>
            </div>
          </form>
    </div>
</div>

{{-- edit petition modal --}}
<div class="modal" id="editPetitionModal">
    <div data-close-button class="close-btn">&times;</div>
    <div class="form">
        <h2><span class="material-icons-sharp">web_stories</span>  Edit Petition</h2>
        <form id="updatePetitionForm" action="{{route('admin.petitions.update')}}"
            method="post" class="upload-petition-form"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="sn" value=""/>
            <!--- Nigeria states -->
            <div class="form-height">
             <div>
             <div>
                <select id="" name="state" required>
                  <option selected value="" disabled>Select State</option>
                  @foreach(App\Models\PetitionLog::getStates() as $s)
                  <option value="{{$s}}">{{$s}} State</option>
                  @endforeach
                </select>
              </div>
              <div>
                <select id="country-geo" name="gpz">
                  <option value="" selected disabled>Select Geo-Political Zone</option>
                  @foreach(App\Models\PetitionLog::$geoPoliticalZones as $zone)
                  <option value="{{$zone}}">{{$zone}}</option>
                  @endforeach
                </select>
              </div>

              <div>
                <select id="election-type" name="election_type">
                  <option value="" selected disabled>Election Type</option>
                  @foreach(App\Models\PetitionLog::$electionTypes as $t)
                  <option class="electionTypeOption" value="{{$t}}">{{$t}}</option>
                  @endforeach
                </select>
              </div>
              <div>
                <select id="ept-type" name="ept_type" required>
                  <option value="" selected disabled>Select EPT Type</option>
                  @foreach(App\Models\PetitionLog::$eptTypes as $t)
                  <option value="{{$t}}">{{$t}}</option>
                  @endforeach
                </select>
              </div>
              <div>
                <select id="ground-of-petition" name="grounds_of_petition[]" multiple>
                  <option value="" disabled>Select Ground of Petition</option>
                  @foreach(\App\Models\PetitionLog::$petitionGrounds as $code => $ground)
                    <option value="{{$code}}">{{$ground}}</option>
                  @endforeach
                </select>
              </div>
              <div>
                <select id="stage-of-petition" name="stage">
                  <option value="" selected disabled>Stage of Petition</option>
                  @foreach(App\Models\PetitionLog::$petitionStages as $s)
                  <option value="{{$s}}">{{$s}} Stage</option>
                  @endforeach
                </select>
              </div>
             </div>
              <div>
              <div>
                <input type="text" name="petitioners_name" id="petitioners-name" placeholder="Petitioner" required>
              </div>
              <div>
                <input type="text" name="petition_number" id="petition-num" placeholder="Petition Number" required>
              </div>
              <div>
                <input type="text" name="respondent_pol" id="respodent-pol" placeholder="Respondents" required>
              </div>

              <div>
                <select id="judgement-passed" name="judgement" required>
                  <option value="" selected disabled>Select Judgement Passed</option>
                  @foreach(App\Models\PetitionLog::$judgements as $j)
                  <option value="{{$j}}">{{$j}}</option>
                  @endforeach
                </select>
              </div>
              <div>
                <!-- <label for="upload-petition-document" >Upload Petition Document</label> -->
                <input type="file" name="petition_document" id="petition_document" required>
              </div>
              </div>

            </div>

            <div class="submit-petition" onclick="document.forms['updatePetitionForm'].submit()">
              <!-- <input type="submit" value="Add New Petition"> -->
              <a>Update</a>
            </div>
          </form>
    </div>
</div>

<div class="delete-modal" id="delete-modal">
  <div data-close-button2 class="close-btn">&times;</div>
    <h2>Are you sure, this action cannot be reversed?</h2>
    <div class="delete-options">
        <form id="delPetitionForm" style="display:none"
          method="post" action="{{route('admin.petitions.delete')}}">
          @csrf
          <input type="hidden" name="id" required/>
        </form>
        <button class="cancel-delete" data-close-button2
          onclick="document.forms['delPetitionForm'].reset()">Cancel</button>
        <button class="approve-delete"
          onclick="document.forms['delPetitionForm'].submit()">Delete</button>
    </div>
</div>
<div class="" id="overlay"></div>
<script src="/assets/js/log-filter.js"></script>
<script>
  function onEdit(id){
  let endPoint = `{{env('APP_URL')}}/admin/petition/details/${id}`;
  loadPetition(endPoint, (courseData)=>{
      form = document.forms['updatePetitionForm'];
      form.sn.value = courseData.sn;
      form.state.value = courseData.state;
      form.gpz.value = courseData.gpz;
      form.ept_type.value = courseData.ept_type;
      form.judgement.value = courseData.judgement;

      // clear previous selection
      form['grounds_of_petition[]'].querySelectorAll(`option[selected]`).forEach((e)=>{
        e.removeAttribute("selected");
      });
      // selection for new data
      for(let ground of courseData.grounds_of_petition){
            // console.log(ground);
            form['grounds_of_petition[]'].querySelector(`option[value='${ground}']`).setAttribute('selected', null);
      }

      form.election_type.querySelector(`option[selected]`).removeAttribute('selected');
      let a = form.election_type.querySelector(`option[value='${courseData.election_type}']`);
      a.setAttribute('selected', '');
      // console.log(a);
      form.petitioners_name.value = courseData.petitioners_name;
      form.petition_number.value = courseData.petition_number;
      form.respondent_pol.value = courseData.respondent_pol;
      form.stage.value = courseData.stage;
  });
}
window.addEventListener('load', ()=>{
  let requestUrl = "{{route('filter.petitions')}}";
  dataFilter = new DataFilter(requestUrl, onFilter);
});
</script>

@endsection
