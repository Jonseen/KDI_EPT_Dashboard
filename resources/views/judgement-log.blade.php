@extends('layouts.base')

@section('title', 'Judgement Log')

@section('content')
<div class="insights_3">
    @if(count($judgements) > 0)
    <table>
        <thead>
            <tr>
            <th>S/N</th>
            <th>Petition No</th>
            <th>Petitioner</th>
            <th>Respondent</th>
            <th>Tribunal:</th>
            <th>Tribunal Verdict</th>
            <th>Election Type</th>
            <th></th>
            </tr>
        </thead>
        <tbody id="tableBody">
            @foreach($judgements as $judgement)
            <tr>
            <td>{{$sn[$loop->index]}}.</td>
            <td>{{$judgement->petition_number}}</td>
            <td>{{$judgement->petitioners_name}}</td>
            <td>{{$judgement->respondent_pol}}</td>
            <td>{{$judgement->state}} State Tribunal</td>
            <td class="warning">{{$judgement->judgement}}</td>
            <td>{{$judgement->election_type}}</td>
            <td><a href="" class="primary">Download</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="center">
    <div class="pagination">
        <a id="prevLink" href="{{$pageLinks['prev']}}">&laquo;</a>
        <a style="border: none">Page </a>
        <select id="otherLinks" style="float: left; width: auto; margin:0px 10px" onchange="location='{{route('judgementLog')}}/'+ event.target.value">
            @foreach($pageLinks['otherLinks'] as $num => $link)
              <option {{($page == $num + 1)? "selected" : ""}}>{{$num + 1}}</option>
            @endforeach
        </select>
        <a id="pageCount" style="border: none;"> of {{$totalPages}}</a>
        <a id="nextLink" href="{{$pageLinks['next']}}">&raquo;</a>
    </div>
</div>
@else
    <div>
        <p>No Judgements Passed</p>
    </div>
@endif
    {{-- <script src="/assets/js/log-filter.js"></script> --}}
    <script> 
        let dataFilter = null;
        window.addEventListener('load', ()=>{
            let requestUrl = "{{route('filter.petitions.judgements')}}";
            dataFilter = new DataFilter(requestUrl, onFilter);
        });
        
        let onFilter = (data)=>{
            let tbody = document.getElementById('tableBody');
            tbody.innerHTML = "";
            let htmlContent = "";
            let index = 0;
            let petitions = data.petitions;
            // console.log(petitions);
            for(let petition of petitions){
                // let petitionJson = JSON.stringify(data);
                htmlContent += `
                <tr>
                    <td>${data.sn[index++]}</td>
                    <td>${petition.petition_number}</td>
                    <td>${petition.petitioners_name}</td>
                    <td>${petition.respondent_pol}</td>
                    <td>${petition.state}</td>
                    <td class="warning">${petition.judgement}</td>
                    <td>${petition.election_type}</td>
                    <td>
                        <a href="${petition.download_link}" class="details">Download</a>
                    </td>`;                    
                htmlContent += `</tr>`;
            }
            tbody.innerHTML = htmlContent;

            // reset pagination for the filter
            let otherLinks = document.querySelector("#otherLinks");
            let prevLink = document.querySelector("#prevLink");
            let nextLink = document.querySelector("#nextLink");
            let pageCount = document.querySelector("#pageCount");

            let a = data.pageLinks["prev"];
            let b = data.pageLinks["next"];    

            prevLink.setAttribute("href", "#");
            nextLink.setAttribute("href", "#");

            prevLink.onclick = ()=>{
                dataFilter.filterDataPage(data.page - 1);
            };

            nextLink.onclick = ()=>{
                dataFilter.filterDataPage(data.page + 1);
            };

            pageCount.innerText = data.totalPages;

            let pageLinksHTML = "";
            for(let page in data.pageLinks['otherLinks']){
                page = parseInt(page);
                if(data.page == page + 1){
                    pageLinksHTML += `<option selected value='${page + 1}'>${page + 1}</option>`;
                    continue;
                }
                pageLinksHTML += `<option value='${page + 1}'>${page + 1}</option>`;
            }
            otherLinks.innerHTML = pageLinksHTML;
            otherLinks.onchange = ()=>{
                dataFilter.filterDataPage(event.target.value);
            };

            initModalElements();
        } 

        function onDelete(id){
            form = document.forms['delPetitionForm'];
            form.id.value = id;
        }
    </script>
@endsection