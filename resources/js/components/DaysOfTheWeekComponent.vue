<template>
  <div>
    <div v-if="seletedDays.length == 0">
      <label for="days_of_week">Horario</label>
      <select class="form-control" v-model="selected" v-on:change="addDay(selected)">
        <option value="" selected disabled>Seleccione un día</option>
        <option v-for="day in days" v-bind:value="day">{{day.dayName}}</option>
      </select>
      <transition-group name="list" tag="div">
        <div v-for="(day, indexday) in days" :key="day.dayName" v-if="day.hours > 0">
          <h4 class="text-center m-1">{{day.dayName}}</h4>
          <div class="row d-flex justify-content-center">
            <input type="hidden" v-bind:name="'days['+day.dayName+']'">
            <button class="btn btn-link" type="button" v-on:click="removeDay(day, indexday)">Quitar día<i class="fa fa-trash mx-1"></i></button>
            <button class="btn btn-link" type="button" v-on:click="addHour(day)">Agregar hora<i class="fa fa-plus mx-1"></i></button>
          </div>  
          <div class="row my-1" v-for="(hour, index) in day.hours" :key="index">
            <div class="col">
              <input class="form-control" type="time" v-bind:name="'days['+day.dayName+'][]'" required>
            </div>
            <div class="col">
              <input class="form-control" type="time" v-bind:name="'days['+day.dayName+'][]'" required>
            </div>
            <button class="btn btn-danger btn-sm" type="button" v-on:click="removeHour(day)"><i class="fa fa-trash"></i></button>
          </div>
        </div>
      </transition-group>
    </div>
    <label v-if="seletedDays.length > 0">Horario</label>
    <transition-group name="list" tag="div">
      <div v-for="(day, index) in seletedDays" :key="day.dayName">
        <h4 class="text-center m-1">{{day.dayName}}</h4>
        <div class="row d-flex justify-content-center">
          <input type="hidden" v-bind:name="'days['+day.dayName+']'">
          <button class="btn btn-link" type="button" v-on:click="removeDay(day, index)">Quitar día<i class="fa fa-trash mx-1"></i></button>
        </div> 
        <input type="hidden" v-bind:name="'days['+day.dayName+']'">
        <div class="row my-1" v-for="(hour, index) in day.hours" :key="index">
          <div class="col">
            <input class="form-control" type="time" v-bind:name="'days['+day.dayName+'][]'" v-bind:value="hour" required>
          </div>
        </div>
      </div>
    </transition-group>
  </div>
</template>

<script>
    let savedDays = [];
    export default {
      props:['businessdays'],
      data(){
        return {
          days: [{dayName: 'Lunes - viernes', hours: 0}, {dayName: 'Sábado', hours: 0}, {dayName: 'Domingo', hours: 0}],
          seletedDays: [],
          selected: "",
        }   
      },
      mounted() {
        this.seletedDays = [];
        if(this.businessdays){
          this.buildOnEdit();
        }
      },
      methods: {
        addDay(day){
          if(day.hours == 0){
            day.hours = 1;
          }
        },
        removeDay(day, index){
          if(this.seletedDays.length == 0){
            if(this.days.includes(day)){
              day.hours = 0;
            }
          }else{
            if(this.seletedDays.includes(day)){
              day.hours = [];
              this.seletedDays.splice(index,1);
            }
          }
        },
        addHour(day){
          day.hours += 1;        
        },
        removeHour(day){
          day.hours -= 1;       
        },
        buildOnEdit(){
          this.businessdays.forEach(function(days, index){
            $.each(days, function(key, hour) {
              savedDays.push({dayName: key, hours: hour})
            });
          });
          this.seletedDays =  savedDays;
        },
      },
      created () {

      },
      destroyed () {  

      }
    }
</script>

<style>
.list-item {
  display: inline-block;
  margin-right: 10px;
}
.list-enter-active, .list-leave-active {
  transition: all .5s;
}
.list-enter, .list-leave-to{
  opacity: 0;
  transform: translateY(30px);
}
</style>
