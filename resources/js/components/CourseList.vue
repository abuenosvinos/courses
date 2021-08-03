<template>
  <div class="container">
    <div class="row">
      <div class="col" v-for="course in courses" :key="course.id">
        <CourseShort :course="course" />
      </div>
    </div>
  </div>
</template>

<script>
import CourseShort from "./CourseShort";
export default {
  name: "CourseList",
  components: {CourseShort},
  props: {
    courses: Array
  }
}
</script>

<style scoped>

</style>