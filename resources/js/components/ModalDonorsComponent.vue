<template>
  <div>
    <div class="modal fade" id="modalDonors" tabindex="-1" role="dialog" aria-labelledby="modalDonorsTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document" style="transition: .2s;">
        <div class="modal-content" >
          <div class="modal-header">
            <h5 class="modal-title" id="modalDonorsTitle">Agregar un pre donador a la campaña</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" v-on:click="resetValues()">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <create-donor-component :genders = genders :bloods = blood :campaign = campaign v-on:add-not-registered-donor-in-campaign-event="reloadDonors();"></create-donor-component>
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
        this.search = '';
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