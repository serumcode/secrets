<template>
  <v-app id="app">
    <div id="nav">
      <router-link to="/">Home</router-link> |
      <router-link to="/about">About</router-link>
    </div>
    <navigation></navigation>
    <v-alert
      dismissible
      :type="$root.alert_type"
      v-model="$root.alert_log"
      class="fixed mx-3"

    >
      {{ $root.alert_text }}
    </v-alert>
    
    <div class="text-center pt-8 mt-9">
      <div class="d-inline-block circle pa-5 white--bg"><v-icon x-large color="var(--primary)">fas fa-user-secret</v-icon></div>
    </div>
    <h2 class="primary--text uppercase text-center mt-9 mb-4 customtitle">
      <span class="">Titkos titok</span>
    </h2>
    <v-main id="main">
      <router-view />
    </v-main>

    <c-footer></c-footer>
  </v-app>
</template>
<script>

import Navigation from "@/components/Navigation.vue";
import CFooter from "@/components/CFooter.vue";

export default {
  name: "App",
  components: {
    Navigation,
    CFooter,
  },
  data: () => ({
    
  }),
  
};
</script>
<style lang="scss">
:root {
  --primary: #344c47;
  --secondary: #0cad8d;
  --lightcolor: #e2cc48fc;
}
#app {
  background-image: linear-gradient(315deg, #f2cf43 0%, #19a186 74%);
  min-height: 100vh;

  .primary {
    background-color: var(--primary) !important;
    border-color: var(--primary) !important;
  }

  .secondary {
    background-color: var(--secondary) !important;
    border-color: var(--secondary) !important;
  }
  .success {
    background-color: #d5eaca !important;
    border-color: var(--primary) !important;
    color: var(--primary);
    .v-icon{
      color: var(--primary);
    }
  }
  .v-application--wrap{
    >.v-alert{
    z-index: 1000;
    position: fixed;
    margin-top: 60px !important;
    width: calc(100% - 25px);
  }
  }
  .white--text {
    color: white;
  }
  .primary--text {
    color: var(--primary) !important;
    caret-color: var(--primary) !important;
  }
  .justify-center {
    justify-content: center;
  }
  .centerx {
    left: 50%;
    position: relative;
    transform: translateX(-50%);
  }

  .main {
    min-height: calc(100vh - 55px) !important;
  }
  .uppercase {
    text-transform: uppercase;
  }
  .centery {
    top: 50%;
    position: relative;
    transform: translateY(-50%);
  }

  .w-100 {
    width: 100%;
  }
  .circle{
    border-radius: 50%;
    border: 4px solid #ffffff;
    background: var(--lightcolor);
  }
  .v-card__title{
    border-bottom:5px solid var(--lightcolor) !important
  }
}
</style>
