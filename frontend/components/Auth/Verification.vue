<template>
  <h4>Предварительная верификация</h4>
  <label for="selectCountry">Гражданство:</label>
  <select name="" id="selectCountry" class="form-select">
    <option value="rus">Россия</option>
    <option value="bel">Беларусь</option>
    <option value="oth">Другое</option>
  </select>
  <label for="userPassword">Фамилия (на латинице):</label>
  <input type="text" class="form-control" v-model="lName" id="userPassword">
  <label for="userPassword">Имя (на латинице):</label>
  <input type="text" class="form-control" v-model="fName" id="userPassword">
  <label for="userPassword">Дата рождения:</label>
  <input type="date" class="form-control" v-model="dOfBirth" id="userPassword">
  <label for="selectCountry">Документ:</label>
  <select name="" id="selectPassport" class="form-select">
    <option value="passport">Паспорт</option>
    <option value="bel">Водительское удостоверение</option>
  </select>
  <div class="mb-3">
    <label for="formFile" class="form-label">Фотография документа</label>
    <input class="form-control" type="file" id="formFile">
  </div>
</template>

<script lang="ts">
import {defineComponent} from "vue";
import dayjs from "dayjs";
export default defineComponent({
  name: "IdVerification",
  data(){
    return{
      lName:"" as string,
      fName:"" as string,
      dOfBirth:dayjs().format("YYYY-MM-DD") as string
    }
  }
})
</script>

<style scoped>

</style>