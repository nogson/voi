<template>
  <div>
    <transition name="fade">
      <div class="rec_wrap" :class="recWrapClass" @click="toggleModal">
        <button class="btn_rec" @click.stop.prevent="toggleModal" v-show="!isOpen">REC</button>
        <div class="recording_wrap" v-show="isOpen">
          <transition name="fade">
            <span class="recording_text" v-show="isRecording">Recording</span>
          </transition>
          <transition name="fade">
            <spinner v-show="isRecording"/>
          </transition>
          <transition name="fade">
            <button v-show="isRecording" class="recording_stop" @click.stop.prevent="stopRecording">Stop</button>
          </transition>
          <transition name="fade">
            <button v-show="!isRecording" class="recording_start" @click.stop.prevent="startRecording">Start Recording</button>
          </transition>
        </div>
      </div>
    </transition>
  </div>
</template>

<script lang="ts">
    import Spinner from "@/components/Spinner.vue";

    declare const MediaRecorder: any;

    import {Component, Prop, Vue} from "vue-property-decorator";

    @Component({
        components: {Spinner}
    })
    export default class Record extends Vue {
        status = "init";
        recorder: any = null;
        audioData: Blob[] = [];
        audioExtension: any = "";
        isOpen = false;
        isRecording = false;


        created(): void {
            navigator.mediaDevices.getUserMedia({audio: true}).then(stream => {
                this.recorder = new MediaRecorder(stream);
                this.recorder.addEventListener("dataavailable", (e: any) => {
                    this.audioData.push(e.data);
                    this.audioExtension = this.getExtension(e.data.type);
                });
                this.recorder.addEventListener("stop", () => {
                    console.log('okk')
                    const audioBlob = new Blob(this.audioData);
                    this.save(audioBlob)
                });
                this.status = "ready";
            });
        }

        save(blobData: any) {
            const data = new FormData();
            data.append('sound', blobData, 'sound.webm');
            data.append('avatar', `avatar_${Math.floor(Math.random() * 33 + 1)}.png`);

            this.axios.post('/api/record', data, {
                headers: {'content-type': 'multipart/form-data'}
            }).then((res: any) => {
                this.$emit('update', res.data)
            }).catch((error: any) => {
                new Error(error)
            });
        }

        toggleModal() {
            if(this.isRecording){
                this.stopRecording()
                return
            }
            this.isOpen = !this.isOpen
        }

        startRecording() {
            this.isRecording = true;
            this.audioData = [];
            this.recorder.start();
        }

        stopRecording() {
            this.isRecording = false;
            this.isOpen = false
            this.recorder.stop();
        }

        getExtension(audioType: string) {
            let extension = "wav";
            const matches = audioType.match(/audio\/([^;]+)/);

            if (matches) {
                extension = matches[1];
            }

            return "." + extension;
        }

        get recWrapClass(): string {
            return this.isOpen ? 'open' : 'close'
        }
    }
</script>

<style scoped lang="scss">
  $btn-size: 60px;
  $color-primary: #38c867;
  $max-width:300px;

  .rec_wrap {
    position: fixed;
    right: 40px;
    bottom: 40px;
    background: rgba($color-primary, 0);
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 400px;

    &.open {
      animation: open 0.5s ease-in-out .0s forwards;;
    }

    &.close {
      animation: close 0.5s ease-in-out .0s forwards;;
    }
  }


  .btn_rec {
    width: $btn-size;
    height: $btn-size;
    background: $color-primary;
    color: #FFF;
    font-weight: bold;
    text-align: center;
    line-height: $btn-size;
    border-radius: $btn-size;
    font-size: 18px;
    border: none;
  }

  .recording_wrap {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    /*margin-top: 40px;*/
  }

  .recording_text {
    color: #FFF;
    font-weight: bold;
    padding-bottom: 10px;
  }

  .recording_start {
    width: 200px;
    background: #FFF;
    color: $color-primary;
    font-size: 20px;
    padding: 10px 20px;
    border-radius: 100px;
    font-weight: bold;
    position: absolute;
    left:50%;
    right: 50%;
    transform: translateY(-50%);
    transform: translateX(-50%);
    border: none;
  }


  .recording_stop {
    background: none;
    color: #FFF;
    border: 2px solid #FFF;
    margin-top: 30px;
    font-size: 20px;
    padding: 10px 20px;
    border-radius: 100px;
    font-weight: bold;
    border: none;
  }

  @keyframes open {
    0% {
      right: 40px;
      bottom: 40px;
      width: $btn-size;
      height: $btn-size;
    }

    50% {
      background: rgba($color-primary, 0.9);
    }

    100% {
      right: calc(50% - #{$max-width} / 2);
      bottom: calc(50% - #{$max-width} / 2);
      width: $max-width;
      height: $max-width;
      background: rgba($color-primary, 0.9);
    }
  }


  @keyframes close {
    0% {
      right: calc(50% - #{$max-width} / 2);
      bottom: calc(50% - #{$max-width} / 2);
      width: $max-width;
      height: $max-width;
      background: rgba($color-primary, 0.9);
    }

    50% {
      background: rgba($color-primary, 0);
    }

    100% {
      right: 40px;
      bottom: 40px;
      width: $btn-size;
      height: $btn-size;
    }
  }

  .fade-enter-active, .fade-leave-active {
    transition: opacity 0.5s ease-in-out 0s;
  }

  .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */
  {
    opacity: 0;
  }

  .btn_rec,
  .recording_stop,
  .recording_start{
    cursor: pointer;
  }


</style>
