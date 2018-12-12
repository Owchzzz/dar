<template>
    <div class="survey-single container-fluid">
        <div class="product-payment-inner-st" v-if="data">
            <div class="row">
                <div class="col-md-412col-xs-12">
                    <div class="form-area">
                        <h2>Survey Information</h2>
                        <form class="form" style="margin-top:20px;" ref="fieldForm">
                            <div class="form-group">
                                <label class="">CED</label>
                                <input class="form-control" type="text" v-model="data.ced"/>
                            </div>
                            <div class="row">
                            <div class="form-group col-xs-6">
                                <label class="">Patent No.</label>
                                <input class="form-control" type="text" v-model="data.patent_no"/>
                            </div>
                            <div class="form-group col-xs-6">
                                <label class="">OCT</label>
                                <input class="form-control" type="text" v-model="data.oct"/>
                            </div>
                            </div>
                            <div class="form-group">
                                <label class="">TCT</label>
                                <input class="form-control" type="text" v-model="data.tct"/>
                            </div>
                            
                        </form>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="cf-status col-sm-6" v-show="!activeSurveyStatus">
                        <h2>CF Status</h2>
                        <table class="table table-bordered cfRecords" v-if="cfRecords">
                            <thead>
                                <tr>
                                    <th class="text-center">Code</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="cf in cfRecords" :key="cf.id" v-bind:class="getCfClass(cf)" class="clickable" @click="selectCfStatus(cf)">
                                    <td class="text-center" style="font-size:11.5px">{{cf.cf_status_code}}</td>
                                        <td>{{cf.cf_status_value}}</td>
                                        <td style="text-transform:uppercase;">{{cf.status || "pending"}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="survey-status col-sm-6">
                        <h2>Survey Status</h2>
                        <table class="table table-bordered cfRecords" v-if="surveyRecords">
                            <thead>
                                <tr>
                                    <th class="text-center">Code</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="cf in surveyRecords" :key="cf.id" v-bind:class="getCfClass(cf)" class="clickable" @click="selectSurveyStatus(cf)">
                                    <td class="text-center" style="font-size:11.5px">{{cf.survey_status_code}}</td>
                                        <td>{{cf.survey_status_value}}</td>
                                        <td style="text-transform:uppercase;">{{cf.status || "pending"}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="media-fields"></div>
        </div>
        <div v-else>
            
        </div>

        <!-- Modals -->
        <div v-if="activeCf">
            <cf-status :data="activeCf" :current-user-id="currentUserId"></cf-status>
        </div>
        <survey-status v-if="activeSurveyStatus" :data="activeSurveyStatus" :current-user-id="currentUserId"></survey-status>
    </div>
</template>

<script>
import swal from 'sweetalert';
import CfStatus from './cf_status.vue';
import SurveyStatus from './survey_status.vue';

export default {
    props: ['survey_id'],
    components: {
        CfStatus,
        SurveyStatus
    },
    data() {
        return {
            loading:false,
            data:false,
            editting:false,
            cfRecords: false,
            surveyRecords:false,
            activeCf: false,
            activeSurveyStatus: false,
            queueSave:false,
            currentUserId: false,
        }
    },
    watch: {
        editting(val) {
            if(!val) {
                this.disableForm();
            }
            else {
                this.enableForm();
            }
        },
        activeCf: {
            immediate:true,
            deep:true,
            handler(val) {
                if(val) {
                    console.log('cf changed to:',val.status);
                    if(val.status == null) {
                        val.status = "";
                    }
                    if(this.queueSave) {
                        console.log('willsave');
                        let data = {
                            id: this.activeCf.id,
                            status: this.activeCf.status
                        };
                        this.$call('/updatecf', data, resp => {
                            console.log('Saved CF:', resp);
                        });
                    }
                    // Next action will execute a save
                    this.queueSave = true;
                }
                else {
                    this.queueSave = false;
                }
            }

        },

        activeSurveyStatus: {
            immediate:true,
            deep:true,
            handler(val) {
                if(val) {
                    console.log('cf changed to:',val.status);
                    if(val.status == null) {
                        val.status = "";
                    }
                    if(this.queueSave) {
                        console.log('willsave');
                        let data = {
                            id: this.activeSurveyStatus.id,
                            status: this.activeSurveyStatus.status
                        };
                        this.$call('/updatesurvey', data, resp => {
                            console.log('Saved CF:', resp);
                        });
                    }
                    // Next action will execute a save
                    this.queueSave = true;
                }
                else {
                    this.queueSave = false;
                }
            }
        }
    },
    methods: {
        selectCfStatus(cf) {
            console.log('activating cf');
            this.activeCf = cf;
        },
        selectSurveyStatus(cf) {
            console.log('activating cf');
            this.activeSurveyStatus = cf;
        },
        getCfClass(cf) {
            if(cf.status) {
                return cf.status;
            } else {
                return 'stagnant';
            }
        },
        enableForm() {

        },

        disableForm() {
            let form = this.$refs.fieldForm;
            console.log('form:',form);
            let elements = Array.from(form.elements);

            elements.forEach(element => {
                console.log('element:',element);
                element.readOnly = true;
            });
        },

        getCfRecords() {
            this.$call('/cfRecords/'+this.survey_id,{}, data => {
                console.log('cf:resp:',data);
                this.cfRecords = data;
            });
        },

        getSurveyRecords() {
            this.$call('/surveyRecords/'+this.survey_id,{},data=> {
                console.log('sf:resp:',data);
                this.surveyRecords = data;
            });
        }
    },

    mounted() {
        this.currentUserId = window.userId;
        try {
            this.$getSingle({id:this.survey_id}, (data) => {
                this.data = data;
                this.$nextTick(() => {    
                    this.disableForm();
                    this.getCfRecords();
                    this.getSurveyRecords();
                });
            });
        } catch (e) {
            console.error(e);
            swal('Unauthorized.','You have no access to this page. Or the page you are trying to access does not exist','error').then(resp => {
                console.log('redirecting back');
                window.history.back();
            });
        }

        this.$root.$on('closeCf',()=>{
            this.activeCf = false;
        });

        this.$root.$on('closeSurvey',()=>{
            this.activeSurveyStatus = false;
        });
        
    }
}
</script>

<style lang="scss">
    .form-area {
        padding:15px;
        background-color: #fafafa;
    }

    .cfRecords {
        tr {
            transition:0.2s ease all;
            &.clickable {
                &:hover {
                    background-color:white;
                    cursor: pointer;
                    transition: 0.2s ease all;
                    font-weight:bold;
                    border-left:3px solid rgb(0, 0, 66);
                }
            }
            &.stagnant {
                background-color:#fafafa;
            }
            &.completed {
                background-color:rgb(176, 255, 176);
            }
            &.problem {
                background-color:rgb(255, 206, 206);
            }
            &.warning {
                background-color:rgb(255, 255, 200);
            }
        }
    }
    .file-upload-item {
    display:flex;
    flex-wrap:wrap;
    flex-direction: row;
    margin:0;
    padding:13px;
    background-color:white;
    border:1px solid #fafafa;
    span.file-name {
        flex-grow:3;
        font-size:14px;
        font-weight:bold;
    }
    span.file-status {
    }
}
</style>
