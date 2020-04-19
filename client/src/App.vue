<template>
  <div id="app">
    <common-header/>
    <voices v-if="loaded" :items="sounds"/>
    <div v-else class="spinner2">
      <spinner2/>
    </div>
    <Record @update="update"/>
  </div>
</template>

<script lang="ts">
    import {Component, Vue} from "vue-property-decorator";
    import HelloWorld from "./components/HelloWorld.vue";
    import Record from "./components/Record.vue";
    import Voices from "./components/Voices.vue";
    import {IVoice} from "@/common/interface";
    import CommonHeader from "@/components/CommonHeader.vue";
    import Spinner2 from "@/components/Spinner2.vue";

    @Component({
        components: {
            Spinner2,
            CommonHeader,
            Voices,
            Record,
            HelloWorld
        }
    })
    export default class App extends Vue {
        sounds: any = null;
        loaded = false

        created(): void {
            this.axios.get('/api/sound').then(res => {
                this.sounds = res.data.sounds;
                this.loaded = true
            })
        }

        update(res: any) {
            this.sounds.unshift(res.sound)
        }
    }
</script>

<style lang="scss">
  #app {
    font-family: Avenir, Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    height: 100%;
  }

  body, html {
    height: 100%;
  }

  .spinner2 {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: -120px;
  }
</style>
