<template>
  <div>
    <label>
      Donadores suscritos {{this.campaigndonors.length}}
    </label>
    <div class="d-flex justify-content-center">
      <button type="button" class="is-link-red" data-toggle="modal" data-target="#modalDonors" data-backdrop="static" data-keyboard="false">
        Agregar donador <i class="fa fa-plus mx-1" aria-hidden="true"></i>
      </button>
    </div>
    <modal-donor-component :campaign = campaignid v-on:added-donor-campaign-event="getDonorsInCampaign()" :genders = gendertypes :blood = bloodtypes></modal-donor-component>
    <div class="table-responsive">
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
            <th scope="col">Asistió</th>
            <th scope="col">Donó</th>
            <th scope="col">Acciones</th>
          </tr>
        </thead>
        <paginate name="campaigndonors" :list="campaigndonors" :per="15" tag="tbody">
          <tr v-for="(campaigndonor, index) in paginated('campaigndonors')" :key="index">
            <th scope="row">{{index + 1}}</th>
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
              <i v-if="campaigndonor.pivot.donor_attended" class="fa fa-check text-success" aria-hidden="true"></i>
              <i v-else class="fa fa-times text-danger" aria-hidden="true"></i>
            </td>
            <td>
              <i v-if="campaigndonor.pivot.donor_donated" class="fa fa-check text-success" aria-hidden="true"></i>
              <i v-else class="fa fa-times text-danger" aria-hidden="true"></i>
            </td>
            <td>
              <div class="btn-group dropleft">
                <button type="button" class="btn btn-secondary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Acción
                </button>
                <div class="dropdown-menu">
                  <button class="dropdown-item" v-if="campaigndonor.pivot.donor_attended" v-on:click="changeStatusDonationAttended(campaigndonor, 0)"  data-toggle="tooltip" data-placement="right" title="Marcar como no asistió"> <i class="fa fa-times"></i> Marcar como no asistió</button>
                  <button class="dropdown-item" v-else v-on:click="changeStatusDonationAttended(campaigndonor, 1)" data-toggle="tooltip" data-placement="right" title="Marcar como asistió"><i class="fa fa-check"></i> Marcar como asistió</button> 
                  <div v-if="campaigndonor.pivot.donor_attended">
                    <button class="dropdown-item" v-if="campaigndonor.pivot.donor_donated"  v-on:click="changeStatusDonation(campaigndonor, 0)" data-toggle="tooltip" data-placement="right" title="Marcar como donó"><i class="fa fa-times"></i>Marcar como no donó</button>
                    <button class="dropdown-item" v-else  v-on:click="changeStatusDonation(campaigndonor, 1)" data-toggle="tooltip" data-placement="right" title="Marcar como no donó"><i class="fa fa-check"></i>Marcar como donó</button>
                  </div>
                  <button class="dropdown-item" v-on:click="deleteDonorFromCampaign(campaigndonor)"><i class="fa fa-trash"></i> Borrar</button>
                  <a :href="'/donors/'+campaigndonor.id" class="dropdown-item" target="__blank"><i class="fa fa-eye"></i> Ver donador</a>
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
  </div>
</template>

<script>
  import Alert from './ModalDonorsComponent.vue';
  export default {
  props: ['campaignid', 'gendertypes', 'bloodtypes'],
  data(){
    return {
      campaigndonors: [],
      bloods: [],
      genders: [],
      statusAttend: 0,
      paginate: ['campaigndonors'],
      listTime :[],
      isButtonActive: true,
      selectedTime: '',
      lastSelected: '',
      lastTimeSelected: ''
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
        this.campaigndonors = response.data;
      });
    },
    changeStatusDonationAttended:function(index, value){
    axios.patch(`/donor/campaign/${this.campaignid}/donation`,{ donor_id: index.id, status: value, attribute:1})
      .then(response => {
        index.pivot.donor_attended = value;
        this.statusAttend = value;
        if(value==1){
          toastNotification('success', 'Asistencia del donador marcada correctamente');
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
    changeStatusDonation:function(index, value){
    axios.patch(`/donor/campaign/${this.campaignid}/donation`,{ donor_id: index.id, status: value, attribute:2})
      .then(response => {
        index.pivot.donor_donated = value;
        this.statusAttend = value;
        if(value==1){
          toastNotification('success', 'Donación del donador marcada correctamente');
        }else{
          toastNotification('success', 'Donación faltante del donador marcada correctamente');
        }
      }).catch((error) =>{
      })
    }
  }
}
</script>
    