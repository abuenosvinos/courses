<template>
  <div class="content">
    <Header />

    <div class="container">
      <div class="row">
        <div class="col">
          <h1>Listado de Cursos</h1>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <CourseList v-if="courses.length && !error" :courses="courses" />
        </div>
      </div>
      <div v-if="!courses.length && !error" class="row alert alert-info" role="alert">
        <div class="col">
          No hay cursos
        </div>
      </div>
      <div v-if="error" class="row alert alert-danger" role="alert">
        <div class="col">
          Error al obtener los cursos
        </div>
      </div>
    </div>

    <Footer />
  </div>
</template>

<script>
import Header from './components/Header.vue'
import CourseList from './components/CourseList.vue'
import Footer from './components/Footer.vue'
export default {
  components: {
    Header,
    CourseList,
    Footer
  },
  data() {
    return {
      courses: [],
      error: false
    }
  },
  methods: {
    loadCourses: async function () {
      try {
        this.error = false;
        const response = await fetch('http://api.courses.local:8080/api/courses?page=3', {
          headers: {
            'Content-Type': 'application/json',
            'X-AUTH-TOKEN': 'eyJhbGciOiJkaXIiLCJlbmMiOiJBMjU2R0NNIiwiemlwIjoiREVGIn0..RDn-WnSMJOSJi7cN.05c4S6csHFt9Szawt5u8gnCIOysyakz5zZLI.tgxBHwroAzVZoNMel6j5aA'
          }
        });
        let responseJson = await response.json();
        let results = responseJson.results;

        results.forEach(function(valor, index) {
            this.push(
                {
                  id: index,
                  title: valor.title,
                  description: valor.description,
                  startAt: valor.startAt,
                  level: valor.level,
                  categories: valor.categories,
                  prices: valor.prices
                }
            );
          }, this.courses
        );
      } catch (error) {
        this.error = true;
        console.error('Error: ' + error);
      }
    },
  },
  mounted() {
    this.loadCourses();
  }
}
</script>