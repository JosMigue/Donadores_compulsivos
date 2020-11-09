async function deleteCampaign(button){
  const campaignId = button.value;
  const sweetAlerPromise = await questionNotification('¿Está seguro que desea eliminar la campaña?', 'Esta acción no se puede corrergir', 'Sí, estoy seguro');
  if(sweetAlerPromise){
    axios.delete(`/campaigns/${campaignId}`)
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

function toggleFilters(){
  const filterSection = document.getElementById('filter-section');
  if(filterSection.classList.contains('is-active')){
    filterSection.classList.remove('is-active');
  }else{
    filterSection.classList.add('is-active');
  }
}

function toggleBloodbanksSection(ratioInput){
  const section = document.getElementById('blood_bank_section');
  const select = document.getElementById('blood_bank_id');
  const field_place = document.getElementById('place_section');
  if(ratioInput.value == 'c1'){
    if(section.classList.contains('d-none')){
    }else{
      section.classList.add('d-none');
      field_place.classList.remove('d-none')
      select.value = '';
      resetCityStateSelector();
    }
  }else{
    section.classList.remove('d-none')
    field_place.classList.add('d-none');
    field_place.value = 'banco de sangre';
  }
}

function updateCampaignImage(){
  const section = document.getElementById('toggleable-button');
  const input = document.getElementById('campaign_image');
  if(section.classList.contains('is-active')){
    input.value='';
    section.classList.remove('is-active');
  }else{
    section.classList.add('is-active');
  }
}

function showHelp(){
  Swal.fire({
    title: 'Ayuda',
    icon: 'info',
    text: 'Los filtros estás hechos con el fin de mandar el aviso de nueva campaña a un número en especifico de donadores, es decir si usted quire mandar solo a los donadores de un estado especifico o solo a donadores con "x" tipo de sangre. Los filtros no son obligatorios.',
    confirmButtonText: 'Entendido',
    showClass: {
      popup: 'animate__animated animate__bounceIn'
    },
    hideClass: {
      popup: 'animate__animated animate__bounceOut'
    }
  })
}

function getBloodBankLocationInfo(bloodBank) { 
  const cityName = bloodBank.options[bloodBank.selectedIndex].getAttribute('data-city-name');
  const cityId = bloodBank.options[bloodBank.selectedIndex].getAttribute('data-city-id');
  const stateName = bloodBank.options[bloodBank.selectedIndex].getAttribute('data-state-name');
  const stateId = bloodBank.options[bloodBank.selectedIndex].getAttribute('data-state-id');
  toggleCityStateSection(cityName, cityId, stateName, stateId)
}

function toggleCityStateSection(cityName, cityId, stateName, stateId){
  document.getElementById('city_id').innerHTML=`<select id="city_id" name="city_id" class="form-control" required><option selected value="${cityId}">${cityName}</option></select>`;
  document.getElementById('state_id').value=stateId;
}

function resetCityStateSelector(){
  document.getElementById('state_id').value='';
  document.getElementById('city_id').innerHTML=`<select id="city_id" name="city_id" class="form-control" required><option value="" selected disabled>Seleccione un estado primero</option></select>`;
}
