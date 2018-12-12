<template>
    <div class="dashboard">
        <div class="dashboard-statistics">
            <button class="btn btn-success-bg btn-lg" @click="createNew()">Create</button>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    mounted() {
        
    },
    methods: {
        createNew() {
            let uri = route('api/survey/create');
            axios.post(uri, {name:'test'}).then(resp => {
                console.log(resp);
            })
        }
    }
}
</script>
