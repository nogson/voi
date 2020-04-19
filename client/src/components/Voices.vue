<template>
  <div class="voices">
    <Voice v-for="item in items" :key="item.id" :item="item"/>
  </div>
</template>

<script lang="ts">
    import {Component, Prop, Vue} from "vue-property-decorator";
    import Voice from "./Voice.vue";
    import {IVoice} from '@/common/interface';

    @Component({
        components: {
            Voice
        }
    })

    export default class Voices extends Vue {

        @Prop({default: null}) items!: IVoice[];
    }

</script>

<style scoped lang="scss">

  .voices{
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    padding: 10px;

  }

</style>