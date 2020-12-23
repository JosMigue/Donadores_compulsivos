<template>
  <div>
    <div class="text-right mb-2" v-if="!isSectionFilterActive">
      <button class="btn btn-primary" v-on:click="toggleFilterSection()">Mostrar filtros</button>
    </div>
    <div class="text-right mb-2" v-if="isSectionFilterActive">
      <button class="btn btn-primary" v-on:click="toggleFilterSection()">Ocultar filtros</button>
    </div>
    <div id="advanced-search-section" class="animate__animated animate__fadeInDown p-4" v-if="isSectionFilterActive">
      <div class="row justify-content-center">
        <p>Búsqueda en tiempo real</p>
      </div>
      <div class="row">
        <div class="col-lg-3 col-12">
          <label for="">Por Id:</label>
          <input class="form-control" type="text" v-model="iddonor" placeholder="id" v-on:keyup="filterTable()">
        </div>
        <div class="col-lg-9 col-12">
          <label for="">Por nombre o apellido:</label>
          <input class="form-control" type="text" v-model="search" placeholder="Buscar por nombre o apellidos" v-on:keyup="filterTable()">
        </div>
      </div>
      <div class="row justify-content-center pt-2">
        <p>Filtro avanzado</p>
      </div>
      <div class="row">
        <div class="col-lg-3 col-12">
          <label for="">Tipo de donador</label>
          <select class="form-control" v-on:change="filterTable()" name="" id="" v-model="selectedDonorType">
            <option value="" selected disabled>Seleccione un tipo de donador</option>
            <option v-bind:value="index" v-for="(donortype, index) in donortypes" :key="index">{{donortype}}</option>
          </select>
        </div>
        <div class="col-lg-3 col-12">
          <label for="">Tipo de sangre</label>
          <select class="form-control" v-on:change="filterTable()" v-model="selectedBloodType">
            <option value="" selected disabled>Seleccione un tipo de sangre</option>
            <option v-bind:value="index" v-for="(bloodtype, index) in bloodtypes" :key="index">{{bloodtype}}</option>
          </select>
        </div>
        <div class="col-lg-3 col-12">
          <label for="">Estado</label>
          <select class="form-control" v-model="selectedState" v-on:change="getCitiesByState()">
            <option value="" disabled>Selecciones un estado</option>
            <option v-bind:value="state.id" v-for="(state, index) in states" :key="index">{{state.name}}</option>
          </select>
        </div>
        <div class="col-lg-3 col-12">
          <label for="">Municipio</label>
          <select class="form-control" v-on:change="filterTable()" v-model="selectedCity">
            <option value="" selected disabled>Selecciones una ciudad</option>
            <option v-bind:value="city.id" v-for="(city, index) in citiesbystate" :key="index">{{city.name}}</option>
          </select>
        </div>
      </div>
      <div class="d-flex flex-wrap flex-lg-row flex-column justify-content-around my-2">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" v-model="be_the_match" v-on:change="filterTable()">
          <label class="form-check-label" for="defaultCheck1">
            Be The Match
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" v-model="letter" v-on:change="filterTable()">
          <label class="form-check-label">
            Carta
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" v-model="is_donor_first_time" v-on:change="filterTable()">
          <label class="form-check-label">
            Primera vez siendo donador
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" v-model="isActive" v-on:change="filterTable()">
          <label class="form-check-label">
            Mostrar solo no activos
          </label>
        </div>
      </div>
      <div class="row justify-content-end mt-2">
        <button class="btn btn-primary mx-1" v-on:click="resetFilter()" v-if="isFilterTable" >Reset filtros<i class="fa fa-refresh ml-1"></i></button>
      </div>
    </div>
    <div class="row d-flex justify-content-center" v-if="isFilterTable">
      Se han encontrado {{this.donors.length}} conincidencias
    </div>
    <div class="row d-flex justify-content-center" v-if="!isFilterTable">
      Hay {{this.totalDonors}} donadores en total
    </div>
    <div class="table-responsive">
      <table class="table table-hover table-striped">
        <thead class="thead-dark text-center">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Municipio</th>
            <th scope="col">Estado</th>
            <th scope="col">TS</th>
            <th scope="col">TD</th>
            <th scope="col">Teléfono</th>
            <th scope="col">Correo</th>
            <th scope="col">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="10" v-if="isTableLoading">
              <div class="d-flex justify-content-center">
                  <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                  <span class="sr-only">Loading...</span>
              </div>
            </td>
          </tr>
          <tr v-for="(donor, index) in donors" :key="index">
            <th>{{donor.id}}</th>
            <td>{{donor.name}} {{donor.parental_surname}} {{donor.maternal_surname}}</td>
            <td>{{donor.city.name}}</td>
            <td>{{donor.state.name}}</td>
            <td>{{bloodtypes[donor.bloodtype]}}</td>
            <td>{{donortypes[donor.donortype]}}</td>
            <td>{{donor.mobile}}</td>
            <td>{{donor.email}}</td>
            <td>
              <div class="btn-group dropleft">
                <button class="btn btn-dark dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Action <i class="fa fa-cog mx-1" aria-hidden="true"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" :href="'donors/'+donor.id"><i class="fa fa-eye mx-1" aria-hidden="true"></i>Mostrar</a>
                  <a class="dropdown-item" :href="'donors/'+donor.id+'/edit'"><i class="fa fa-pencil mx-1" aria-hidden="true"></i>Editar</a>
                  <button class="dropdown-item" v-on:click="deleteDonor(donor.id, index)" v-bind:value="donor.id"><i class="fa fa-trash mx-1" aria-hidden="true"></i>Eliminar</button>
                </div>
              </div>
            </td>
          </tr>
          <tr v-if="donors.length == 0 && !isTableLoading">
            <td class="table-info text-center" colspan="10">Nada para mostrar</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="row d-flex justify-content-center" v-if="!isTableLoading && !isFilterTable">
      <button class="btn btn-primary btn-md mx-1" v-on:click="loadMore()"><i class="fa fa-refresh mx-1" v-bind:class="{ 'fa-spin': isLoadingMore }" aria-hidden="true"></i>Cargar más</button>  
      <button class="btn btn-primary btn-md mx-1" v-on:click="loadAll()"><i class="fa fa-refresh mx-1" aria-hidden="true"></i>Cargar todo</button>  
    </div> 
  </div>
