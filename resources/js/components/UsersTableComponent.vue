<template>

  </template>

  <script>


  export default {
    data() {
      return {
        headers: [

        ],
        users: [],
        totalUsers: 0,
        options: {},
        search: '',
        loading: true,
      };
    },
    created () {
        this.fetchData();
    },
    methods: {

    },
    mounted() {

    },
  };
  </script>
