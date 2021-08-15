<template>
  <header>
    <div class="container">
      <div class="row">
        <div class="col">
          Simple Vue.js App
        </div>
        <div class="col-1">
          <ul>
            <li><span data-lang="en" v-on:click="ChangeLang('en')">US</span></li>
            <li><span data-lang="mx" v-on:click="ChangeLang('mx')">Mexico</span></li>
            <li><span data-lang="es" v-on:click="ChangeLang('es')">Spain</span></li>
          </ul>
        </div>
      </div>
    </div>
  </header>
</template>

<script>
export default {
  name: 'Header',
  methods: {
    ChangeLang: function (lang) {
      if (document.documentElement.lang !== lang) {
        document.documentElement.lang = lang;
        this.$root.$emit('change_language', lang);
      }
    }
  }
}
</script>

<style scoped></style>