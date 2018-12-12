<template>
	<div class="location-controller">

		<sweet-modal ref="locationModal">
			<h1>Field Profile</h1>
			<form class="form locationProfileForm" ref="createForm">

				<div class="form-group">
					<label class="form-label">As Surveyed For</label>
					<input class="form-control" type="text" name="survey_for" placeholder="Survey For" required/>
				</div>
				<hr/>

				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label class="form-label">lot no.</label>
							<input class="form-control" type="text" name="lot_no" placeholder="LOT No." />
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label class="form-label">psd</label>
							<input class="form-control" type="text" name="psd" placeholder="PSD" />
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label class="form-label">rurban code</label>
							<input class="form-control" type="text" name="rurban_code" placeholder="RURBAN CODE" />
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label class="form-label">barangay</label>
							<input class="form-control" type="text" name="barangay" placeholder="Barangay" />
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label class="form-label">city</label>
							<input class="form-control" type="text" name="city" placeholder="City" />
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label class="form-label">province</label>
							<input class="form-control" type="text" name="province" placeholder="Province" />
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="form-label">Island</label>
					<input class="form-control" type="text" name="island" placeholder="Island" />
				</div>

				<div class="form-group">
					<label class="form-label">Area (sq.m)</label>
					<input class="form-control" type="number" name="area" placeholder="Area (sq.m)" />
				</div>

				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							<label class="form-label">ppcs zone</label>
							<input class="form-control" type="text" name="ppcs" placeholder="PPCS ZONE NO" />
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label class="form-label">bearings</label>
							<select class="form-control" name="bearings">
								<option value="1">TRUE</option>
								<option value="0">FALSE</option>
							</select>

						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label class="form-label">scale</label>
							<input class="form-control" type="number" name="scale" placeholder="SCALE" />
						</div>
					</div>
					
				</div>

				<div class="col-xs-12">
					<input type="submit" class="btn btn-md btn-success col-xs-12"/>
				</div>
			</form>
		</sweet-modal>

		<!-- End of Modals -->

		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="breadcome-list single-page-breadcome">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<div class="breadcome-heading">
									<button class="btn btn-lg btn-primary" @click="$refs.locationModal.open()">Create New Field</button>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

							</div>
						</div>
					</div>
				</div>
			</div> <!-- End of Command module -->

			<div class="row">
				<div class="col-xs-12">
					<div class="product-status-wrap">
					<table class="table">
						<thead>
							<tr>
								<th style="width:20px;text-align:center"></th>
								<th>Lot No.</th>
								<th>Rurban code</th>
								<th>Barangay</th>
								<th>City</th>
								<th>Province</th>
								<th>Island</th>
								<th>Area</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(field,index) in fields" :key="field.id">
								<td class="text-center w-10" style="color:#155cf3;font-size:11px;padding-top:10px">{{index+1}}</td>
								<td>{{ field.lot_no }}</td>
								<td>{{field.rurban_code}}</td>
								<td>{{field.barangay}}</td>
								<td>{{field.city}}</td>
								<td>{{field.province}}</td>
								<td>{{field.island}}</td>
								<td>{{field.area}}sq.m</td>
							</tr>
						</tbody>
					</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>

	// Import SweetModal
	import {
		SweetModal,
		SweetModalTab
	} from 'sweet-modal-vue';
	import swal from 'sweetalert';
	import DatePick from 'vue-date-pick';
	import 'vue-date-pick/dist/vueDatePick.css';

	export default {
		data() {
			return{
				fields: [],
				originalDate: '2019.01.01'
			}
		},

		components: {
			SweetModal,
			DatePick
		},

		methods: {

			/**
			 * Creates a field
			 */
			createField(e) {
				e.preventDefault(); // Prevent the default formsubmission

				let form = this.$refs.createForm;
				let data = this.$parse(form); // Serialize the form data with FormPack

				console.log(data);
				this.$create(data, (resp) => {
					this.fields.unshift(data); // Add the field to the current list without requesting new get request
					let nodes = this.$refs.createForm.querySelectorAll('input[type="text"],input[type="number"],textarea,select');
					console.log('nodes:',nodes);

					for(let i = 0; i < nodes.length; i++) {
						nodes[i].value = '';
					}

					swal('Field Profile','You have created a field profile','success');
					this.$refs.locationModal.close();

				}); // Createis called from the vue plugin
			}
		},
		mounted() {
			// this.$refs.alertmodal.open();
			this.$refs.createForm.addEventListener('submit',this.createField);

			this.$get(data => {
				console.log('response:',data);
				this.fields = data;
			});
		}
	}

</script>
<style lang="scss">
	.locationProfileForm {
		text-align: left;

		.form-label {
			text-transform: uppercase;
		}

		.row {
			margin-bottom:10px;
		}
	}

	.vdpComponent {
		width:100%;
		font-size:12px;
		input[type="text"] {
			padding:10px;
			width:100%;
		}
	}

	.nopadding {
		padding:0 !important;
	}
</style>

