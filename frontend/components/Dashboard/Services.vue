<template>
  <h4>{{ Localization.services }}</h4>

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