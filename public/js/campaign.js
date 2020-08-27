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