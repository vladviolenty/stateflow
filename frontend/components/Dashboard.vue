<template>
  <router-view></router-view>
  <div class="fixed-bottom">
    <div class="btn-group w-100">
      <router-link to="/dashboard/services" class="btn btn-outline-secondary" exact-active-class="active"><i class="bi bi-list"></i></router-link>
      <router-link to="/dashboard" class="btn btn-outline-secondary" exact-active-class="active"><i class="bi bi-house"></i></router-link>
      <router-link to="/dashboard/profile" class="btn btn-outline-secondary" exact-active-class="active"><i class="bi bi-person"></i></router-link>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "vue";
import {mapState} from "pinia";
import {appStore} from "@/stores/AppStore";
import AuthenticationMethods from "@/security/AuthenticationMethods";
export default defineComponent({
  name: "DashboardCore",
  computed:{
    ...mapState(appStore, ['DashboardGateway']),
  },
  mounted() {
    let token = localStorage.getItem("authToken");
    let iv = localStorage.getItem("iv");
    if(token===null || iv===null){
      AuthenticationMethods.logOut()
      this.$router.push("/auth");
      return;
    }
    this.DashboardGateway.checkAuth(token).then(response=>{
      if (!response.success) {
        return;
        AuthenticationMethods.logOut()
        this.$router.push("/auth");
      }
    });

  }
})
</script>

<style scoped>

</style>