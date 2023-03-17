<template>
  <h4>{{ Localization.register }}</h4>
  <label for="lName">Фамилия (на латинице):</label>
  <input type="text" class="form-control" v-model="lName" id="lName">
  <label for="fName">Имя (на латинице):</label>
  <input type="text" class="form-control" v-model="fName" id="fName">
  <label for="dOfBirth">Дата рождения:</label>
  <input type="date" class="form-control" v-model="dOfBirth" id="dOfBirth">
  <label for="password">Введите пароль:</label>
  <input type="password" class="form-control" v-model="password" id="password">
  <p class="text-primary m-0">Энтропия Log2 - {{entropyLog2}}</p>

  <div class="form-check">
    <input class="form-check-input" type="checkbox" v-model="dontVerificate" id="dontVerificate">
    <label class="form-check-label" for="dontVerificate">Я отказываюсь проходить верификацию</label>
  </div>

  <button class="btn btn-primary w-100" @click="registerNewUser"
          :disabled="buttonDisabled">
    {{ this.buttonDisabled ? 'Выполняется регистрация' : 'Создать пользователя'}}
  </button>
  <p class="m-0 text-center text-danger">{{errorText}}</p>
</template>

<script lang="ts">
import {defineComponent} from "vue";
import {mapState} from "pinia";
import {appStore} from "@/stores/AppStore";
import Encryption from "@/security/Encryption";
import Hashing from "@/security/Hashing";
import Security from "@/security/Security";
import AuthGateway from "@/gateway/AuthGateway";
import Mathematics from "@/security/Mathematics";

export default defineComponent({
  name: "IdRegister",
  data(){
    return{
      fName:"" as string,
      lName:"" as string,
      dOfBirth:"" as string,
      password:"" as string,
      buttonDisabled:false as boolean,
      dontVerificate:false as boolean,
      errorText:"" as string
    }
  },
  computed: {
    entropyLog2():number{
      return Math.pow(2,Mathematics.entropyLog2(this.password));
    },
    ...mapState(appStore, ['Localization']),
  },

  methods:{
    async registerNewUser(){

      if(this.fName==="") {
        this.errorText = "Имя не введено";
        return;
      }
      if(this.lName==="") {
        this.errorText = "Фамилия не введена";
        return;
      }
      if(this.dOfBirth==="") {
        this.errorText = "Дата рождения не введена";
        return;
      }
      if(this.password==="") {
        this.errorText = "Пароль не введён";
        return;
      }
      this.buttonDisabled = true;

      let iv = await Security.getRandom(16);
      let salt = await Security.getRandom(16);

      let pbkdf2Key = await Encryption.deriveKey(this.password,salt);
      let passwordHash = await Hashing.digest(Security.ab2str(salt)+''+this.password);
      let rsaKey = await Encryption.generateRSA();
      let basePublic = await Encryption.exportPublicKey(rsaKey.publicKey);
      let basePrivate = await Encryption.exportPrivateKey(rsaKey.privateKey);

      let encryptedPrivateKey = await Encryption.encryptAESBytes(basePrivate,pbkdf2Key,iv);
      console.log(this.fName+'-'+this.lName+'-'+this.dOfBirth+'-'+window.btoa(Security.ab2str(salt)));
      AuthGateway.registerNewUser(
          passwordHash,
          window.btoa(Security.ab2str(iv)),
          window.btoa(Security.ab2str(salt)),
          basePublic,
          window.btoa(Security.ab2str(encryptedPrivateKey)),
          window.btoa(Security.ab2str(await Encryption.encryptAESBytes(Security.utf8str2ab(this.fName),pbkdf2Key,iv))),
          window.btoa(Security.ab2str(await Encryption.encryptAESBytes(Security.utf8str2ab(this.lName),pbkdf2Key,iv))),
          window.btoa(Security.ab2str(await Encryption.encryptAESBytes(Security.utf8str2ab(this.dOfBirth),pbkdf2Key,iv))),
          await Hashing.digest(this.fName+'-'+this.lName+'-'+this.dOfBirth+'-'+window.btoa(Security.ab2str(salt)))
      ).then(response=>{
        this.buttonDisabled = false;
        if(response.success){

        } else {
          this.errorText = response.text;
        }
      }).catch(()=>{
        this.buttonDisabled = false;
        this.errorText = 'Ошибка запроса';
      })

      console.log("iv - "+window.btoa(Security.ab2str(iv)));
      console.log("salt - "+window.btoa(Security.ab2str(salt)));
      console.log("passwordHash - "+passwordHash);
      console.log("publicKey - "+basePublic);
      console.log("privateKey - "+encryptedPrivateKey);
    }
  }
});
</script>

<style scoped>

</style>