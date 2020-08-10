function calculateAge(birthdayDate) { 
  birthdayDate =  new Date(birthdayDate.value);
  var ageDifMs = Date.now() - birthdayDate.getTime();
  var ageDate = new Date(ageDifMs); // miliseconds from epoch
  const age = Math.abs(ageDate.getUTCFullYear() - 1970);
  document.getElementById('age').value = age;
}