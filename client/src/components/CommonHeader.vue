<template>
    <header>
      <img class="logo" alt="voooice" src="@/assets/images/logo.png" />
      <span class="desc">声を録音したり聞いたりするだけのサービス</span>
    </header>
</template>

<script lang="ts">
    import {Component, Prop, Vue} from "vue-property-decorator";

    @Component({
        components: {}
    })

    export default class CommonHeader extends Vue {

    }

</script>

<style scoped lang="scss">
  header{
    padding: 40px;
    display: flex;
    align-items: center;
  }
  .logo{
    width: 120px;
    margin-right: 20px;
  }

  .desc{
    font-size: 10px;
    margin-top: 15px;
  }

</style>