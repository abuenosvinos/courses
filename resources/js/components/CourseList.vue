<template>
  <ul>
    <li v-for="course in courses" :key="course.id">
      <CourseShort :course="course" />
    </li>
  </ul>
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