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
                  <i v-if="campaigndonor.pivot.donor_donated" class="fa fa-check text-success" aria-hidden="true"></i>
                  <i v-else class="fa fa-times text-danger" aria-hidden="true"></i>
              </td>
              <td>
                <button v-if="campaigndonor.pivot.donor_donated" v-on:click="changeStatusDonation(index, 0)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="right" title="Marcar como no asistió">Marcar como no asistió</button>
                <button  v-else class="btn btn-success btn-sm" v-on:click="changeStatusDonation(index, 1)" data-toggle="tooltip" data-placement="right" title="Marcar como asistió">Marcar como asistió</button>
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
  changeStatusDonation:function(index, value){
  axios.patch(`/donor/campaign/${this.campaignid}/donation`,{ donor_id: this.campaigndonors.data[index].id, status: value})
    .then(response => {
      this.campaigndonors.data[index].pivot.donor_donated = value;
      if(value==1){
        toastNotification('success', 'Asistencia del donador marcada correctamente');
      }else{
        toastNotification('success', 'Falta del donador marcada correctamente');
      }
    }).catch(error =>{
    })
  }  
  },
}
</script>
    