</template>

<script>
export default {
  props: ['donorsarray', 'donortypes', 'gendertypes', 'bloodtypes', 'cities', 'states'],
  data() {
    return {
      donors: [],
      search: '',
      iddonor: '',
      isSectionFilterActive: false,
      citiesbystate:[],
      selectedState: '',
      selectedCity: '',
      selectedBloodType: '',
      selectedDonorType: '',
      be_the_match: 0,
      letter: 0,
      is_donor_first_time: 0,
      limitDonors: 15,
      totalDonors: 0,
      isTableLoading: true,
      isFilterTable: false,
      isLoadingMore: false,
      isActive: false
    }
  },
  mounted() {
    this.getDonors();
    this.citiesbystate = this.cities;
  },
  methods: {
    getDonors: function(){
      axios.get('api/donors',{
        params: {
          takeRecords:this.limitDonors
        }
      })
      .then(response=>{
        this.isTableLoading = false;
        this.isLoadingMore = false;
        this.donors = response.data.donors;
        this.totalDonors = response.data.countDonors;
      })
    },
    deleteDonor: async function(donorId, index){
      const sweetAlerPromise = await questionNotification('¿Está seguro?', 'Esta acción no se puede corrergir', 'Sí, estoy seguro');
      if(sweetAlerPromise){
        axios.delete(`/donors/${donorId}`)
        .then(response => {
          if(response.data['code']==200){
            this.donors.splice(index, 1);
            successNotification(response.data['message']);
          }else{
            errorNotification(response.data['message']);
          }
        })
        .catch(error => {
          errorNotification(`Algo salió mal, intente más tarde ${error}`);
        });
      }
    },
    loadMore:function(){
      this.isLoadingMore = true;
      this.limitDonors += 15;
      this.getDonors(); 
    },
    loadAll:function(){
      this.limitDonors = this.totalDonors;
      this.isTableLoading = true;
      this.donors = [],
      this.getDonors(); 
    },
    toggleFilterSection:function(){
      if(this.isSectionFilterActive){
        this.isSectionFilterActive = false;
      }else{
        this.isSectionFilterActive = true;
      }
    },
    getCitiesByState:function(){
      axios.post('/citiesByState',{
        stateId: this.selectedState
      }).then(response =>{
        this.citiesbystate = response.data;
        this.filterTable();
      })
    },
    filterTable:function(){
      this.isTableLoading = true;
      this.donors = [],
      axios.get('/filter/donors',{ 
        params:{
          bloodType: this.selectedBloodType,
          donorType: this.selectedDonorType,
          city: this.selectedCity,
          state: this.selectedState,
          name: this.search,
          id: this.iddonor,
          be_the_match: this.be_the_match,
          letter: this.letter,
          isFirstTimeDonor: this.is_donor_first_time,
          isActive:this.isActive
        }
      })
      .then(response => {
        this.isTableLoading = false;
        this.isFilterTable = true;
        this.donors = response.data;
      })
    },
    resetFilter:function(){
      this.getDonors();
      this.isFilterTable = false;
      this.citiesbystate = this.cities;
      this.selectedState =  '';
      this.selectedCity =  '';
      this.selectedBloodType =  '';
      this.selectedDonorType =  '';
      this.search = '',
      this.iddonor = '',
      this.limitDonors = 15,
      this.be_the_match = 0,
      this.letter = 0,
      this.is_donor_first_time = 0;
      this.isActive = false;
    },
  },
}
</script>