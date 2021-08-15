<template>
  <div class="content">
    <Header />
    <CourseFeatured />
    <Footer />
  </div>
</template>

<script>
import Header from './components/Header.vue'
import CourseFeatured from './components/CourseFeatured.vue'
import Footer from './components/Footer.vue'
export default {
  components: {
    Header,
    CourseFeatured,
    Footer
  },
}
</script>