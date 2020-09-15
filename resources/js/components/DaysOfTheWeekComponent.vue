<template>
  <div>
    <label for="days_of_week">Horario</label>
    <select class="form-control" v-model="selected" v-on:change="addDay(selected)">
      <option value="" selected disabled>Seleccione un día</option>
      <option v-for="day in days" v-bind:value="day">{{day.dayName}}</option>
    </select>
    <transition-group name="list" tag="div">
      <div v-for="(selectedDay, indexday) in seletedDays" :key="selectedDay.dayName">
        <h4 class="text-center m-1">{{selectedDay.dayName}}</h4>
        <div class="row d-flex justify-content-center">
          <input type="hidden" v-bind:name="'days['+selectedDay.dayName+']'">
          <button class="btn btn-link" type="button" v-on:click="removeDay(selectedDay, indexday)">Quitar día<i class="fa fa-trash mx-1"></i></button>
          <button class="btn btn-link" type="button" v-on:click="addHour(selectedDay)">Agregar hora<i class="fa fa-plus mx-1"></i></button>
        </div>  
        <div class="row my-1" v-for="(hour, index) in selectedDay.hours" :key="index">
          <div class="col">
            <input class="form-control" type="time" v-bind:name="'days['+selectedDay.dayName+'][]'" required>
          </div>
          <div class="col">
            <input class="form-control" type="time" v-bind:name="'days['+selectedDay.dayName+'][]'" required>
          </div>
          <button class="btn btn-danger btn-sm" type="button" v-on:click="removeHour(selectedDay, index)"><i class="fa fa-trash"></i></button>
        </div>
      </div>
    </transition-group>
  </div>
</template>

<script>
    export default {
      data(){
        return {
          days: [{ index:1 ,dayName: 'Lunes', hours: []},{ index:2 ,dayName: 'Martes', hours: []}, { index:3 ,dayName: 'Miércoles', hours: []}, { index:4 ,dayName: 'Jueves', hours: []}, { index:5 ,dayName: 'Viernes', hours: []}, { index:6 ,dayName: 'Sábado', hours: []}, { index:7 ,dayName: 'Domingo', hours: []}],
          seletedDays: [],
          selected: "",
        }   
      },
      mounted() {
        this.seletedDays = []
      },
      methods: {
        addDay(day){
          if(!this.seletedDays.includes(day)){
            day.hours.push({'hour': 1});
            this.seletedDays.push(day);
          }
        },
        removeDay(day, index){
          if(this.seletedDays.includes(day)){
            day.hours = [];
            this.seletedDays.splice(index,1);
          }
        },
        addHour(day){
          day.hours.push(1);        
        },
        removeHour(day,index){
          day.hours.splice(index,1);        
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
