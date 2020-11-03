<template>
    <div>
        <div class="table-responsive">
        <table class="table table-hover table-striped table-sm text-center">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nombre</th>
              <th scope="col">Tipo de sangre</th>
              <th scope="col">Genero</th>
              <th scope="col">Teléfono</th>
              <th scope="col">Correo electrónico</th>
              <th scope="col">Turno</th>
              <th scope="col">Asistió</th>
              <th scope="col">Donó</th>
              <th scope="col">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(campaigndonor, index) in campaigndonors.data" :key="index">
              <th scope="row">{{index + 1}}</th>
              <td>{{campaigndonor.name}} {{campaigndonor.parental_surname}} {{campaigndonor.maternal_surname}}</td>
              <td>{{bloods[campaigndonor.bloodtype]}}</td>
              <td>{{genders[campaigndonor.gendertype]}}</td>
              <td>{{campaigndonor.mobile}}</td>
              <td>{{campaigndonor.email}}</td>
              <td>{{campaigndonor.pivot.turn}}</td>
              <td>
                  <i v-if="campaigndonor.pivot.donor_attended" class="fa fa-check text-success" aria-hidden="true"></i>
                  <i v-else class="fa fa-times text-danger" aria-hidden="true"></i>
              </td>
              <td>
                  <i v-if="campaigndonor.pivot.donor_donated" class="fa fa-check text-success" aria-hidden="true"></i>
                  <i v-else class="fa fa-times text-danger" aria-hidden="true"></i>
              </td>
              <td>
                <div class="row no-gutters">
                  <div class="col">
                    <button v-if="campaigndonor.pivot.donor_attended" v-on:click="changeStatusDonationAttended(index, 0)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="right" title="Marcar como no asistió">Marcar como no asistió</button>
                    <button  v-else class="btn btn-success btn-sm" v-on:click="changeStatusDonationAttended(index, 1)" data-toggle="tooltip" data-placement="right" title="Marcar como asistió">Marcar como asistió</button>
                  </div>
                  <div class="col" v-if="campaigndonor.pivot.donor_attended">
                    <button  v-if="campaigndonor.pivot.donor_donated" class="btn btn-danger btn-sm" v-on:click="changeStatusDonation(index, 0)" data-toggle="tooltip" data-placement="right" title="Marcar como donó">Marcar como no donó</button>
                    <button  v-else class="btn btn-success btn-sm" v-on:click="changeStatusDonation(index, 1)" data-toggle="tooltip" data-placement="right" title="Marcar como no donó">Marcar como donó</button>
                  </div>
                </div>
              </td>
            </tr>
            <tr v-if="campaigndonors.data && campaigndonors.data.length == 0">
              <td colspan="9">No se encontraron registros</td>
            </tr>
          </tbody>
        </table>
      </div> 
    </div>
</template>

<script>
export default {
  props: ['campaigndonorsarray', 'campaignid', 'gendertypes', 'bloodtypes'],
  data(){
    return {
      campaigndonors: [],
      bloods: [],
      genders: [],
      statusAttend: 0,
    }
  },
  mounted() {
    if(this.campaigndonorsarray){
      this.campaigndonors = this.campaigndonorsarray;
      this.bloods = this.bloodtypes;
      this.genders = this.gendertypes;
    }
  },
  methods: {
    changeStatusDonationAttended:function(index, value){
    axios.patch(`/donor/campaign/${this.campaignid}/donation`,{ donor_id: this.campaigndonors.data[index].id, status: value, attribute:1})
      .then(response => {
        this.campaigndonors.data[index].pivot.donor_attended = value;
        this.statusAttend = value;
        if(value==1){
          toastNotification('success', 'Asistencia del donador marcada correctamente');
        }else{
          toastNotification('success', 'Falta del donador marcada correctamente');
          this.campaigndonors.data[index].pivot.donor_donated = value;
        }
      }).catch(error =>{
      })
    },
    changeStatusDonation:function(index, value){
    axios.patch(`/donor/campaign/${this.campaignid}/donation`,{ donor_id: this.campaigndonors.data[index].id, status: value, attribute:2})
      .then(response => {
        this.campaigndonors.data[index].pivot.donor_donated = value;
        this.statusAttend = value;
        if(value==1){
          toastNotification('success', 'Donación del donador marcada correctamente');
        }else{
          toastNotification('success', 'Donación faltante del donador marcada correctamente');
        }
      }).catch(error =>{
      })
    }  
  },
}
</script>
    