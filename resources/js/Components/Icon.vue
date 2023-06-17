<template>
    <SvgIcon type="mdi" :path="path" />
</template>

<script setup lang="ts">
import SvgIcon from '@jamescoyle/vue-icon'

defineProps({
  path: String
})

</script>

<style scoped>

</style>
