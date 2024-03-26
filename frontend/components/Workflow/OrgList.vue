<template>
  <h4>Список организаций</h4>

  <button class="btn btn-primary w-100" @click="(<typeof CreateNewOrgModal>$refs.createNewOrgModal).showOffcanvas()">
    Создать организацию
  </button>

  <div class="row my-1">
    <div class="col-md-4" v-for="item in orgList">
      <div class="card">
        <div class="card-body text-center">
          <h5 class="card-title">{{ item.name }}</h5>

          <button class="btn btn-outline-primary w-100">Перейти к организации</button>
        </div>
      </div>
    </div>
  </div>

  <CreateNewOrgModal ref="createNewOrgModal"></CreateNewOrgModal>
</template>

<script lang="ts">
import {defineComponent} from 'vue'
import CreateNewOrgModal from "@/components/Workflow/Modals/CreateNewOrgModal.vue";
import WorkflowGateway from "@/gateway/WorkflowGateway";
import type {phoneListResponseItem} from "@/gateway/Interfaces/DashboardGatewayIntefaces";
import Encryption from "@/security/Encryption";
import Security from "@/security/Security";
import type {organizationItemInterface} from "@/gateway/Interfaces/WorkflowGatewayInterfaces";

export default defineComponent({
  name: "OrgList",
  computed: {
    CreateNewOrgModal() {
      return CreateNewOrgModal
    }
  },
  data() {
    return {
      orgList: [] as organizationItemInterface[],

      cryptoKey: null as CryptoKey|null,
      gateway: new WorkflowGateway(localStorage.getItem("authToken") ?? "")
    }
  },
  async mounted() {
    this.cryptoKey = await Security.getDerivedKey()
    this.gateway.getMyOrg().then(async response => {
      if (response.success) {
        this.orgList = await this.remapListElements(response.data.organizations)
      }
    })
  },
  methods:{
    async remapListElements(input:organizationItemInterface[]):Promise<organizationItemInterface[]>{
      let clientIv = localStorage.getItem("iv") ?? "";
      return await Promise.all(input.map(async item => {
        if(this.cryptoKey!==null) {
          let orgKey = await Encryption.decryptAES(item.encryptionKey, this.cryptoKey,clientIv);
          console.log(orgKey)
          let derivedOrgKey = await Encryption.deriveKey(orgKey,Security.str2ab(window.atob(item.salt)));
          item.name = await Encryption.decryptAES(item.name,derivedOrgKey,item.iv)
        }
        return item;
      }));
    },
  },
  components: {CreateNewOrgModal}
})
</script>


<style scoped>

</style>