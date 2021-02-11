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
      <div class="row justify-content-end mt-2">
        <button class="btn btn-primary mx-1" v-on:click="resetFilter()" v-if="isFilterTable" >Reset filtros<i class="fa fa-refresh ml-1"></i></button>
      </div>
    </div>
    <div class="row d-flex justify-content-center" v-if="isFilterTable">
      Se han encontrado {{this.temporalDonors.length}} conincidencias
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
          <tr v-for="(temporaldonor, index) in temporalDonors" :key="index">
            <th>{{temporaldonor.id}}</th>
            <td>{{temporaldonor.name}} {{temporaldonor.parental_surname}} {{temporaldonor.maternal_surname}}</td>
            <td>{{temporaldonor.city.name}}</td>
            <td>{{temporaldonor.state.name}}</td>
            <td>{{bloodtypes[temporaldonor.bloodtype]}}</td>
            <td>{{donortypes[temporaldonor.donortype]}}</td>
            <td>{{temporaldonor.mobile}}</td>
            <td><div style="width:235px;">{{temporaldonor.email}}</div></td>
            <td>
              <div class="btn-group dropleft">
                <button class="btn btn-dark dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Action <i class="fa fa-cog mx-1" aria-hidden="true"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" :href="'temporal_donors/'+temporaldonor.id"><i class="fa fa-eye mx-1" aria-hidden="true"></i>Mostrar</a>
                  <a class="dropdown-item" :href="'temporal_donors/'+temporaldonor.id+'/edit'"><i class="fa fa-pencil mx-1" aria-hidden="true"></i>Editar</a>
                  <button class="dropdown-item" v-on:click="deleteTemporalDonor(temporaldonor.id, index)" v-bind:value="temporaldonor.id"><i class="fa fa-trash mx-1" aria-hidden="true"></i>Eliminar</button>
                  <div class="dropdown-divider"></div>
                  <button class="dropdown-item" v-on:click="becomeIntoDonor(temporaldonor.id)" ><i class="fa fa-tint mx-1"></i>Convertir a donador</button>
                </div>
              </div>
            </td>
          </tr>
          <tr v-if="temporalDonors.length == 0 && !isTableLoading">
            <td class="table-info text-center" colspan="10">Nada para mostrar</td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- <paginate-links v-if="temporalDonors.length > 0" class="d-flex justify-content-center" for="temporalDonors" :simple="{prev: 'Ante', next: 'Sig'}" :classes="{'ul': 'pagination', 'li': 'page-item', 'a': 'page-link'}"></paginate-links> -->
  </div>
</template>

<script>
export default {
  props: ['donortypes', 'gendertypes', 'bloodtypes', 'cities', 'states'],
  data() {
    return {
      temporalDonors: [],
      /* paginate:['temporalDonors'], */
      search: '',
      iddonor: '',
      isSectionFilterActive: false,
      citiesbystate:[],
      selectedState: '',
      selectedCity: '',
      selectedBloodType: '',
      selectedDonorType: '',
      limitDonors: 15,
      totalDonors: 0,
      isTableLoading: true,
      isFilterTable: false
    }
  },
  mounted() {
    this.getTemporalDonors();
    this.citiesbystate = this.cities;
  },
  methods: {
    updatePaginator:function(){
      if (this.$refs.paginator) {
        this.$refs.paginator.goToPage(0);
        console.log('regresara 1');
      }
    },
    getTemporalDonors: function(){
      axios.get('api/temporal_donors')
      .then(response=>{
        this.isTableLoading = false;
        this.isLoadingMore = false;
        this.temporalDonors = response.data;
      })
    },
    deleteTemporalDonor: async function(donorId, index){
      const sweetAlerPromise = await questionNotification('¿Está seguro que quiere eliminar el donador pre registrado?', 'Esta acción no se puede corrergir', 'Sí, estoy seguro');
      if(sweetAlerPromise){
        axios.delete(`/temporal_donors/${donorId}`)
        .then(response => {
          if(response.data['code']==200){
            this.getTemporalDonors();
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
      this.temporalDonors = [];
      axios.get('/filter/temporal_donors',{ 
        params:{
          bloodType: this.selectedBloodType,
          donorType: this.selectedDonorType,
          city: this.selectedCity,
          state: this.selectedState,
          name: this.search,
          id: this.iddonor,
        }
      })
      .then(response => {
        this.isTableLoading = false;
        this.isFilterTable = true;
        this.temporalDonors = response.data;
        this.updatePaginator();
      })
    },
    resetFilter:function(){
      this.getTemporalDonors();
      this.isFilterTable = false;
      this.citiesbystate = this.cities;
      this.selectedState =  '';
      this.selectedCity =  '';
      this.selectedBloodType =  '';
      this.selectedDonorType =  '';
      this.search = '';
      this.iddonor = '';
      this.updatePaginator()
    },
    becomeIntoDonor:async function(temporalDonorId){
      const userResponse = await questionNotification('¿Está seguro que quiere convertir en donador al predonador?','Esta acción no se puede corregir', 'Sí, lo estoy');
      if(userResponse){
        axios.post('/api/temporal_donor/morph_to_donor',{
          'predonorId': temporalDonorId
        })
        .then((response)=>{
          if(response.data['code']==200){
            this.getTemporalDonors();
            successNotification(response.data['message']);
          }else{
            errorNotification(response.data['message']);
          }
        })
        .catch((err)=>{
          errorNotification(`Algo salió mal, intente más tarde ${error}`);
        });
      }
    }
  },
}
</script>