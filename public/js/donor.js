'use sctrict'

document.addEventListener("DOMContentLoaded", retrieveSelectedTab);

async function deleteDonor(button){
  const donorId = button.value;
  const sweetAlerPromise = await questionNotification('¿Está seguro?', 'Esta acción no se puede corrergir', 'Sí, estoy seguro');
  if(sweetAlerPromise){
    axios.delete(`/donors/${donorId}`)
    .then(response => {
      if(response.data['code']==200){
        button.closest('tr').remove();
        successNotification(response.data['message']);
      }else{
        errorNotification(response.data['message']);
      }
    })
    .catch(error => {
      errorNotification(`Algo salió mal, intente más tarde ${error}`);
    });
  }
}

function calculateAge(birthdayDate) { 
  birthdayDate =  new Date(birthdayDate.value);
  var ageDifMs = Date.now() - birthdayDate.getTime();
  var ageDate = new Date(ageDifMs); // miliseconds from epoch
  const age = Math.abs(ageDate.getUTCFullYear() - 1970);
  document.getElementById('age').value = age;
}

function updateProfilePicture(){
  const section = document.getElementById('toggleable-button');
  if(section.classList.contains('is-active')){
    section.classList.remove('is-active');
  }else{
    section.classList.add('is-active');
  }
}

function saveTabSelect(navLink) {
  localStorage.setItem("tagSelected", navLink.id);
  return true;
}

function retrieveSelectedTab(){
  const curTag = localStorage.getItem("tagSelected");
  const tab = document.getElementById('information-tab')
  if(curTag){
    if(tab){
      document.getElementById(curTag).classList.add("active");
      document.getElementById(`${curTag}-tab`).classList.add('active');
    }
  }else{
    if(tab){
      tab.classList.add('active');
      document.getElementById('information').classList.add('active');
    }
  }
}
