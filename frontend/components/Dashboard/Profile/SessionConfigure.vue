<template>
  <h4>Сессии</h4>
  <div class="row"  v-if="list.length>0">
    <div class="col-md-4" v-for="item in list">
      <div class="card w-100" >
        <div class="card-body">
          <h5 class="card-title">Card title</h5>
          <h6 class="card-subtitle mb-2 text-body-secondary">Card subtitle</h6>
          <p class="card-text">User-agent - {{item.ua}}</p>
          <button class="card-link" @click="killSession(item.ua)">Закрыть</button>
        </div>
      </div>
    </div>
  </div>

</template>

<script lang="ts">
import {defineComponent} from "vue";
import Encryption from "@/security/Encryption";
import Security from "@/security/Security";
import {mapState} from "pinia";
import {appStore} from "@/stores/AppStore";
import type {phoneListResponseItem, sessionListResponseItem} from "@/gateway/Interfaces/DashboardGatewayIntefaces";
export default defineComponent({
  name: "SessionConfigure",
  data(){
    return{
      list:[] as Array<{ ua:string }>,
      cryptoKey:null as null|CryptoKey

    }
  },
  async mounted() {
    this.cryptoKey = await Encryption.deriveKey(localStorage.getItem("password")??"",Security.str2ab(localStorage.getItem("salt")??""))
    let response = await this.DashboardGateway.getSessionsList();
    if(response.success){
      await this.remapListElements(response.data);
    }
  },
  computed:{
    ...mapState(appStore, ['DashboardGateway','Localization']),
  },
  methods:{
    async remapListElements(response:sessionListResponseItem[]){
      let iv = localStorage.getItem("iv") ?? "";
      this.list = await Promise.all(response.map(async item => {
        if(this.cryptoKey!==null) {
          item.ua = await Encryption.decryptAES(item.ua, this.cryptoKey,iv );
        }
        return item;
      }));
    },
    killSession(hash:string):void{

    }
  }
})
</script>

<style scoped>

</style>