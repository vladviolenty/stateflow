<template>
  <div class="fixed-top">
    <div class="container">
      <div class="row justify-content-end">
        <div class="col-6 col-md-2">
          <select name="" id="" class="form-select form-select-sm" v-model="selectedLang" @change="setLang">
            <option value="en">English</option>
            <option value="ru">Русский</option>
            <option value="by">Беларуская</option>
            <option value="ua">Українська</option>
          </select>
        </div>
      </div>
    </div>
  </div>

  <div class="row justify-content-center align-items-center" style="height: 100vh">
    <div class="col-12">
      <h4 class="text-center">Авторизация</h4>
      <input type="text" class="form-control my-1" v-model="authString" :disabled="step!=='auth'" placeholder="Email, Телефон или Uuid">
      <input type="password" class="form-control my-1" v-model="authPassword" v-if="step==='password'" placeholder="Введите пароль">
      <button class="btn btn-outline-primary w-100 my-1" @click="checkPhone" v-if="step==='auth'">{{ Localization.next }}</button>
      <button class="btn btn-outline-primary w-100 my-1" @click="passwordAuth" v-if="step==='password'">{{ Localization.enter }}</button>
      <router-link to="/register" class="text-center btn btn-link w-100"  v-if="step==='auth'">{{ Localization.register }}</router-link>
      <p class="text-danger text-center" v-if="authErrorCode!==null">{{Localization.errorCodes[authErrorCode]}}</p>
    </div>
  </div>


</template>

<script lang="ts">
import {defineComponent} from "vue";
import AuthGateway from "../../gateway/AuthGateway";
import {appStore} from "@/stores/AppStore";
import {mapActions, mapState} from "pinia";
import Credentials from "../../security/Credentials";
import Hashing from "@/security/Hashing";
import Security from "@/security/Security";
import type {errorCodeList} from "@/localization/CustomInterfaces";
import Validation from "@/security/Validation";
export default defineComponent({
  name: "AuthPage",
  data(){
    return{
      selectedLang:"ru" as 'ru'|'by'|'ua'|'en',
      authString:"" as string,
      authErrorCode:null as errorCodeList|null,
      step:'auth' as 'password'|'finger'|'auth',
      authPassword:"" as string,
      authSalt:"" as string,
    }
  },
  computed: {
    ...mapState(appStore, ['Localization']),
  },
  methods:{
    async getUserNametype():Promise<{type:'uuid'|'email'|'phone',authString:string}>{
      let type:'phone'|'uuid'|'email' = "phone";
      let authString = this.authString;
      this.authErrorCode = null;
      if(Validation.isUUID(this.authString)){
        type = 'uuid'
      } else if (Validation.isEmail(this.authString)){
        type = 'email';
        authString = await Hashing.digest(this.authString);
      } else if(Validation.isPhone(this.authString)) {
        authString = await Hashing.digest(this.authString);
      } else {
        this.authErrorCode = 5;
        throw "5";
      }
      return {
        type:type,
        authString:authString,
      };
    },
    async checkPhone(){
      let info = await this.getUserNametype();
      AuthGateway.preAuth(info.authString,info.type).then(response=>{
        if(response.success){
          this.step = 'password';
          this.authSalt = window.atob(response.data.salt);
        } else {
          this.authErrorCode = response.code;
        }
      }).catch(response=>{
        console.log(response)
        this.authErrorCode = 0;
      })
    },
    async passwordAuth(){
      let info = await this.getUserNametype();
      let passwordHash = await Hashing.digest(this.authSalt+''+this.authPassword);
      AuthGateway.passwordAuth(info.authString,info.type,passwordHash).then(response=>{
        if(response.success){
          localStorage.setItem("authToken",response.data.hash);
          localStorage.setItem("salt",response.data.salt);
          localStorage.setItem("iv",response.data.iv);
          localStorage.setItem("password",this.authPassword);
          this.setNewToken(response.data.hash)
          this.$router.push("/");
        } else {
          this.authErrorCode = response.code;
        }
      }).catch(response=>{
        this.authErrorCode = 0;
      })
    },
    async fingerPrintAuth(){
      let result = await Credentials.create(
          Security.getRandom(32),
          "123-455331-213-123-12-312333",
          "vlad",
          "vlad"
      );
      console.log(result)
      let success = await Credentials.get("333");
      console.log(success)
    },
    setLang(){
      this.setNewLang(this.selectedLang)
    },
    ...mapActions(appStore,['setNewLang',"setNewToken"])
  }
})
</script>

<style scoped>

</style>