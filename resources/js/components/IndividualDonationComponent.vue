<template>
    <div>
      <div class="text-right my-2" v-if="loggeduseradmin == 1">
        <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalAddIndividualDonation" data-backdrop="static" data-keyboard="false">Agregar <i class="fa fa-plus mx-1"></i></button>
      </div>
      <individual-donation-create-component :currentdonorid="this.donorid" v-on:new-individual-donation="getindividualdonations()"></individual-donation-create-component>
      <div class="table-responsive">
        <table class="table table-hover table-striped table-sm">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Lugar</th>
              <th scope="col">Estado</th>
              <th scope="col">Municipio</th>
              <th scope="col">Fecha</th>
              <th scope="col">Hora</th>
              <th scope="col">T.D</th>
              <th v-if="loggeduseradmin == 1" scope="col">Acción</th>
            </tr>
          </thead>
          <paginate name="individualdonations" :list="individualdonations" :per="10" tag="tbody">
            <tr v-for="(individualDonation, index) in paginated('individualdonations')" :key="index">
              <td>{{individualDonation.bloodbank.name}}</td>
              <td>{{individualDonation.bloodbank.state.name}}</td>
              <td>{{individualDonation.bloodbank.city.name}}</td>
              <td>{{moment(individualDonation.date_donation).format('DD-MM-Y')}}</td>
              <td>{{individualDonation.time_donation}}</td>
              <td v-if="individualDonation.donationtype == 'D1'">Sangre</td>
              <td v-else>Aféresis</td>
              <td v-if="loggeduseradmin == 1"><a class="btn btn-warning btn-sm" @click="redirectToEdit(individualDonation.id)" ><i class="fa fa-pencil"></i></a></td>
            </tr>
            <tr class="text-center" v-if="individualdonations.length == 0">
              <td colspan="7">No se encontraron registros</td>
            </tr>
          </paginate>
        </table>
      </div>
      <paginate-links v-if="individualdonations.length > 0" class="d-flex justify-content-center" for="individualdonations" :simple="{prev: 'Ante', next: 'Sig'}" :classes="{'ul': 'pagination', 'li': 'page-item', 'a': 'page-link'}"></paginate-links>
    </div>
</template>

<script>
  import individualDonationComponent from './ModalIndividualDOnationCreateComponent.vue';
  import moment from 'moment';
  moment.locale('es-mx');
  export default {
    props: ['loggeduseradmin', 'donorid'],
    data() {
      return {
          individualdonations: [],
          paginate:['individualdonations'],
          individualDonationForEdit: ''
        }
    },
    mounted() {
      this.getindividualdonations();
    },
    methods: {
      getindividualdonations:function(){
        axios.get(`/get/individual-donations/donor/${this.donorid}`)
        .then((response)=>{
          this.individualdonations = response.data.individualDonations;
        });
      },
      redirectToEdit:function(id){
        window.location.href=`/individual-donations/${id}/edit`;
      },
      moment: function (date) {
        return moment(date);
      },
      date: function (date) {
        return moment(date).format('MMMM Do YYYY, h:mm:ss a');
      }
    },
    filters: {
    moment: function (date) {
      return moment(date).format('MMMM Do YYYY, h:mm:ss a');
    }
  }
  }
</script>