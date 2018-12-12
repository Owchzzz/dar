<template>
	<div class="surveys">
		<sweet-modal ref="newSurveyModal">
			<h2>Survey Form</h2>
			<hr />
			<form class="form locationProfileForm text-left" ref="createForm">

				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<label class="form-label">Ced/PLS/GSS.</label>
							<input class="form-control" type="text" name="ced" placeholder="" />
						</div>
					</div>
				</div>
				<hr />
				<div class="row mt-10">
					<div class="col-sm-6">
						<div class="form-group">
							<label class="form-label">Lot No.</label>
							<input class="form-control" type="text" name="field_id" placeholder="Lot." readonly @click="$refs.locationSelectModal.open()"
							 ref="lotInpt" />
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label class="form-label">Patent No.</label>
							<input class="form-control" type="text" name="patent_no" placeholder="Patent No." />
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label class="form-label">Decreed</label>
							<input class="form-control" type="text" name="decree" placeholder="Decreed" />
						</div>
					</div>

				</div>

				<div class="row">

					<div class="col-sm-12">
						<div class="form-group">
							<label class="form-label">LRC Rec No.</label>
							<input class="form-control" type="text" name="lrc" placeholder="LRC" />
						</div>
					</div>

				</div>

				<div class="row">

					<div class="col-sm-6">
						<div class="form-group">
							<label class="form-label">OCT.</label>
							<input class="form-control" type="text" name="oct" placeholder="OCT" />
						</div>
					</div>

					<div class="col-sm-6">
						<div class="form-group">
							<label class="form-label">TCT.</label>
							<input class="form-control" type="text" name="tct" placeholder="TCT" />
						</div>
					</div>

				</div>

				<div class="col-xs-12">
					<input type="submit" class="btn btn-md btn-success col-xs-12" />
				</div>
			</form>

		</sweet-modal> <!-- Create new survey Modal -->

		<sweet-modal width="80%" ref="locationSelectModal">
			<div class="row">
				<div class="col-xs-12">
					<h2>Field Selector</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-7">
					<table class="table table-hoverable">
						<thead>
							<tr>
								<th colspan="2" class="text-center">Field Address</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="field in fields" :key="field.id">
								<td>
									<span class="label label-sm label-info pull-left" v-if="previewField == field">Previewing</span>
									{{field.lot_no}}, {{field.barangay}}, {{field.city}} {{field.province}}
								</td>
								<td class="text-right">
									<button class="btn btn-sm btn-warning" @click="selectField(field)"><i class="fa fa-eye"></i> Preview</button>
									<button class="btn btn-sm btn-success" @click="submitFieldSelection(field)"><i class="fa fa-pencil"></i> Select</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="col-xs-5">
					<transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut" mode="out-in">
						<div class="text-center align-middle" v-if="!previewField">
							<i class="fa fa-5x fa-eye"></i><br />
							Select a field to preview all data
						</div>
						<div class="text-left" v-else>
							<h2 class="text-center">Field Data</h2>
							<table class="table fieldData">
								<tbody>
									<tr v-for="(val,key) in previewField" :key="key" v-if="! skip(key)">
										<!-- <td>{{val}}</td>
                                        <td v-if="val != 'bearings'">{{key}}</td>
                                        <td v-else><span v-if="key">TRUE</span><span v-else>FALSE</span></td> -->
										<td>
											<div class="form-group row">
												<label class="form-label col-sm-4">{{key}}</label>
												<input class="form-control-plaintext col-sm-8" readonly v-if="key !=='bearings'" :value="val" />
												<input class="form-control-plaintext col-sm-8" readonly v-else :value="(val) ? 'TRUE' : 'FALSE'" />
											</div>
										</td>
									</tr>
								</tbody>
							</table>
							<button class="btn btn-lg btn-success col-sm-12" @click="submitFieldSelection(previewField)"> <i class="fa fa-pencil"></i> Select this field</button>
						</div>
					</transition>
				</div>
			</div>
		</sweet-modal> <!-- Location Select Modal -->

		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="breadcome-list single-page-breadcome">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <h2 class="pull-left">Survey Management Panel</h2>
								<div class="breadcome-heading">
									<button class="btn btn-md btn-primary pull-right" @click="$refs.newSurveyModal.open()">Create New Survey</button>
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</div> <!-- End of Command module -->
			
			<div class="row">

				<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="margin-top:10px;" v-for="survey in surveys" :key="survey.id">
					<div class="hpanel widget-int-shape responsive-mg-b-30 res-tablet-mg-t-30 dk-res-t-pro-30">
						<div class="panel-body">
							<div class="text-center content-box">
								<h2 class="m-b-xs"><span class="sm-text">Ced</span></h2>
								<p class="font-bold text-warning">{{survey.ced}}</p>
								<div class="m icon-box">
									<i class="fa fa-2x fa-map"></i>
								</div>
								<p class="small mg-t-box">
									Current Activity: Changed CF Status.
								</p>
								<button class="btn btn-warning widget-btn-3 btn-sm" @click="selectSurvey(survey)">Select Survey</button>
							</div>
						</div>
					</div>
				</div>
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

	import axios from 'axios';
	export default {
		components: {
			SweetModal
		},
		data() {
			return {
				surveys: [],
				fields: [],
				previewField: false,
				currentUserId: false
			}
		},
		methods: {
			createSurvey(e) {
				e.preventDefault();
				let form = this.$refs.createForm;
				let data = this.$parse(form); // Serialize the form data with FormPack
				data.field_id = this.previewField.id;
				console.log(data)
				this.$create(data, resp => {
					console.log('created new data:');
					console.log(resp);
					let nodes = this.$refs.createForm.querySelectorAll('input[type="text"],input[type="number"],textarea,select');

					for(let i = 0; i < nodes.length; i++) {
						nodes[i].value = '';
					}
					this.surveys.unshift(resp)
					swal('Survey Form','You have successfully created a survey.','success');
					this.$refs.newSurveyModal.close();
				});
			},

			selectField(f) {
				this.previewField = f;
			},
			submitFieldSelection(f) {
				this.previewField = f;
				this.$refs.locationSelectModal.close();
				this.$refs.lotInpt.value = `${f.lot_no}, ${f.barangay} ${f.city}, ${f.province}`;
			},
			skip(k) {
				let skippable = ['id', 'survey_for', 'creator_id'];
				return skippable.find(i => {
					return i == k;
				});
			},
			formatTitle() {

			},
			selectSurvey(survey) {
				window.location = window.location.href+"/view/"+survey.id;
			}
		},
		mounted() {
			
			this.$get(data => {
				this.surveys = data;
				console.log('Survey Data:',this.surveys);
			});

			this.$refs.createForm.addEventListener('submit',this.createSurvey);

			axios.get('api/field/get')
				.then(resp => {
					this.fields = resp.data;
				});
		}
	}

</script>
<style lang="scss" scoped>
	.fieldData {
		max-height: 500px;
		overflow-y: scroll;
	}

</style>
