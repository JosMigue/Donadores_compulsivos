<template>
  <div>
    <div class="d-flex align-items-center justify-content-center" >
      <div class="shadow-lg p-5 mb-5 mt-5 bg-white rounded" style="width:700px; height:565px;">
        <div class="row d-flex justify-content-center mt-5" v-if="!isAbleToDonate">
          <h1 class="text-center font-weight-bold">QUIERO SER DONADOR</h1>
        </div>
        <div class="row d-flex justify-content-center p-4" v-if="!isAbleToDonate">
          <p class="text-justify">Antes que nada, debes tener 100% la voluntad de donar sin esperar recibir nada cambio, sólo la satisfacción de ayudar a quien lo necesite. Para saber si cumples con los requisitos básicos para donar, contesta este sencillo cuestionario:</p>        
        </div>
        <div class="d-flex flex-column justify-content-center" v-if="isAbleToDonate">
          <h1 class="text-center font-weight-bold">¡FELICIDADES!</h1>
          <p class="text-center">Calificas como donante. Ahora sólo queda acercarte a tu centro de donación más cercano.</p>
          <a class="btn btn-red" href="/donor/register">Registrase</a>
        </div>
        <div class="border border-gray rounded my-5 py-1" v-if="!isWrongAnswer && !isAbleToDonate">
          <div class="row d-flex justify-content-center">
            <p class="text-center">{{questions[counter].question}}</p>
          </div>
          <div class="row">
            <div class="col-6 d-flex justify-content-center">
              <button class="btn btn-red px-4 font-weight-bold" v-on:click="checkResponse(true)">Sí</button>
            </div>
            <div class="col-6 d-flex justify-content-center">
              <button class="btn btn-red px-4 font-weight-bold" v-on:click="checkResponse(false)">No</button>
            </div>
          </div>
        </div>
        <div class="border border-gray rounded my-5 py-2" v-if="isWrongAnswer">
          <p class="text-center">{{questions[counter].badResponse}}</p>
          <div class="row justify-content-center">
            <a class="btn btn-red px-4 d-block font-weight-bold" >Donar de otra manera</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
  data() {
    return {
        counter: 0,
        isWrongAnswer: false,
        isAbleToDonate: false,
        questions: [
          {question: '¿Tienes más de 18 años?', response: true, badResponse:'Necesitas ser mayor de edad para poder donar'},
          {question: '¿Estás embarazada o lactando?', response: false, badResponse:'Tu salud es primero, es necesario esperar un tiempo para poder donar'},
          {question: '¿Traes contigo una identificación oficial con fotografía?', response: true, badResponse: 'Necesitas una identificación oficial para poder registrarte a la hora de donar, puede ser tu INE, Licencia o pasaporte'},
          {question: '¿Pesas más de 50 kilos?', response: true, badResponse: 'Tu peso corporal no es suficiente para que dones sangre, puesto que al hacerlo podrías sentirte mal'},
          {question: '¿Has padecido de ataques epilépticos, convulsiones o enfermedades del corazón?', response: false, badResponse: 'Tu salud es primero, habla con tu médico para saber si puedes donar'},
          {question: '¿Te has sometido a una operación en los últimos meses?', response: false , badResponse: 'Tu cirugía fue: Cirugia Mayor / Cirugia Menor i. (Consulta con tu médico si fue una cirugía mayor o menor)'},
          {question: '¿Te has tatuado o hecho piercings en los últimos 12 meses?', response: false, badResponse: 'En México es necesario esperar 12 meses para poder donar'},
          {question: '¿Te has vacunado en los últimos 30 días?', response: false, badResponse: 'Es necesario esperar 1 mes para poder donar'},
          {question: '¿Padeciste hepatitis después de los 10 años?', response: false, badResponse: 'Existe un riesgo de que puedas transmitir el virus de la hepatitis, así que es mejor no donar'},
          {question: '¿Tienes síntomas como tos o dolor de garganta?', response: false, badResponse: 'Necesitas esperar a que pasen tus síntomas para poder donar'},
          {question: '¿Has tomado medicamentos en los últimos 5 días?', response: false, badResponse: 'Consulta con tu médico si puedes donar sangre'},
          ],      
    }
  },
  methods: {
    checkResponse:function(response){
      if(response === this.questions[this.counter].response){
        if(this.counter == 10){
          this.isAbleToDonate = true;
        }else{
          this.counter += 1;
        }
      }else{
        this.isWrongAnswer = true;
      }
    }
  }
  }
</script>