<template>
  <h4>Настройка телефонов</h4>

  <button class="btn btn-outline-success w-100 my-1" @click="addNewShow">Добавить телефон</button>
  <p class="text-center my-1" v-if="list.length===0">Телефоны не добавлены</p>
  <ul class="list-group my-1" v-if="list.length>0">
    <li class="list-group-item" :key="item.id" v-for="item in list" @click="editItem(item.id)">{{item.email}}</li>
  </ul>


  <div class="offcanvas offcanvas-start" tabindex="-1" id="addEditPhone" aria-labelledby="offcanvasLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasLabel">{{newEditId===null?'Добавление нового телефона':'Редактирование телефона'}}</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <label for="newEditEmail">Email:</label>
      <input type="email" class="form-control" id="newEditEmail" v-model="newEditEmail">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" v-model="newEditAllowAuth" id="newEditAllowAuth">
        <label class="form-check-label" for="newEditAllowAuth">
          Разрешить авторизацию
        </label>
      </div>
      <p class="m-0 text-danger text-center">{{errorText}}</p>
      <button class="btn btn-primary w-100 my-1" v-if="newEditId===null" @click="addNewPhone">{{ Localization.add }}</button>
      <button class="btn btn-primary w-100 my-1" v-if="newEditId!==null">{{ Localization.edit }}</button>
      <button class="btn btn-danger w-100 my-1" v-if="newEditId!==null" @click="deletePhone">{{ Localization.delete }}</button>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "vue";
import {Offcanvas} from "bootstrap";
export default defineComponent({
  name: "PhonesConfigure",
  data(){
    return{
      list:[],

      newEditId:null as number|null,
      newEditEmail:"" as string,
      newEditAllowAuth:false as boolean,
      errorText:"" as string,
    }
  },
  methods:{
    addNewShow():void{
      this.newEditId = null;
      this.newEditEmail ="";
      this.newEditAllowAuth =false;
      let item = Offcanvas.getOrCreateInstance("#addEditEmail");
      item.show();
    },
    addNewPhone():void{},
    deletePhone():void{},
  }
})
</script>

<style scoped>

</style>