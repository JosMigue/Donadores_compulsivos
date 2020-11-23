<template>
  <div>
    <div class="text-right mb-2" v-if="!isSectionFilterActive">
      <button class="btn btn-primary" v-on:click="toggleFilterSection()">Mostrar filtros</button>
    </div>
    <div class="text-right mb-2" v-if="isSectionFilterActive">
      <button class="btn btn-primary" v-on:click="toggleFilterSection()">Ocultar filtros</button>
    </div>
    <div class="animate__animated animate__fadeInDown p-4" v-if="isSectionFilterActive">
      <form action="/filter/donors" method="GET">
        <div class="row justify-content-center pt-2">
          <p>Filtro avanzado</p>
        </div>
        <div class="row">
          <div class="col-lg-3 col-12">
            <label for="">Tipo de donador</label>
            <select class="form-control" name="donorType" id="donorType">
              <option value="" selected disabled>Seleccione un tipo de donador</option>
              <option v-bind:value="index" v-for="(donortype, index) in donortypes" :key="index">{{donortype}}</option>
            </select>
          </div>
          <div class="col-lg-3 col-12">
            <label for="">Tipo de sangre</label>
            <select class="form-control" name="bloodType">
              <option value="" selected disabled>Seleccione un tipo de sangre</option>
              <option v-bind:value="index" v-for="(bloodtype, index) in bloodtypes" :key="index">{{bloodtype}}</option>
            </select>
          </div>
          <div class="col-lg-3 col-12">
            <label for="">Estado</label>
            <select class="form-control" name="stateId" v-model="selectedState" v-on:change="getCitiesByState()">
              <option value="" disabled>Selecciones un estado</option>
              <option v-bind:value="state.id" v-for="(state, index) in states" :key="index">{{state.name}}</option>
            </select>
          </div>
          <div class="col-lg-3 col-12">
            <label for="">Ciudad</label>
            <select class="form-control" name="cityId">
              <option value="" selected disabled>Selecciones una ciudad</option>
              <option v-bind:value="city.id" v-for="(city, index) in citiesbystate" :key="index">{{city.name}}</option>
            </select>
          </div>
        </div>
        <div class="row justify-content-end mt-2">
          <button class="btn btn-primary mx-1" type="submit">Buscar<i class="fa fa-filter ml-1"></i></button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
    props:['cities', 'states','bloodtypes', 'donortypes'],
    data() {
        return {
          selectedState: '',
          citiesbystate:[],
          selectedCity: '',
          selectedBloodType: '',
          selectedDonorType: '',
          isSectionFilterActive: false,
        }
    },
    mounted() {
      this.citiesbystate = this.cities;
    },
    methods: {
      getCitiesByState:function(){
        axios.post('/citiesByState',{
          stateId: this.selectedState
        }).then(response =>{
          this.citiesbystate = response.data;
        })
      },
      toggleFilterSection:function(){
        if(this.isSectionFilterActive){
          this.isSectionFilterActive = false;
        }else{
          this.isSectionFilterActive = true;
        }
      },
    },
}
</script>