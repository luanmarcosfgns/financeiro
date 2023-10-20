<template>
  <header>
    <nav class="navbar  bg-body-tertiary p-2" style="z-index: 1;">


      <a aria-controls="offcanvasScrolling" class="navbar-brand  " data-bs-target="#sideBar"
         data-bs-toggle="collapse" href="#">

          <img src="@/assets/logo.png" width="50">

      </a>



      <a class="float-end p-2" href="/logout">
        <svg class="bi bi-box-arrow-right" fill="currentColor" height="16" style="color: #1a202c"
             viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg">
          <path
              d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"
              fill-rule="evenodd"/>
          <path
              d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"
              fill-rule="evenodd"/>
        </svg>
      </a>

    </nav>
  </header>

  <div class="container">


    <div class="container mt-3">
      <div class="row">
        <div class="col-12" style="z-index: 0;">
              <div class="card card-12">
                <slot></slot>
              </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>


export default {
  name: "layoutPage",
  data() {
    return {
      countNotification: 0,
      notifications: 0
    }
  },
  methods: {},
  mounted() {

  }
}
</script>

<style scoped>
body {
  padding: 2px;
}

</style>