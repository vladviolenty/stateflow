<template>
  <h4>{{Localization.welcome}}</h4>
</template>

<script lang="ts">
import {defineComponent} from "vue";
import {mapState} from "pinia";
import {appStore} from "@/stores/AppStore";
export default defineComponent({
  name: "IndexPage",
  computed: {
    ...mapState(appStore, ['Localization']),
  },
})
</script>

<style scoped>

</style>