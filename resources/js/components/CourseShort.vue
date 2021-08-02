<template>
  <div>
    <p>{{ course.title }}</p>
    <p>{{ course.description }}</p>
    <p>{{ course.startAt }}</p>
    <p>{{ course.level }}</p>
    <ul>
      <li v-for="category in course.categories">
        {{ category.name }}
      </li>
      <li v-for="price in course.prices">
        {{ price.price }}{{ price.code }}
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "CourseShort",
  props: {
    course: Object,
  }
}
</script>

<style scoped>

</style>