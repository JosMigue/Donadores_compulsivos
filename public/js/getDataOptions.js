function getAllCitiesState(select){
  event.preventDefault();
  const stateId = select.value;
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type: 'GET',
    url:'/cities',
    data: { stateId },
  success: (response) => {
    document.getElementById('city_id').innerHTML=response;
  },
  error: function(err){
      
  }
  });
}