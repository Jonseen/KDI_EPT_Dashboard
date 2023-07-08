let dataFilter = null;
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
        <td class="warning">${petition.stage}</td>
        <td>${petition.election_type}</td>
        <td>
          <a href="${petition.download_link}" class="details">Download</a>
        </td>`;
        if(config.isAdmin){
        htmlContent += 
          `<td>
              <button id="" 
                  data-modal-target="#editPetitionModal" 
                  class="edit" onclick="onEdit('${petition.sn}')">Edit
              </button>
          </td>
          <td>
            <button data-modal-target2="#delete-modal" class="delete" onclick="onDelete('${petition.sn}')">Delete</button>
          </td>`;
      
    }
    htmlContent += `</tr>`;
  }
  tbody.innerHTML = htmlContent;

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

function loadPetition(url, callback){
  $.ajax({
          url: url,
          type: 'GET',
          headers: {
            "Access-Control-Allow-Origin": "*",
          },
          async: false,            
          success: function(res) {
              if(res.status){
                  callback(res.data);
              }else{
                  swal.fire({
                    icon: "error",
                    title: "Failed to load petition",
                    toast: true,
                    showConfirmButton: false,
                    position: "bottom-right",
                    timer: 1500,
                  });
              }
              // console.log(res);
          },
          error: function(data){
              swal.fire({
                  icon: "error",
                  title: "Failed to load petition",
                  toast: true,
                  showConfirmButton: false,
                  position: "bottom-right",
                  timer: 1500,
              });
              // console.log(data);
          }
      });
}


function onDelete(id){
  form = document.forms['delPetitionForm'];
  form.id.value = id;
}