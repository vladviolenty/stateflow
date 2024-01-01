<template>
  <h4>{{ Localization.services }}</h4>
  <div class="row">
    <div class="col-md-4">
      <router-link to="/dashboard/workflow" class="card">
        <div class="card-body text-center">
          <h1><i class="bi bi-person-workspace"></i></h1>
          WorkFlow
        </div>
      </router-link>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "vue";
import {mapState} from "pinia";
import {appStore} from "@/stores/AppStore";
export default defineComponent({
  name: "DashboardServices",
  computed:{
    ...mapState(appStore, ['Localization']),
  },
})

</script>

<style scoped>

</style>