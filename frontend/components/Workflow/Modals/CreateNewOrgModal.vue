<template>
  <div class="offcanvas offcanvas-end" tabindex="-1" id="createNewOrgOffcanvas" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasExampleLabel">Создание организации</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <label for="orgName">Наименование организации</label>
      <input type="text" class="form-control" id="orgName" v-model="orgName">
      <label for="genericId">Общий идентификатор</label>
      <input type="text" class="form-control" id="genericId" v-model="genericId">

      <div class="form-check">
        <input class="form-check-input" type="checkbox" v-model="makePublicFLNames" id="makePublicFLNames">
        <label class="form-check-label" for="makePublicFLNames">
          Сделать публичными имена пользователей для всех членов организации
        </label>
      </div>

      <button class="btn btn-primary w-100" :disabled="creatingInProcess" @click="createOrg">Создать организацию</button>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from 'vue'
import Security from "@/security/Security";
import Encryption from "@/security/Encryption";
import WorkflowGateway from "@/gateway/WorkflowGateway";
import {Offcanvas} from "bootstrap";

export default defineComponent({
  name: "CreateNewOrgModal",
  data(){
    return{
      orgName:"" as string,
      genericId:"" as string,
      makePublicFLNames: false as boolean,
      creatingInProcess: false as boolean,

      gateway: new WorkflowGateway()
    }
  },
  methods:{
    showOffcanvas():void{
      let offCanvas = Offcanvas.getOrCreateInstance('#createNewOrgOffcanvas');
      offCanvas.show();
      this.orgName = "";
      this.genericId = "";
      this.makePublicFLNames = false;
      this.creatingInProcess = false;
    },
    async createOrg(){
      let iv = Security.getRandom(16);
      let salt = Security.getRandom(16);
      let orgPasswordString = window.btoa(Security.ab2str(Security.getRandom(16)))
      let derivedOrganizationKey = await Encryption.deriveKey(orgPasswordString,salt);

      let userPassword = await Encryption.deriveKey(localStorage.getItem("password")??"",Security.str2ab(localStorage.getItem("salt")??""))
      let encryptedOrgPasswordByUserPassword = await Encryption.encryptAES(orgPasswordString,userPassword,localStorage.getItem("iv")??"");

      let rsaKey = await Encryption.generateRSA();
      let basePublic = await Encryption.exportPublicKey(rsaKey.publicKey);
      let basePrivate = await Encryption.exportPrivateKey(rsaKey.privateKey);

      let encryptedOrgPrivateKey = await Encryption.encryptAESBytes(basePrivate,derivedOrganizationKey,iv);

      this.gateway.createNewOrg(
          window.btoa(Security.ab2str(await Encryption.encryptAESBytes(Security.utf8str2ab(this.orgName),derivedOrganizationKey,iv))),
          window.btoa(Security.ab2str(await Encryption.encryptAESBytes(Security.utf8str2ab(this.genericId),derivedOrganizationKey,iv))),
          this.makePublicFLNames,
          window.btoa(Security.ab2str(iv)),
          window.btoa(Security.ab2str(salt)),
          encryptedOrgPasswordByUserPassword,
          basePublic,
          window.btoa(Security.ab2str(encryptedOrgPrivateKey))
      ).then(response=>{
        if(response.success){

        }
      })
    }
  }
})
</script>



<style scoped>

</style>