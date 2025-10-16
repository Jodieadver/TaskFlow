<template>
  <button @click="toggleActive" class="base-button" :class="mode">
    <slot></slot>
  </button>
</template>

<script>
export default {
  props: ["mode"],
  data() {
    return {
      isActive: false,
    };
  },
  methods: {
    toggleActive() {
      this.isActive = !this.isActive;
    },
  },
};
</script>

<style scoped>
.active {
  color: hsl(220, 98%, 61%);
}
</style>