<template>
  <h4>Список организаций</h4>

  <button class="btn btn-primary w-100" @click="(<typeof CreateNewOrgModal>$refs.createNewOrgModal).showOffcanvas()">Создать организацию</button>

  <CreateNewOrgModal ref="createNewOrgModal"></CreateNewOrgModal>
</template>

<script lang="ts">
import {defineComponent} from 'vue'
import CreateNewOrgModal from "@/components/Workflow/Modals/CreateNewOrgModal.vue";

export default defineComponent({
  name: "OrgList",
  computed: {
    CreateNewOrgModal() {
      return CreateNewOrgModal
    }
  },
  components: {CreateNewOrgModal}
})
</script>



<style scoped>

</style>