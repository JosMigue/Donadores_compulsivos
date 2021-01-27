<template>
  <div>
    <div v-if="isCameraActive" class="row d-flex justify-content-center">
      <h4>Foto de perfil</h4>
    </div>
    <div class="form-group row" v-if="isCameraActive">
      <div class="col-md-6">
        <h5>Cámara seleccionada</h5>
        <div class="border">
            <vue-web-cam ref="webcam" :device-id="deviceId" width="100%" height="250" :resolution= resolutionToSet 
              @started="onStarted"
              @stopped="onStopped"
              @error="onError"
              @cameras="onCameras"
              @camera-change="onCameraChange"
            />
        </div>
        <div class="row">
          <div class="col-md-12">
            <select v-model="camera" class="form-control">
              <option>-- Seleccione un dispositivo --</option>
              <option v-for="device in devices" :key="device.deviceId" :value="device.deviceId">{{ device.label }}</option>
            </select>
          </div>
          <div class="col-md-12 d-flex flex-column">
            <button type="button" class="btn btn-danger" @click="onStart">Iniciar cámara <i class="fa fa-power-off mx-1" aria-hidden="true"></i></button>
            <button type="button" class="btn btn-dark" @click="onCapture">Capturar foto<i class="fa fa-picture-o mx-1" aria-hidden="true"></i></button>
            <button type="button" class="btn btn-danger" @click="onStop">Detener cámara<i class="fa fa-stop mx-1" aria-hidden="true"></i></button>
            <button type="button" class="btn btn-dark" @click="changeProfilePictureWay(false)">Usar archivo<i class="fa fa-file mx-1" aria-hidden="true"></i></button>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <h5>Imagen capturada</h5>
        <figure class="figure d-flex justify-content-center">
          <img :src="img" class="img-responsive" />
        </figure>
      </div>
      <input name="captured_image"  type="hidden" :value="img" >
    </div>
    <div class="form-group row d-flex justify-content-center" v-else>
      <label for="profile_picture">Foto de perfil</label>
      <div class="col-md-6">
        <div class="input-group mb-3">
          <input type="file" class="form-control" name="profile_picture" id="profile_picture">
          <div class="input-group-append text-center">
            <button v-if="!isCameraActive" type="button" @click="changeProfilePictureWay(true)" class="btn btn-primary"><i class="fa fa-camera"></i></button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { WebCam } from "vue-web-cam";
export default {
    name: "App",
    components: {
        "vue-web-cam": WebCam
    },
    data() {
        return {
            img: null,
            camera: null,
            deviceId: null,
            devices: [],
            resolutionToSet: {height:300, width:250},
            isCameraActive: true
        };
    },
    computed: {
        device: function() {
            return this.devices.find(n => n.deviceId === this.deviceId);
        }
    },
    watch: {
        camera: function(id) {
            this.deviceId = id;
        },
        devices: function() {
            // Once we have a list select the first one
            const [first, ...tail] = this.devices;
            if (first) {
                this.camera = first.deviceId;
                this.deviceId = first.deviceId;
            }
        }
    },
    methods: {
      onCapture:function() {
        toastNotification('success', `Imagen capturada`);
        this.img = this.$refs.webcam.capture();
      },
      onStarted:function(stream) {
        toastNotification('success', `Cámara activada`);
      },
      onStopped:function(stream) {
        toastNotification('info', `Cámara desactivada`);
      },
      onStop:function() {
          this.$refs.webcam.stop();
      },
      onStart:function() {
          this.$refs.webcam.start();
      },
      onError:function(error) {
        toastNotification('error', `Evento erroneo encontrado, mensaje: ${error}`) 
      },
      onCameras:function(cameras) {
          this.devices = cameras;
      },
      onCameraChange:function(deviceId) {
          this.deviceId = deviceId;
          this.camera = deviceId;
      },
      changeProfilePictureWay:function(status){
        this.isCameraActive = status;
        if(status){
          document.getElementById('profile_picture').value="";
        }else{
          this.img = '';
        }
      }
    }
};
</script>