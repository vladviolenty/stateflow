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
import {mapActions, mapState} from "pinia";
import {appStore} from "@/stores/AppStore";
import AuthenticationMethods from "@/security/AuthenticationMethods";
import Encryption from "@/security/Encryption";
import Security from "@/security/Security";
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
    this.DashboardGateway.checkAuth().then(response=>{
      if (!response.success) {
        AuthenticationMethods.logOut()
        this.$router.push("/auth");
      } else {
        this.setNewLang(response.data.lang)
        this.sendEncryptionInfo(
            response.data.ip,
            response.data.ua,
            response.data.acceptLang,
            response.data.acceptEncoding,
            iv??""
        );
      }
    })

  },
  methods:{
    async sendEncryptionInfo(
        ip:string,
        ua:string,
        al:string,
        ae:string,
        iv:string
    ){

      let cryptoKey = await Security.getDerivedKey()
      let date = new Date();
      this.DashboardGateway.insertMetaHashInfo(
          await Encryption.encryptAES(ip,cryptoKey,iv),
          await Encryption.encryptAES(ua,cryptoKey,iv),
          await Encryption.encryptAES(al,cryptoKey,iv),
          await Encryption.encryptAES(ae,cryptoKey,iv),
          await Encryption.encryptAES(date.toISOString(),cryptoKey,iv),
      )
      console.log(Date.now())
    },
    ...mapActions(appStore,['setNewLang'])
  }
})
</script>

<style scoped>

</style>