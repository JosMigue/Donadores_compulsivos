<template>
  <div>
    <div class="modal fade" id="modalPreDonorsAsign" tabindex="-1" role="dialog" aria-labelledby="modalPreDonorsAsignTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document" style="transition: .2s;">
        <div class="modal-content" >
          <div class="modal-header">
            <h5 class="modal-title" id="modalPreDonorsAsignTitle">Asignar predonador a otra campaña</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-12 col-lg-6 d-flex flex-column justify-content-center">
                <div class="text-center pr-2 pt-1">Pre donador<i class="fa fa-user mx-1"></i></div>
                <div class="d-flex justify-content-center"><img :src="'/'+predonor.profile_picture" width="50" height="50" class="rounded-circle"></div>
                <div class="text-center"> <span class="name">{{predonor.name}} {{predonor.parental_surname}} {{predonor.maternal_surname}}</span>
                  <p class="mail">{{predonor.email}}</p>
                </div>
                <div class="text-center"> <span class="total d-block pt-2">Teléfono</span> <span class="money">{{predonor.mobile}}</span> </div>
                <div class="text-center"> <span class="total d-block pt-2">Fecha de registro</span> <span class="money">{{moment(predonor.created_at).format('DD-MM-Y')}}</span> </div>
                <div class="text-center align-items-center d-flex justify-content-center pt-2 pb-2"><span class="details"><a class="btn btn-link" :href="'/temporal_donors/'+predonor.id">Ver más</a></span><i class="mdi mdi-arrow-right right pl-1"></i></div>
              </div>
              <div class="col-12 col-lg-6 d-flex flex-column justify-content-center">
                <label for="available_campaigns">Campañas disponibles</label>
                <select class="form-control" name="available_campaigns" id="available_campaigns" v-model="selectedCampaign">
                  <option v-if="availablecampaigns.length == 0" value="" selected disabled>No se encontraron campañas disponibles :( </option>
                  <option v-else value="" selected disabled >Seleccione una campaña...</option>
                  <option :value="availableCampaign.id" v-for="(availableCampaign, index) in availablecampaigns" :key="index">{{getTranslatedName(availableCampaign.name)}} | Fecha: {{moment(availableCampaign.date_start).format('DD-MM-Y')}}</option>
                </select> 
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" v-on:click="resetData()" data-dismiss="modal">Cancelar</button>
            <button v-if="selectedCampaign" v-on:click="asignCampaignPreDonor()" class="btn btn-success animate__animated animate__fadeInRight">Asignar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import moment from 'moment';
moment.locale('es-mx');
export default {
  props: ['predonor', 'campaign', 'availablecampaigns'],
  data() {
    return {
       selectedCampaign: ''
    }
  },
  methods: {
    moment: function (date) {
      return moment(date);
    },
    date: function (date) {
      return moment(date).format('MMMM Do YYYY, h:mm:ss a');
    },
    getTranslatedName:function(campaignName){
      switch (campaignName) {
        case 'Donating love':
          return 'Donando Amor';
          break;
        case 'Donors students':
          return 'Donadores estudiando';
          break;
        case 'Donors workers':
          return 'Donadores trabajando';
          break;
        default:
          return 'Nombre no añadido';
          break;
      }
    },
    asignCampaignPreDonor:function(){
      axios.post('/campaigns/temporal_donors/involve/manually', {
        'donor':this.predonor.id,
        'campaign': this.selectedCampaign
      })
      .then((response)=>{
        if(response.data.status == 200){
          toastNotification('success', response.data.message);
        }else{
          toastNotification('error', response.data.message);
        }
      })
      .catch((err)=>{
        errorNotification(`Ha ocurrido un error al asignar el predonador a la campaña, intente más tarde. ${err}`);
      });
    },
    resetData:function(){
      this.selectedCampaign = '';
    }
  },
  filters: {
    moment: function (date) {
      return moment(date).format('MMMM Do YYYY, h:mm:ss a');
    }
  }
  
}
</script>