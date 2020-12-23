<template>
  <div>
    <div class="modal fade" id="modalDonors" tabindex="-1" role="dialog" aria-labelledby="modalDonorsTitle" aria-hidden="true">
      <div class="modal-dialog" v-bind:class="{'modal-lg': donorIsRegistered, 'modal-lg': donorIsNotRegistered, 'modal-sm': isVisibleContent}" role="document" style="transition: .2s;">
        <div class="modal-content" >
          <div class="modal-header">
            <h5 class="modal-title" id="modalDonorsTitle">Agregar donador a la campaña</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div v-if="isVisibleContent" >
              <p class="text-danger text-center">¿De dónde desea agregar donadores?</p>
              <div class="row">
                <div class="col-12 col-lg-6 d-flex justify-content-center">
                  <button v-on:click="isNewDonor()" class="btn btn-primary btn-md">No registrado</button>
                </div>
                <div class="col-12 col-lg-6 d-flex justify-content-center">
                  <button v-on:click="isRegisteredDonor()" class="btn btn-primary btn-md">Registrado</button>
                </div>
              </div>
            </div>
            <div v-if="donorIsRegistered" >
              <p class="text-danger text-center">Registrado</p>
              <p class="text-danger text-center">De clic en el donador que desea agregar</p>
              <input type="text" class="form-control" placeholder="Buscar donador..." v-model="search" v-on:keyup="searchDonor()">
              <div class="autocomplete-items" v-for="(donor, index) in donors" :key="index">
                <div class="autocomplete-item" v-on:click="addDonorInCampaign(donor.id)" > <i class="fa fa-user mx-1"></i> {{donor.name}} {{donor.parental_surname}} {{donor.maternal_surname}} <strong>/</strong> {{donor.city.name}}<strong>-</strong>{{donor.state.name}}</div>
              </div>
            </div>
            <div v-if="donorIsNotRegistered" >
              <p class="text-danger text-center">No Registrado</p>
              <p class="text-danger text-center">Ingrese los datos aquí mostrados</p>
              <create-donor-component :genders = genders :bloods = blood :campaign = campaign v-on:add-not-registered-donor-in-campaign-event="reloadDonors();"></create-donor-component>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" v-on:click="resetValues()" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import CreateDonorComponent from './CreateDonorComponent.vue';
export default {
  components: { CreateDonorComponent },
  props: ['campaign', 'genders', 'blood'],
    data() {
        return {
          donorIsRegistered: false,
          donorIsNotRegistered: false,
          isVisibleContent:true,
          donors: [],
          search: ''
        }
    },
    methods: {
      reloadDonors:function(){
        this.$emit('added-donor-campaign-event');
      },
      isNewDonor: function(){
        this.isVisibleContent = false;
        this.donorIsRegistered =  false;
        this.donorIsNotRegistered =  true;
      },
      isRegisteredDonor: function(){
        this.isVisibleContent = false;
        this.donorIsNotRegistered =  false;
        this.donorIsRegistered =  true;
      },
      resetValues: function(){
        this.isVisibleContent = true;
        this.donorIsNotRegistered =  false;
        this.donorIsRegistered =  false;
      },
      resetFilter: function(){
        this.search = '',
        this.donors = []
      },
      searchDonor: function(){
        if(this.search){
          axios.get('/api/donors/search/',{
            params:{
              search: this.search
            }
          })
          .then((response)=>{
            this.donors = response.data;
          });
        }else{
          this.donors = [];
        }
      },
      addDonorInCampaign: function(idDonor){
        axios.post('/campaigns/donors/involve/manually', {
          campaign: this.campaign,
          donor: idDonor
        }).then((response)=>{
          if(response.data['status'] == 200){
            this.$emit('added-donor-campaign-event');
            toastNotification('success', response.data['message']);
            this.resetFilter();
          }else{
            toastNotification('info', response.data['message']);
          }
        });
      },
    },
}
</script>