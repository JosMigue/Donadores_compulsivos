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