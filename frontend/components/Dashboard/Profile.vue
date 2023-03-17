<template>
  <h4>Профиль</h4>
  <ul class="list-group list-group-flush">
    <router-link to="/dashboard/profile/email" class="list-group-item">Настройка Email</router-link>
    <router-link to="/dashboard/profile/phones" class="list-group-item">Настройка Телефонов</router-link>
    <router-link to="/dashboard/profile/fingerprint" class="list-group-item">Отпечатки пальцев</router-link>
    <router-link to="/dashboard/profile/sessions" class="list-group-item">Сессии</router-link>
    <li class="list-group-item text-danger" @click="logOut">Выйти из системы</li>
  </ul>
</template>

<script lang="ts">
import {defineComponent} from "vue";
import AuthenticationMethods from "@/security/AuthenticationMethods";
export default defineComponent({
  name: "DashboardProfile",
  methods:{
    logOut():void{
      AuthenticationMethods.logOut()
      this.$router.push("/auth");

    }
  }
})
</script>

<style scoped>

</style>