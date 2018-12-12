<template>
    <div class="cf-status">

        <div class="cf-overlay" @click="closeCf()"></div>
        <div class="cf-content animated slideInRight">
            <div class="top-content">
            <i class="fa fa-times pull-right clickable" @click="closeCf"></i>
            <h3>{{data.cf_status_code}} {{data.cf_status_value}}</h3>
            <hr/>

            <div class="cf-content-header">
                <span class="label label-primary">CF Status</span>
                <div class="form-group">
                    <select v-model="data.status" class="form-control" placeholder="Pending">
                        <option value="">Pending</option>
                        <option value="completed">Completed</option>
                        <option value="problem">Has Problem</option>
                        <option value="warning">Has Warning</option>
                    </select>
                </div>
            </div>

            
            
            <div class="logs commentTable">
                <table class="table ">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Message</th>
                            <th style="width:150px;">Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="log in data.logs" :key="log.id">

                            <td v-if="log.user_id != currentUserId">{{ log.first_name}} {{log.last_name}}</td>
                            <td style="font-style:italic;" v-else>You</td>
                            <td style="max-width:80%"><p>{{log.log}}</p><files :files="log.files"></files></td>
                            <td>{{getTime(log.created_at)}}</td>
                            
                        </tr>
                        <tr v-if="data.logs.length === 0">
                            <td colspan="3" style="text-align:center">No comments yet.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            </div>
            <div class="commentEditor">
                <span class="label label-info">Write a comment</span>
                <textarea class="form-control commentBox" v-model="comment" placeholder="Coment here..."></textarea>
                <!-- <uploader :options="options" class="uploader-example" ref="uploader" :is-complete="fileUploaded">
                    <uploader-unsupport></uploader-unsupport>
                    <uploader-drop>
                    <uploader-btn>upload files</uploader-btn>
                    </uploader-drop>
                    <uploader-list></uploader-list>
                </uploader> -->
                <div v-if="options">
                <vue-clip :options="options" :on-complete="fileUploaded">
                    <template slot="clip-uploader-action">
                    <div>
                        <div class="dz-message"><button class="btn btn-md"><i class="fa fa-file"></i> Upload file</button></div>
                    </div>
                    </template>

                    <template slot="clip-uploader-body" scope="props">
                    <div class="file-upload-item" v-for="file in props.files" :key="file.id">
                        <span class="file-name">{{ file.name }}</span> <span class="file-status">{{ file.status }}</span>
                    </div>
                    </template>

                </vue-clip>
                </div>
                <button style="margin-top:12px;" class="btn btn-md btn-info pull-right" @click="submitComment()"><i class="fa fa-check"></i> Save Comment</button>
            </div>
        </div>
    </div>
</template>
<script>
import {
    SweetModal,
    SweetModalTab
} from 'sweet-modal-vue';
import swal from 'sweetalert';
import moment from 'moment';
import files from './files';
export default {
    data() {
        return {
            comment: '',
            users: [],
            options: false,
            uploadedFiles: [],
        }
    },

    props: ['data','currentUserId'],
    components: {
        SweetModal,
        SweetModalTab,
        files
    },
    watch: {
        
    },
    methods: {
        fileUploaded(resp,status,xhr) {
            let data = JSON.parse(xhr.response);
            this.uploadedFiles.push(data.id);
        },
        

        getTime(time) {
            return moment(time).format('LLL');
        },
        closeCf() {
            this.$root.$emit('closeCf',true);
        },
        getCommentor: async (id) => {
            let user = this.users.find(user => {
                return id === user.id;
            });

            if(!user) {
                return this.$call('/getCommentor/'+id,{},resp => { 
                    this.users.push(resp);
                    return resp;
                });
            } else {
                return user;
            }


        },
        submitComment() {
            
            if(!this.comment || this.comment == '') {
                swal('Error','Can not submit empty comment request','error');
                return false;
                
            }
            console.log('Submitted:',this.comment);
            let data = {
                log_id: this.data.log_id,
                log: this.comment,
                files: this.uploadedFiles
            }

            this.options = false;
            this.$call('/submitComment',data, (resp) => {
                console.log('comment submitted', resp);
                this.data.logs.push(resp);
                this.comment = '';
                swal('Log Comment','Comment has been submitted','success');
                this.options = {
                    url: this.$getUrl('tempFileUpload/'+this.data.log_id),
                    autostart:true,
                }
            });
        }
    },
    mounted() {
        // this.$refs.modal.open();
        this.options = {
                url: this.$getUrl('tempFileUpload/'+this.data.log_id),
                autostart:true
            };
    }
}
</script>
<style>
.swal-overlay {
    z-index:20000;
}
</style>

<style lang="scss" scoped>
.cf-status {
    .cf-content {
        h3 {
            font-weight:normal;
            font-size:14px;
        }
        display:block;
        position:fixed;
        top:0;
        right:0;
        height:100%;
        width:70%;
        min-width:550px;
        background-color:white;
        -webkit-box-shadow: 0px 0px 10px 0px rgba(87,87,87,1);
        -moz-box-shadow: 0px 0px 10px 0px rgba(87,87,87,1);
        box-shadow: 0px 0px 10px 0px rgba(87,87,87,1);
        z-index:10001;

        .top-content {
            padding:22px;
            display:block;
            height:60%;
            overflow-y:scroll;
        }
    }
    .cf-overlay {
        z-index:10000;
        display:block;
        position:fixed;
        top:0;
        left:0;
        width:100%;
        height:100%;
        background-color:black;
        opacity:0.1;
        cursor:pointer;
    }
    .clickable {
        cursor:pointer;
    }
    .commentBox {
        resize: none;
        height:64%;
        padding:7px;
        
    }
    .commentEditor {
        display:block;
        height:40%;
        overflow-y:scroll;
        padding:22px;
        background-color:#fafafa;
        width:97%;
    }
    // .commentTable {
    //     max-height:400px;
    //     overflow-y:scroll;
    //     padding-bottom:200px;
    //     display:block;
    //     height:30%;
    // }

}


/** File uploader **/


</style>
