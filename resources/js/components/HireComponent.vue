<template>
    <div class="card text-center">
        <div class="card-body">
            <h5 class="card-title">Hire me!</h5>
            <p class="card-text">It's going to be a good addition to your team.</p>

            <v-btn :href="cvRoute" color="primary" rounded="lg" prepend-icon="bi bi-box-arrow-down pt-1">Get CV</v-btn>
        </div>
        <div class="card-footer text-muted">
            Antonio Morales Zúñiga
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Hire me card',
        props: {
            cvRoute: { type: String, required: true }
        },
        data() {
            return {

            }
        },
        methods:{

        },
        mounted() {

        }
    }
</script>
