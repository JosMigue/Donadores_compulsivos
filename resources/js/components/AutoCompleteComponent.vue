<template>
  <div>
    <div class="panel panel-default m-2">
      <div class="row">
        <div class="col-6">
          <input class="form-control form-control-sm rounded" type="search" placeholder="Buscar donador..." v-model="search" v-on:keyup="searchDonor()">
        </div>
      </div>
      <div class="row">
        <div class="col-6">
          <ul id="autolist" class="list-group" v-bind:class="{'d-block':visible, 'd-none':iSNotVisible}">
            <li id="fav" class="list-group-item" v-if="donors.length >= 1">
              <div class="row">
                <div id="favorites" class="">
                  <div class="container">
                    <b>Resultados de la busqueda...</b>
                  </div>
                </div>
              </div>
            </li>
            <li class="list-group-item link" v-for="donor in donors" v-if="donors.length >= 1 && search != ''">
              <div class='row'>
                <div class='col'>
                  <div id='center'>
                  <a class="link-donor d-block" v-bind:href="'donors/'+donor.id"><i class="fa fa-user mx-1" aria-hidden="true"></i>{{donor.name}} {{donor.parental_surname}} {{donor.maternal_surname}}</a>
                  </div>
                </div>
              </div>
            </li>
            <li class="list-group-item" v-if="donors.length == 0 || search == ''">
              <div class='row'>
                <div class='col-md-12'>
                  <div id='center'>
                    No se cencontraron registros
                  </div>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
    export default {
      data(){
        return {
          donors: [],
          search: '',
          visible: false,
          iSNotVisible: true,
        }   
      },
      methods: {
        searchDonor: function (){
          axios.get(`/search/donor/${this.search}`)
          .then(response => {
            this.visible = true;
            this.iSNotVisible = false;
            this.donors = response.data;
          }).catch(error =>{

          })
        },
        closeAllLists: function(){
          this.visible = false;
          this.iSNotVisible = true;
        }
      },
      created () {
        document.addEventListener('click', this.closeAllLists)
      },
      destroyed () {
        document.removeEventListener('click', this.closeAllLists)
  }
    }
</script>
