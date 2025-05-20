<template>
    <div id="app">
      <LocationStatus /> <!-- Include your LocationStatus component -->
      <!-- You can add more components or content here as needed -->
    </div>
  </template>
  
  <script>
  import LocationStatus from './components/LocationStatus.vue';
  
  export default {
    name: 'App',
    components: {
      LocationStatus,
    },
  };
  </script>
  
  <style>
  /* Global styles can go here */
  </style>
  