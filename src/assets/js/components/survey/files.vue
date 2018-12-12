<template>
    <p class="filesData" v-if="fileData">
        <b>Attachments: </b>
        <br/>
        <span class="file-single" v-for="file in fileData" :key="file.id">
            <a target="_blank" :href="'/file/download/' + file.id">
                {{file.filename}}, 
            </a>
        </span> 
    </p>
</template>
<script>
export default {
    props: ['files'],
    
    data() {
        return {
            fileData:false
        }
    },

    methods: {
        getFiles(filesdata) {
            if(filesdata) {
                let files = [];
                let fileData = JSON.parse(filesdata);
                this.fileData = [];
                fileData.forEach(file => {
                    this.$callGet('/file/'+file, data => {
                        console.log('Loaded file data');
                        console.log(data);
                        this.fileData.push(data);
                    });
                });
            }

        },
    },
    mounted() {
        console.log('Loading file data...');
        this.getFiles(this.files);
    }
}
</script>

<style lang="scss" scoped>
.filesData {
    line-height: 2.3;
}
    .file-single {
        padding:6px;
        margin:0px 8px;
        border-radius:10px;
        background-color:#c4c4c4;
        border:1px solid #fafafa;
    }
</style>
