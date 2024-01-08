<template>
  <transition
    name="loading-fade"
    @after-leave="handleAfterLeave"
  >
    <div
      v-show="visible"
      class="loading-mask"
      :style="{ backgroundColor: background || '' }"
      :class="[customClass, { 'is-fullscreen': fullscreen }]"
    >
      <div class="loading-spinner">
        <svg
          v-if="!spinner"
          class="circular"
          viewBox="25 25 50 50"
        >
          <circle
            class="path"
            cx="50"
            cy="50"
            r="20"
            fill="none"
          />
        </svg>
        <i
          v-else
          :class="spinner"
        />
        <p
          v-if="text"
          class="loading-text"
        >
          {{ text }}
        </p>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  data() {
    return {
      text: null,
      spinner: null,
      background: null,
      fullscreen: false,
      visible: false,
      customClass: ''
    }
  },

  methods: {
    /**
     * Handle after leave
     */
    handleAfterLeave() {
      this.$emit('after-leave')
    },

    /**
     * Set loading text
     *
     * @param {string} text - Set text loading when option text has value
     */
    setText(text) {
      this.text = text
    }
  }
}
</script>

<style lang="scss" scoped>
.loading-mask {
  position: absolute;
  z-index: 1100;
  background-color: rgba(255, 255, 255, 0.9);
  margin: 0;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  transition: opacity 0.4s ease;

  &.is-fullscreen {
    position: fixed;
    z-index: 2000;
  }

  .loading-spinner {
    top: 50%;
    margin-top: -18px;
    width: 100%;
    text-align: center;
    position: absolute;

    .loading-text {
      color: #ccc;
    }

    .circular {
      height: 50px;
      width: 50px;
      animation: loading-rotate 2s linear infinite;
    }

    .path {
      animation: loading-dash 1.5s ease-in-out infinite;
      stroke-dasharray: 90, 150;
      stroke-dashoffset: 0;
      stroke-width: 4;
      stroke: #000;
      stroke-linecap: round;
    }

    i {
      color: #000;
    }
  }
}

.loading-fade {
  &-enter {
    opacity: 0;
  }
  &-enter-active {
    transition: opacity 0.4s ease;
  }
  &-leave-active {
    opacity: 0;
    transition: opacity 0.4s ease;
  }
}

@keyframes loading-rotate {
  100% {
    transform: rotate(360deg);
  }
}

@keyframes loading-dash {
  0% {
    stroke-dasharray: 1, 200;
    stroke-dashoffset: 0;
  }

  50% {
    stroke-dasharray: 90, 150;
    stroke-dashoffset: -40px;
  }

  100% {
    stroke-dasharray: 90, 150;
    stroke-dashoffset: -120px;
  }
}
</style>
