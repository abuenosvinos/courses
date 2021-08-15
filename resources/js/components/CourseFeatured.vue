<template>
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
</template>

<script>
import CourseList from "./CourseList";
export default {
  name: "CourseFeatured",
  components: {CourseList},
  props: {
    lang: String,
  },
  data() {
    return {
      lang: 'en',
      courses: [],
      error: false
    }
  },
  methods: {
    loadCourses: async function () {
      try {
        this.error = false;
        this.courses = [];
        const response = await fetch('http://api.courses.local:8080/api/courses?page=3&lang=' + this.lang, {
          headers: {
            'Content-Type': 'application/json',
            'X-AUTH-TOKEN': 'eyJhbGciOiJkaXIiLCJlbmMiOiJBMjU2R0NNIiwiemlwIjoiREVGIn0..7loEvj9wdQ5fGpRB.KDBqffJlOy7mG3rvga2yTo8NREbMgVyxI9R0hF12_Kj9sXp30MSO.KLeY4O9wwx4GrtG0pXeEug'
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
    this.$root.$on('change_language', (lang) => {
      this.lang = lang;
      this.loadCourses();
    })
    this.loadCourses();
  }
}
</script>

<style scoped>

</style>