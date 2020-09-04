function questionNotification(title, body, action){
  return Swal.fire({
    title: title,
    text: body,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: action
  }).then((result) => {
      return result.value;
  });
}
  
function successNotification(title){
  return Swal.fire({
    position: 'center',
    icon: 'success',
    title: title,
    showConfirmButton: false,
    timer: 2200
  });
}

function errorNotification(title){
  Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: title,
  });
}

function unknowNotification(title, body){
  Swal.fire(
    title,
    body,
    'question'
  );
}

function toastNotification(icon, title){
  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })
  
  Toast.fire({
    icon: icon,
    title: title
  })
}