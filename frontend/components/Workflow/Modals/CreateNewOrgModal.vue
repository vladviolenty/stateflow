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
      <p class="m-0 text-center text-danger">{{errorText}}</p>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from 'vue'
import Security from "@/security/Security";
import Encryption from "@/security/Encryption";
import WorkflowGateway from "@/gateway/WorkflowGateway";
import {Offcanvas} from "bootstrap";
import {mapState} from "pinia";
import {appStore} from "@/stores/AppStore";

export default defineComponent({
  name: "CreateNewOrgModal",
  data(){
    return{
      orgName:"" as string,
      genericId:"" as string,
      makePublicFLNames: false as boolean,
      creatingInProcess: false as boolean,

      errorText:"" as string,

      gateway: new WorkflowGateway(localStorage.getItem("authToken")??"")
    }
  },
  computed:{
    ...mapState(appStore, ['Localization',"DashboardGateway"]),
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
      this.creatingInProcess = true;

      if(this.orgName===""){
        this.errorText = "Имя организации пустое";
        this.creatingInProcess = false;
        return;
      }
      if(this.genericId===""){
        this.errorText = "Общий идентификатор пустой";
        this.creatingInProcess = false;
        return;
      }

      let iv = Security.getRandom(16);
      let salt = Security.getRandom(16);
      let orgPasswordString = window.btoa(Security.ab2str(Security.getRandom(16)))
      let derivedOrganizationKey = await Encryption.deriveKey(orgPasswordString,salt);

      let userPassword = await Security.getDerivedKey();
      let userIv = localStorage.getItem("iv")??"";
      let encryptedOrgPasswordByUserPassword = await Encryption.encryptAES(orgPasswordString,userPassword,userIv);

      let rsaKey = await Encryption.generateRSA();
      let basePublic = await Encryption.exportPublicKey(rsaKey.publicKey);
      let basePrivate = await Encryption.exportPrivateKey(rsaKey.privateKey);

      let encryptedOrgPrivateKey = await Encryption.encryptAESBytes(basePrivate,derivedOrganizationKey,iv);

      let resultName = ""
      if(this.makePublicFLNames){
        let currentUserNameInfo = await this.DashboardGateway.getGeneralInfo();
        if(currentUserNameInfo.success){
          resultName = await Encryption.decryptAES(currentUserNameInfo.data.fNameEncrypted,userPassword,userIv) + ' '+ await Encryption.decryptAES(currentUserNameInfo.data.lNameEncrypted,userPassword,userIv)
        }
      }
      let ivString = window.btoa(Security.ab2str(iv));
      this.gateway.createNewOrg(
          await Encryption.encryptAES(this.orgName,derivedOrganizationKey,ivString),
          await Encryption.encryptAES(this.genericId,derivedOrganizationKey,ivString),
          await Encryption.encryptAES(resultName,derivedOrganizationKey,ivString),
          ivString,
          window.btoa(Security.ab2str(salt)),
          encryptedOrgPasswordByUserPassword,
          basePublic,
          window.btoa(Security.ab2str(encryptedOrgPrivateKey)),
          await Encryption.encryptAES((new Date().toISOString()),derivedOrganizationKey,ivString),

      ).then(response=>{
        this.creatingInProcess = false;
        if(response.success){
          let offcanvas = Offcanvas.getOrCreateInstance("#createNewOrgOffcanvas");
          offcanvas.hide();
        }
      })
    }
  }
})
</script>



<style scoped>

</style>