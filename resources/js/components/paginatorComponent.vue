<template>
  <div>
    <div class="row">
      <div class="col-6 d-flex justify-content-start">
        <ul class="pagination">
          <li class="page-item" v-if="paginator.current_page != 1">
            <a class="page-link" :href="paginator.first_page_url"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a>
          </li>
          <li class="page-item disabled" v-if="paginator.prev_page_url == null">
            <a class="page-link" href="#">Anterior</a>
          </li>
          <li class="page-item" v-else>
            <a class="page-link" :href="paginator.prev_page_url">Anterior</a>
          </li>
          <li class="page-item">
            Página {{this.paginator.current_page}} de {{this.paginator.last_page}}
          </li>
          <li class="page-item disabled" v-if="paginator.next_page_url == null">
            <a class="page-link" href="#">Siguiente</a>
          </li>
          <li class="page-item" v-else>
            <a class="page-link" :href="paginator.next_page_url">Siguiente</a>
          </li>
          <li class="page-item" v-if="paginator.current_page != paginator.last_page">
            <a class="page-link" :href="paginator.last_page_url"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
          </li>
        </ul>
      </div>
      <div class="col-6 d-flex justify-content-end">
        <p class="text-secondary lead text-center">
            <small>
                Mostrando del
            </small>
            <span class="font-medium"><small>{{ this.paginator.from }}</small></span>
            <small>
                al
            </small>
            <span class="font-medium"><small>{{ this.paginator.to  }}</small></span>
            <small>
                de
            </small>
            <span class="font-medium"><small>{{ this.paginator.total  }}</small></span>
            <small>
              resultados
            </small>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['paginator'],
  data() {
      return {
          
      }
  },
}
</script>