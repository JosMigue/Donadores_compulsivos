<template>
    <div>
      <div class="modal fade" id="modalAddIndividualDonation" tabindex="-1" role="dialog" aria-labelledby="modalAddIndividualDonationTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
          <div class="modal-content ">
            <div class="modal-header">
              <h5 class="modal-title" id="modalAddIndividualDonationTitle">Agregar donación individual</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" v-on:click="resetForm()">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="alert alert-danger alert-dismissible fade show" role="alert" v-if="errors">
                <ul v-for="(error, index) in errors" :key="index" >
                  <li>{{error}}</li>
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="row">
                <div class="col-12 col-lg-6">
                  <label for="">Lugar</label>
                  <select class="form-control" v-model="selectectedBloodBank" v-on:change="getBloodBankInfo()">
                    <option value="" selected disabled>Seleccione un banco de sangre...</option>
                    <option :value="bloodbank" v-for="(bloodbank, index) in bloodbanks" :key="index">{{bloodbank.name}}</option>
                  </select>
                </div>
                <div class="col-12 col-lg-6">
                  <label for="">Estado</label>
                  <input type="text" v-model="state" class="form-control" readonly placeholder="Este campo es automatico">
                </div>
                <div class="col-12 col-lg-6">
                  <label for="">Municipio</label>
                  <input type="text" v-model="city" class="form-control" readonly placeholder="Este campo es automatico">
                </div>
                <div class="col-12 col-lg-6">
                  <label for="">Fecha de donación</label>
                  <input type="date" v-model="date_donation" class="form-control">
                </div>
                <div class="col-12 col-lg-6">
                  <label for="">Hora donación</label>
                  <input type="time" v-model="time_donation" class="form-control">
                </div>
                <div class="col-12 col-lg-6">
                  <label for="">Tipo de donación</label>
                  <select class="form-control" name="" id="" v-model="type_donation">
                    <option value="" selected disabled>Seleccione un tipo de doanción</option>
                    <option value="D1">Sangre</option>
                    <option value="D2">Aféresis</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" v-on:click="resetForm()" data-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-success" v-on:click="saveIndividualDonation()">Guardar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
export default {
  props:['currentdonorid'],
  data() {
    return {
      bloodbanks: [],
      selectectedBloodBank: '',
      selectedState: '',
      selectedCity: '',
      city: '',
      state: '',
      date_donation: '',
      time_donation: '',
      type_donation: '',
      errors: ''
    }
  },
  mounted() {
    this.getBloodBanks();
  },
  methods: {
    getBloodBanks:function(){
      axios.get('/api/bloodbanks')
      .then((response)=>{
        this.bloodbanks = response.data;
      });
    },
    getBloodBankInfo: function(){
      this.city = this.selectectedBloodBank.city.name;
      this.state = this.selectectedBloodBank.state.name;
      this.selectedCity = this.selectectedBloodBank.city.id;
      this.selectedState = this.selectectedBloodBank.state.id;
    },
    saveIndividualDonation:function(){
      axios.post('/individual-donations',{
        'bloodbank_id': this.selectectedBloodBank.id,
        'donor_id': this.currentdonorid,
        'date_donation': this.date_donation,
        'time_donation': this.time_donation,
        'donationtype': this.type_donation
      }).then((response)=>{
        if(response.data.code == 200){
          this.$emit('new-individual-donation');
          this.resetForm();
          toastNotification('success',response.data.message);
        }else if(response.data.code == 500){
          toastNotification('error',response.data.message);
        }
      }).catch((err)=>{
        this.errors = err.response.data.errors;
      })
    },
    resetForm:function(){
      this.selectectedBloodBank= '';
      this.selectedState= '';
      this.selectedCity= '';
      this.city= '';
      this.state= '';
      this.date_donation= '';
      this.time_donation= '';
      this.type_donation= '';
      this.error= '';
    }
  },
}
</script>