<template>
  <h4>{{ Localization.profile }}</h4>
  <ul class="list-group list-group-flush">
    <router-link to="/dashboard/profile/email" class="list-group-item">{{ Localization.configure.email }}</router-link>
    <router-link to="/dashboard/profile/phones" class="list-group-item">{{ Localization.configure.phone }}</router-link>
    <router-link to="/dashboard/profile/sessions" class="list-group-item">{{ Localization.configure.session }}</router-link>
    <li class="list-group-item text-danger" @click="logOut">{{Localization.logout}}</li>
  </ul>
</template>

<script lang="ts">
import {defineComponent} from "vue";
import AuthenticationMethods from "@/security/AuthenticationMethods";
import {mapState} from "pinia";
import {appStore} from "@/stores/AppStore";
export default defineComponent({
  name: "DashboardProfile",
  methods:{
    logOut():void{
      const token = localStorage.getItem("authToken")??"";
      this.DashboardGateway.killSession(token,false);
      AuthenticationMethods.logOut();
      this.$router.push("/auth");
    }
  },
  computed:{
    ...mapState(appStore, ['Localization',"DashboardGateway"]),
  },
})
</script>

<style scoped>

</style>