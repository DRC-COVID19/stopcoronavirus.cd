<template>
  <div class="fullscreen-container">
    <Fullscreen :ref="id" @change="fullscreenChange" class="col-12 p-0">
      <slot></slot>
    </Fullscreen>
    <button type="button" @click="toggleFullscreen" class="fullscreen-btn mini">
      <i class="fa fa-expand"></i>
    </button>
  </div>
</template>

<script>
import Fullscreen from "vue-fullscreen/src/component.vue";
export default {
  components: {
    Fullscreen,
  },
  props: {
    id: {
      type: String,
      required: true,
    },
    link: {
      type: String,
      required: true,
    },
  },
  methods: {
    toggleFullscreen() {
      this.$nextTick(() => {
        this.$refs[this.id].toggle();
      });
    },
    fullscreenChange(fullscreen) {
      this.$nextTick(() => {
        this.$emit("change", fullscreen, this.link);
      });
    },
  },
};
</script>
<style lang="scss" scoped>
.fullscreen-container {
  position: relative;
  height: auto;
    width: 100%;
  .fullscreen-btn {
    transform-origin: center;
    transform: scale(0);
    opacity: 0;
    bottom: 20px;
    left: 20px;
    position: absolute;
    z-index: 2;
    background-color: #2e5bff;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: none;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
    transition: all 0.2s ease-in-out;
    &.mini {
      width: 30px;
      height: 30px;
      bottom: 10px;
      left: 10px;
      i {
        font-size: 12px;
      }
    }
    &:focus {
      outline: none;
    }
    i {
      color: white;
    }
  }
  &:hover .fullscreen-btn {
    transform: scale(1);
    opacity: 1;
  }
}
.fullscreen{
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
