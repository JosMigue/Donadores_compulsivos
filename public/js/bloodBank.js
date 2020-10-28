async function deleteBloodBank(button){
    const bankId = button.value;
    const sweetAlerPromise = await questionNotification('¿Está seguro que desea eliminar el banco?', 'Esta acción no se puede corrergir', 'Sí, estoy seguro');
    if(sweetAlerPromise){
      axios.delete(`/bloodbanks/${bankId}`)
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

function showInfoMessage(){
  Swal.fire({
    title: 'Información',
    icon: 'info',
    html: '<p style="text-align: justify; text-justify: inter-word;">Lo sentimos, en este sentido de edición de horario del banco de sangre el sistema está limitado, debido a tiempos de realización. En un futuro esto se mejorará, por el momento se matendrá así. De verdad lo sentimos 💔</p>',
    confirmButtonColor: '#ed1a3b',
    confirmButtonText: 'Entendido',
    showClass: {
      popup: 'animate__animated animate__bounceIn'
    },
    hideClass: {
      popup: 'animate__animated animate__bounceOut'
    }
  })
}