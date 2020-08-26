<template>
  <div>
    <div class="panel panel-default m-2">
      <div class="row">
        <div class="col-6">
          <input class="form-control form-control-sm" type="search" placeholder="Buscar" v-model="search" v-on:keyup="searchDonor()">
        </div>
      </div>
      <div class="row">
        <div class="col-6">
          <ul id="autolist" class="list-group" v-bind:class="{'d-block':isActive, 'd-none':isNotActive}">
            <li id="fav" class="list-group-item" v-if="donors.length >= 1">
              <div class="row">
                <div id="favorites" class="">
                  <div class="container">
                    <span> </span><b>Resultados de la busqueda...</b>
                  </div>
                </div>
              </div>
            </li>
            <li class="list-group-item link" v-for="donor in donors" v-if="donors.length >= 1">
              <div class='row'>
                <div class='col'>
                  <div id='center'>
                  <a class="link-donor d-block" v-bind:href="'donors/'+donor.id"><i class="fa fa-user mx-1" aria-hidden="true"></i>{{donor.name}} {{donor.last_name}}</a>
                  </div>
                </div>
              </div>
            </li>
            <li class="list-group-item" v-if="donors.length == 0">
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
          isActive: false,
          isNotActive: true,
        }   
      },
      methods: {
        searchDonor: function (){
          axios.get(`/search/donor/${this.search}`)
          .then(response => {
            this.isActive = true;
            this.isNotActive = false;
            this.donors = response.data;
          }).catch(error =>{

          })
        },
        closeAllLists: function(){
          this.isActive = false;
          this.isNotActive = true;
        }
      }
    }
</script>
