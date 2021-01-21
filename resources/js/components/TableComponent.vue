<template>
  <div>
    <label>
      Donadores suscritos {{this.campaigndonors.length}}
    </label>
    <!-- <div class="d-flex justify-content-center">
      <button type="button" class="is-link-red" data-toggle="modal" data-target="#modalDonors" data-backdrop="static" data-keyboard="false">
        Buscar donador <i class="fa fa-plus mx-1" aria-hidden="true"></i>
      </button>
    </div> -->
    <modal-donor-component :campaign = campaignid v-on:added-donor-campaign-event="getDonorsInCampaign()" :genders = gendertypes :blood = bloodtypes></modal-donor-component> 
    <div class="text-center">
      <p class="text-danger">Buscar donador por...</p>
    </div>
      <div class="form-row">
        <div class="form-group col-md-3">
          <label>No. Donador</label>
          <input class="form-control" type="text" v-model="typedId" v-on:keyup="searchDonor(1)">
          <div class="autocomplete-items" v-if="selectedDonor">
            <div class="autocomplete-item" v-on:click="addDonorInCampaign(selectedDonor.id)" > <i class="fa fa-user mx-1"></i> {{selectedDonor.name}} {{selectedDonor.parental_surname}} {{selectedDonor.maternal_surname}}</div>
          </div>
          <div class="autocomplete-items" v-if="isSearchIdNull">
            <div class="p-2 text-center"> <p>Parece que no hay nada para mostrar :(</p><p>¿No encuentra lo que busca?</p><button data-toggle="modal" data-target="#modalDonors" data-backdrop="static" data-keyboard="false" class="btn btn-primary btn-md" v-on:click="resetFilter()">Registra uno nuevo <i class="fa fa-plus mx-1"></i></button></div>
          </div>
        </div>
        <div class="form-group col-md-8">
          <label>Nombre o apellidos</label>
          <input class="form-control" type="text" v-model="search" v-on:keyup="searchDonor(2)">
          <div class="autocomplete-items" v-if="donors.length > 0">
            <div class="autocomplete-item" v-for="(donor, index) in donors" :key="index" v-on:click="addDonorInCampaign(donor.id)" > <i class="fa fa-user mx-1"></i> {{donor.name}} {{donor.parental_surname}} {{donor.maternal_surname}} <strong>/</strong> {{donor.city.name}}<strong>-</strong>{{donor.state.name}}</div>
          </div>
          <div class="autocomplete-items" v-if="isSearchNull">
            <div class="p-2 text-center"> <p>Parece que no hay nada para mostrar :(</p><p>¿No encuentra lo que busca?</p><button data-toggle="modal" data-target="#modalDonors" data-backdrop="static" data-keyboard="false" class="btn btn-primary btn-md" v-on:click="resetFilter()">Registra uno nuevo <i class="fa fa-plus mx-1"></i></button></div>
          </div>
        </div>
        <div class="form-group col-md-1 align-self-end">
          <a href="/donors/create" class="btn btn-primary">Registrar</a>
        </div>
      </div>
    <h5>Donadores registrados</h5>
    <div class="table-responsive-sm">
      <table class="table table-hover table-striped table-sm text-center">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">T.S.</th>
            <th scope="col">Género</th>
            <th scope="col">Teléfono</th>
            <th scope="col">Correo electrónico</th>
            <th scope="col">HT</th>
            <th scope="col">Confirmó</th>
            <th scope="col">Asistió</th>
            <th scope="col">Donó</th>
            <th scope="col">Acciones</th>
          </tr>
        </thead>
        <paginate name="campaigndonors" :list="campaigndonors" :per="15" tag="tbody">
          <tr v-for="(campaigndonor, index) in paginated('campaigndonors')" :key="index">
            <th scope="row">{{index+1}}</th>
            <td>{{campaigndonor.name}} {{campaigndonor.parental_surname}} {{campaigndonor.maternal_surname}}</td>
            <td>{{bloods[campaigndonor.bloodtype]}}</td>
            <td>{{genders[campaigndonor.gendertype]}}</td>
            <td>{{campaigndonor.mobile}}</td>
            <td>{{campaigndonor.email}}</td>
            <td @dblclick="showTimePicker(campaigndonor)" v-if="campaigndonor.pivot.time_turn != null">{{campaigndonor.pivot.time_turn}}</td>
            <td v-else>
              <select v-model="selectedTime" class="form-control" v-on:change="updateTimeTurn(campaigndonor)">
                <option :value="time" v-for="(time, index) in listTime" :key="index">{{time}}</option>
              </select>
            </td>
            <td>
              <i v-if="campaigndonor.pivot.is_confirmed" class="fa fa-check text-success" aria-hidden="true"></i>
              <i v-else class="fa fa-times text-danger" aria-hidden="true"></i>
            </td>
            <td>
              <i v-if="campaigndonor.pivot.donor_attended" class="fa fa-check text-success" aria-hidden="true"></i>
              <i v-else class="fa fa-times text-danger" aria-hidden="true"></i>
            </td>
            <td>
              <i v-if="campaigndonor.pivot.donor_donated" class="fa fa-check text-success" aria-hidden="true"></i>
              <i v-else class="fa fa-times text-danger" aria-hidden="true"></i>
            </td>
            <td>
              <div class="btn-group">
                <button type="button" class="btn btn-secondary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Acción
                </button>
                <div class="dropdown-menu">
                  <button class="dropdown-item" v-if="campaigndonor.pivot.is_confirmed" v-on:click="changeConfirmStatus(campaigndonor, 0)"  data-toggle="tooltip" data-placement="right" title="Marcar como no asistió"> <i class="fa fa-times"></i>Desmarcar confirmado</button>
                  <button class="dropdown-item" v-else v-on:click="changeConfirmStatus(campaigndonor, 1)" data-toggle="tooltip" data-placement="right" title="Marcar como asistió"><i class="fa fa-check"></i>Marcar confirmado</button> 
                  <button class="dropdown-item" v-if="campaigndonor.pivot.donor_attended" v-on:click="changeStatusDonationAttended(campaigndonor, 0, 1)"  data-toggle="tooltip" data-placement="right" title="Marcar como no asistió"> <i class="fa fa-times"></i> Marcar como no asistió</button>
                  <button class="dropdown-item" v-else v-on:click="changeStatusDonationAttended(campaigndonor, 1, 1)" data-toggle="tooltip" data-placement="right" title="Marcar como asistió"><i class="fa fa-check"></i> Marcar como asistió</button> 
                  <div v-if="campaigndonor.pivot.donor_attended">
                    <button class="dropdown-item" v-if="campaigndonor.pivot.donor_donated"  v-on:click="changeStatusDonation(campaigndonor, 0, 1)" data-toggle="tooltip" data-placement="right" title="Marcar como donó"><i class="fa fa-times"></i>Marcar como no donó</button>
                    <button class="dropdown-item" v-else  v-on:click="changeStatusDonation(campaigndonor, 1, 1)" data-toggle="tooltip" data-placement="right" title="Marcar como no donó"><i class="fa fa-check"></i>Marcar como donó</button>
                  </div>
                  <button class="dropdown-item" v-on:click="deleteDonorFromCampaign(campaigndonor)"><i class="fa fa-trash"></i> Borrar</button>
                  <a :href="'/donors/'+campaigndonor.id" class="dropdown-item" target="__blank"><i class="fa fa-eye"></i> Ver donador</a>
                  <button v-if="campaigndonor.letter == 1" class="dropdown-item" v-on:click="changeLetterStatus(campaigndonor.id, 0)"><i class="fa fa-times"></i>Desmarcar Carta</button>
                  <button v-else class="dropdown-item" v-on:click="changeLetterStatus(campaigndonor.id, 1)"><i class="fa fa-check"></i> Marcar Carta</button>
                  <button v-if="campaigndonor.be_the_match == 1" class="dropdown-item" v-on:click="changeBeTheMatchStatus(campaigndonor.id, 0)"><i class="fa fa-times"></i>Desmarcar Be The Match</button>
                  <button v-else class="dropdown-item" v-on:click="changeBeTheMatchStatus(campaigndonor.id, 1)"><i class="fa fa-check"></i> Marcar Be The Match</button>
                </div>
              </div>
            </td>
          </tr>
          <tr v-if="campaigndonors.length == 0">
            <td colspan="11">No se encontraron registros</td>
          </tr>
        </paginate>
      </table>
    </div>
    <paginate-links v-if="campaigndonors.length > 0" class="d-flex justify-content-center" for="campaigndonors" :simple="{prev: 'Ante', next: 'Sig'}" :classes="{'ul': 'pagination', 'li': 'page-item', 'a': 'page-link'}"></paginate-links>
    <label>
      Pre Donadores suscritos {{this.campaigntemporaldonors.length}}
    </label>
    <div class="text-center">
      <p class="text-danger">Buscar pre donador por...</p>
    </div>
    <div class="form-row">
      <div class="form-group col-md-3">
        <label>No. pre Donador</label>
        <input class="form-control" type="text" v-model="typedId" v-on:keyup="searchTemporalDonor(1)">
        <div class="autocomplete-items" v-if="selectedTemporalDonor">
          <div class="autocomplete-item" v-on:click="addTemporalDonorInCampaign(selectedTemporalDonor.id)" > <i class="fa fa-user mx-1"></i> {{selectedTemporalDonor.name}} {{selectedTemporalDonor.parental_surname}} {{selectedTemporalDonor.maternal_surname}}</div>
        </div>
        <div class="autocomplete-items" v-if="isSearchTemporalIdNull">
          <div class="p-2 text-center"> <p>Parece que no hay nada para mostrar :(</p><p>¿No encuentra lo que busca?</p><button data-toggle="modal" data-target="#modalDonors" data-backdrop="static" data-keyboard="false" class="btn btn-primary btn-md" v-on:click="resetFilter()">Registra uno nuevo <i class="fa fa-plus mx-1"></i></button></div>
        </div>
      </div>
      <div class="form-group col-md-8">
        <label>Nombre o apellidos</label>
        <input class="form-control" type="text" v-model="search" v-on:keyup="searchTemporalDonor(2)">
        <div class="autocomplete-items" v-if="temporalDonors.length > 0">
          <div class="autocomplete-item" v-for="(donor, index) in temporalDonors" :key="index" v-on:click="addTemporalDonorInCampaign(donor.id)" > <i class="fa fa-user mx-1"></i> {{donor.name}} {{donor.parental_surname}} {{donor.maternal_surname}} <strong>/</strong> {{donor.city.name}}<strong>-</strong>{{donor.state.name}}</div>
        </div>
        <div class="autocomplete-items" v-if="isSearchTemporalNull">
          <div class="p-2 text-center"> <p>Parece que no hay nada para mostrar :(</p><p>¿No encuentra lo que busca?</p><button data-toggle="modal" data-target="#modalDonors" data-backdrop="static" data-keyboard="false" class="btn btn-primary btn-md" v-on:click="resetFilter()">Registra uno nuevo <i class="fa fa-plus mx-1"></i></button></div>
        </div>
      </div>
      <div class="form-group col-md-1 align-self-end">
        <a href="/temporal_donors/create" class="btn btn-primary">Registrar</a>
      </div>
    </div>
    <h5>Pre Donadores</h5>
    <div class="table-responsive-sm">
      <table class="table table-hover table-striped table-sm text-center">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">T.S.</th>
            <th scope="col">Género</th>
            <th scope="col">Teléfono</th>
            <th scope="col">Correo electrónico</th>
            <th scope="col">HT</th>
            <th scope="col">Confirmó</th>
            <th scope="col">Asistió</th>
            <th scope="col">Donó</th>
            <th scope="col">Acciones</th>
          </tr>
        </thead>
        <paginate name="campaigntemporaldonors" :list="campaigntemporaldonors" :per="15" tag="tbody">
          <tr v-for="(campaigntemporaldonor, index) in paginated('campaigntemporaldonors')" :key="index">
            <th scope="row">{{index + 1}}</th>
            <td>{{campaigntemporaldonor.name}} {{campaigntemporaldonor.parental_surname}} {{campaigntemporaldonor.maternal_surname}}</td>
            <td>{{bloods[campaigntemporaldonor.bloodtype]}}</td>
            <td>{{genders[campaigntemporaldonor.gendertype]}}</td>
            <td>{{campaigntemporaldonor.mobile}}</td>
            <td>{{campaigntemporaldonor.email}}</td>
            <td @dblclick="showTimePicker(campaigntemporaldonor)" v-if="campaigntemporaldonor.pivot.time_turn != null">{{campaigntemporaldonor.pivot.time_turn}}</td>
            <td v-else>
              <select v-model="selectedTime" class="form-control" v-on:change="updateTimeTurn(campaigntemporaldonor)">
                <option :value="time" v-for="(time, index) in listTime" :key="index">{{time}}</option>
              </select>
            </td>
            <td>
              <i v-if="campaigntemporaldonor.pivot.is_confirmed" class="fa fa-check text-success" aria-hidden="true"></i>
              <i v-else class="fa fa-times text-danger" aria-hidden="true"></i>
            </td>
            <td>
              <i v-if="campaigntemporaldonor.pivot.donor_attended" class="fa fa-check text-success" aria-hidden="true"></i>
              <i v-else class="fa fa-times text-danger" aria-hidden="true"></i>
            </td>
            <td>
              <i v-if="campaigntemporaldonor.pivot.donor_donated" class="fa fa-check text-success" aria-hidden="true"></i>
              <i v-else class="fa fa-times text-danger" aria-hidden="true"></i>
            </td>
            <td>
              <div class="btn-group dropleft">
                <button type="button" class="btn btn-secondary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Acción
                </button>
                <div class="dropdown-menu">
                  <button class="dropdown-item" v-if="campaigntemporaldonor.pivot.is_confirmed" v-on:click="changeConfirmStatus(campaigntemporaldonor, 0)"  data-toggle="tooltip" data-placement="right" title="Marcar como no asistió"> <i class="fa fa-times"></i>Desmarcar confirmado</button>
                  <button class="dropdown-item" v-else v-on:click="changeConfirmStatus(campaigntemporaldonor, 1)" data-toggle="tooltip" data-placement="right" title="Marcar como asistió"><i class="fa fa-check"></i>Marcar confirmado</button> 
                  <button class="dropdown-item" v-if="campaigntemporaldonor.pivot.donor_attended" v-on:click="changeStatusDonationAttended(campaigntemporaldonor, 0, 0)"  data-toggle="tooltip" data-placement="right" title="Marcar como no asistió"> <i class="fa fa-times"></i> Marcar como no asistió</button>
                  <button class="dropdown-item" v-else v-on:click="changeStatusDonationAttended(campaigntemporaldonor, 1, 0)" data-toggle="tooltip" data-placement="right" title="Marcar como asistió"><i class="fa fa-check"></i> Marcar como asistió</button> 
                  <div v-if="campaigntemporaldonor.pivot.donor_attended">
                    <button class="dropdown-item" v-if="campaigntemporaldonor.pivot.donor_donated"  v-on:click="changeStatusDonation(campaigntemporaldonor, 0, 0)" data-toggle="tooltip" data-placement="right" title="Marcar como donó"><i class="fa fa-times"></i>Marcar como no donó</button>
                    <button class="dropdown-item" v-else  v-on:click="changeStatusDonation(campaigntemporaldonor, 1, 0)" data-toggle="tooltip" data-placement="right" title="Marcar como no donó"><i class="fa fa-check"></i>Marcar como donó</button>
                  </div>
                  <button class="dropdown-item" v-on:click="deleteDonorFromCampaign(campaigntemporaldonor)"><i class="fa fa-trash"></i> Borrar</button>
                  <a :href="'/temporal_donors/'+campaigntemporaldonor.id" class="dropdown-item" target="__blank"><i class="fa fa-eye"></i> Ver pre donador</a>
                  <button v-if="campaigntemporaldonor.letter == 1" class="dropdown-item" v-on:click="changeLetterStatusTemporalDonor(campaigntemporaldonor.id, 0)"><i class="fa fa-times"></i>Desmarcar Carta</button>
                  <button v-else class="dropdown-item" v-on:click="changeLetterStatusTemporalDonor(campaigntemporaldonor.id, 1)"><i class="fa fa-check"></i> Marcar Carta</button>
                  <button v-if="campaigntemporaldonor.be_the_match == 1" class="dropdown-item" v-on:click="changeBeTheMatchStatusTemporalDonor(campaigntemporaldonor.id, 0)"><i class="fa fa-times"></i>Demarcar Be The Match</button>
                  <button v-else class="dropdown-item" v-on:click="changeBeTheMatchStatusTemporalDonor(campaigntemporaldonor.id, 1)"><i class="fa fa-check"></i> Marcar Be The Match</button>
                </div>
              </div>
            </td>
          </tr>
          <tr v-if="campaigntemporaldonors.length == 0">
            <td colspan="11">No se encontraron registros</td>
          </tr>
        </paginate>
      </table>
    </div> 
    <paginate-links v-if="campaigntemporaldonors.length > 0" class="d-flex justify-content-center" for="campaigntemporaldonors" :simple="{prev: 'Ante', next: 'Sig'}" :classes="{'ul': 'pagination', 'li': 'page-item', 'a': 'page-link'}"></paginate-links>
  </div>
</template>

<script>
  import Alert from './ModalDonorsComponent.vue';
  export default {
  props: ['campaignid', 'gendertypes', 'bloodtypes'],
  data(){
    return {
      donors: [],
      selectedDonor: '',
      temporalDonors: [],
      selectedTemporalDonor: '',
      campaigndonors: [],
      campaigntemporaldonors: [],
      bloods: [],
      genders: [],
      statusAttend: 0,
      paginate: ['campaigndonors', 'campaigntemporaldonors'],
      listTime :[],
      isButtonActive: true,
      selectedTime: '',
      lastSelected: '',
      lastTimeSelected: '',
      search: '',
      isSearchNull: false,
      isSearchIdNull: false,
      isSearchTemporalNull: false,
      isSearchTemporalIdNull: false,
      typedId: '',
      autocompleteDonorToShow: 0
    }
  },
  mounted() {
    this.bloods = this.bloodtypes;
    this.genders = this.gendertypes;
    this.getDonorsInCampaign();
    this.createHoursDropdown();
  },
  methods: {
    getDonorsInCampaign:function(){
      axios.post('/campaign/donors/list', {campaignId: this.campaignid})
      .then((response)=>{
        this.campaigndonors = response.data.campaigndonor;
        this.campaigntemporaldonors = response.data.campaigntemporaldonors;
      });
    },
    changeStatusDonationAttended:function(index, value, donorstatus){
    axios.patch(`/donor/campaign/${this.campaignid}/donation`,{ donor_id: index.id, status: value, attribute:1, donor_status: donorstatus})
      .then(response => {
        index.pivot.donor_attended = value;
        this.statusAttend = value;
        if(value==1){
          toastNotification('success', 'Asistencia del donador marcada correctamente');
          this.getDonorsInCampaign();
        }else{
          toastNotification('success', 'Falta del donador marcada correctamente');
          index.pivot.donor_donated = value;
        }
      }).catch(error =>{
      })
    },
    createHoursDropdown:function(){
      axios.get(`/get/hours/campaign/${this.campaignid}`)
      .then((response)=>{
        this.listTime = response.data;
      });
    },
    showTimePicker:function(campaigndonor){
      if(this.lastSelected){
        this.lastSelected.pivot.time_turn = this.lastTimeSelected;
        this.selectedTime = '';
      }
      this.lastSelected = campaigndonor;
      this.lastTimeSelected = campaigndonor.pivot.time_turn;
      campaigndonor.pivot.time_turn = null;
    },
    updateTimeTurn:function(campaignDonor){
      axios.post(`/hours/update/campaign/${campaignDonor.pivot.id}`,{
        'time_turn' : this.selectedTime
      }).then((response)=>{
        if(response.data.code == 200){
          toastNotification('success',response.data.message);
          this.resetAll();
        }else{
          toastNotification('error',response.data.message);
          this.resetAll();
        }
      })
      .catch((err)=>{
        errorNotification('Algo salió mal intente de nuevo, más tarde');
        this.resetAll();
      });
    },
    resetAll:function(){
      this.isButtonActive = false;
      this.lastSelected = '';
      this.selectedTime= '';
      this.lastselectedTime= '';
      this.getDonorsInCampaign();
    },
    deleteDonorFromCampaign: async function(donor){
      const userResponse = await questionNotification('¿Está seguro que quiere eliminar el donador de la campaña?', `Se procederá a borrar el donador ${donor.name} de la camapaña`, 'Sí, estoy seguro');
      if(userResponse){
        axios.delete(`/campaign/donor/delete/${donor.pivot.id}`)
        .then((response)=>{
          if(response.data.code == 200){
            successNotification(response.data.message);
            this.resetAll();
          }else{
            errorNotification(response.data.message);
          }
        }).catch((err)=>{
          errorNotification(`Algo salió mal, intente más trade. Código de error ${err.response}`)
        });
      }
    },
    changeStatusDonation: async function(index, value, donorstatus){
      let notificationResponseUser = true;
      if(donorstatus == 0){
        notificationResponseUser = await questionNotification('¿Esta seguro que desea marcar como donación relizada al pre donador?', 'Una vez marcado como donación realizada el pre donador pasará a ser un donador registrado.', 'Sí estoy seguro')
      }
      if(notificationResponseUser){
        axios.patch(`/donor/campaign/${this.campaignid}/donation`,{ donor_id: index.id, status: value, attribute:2, donor_status: donorstatus})
        .then(response => {
          index.pivot.donor_donated = value;
          this.statusAttend = value;
          if(value==1){
            toastNotification('success', 'Donación del donador marcada correctamente');
            this.getDonorsInCampaign();
          }else{
            toastNotification('success', 'Donación faltante del donador marcada correctamente');
          }
        }).catch((error) =>{
          errorNotification(`Algo salió mal, intente más trade. Código de error ${err.response}`)
        })
      }
    },
    searchDonor: function(){
      this.isSearchNull = false;
      this.isSearchIdNull = false
      if(this.search){
        axios.get('/api/donors/search/',{
          params:{
            search: this.search
          }
        })
        .then((response)=>{
          this.isSearchNull = false;
          this.autocompleteDonorToShow = 2;
          this.donors = response.data;
          if(this.donors.length == 0){
            setTimeout(() => {
              this.isSearchNull = true;
            }, 500);
          }
        });
      }else{
        this.donors = [];
      }

      if(this.typedId){
        axios.get('/api/donors/search/',{
          params:{
            donorid: this.typedId,
          }
        })
        .then((response)=>{
          this.isSearchIdNull = false;
          this.autocompleteDonorToShow = 1;
          this.selectedDonor = response.data;
          if(this.selectedDonor.length == 0){
            setTimeout(() => {
              this.isSearchIdNull = true;
            }, 500);
          }
        });
      }else{
        this.selectedDonor = '';
      }
    },
    searchTemporalDonor: function(){
      this.isSearchTemporalNull = false;
      this.isSearchTemporalIdNull = false
      if(this.search){
        axios.get('/api/temporal_donors/search/',{
          params:{
            search: this.search
          }
        })
        .then((response)=>{
          this.isSearchTemporalNull = false;
          this.autocompleteDonorToShow = 2;
          this.temporalDonors = response.data;
          if(this.temporalDonors.length == 0){
            setTimeout(() => {
              this.isSearchTemporalNull = true;
            }, 500);
          }
        });
      }else{
        this.temporalDonors = [];
      }

      if(this.typedId){
        axios.get('/api/temporal_donors/search/',{
          params:{
            donorid: this.typedId,
          }
        })
        .then((response)=>{
          this.isSearchTemporalIdNull = false;
          this.autocompleteDonorToShow = 1;
          this.selectedTemporalDonor = response.data;
          if(this.selectedTemporalDonor.length == 0){
            setTimeout(() => {
              this.isSearchTemporalIdNull = true;
            }, 500);
          }
        });
      }else{
        this.selectedTemporalDonor = '';
      }
    },
    addDonorInCampaign: function(idDonor){
      axios.post('/campaigns/donors/involve/manually', {
        campaign: this.campaignid,
        donor: idDonor
      }).then((response)=>{
        if(response.data['status'] == 200){
          toastNotification('success', response.data['message']);
          if(this.campaigndonors.length == 0){
            setTimeout(() => {
              window.location.reload();
            }, 500);
          }else{
            this.getDonorsInCampaign();
          }
            this.resetFilter();
        }else{
          toastNotification('info', response.data['message']);
        }
      });
    },
    addTemporalDonorInCampaign: function(idDonor){
      axios.post('/campaigns/temporal_donors/involve/manually', {
        campaign: this.campaignid,
        donor: idDonor
      }).then((response)=>{
        if(response.data['status'] == 200){
          toastNotification('success', response.data['message']);
          if(this.campaigntemporaldonors.length == 0){
            setTimeout(() => {
              window.location.reload();
            }, 500);
          }else{
            this.getDonorsInCampaign();
          }
          this.resetFilter();
        }else{
          toastNotification('info', response.data['message']);
        }
      });
    },
    resetFilter: function(){
      this.search = '';
      this.typedId = '';
      this.donors = [];
      this.selectedDonor = '';
      this.temporalDonors = [];
      this.selectedTemporalDonor = '';
      this.isSearchIdNull = false;
      this.isSearchNull = false;
      this.isSearchTemporalIdNull = false;
      this.isSearchTemporalNull = false;
    },
    changeLetterStatus:function(donorId, statusToChange){
      axios.post(`/api/donor/change/letter/donor/${donorId}/status/${statusToChange}`)
      .then((response)=>{
        if(response.data.code == 200){
          toastNotification('success', response.data.message);
          this.getDonorsInCampaign();
        }else{
          toastNotification('error', response.data.message);
        }
      })
      .catch((err)=>{
        errorNotification(`Algo salió mal intente más tarde ${err.data.response}`)
      });
    }, 
    changeBeTheMatchStatus:function(donorId, statusToChange){
      axios.post(`/api/donor/change/be-the-match/donor/${donorId}/status/${statusToChange}`)
      .then((response)=>{
        if(response.data.code == 200){
          toastNotification('success', response.data.message);
          this.getDonorsInCampaign();
        }else{
          toastNotification('error', response.data.message);
        }
      })
      .catch((err)=>{
        errorNotification(`Algo salió mal intente más tarde ${err.data.response}`)
      });
    },
    changeLetterStatusTemporalDonor:function(donorId, statusToChange){
      axios.post(`/api/temporal_donor/change/letter/temporal_donor/${donorId}/status/${statusToChange}`)
      .then((response)=>{
        if(response.data.code == 200){
          toastNotification('success', response.data.message);
          this.getDonorsInCampaign();
        }else{
          toastNotification('error', response.data.message);
        }
      })
      .catch((err)=>{
        errorNotification(`Algo salió mal intente más tarde ${err.data.response}`)
      });
    }, 
    changeBeTheMatchStatusTemporalDonor:function(donorId, statusToChange){
      axios.post(`/api/temporal_donor/change/be-the-match/temporal_donor/${donorId}/status/${statusToChange}`)
      .then((response)=>{
        if(response.data.code == 200){
          toastNotification('success', response.data.message);
          this.getDonorsInCampaign();
        }else{
          toastNotification('error', response.data.message);
        }
      })
      .catch((err)=>{
        errorNotification(`Algo salió mal intente más tarde ${err.data.response}`)
      });
    },
    changeConfirmStatus:function(campaigndonor, status){
      axios.post('/change/confirmed/status/campaign',{
        'campaigndonor': campaigndonor.pivot.id,
        'status': status
      })
      .then((response)=>{
        if(response.data.code == 200){
          toastNotification('success', response.data.message);
          this.getDonorsInCampaign();
        }else{
          toastNotification('error', response.data.message);
        }
      })
      .catch((err)=>{
        errorNotification(`Algo salió mal intente más tarde ${err.data.response}`)
      });
    }
  }
}
</script>
    