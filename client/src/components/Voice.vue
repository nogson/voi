<template>
  <div class="voice">
    <img class="avatar" :class="{animation:isPlay}" :src="avatar" @click="toggle">
    <audio ref="audio" :src="sound" @ended="ended"/>
  </div>
</template>

<script lang="ts">
    import {Component, Prop, Vue} from "vue-property-decorator";
    import {IVoice} from '@/common/interface';

    // interface Item {
    //     id: number
    //     avatar: string
    //     sound: string
    //     created_at: string
    //     updated_at: string,
    // }

    @Component({
        components: {}
    })

    export default class Voice extends Vue {

        isPlay = false

        @Prop({default: null}) item!: IVoice;

        created(): void {
            this.isPlay = true
            setTimeout(() => {
                this.isPlay = false
            }, 1000)
        }

        get avatar() {
            return require(`@/assets/images/${this.item.avatar}`)
        }

        get sound(): string {
            return `/${this.item.sound}`
        }

        toggle() {
            const audio: any = this.$refs.audio
            if (this.isPlay) {
                audio.pause()
            } else {
                audio.play()
            }
            this.isPlay = !this.isPlay
        }

        ended() {
            this.isPlay = false
        }

    }

</script>

<style scoped lang="scss">
  .voice {
    margin: 0 10px;
    background: url("~@/assets/images/neck.png") no-repeat;
    background-position: 0 115px;
  }

  .avatar {
    cursor: pointer;

    &.animation {
      animation: rotation 1200ms infinite 0ms alternate;
    }
  }

  @keyframes rotation {
    0% {
      transform: rotate(0) translateX(0);
    }

    25% {
      transform: rotate(10deg) translateX(10px);
    }

    50% {
      transform: rotate(0deg) translateX(0);
    }

    75% {
      transform: rotate(10deg) translateX(10px);
    }

    100% {
      transform: rotate(0) translateX(0);
    }
  }
</style>