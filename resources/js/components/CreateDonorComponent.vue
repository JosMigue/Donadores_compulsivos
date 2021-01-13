<template>
  <div>
    <div class="alert alert-danger alert-dismissible fade show" role="alert" v-if="errors">
      <ul v-for="(error, index) in errors" :key="index" >
        <li>{{error}}</li>
      </ul>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="row m-1">
      <p class="text-dark">Campos obligatorios<span class="text-danger">*</span></p>
    </div>
    <div class="row my-1">
      <div class="col-12 col-md-4 pr-md-1">
        <label>Nombre <span class="text-danger text-sm">*</span> </label>
        <input type="text" id="name" name="name" autofocus="true" class="form-control" v-model="name">
      </div>
      <div class="col-12 col-md-4 px-md-1">
        <label>Apellido paterno <span class="text-danger text-sm">*</span></label>
        <input type="text" id="parental_surname" name="parental_surname" class="form-control" v-model="parental_surname">
      </div>
      <div class="col-12 col-md-4 pl-md-1">
        <label>Apellido materno</label>
        <input type="text" id="maternal_surname" name="maternal_surname" class="form-control" v-model="maternal_surname">
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-md-4 pr-md-1">
        <label>CURP <span class="text-danger text-sm">*</span></label>
        <input type="text" maxlength="18" v-model="curp" class="form-control" id="curp" name="curp" placeholder="Ingrese su curp">
      </div>
      <div class="col-12 col-md-4 px-md-1">
        <label>Tipo de sangre <span class="text-danger text-sm">*</span></label>
        <select class="form-control" name="bloodtype" id="bloodtype" v-model="selectedBlood" required>
          <option value="" selected disabled>Seleccione tipo de sangre...</option>
          <option :value="index" v-for="(blood, index) in bloods" :key="index" >{{blood}}</option>
        </select>
      </div>
      <div class="col-12 col-md-4 pl-md-1">
        <label>Tipo de donador <span class="text-danger text-sm">*</span></label>
        <select class="form-control" name="donortype" id="donortype" v-model="selectedDonorType" required>
          <option value="" selected disabled>Seleccione tipo de donador...</option>
          <option value="D1">Sangre</option>
          <option value="D2">Aféresis</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 pr-md-1">
        <label>Correo electrónico</label>
        <input type="email" class="form-control" id="email" name="email" v-model="email">
      </div>
      <div class="col-md-4 px-md-1">
        <label>Estado <span class="text-danger text-sm">*</span></label>
        <select id="state_id" name="state_id" class="form-control" v-model="selectedState" v-on:change="getCitiesByStates(selectedState)" required>
          <option value="" selected disabled>seleccione un estado...</option>
          <option :value="state" v-for="(state, index) in states" :key="index">{{state.name}}</option>
        </select>
      </div>
      <div class="col-md-4 pl-md-1">
        <label>Municipio <span class="text-danger text-sm">*</span></label>
        <select id="city_id" name="city_id" class="form-control" v-model="selectedCity" required>
          <option v-if="cities.length>0" value="" selected disabled>seleccione municipio</option>
          <option v-else value="" selected disabled>Seleccione un estado primero...</option>
          <option :value="city.id" v-for="(city, index) in cities" :key="index" >{{city.name}}</option>
        </select>
      </div>
    </div>
    <div class="row my-1">
      <div class="col-12 col-md-4 pr-md-1">
        <label>Fecha de nacimiento <span class="text-danger text-sm">*</span></label>
        <input type="date" v-model="selectedDate" v-on:change="calculateAge()" id="born_date" name="born_date" class="form-control" required>
      </div>
      <div class="col-6 col-md-4 px-md-1">
        <label>Teléfono celular </label>
        <input type="tel" id="mobile" name="mobile" class="form-control" v-model="mobile" placeholder="" value="" >
      </div>
      <div class="col-6 col-md-4 pl-md-1">
        <label>Edad <span class="text-danger text-sm">*</span></label>
        <input type="text" id="age" name="age" v-model="age" class="form-control" readonly>
      </div>
    </div>
    <div class="row my-1">
      <div class="col-6 col-md-4 pr-md-1">
        <label>Género</label>
        <select id="gendertype" name="gendertype" class="form-control" v-model="selectedGender" required>
          <option :value="index" v-for="(gender, index) in genders" :key="index">{{gender}}</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-lg-4 pr-md-1">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" disabled checked name="first_time_donating" id="first_time_donating">
          <label class="form-check-label" for="first_time_donating">
            Donador primera vez
          </label>
        </div>
      </div>
      <div class="col-12 col-lg-4 px-md-1">
        <div class="form-check">
          <input class="form-check-input" value="0" v-model="beTheMatch" type="checkbox" name="be_the_match" id="be_the_match">
          <label class="form-check-label" for="be_the_match">
            Be The Match
          </label>
        </div>
      </div>
      <div class="col-12 col-lg-4 pl-md-1">
        <div class="form-check">
          <input class="form-check-input" value="0" v-model="letter" type="checkbox" name="letter" id="letter">
          <label class="form-check-label" for="letter">
            Carta
          </label>
        </div>
      </div>
    </div>
    <div class="row my-1">
      <div class="col-lg-12 d-flex justify-content-end">
        <button class="btn btn-success" v-on:click="addDonor()">Registrar</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['genders', 'bloods', 'campaign'],
  data() {
    return {
      cities: [],
      states: [],
      bloodTypes: [],
      genderTypes: [],
      selectedState: '',
      selectedCity: '',
      selectedDate: '',
      selectedBlood: '',
      selectedGender: 'NR',
      selectedDonorType: '',
      age: '',
      mobile: '',
      parental_surname: '',
      maternal_surname: '',
      curp:'',
      name: '',
      beTheMatch:false,
      letter:false,
      email:'',
      errors: ''

    }
  },
  mounted() {
    this.getAllStates();
  },
  methods: {
    getAllStates: function(){
      axios.get('/states')
      .then((response)=>{
        this.states = response.data;
      });
    },
    getCitiesByStates: function(state){
      this.cities = state.cities;
    },
    calculateAge:function(){
      const birthdayDate =  new Date(this.selectedDate);
      const ageDifMs = Date.now() - birthdayDate.getTime();
      const ageDate = new Date(ageDifMs);
      const age = Math.abs(ageDate.getUTCFullYear() - 1970);
      this.age = age;
    },
    resetForm:function(){
      this.selectedState = '';
      this.selectedCity = '';
      this.selectedDate = '';
      this.selectedBlood = '';
      this.selectedGender = '';
      this.selectedDonorType = '';
      this.age = '';
      this.mobile = '';
      this.parental_surname = '';
      this.maternal_surname = '';
      this.name = '';
      this.beTheMatch = false;
      this.letter = false;
      this.email = '';
      this.curp = '';
    },
    addDonor:function(){
      axios.post('/temporal_donors',{
        'name': this.name,
        'parental_surname': this.parental_surname,
        'maternal_surname': this.maternal_surname,
        'curp': this.curp,
        'bloodtype': this.selectedBlood,
        'donortype': this.selectedDonorType,
        'state_id': this.selectedState.id,
        'city_id': this.selectedCity,
        'born_date': this.selectedDate,
        'mobile': this.mobile,
        'age': this.age,
        'gendertype': this.selectedGender,
        'campaign': this.campaign,
        'first_time_donating': 1,
        'be_the_match': this.beTheMatch,
        'letter': this.letter,
        'email': this.email,
      }).then((response)=>{
        if(response.data['code']==200){
          this.$emit('add-not-registered-donor-in-campaign-event');
          successNotification(response.data['message']);
        }else{
          errorNotification(response.data['message']);
        }
        this.resetForm();
      }).catch((err =>{
        this.errors = err.response.data.errors;
      }))
    }
  },
}
</script>