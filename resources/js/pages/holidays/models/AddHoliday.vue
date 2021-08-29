
<template>
     <section>
      <div class="row">
        <div class="col-12">
          <!-- Basic trigger modal -->
          <div class="basic-modal">
            <!-- add modal Modal -->
            <div
              class="edit_custom_modal"
            >
              <div class="modal-dialog" role="document">
                <div class="modal-content" id="modal_content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel1">Add Leave Type</h4>
                    <button
                      type="button"
                      class="close"
                      data-dismiss="modal"
                      aria-label="Close"
                      @click.prevent="hideModal"
                    >
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form>
                        <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="employee_id">Select Employee</label>
                                    <select
                                        v-model="form.employee_id"
                                        class="custom-select"
                                        name="employee_id"
                                        id="employee_id"
                                    >
                                        <option selected="">Select Employee</option>
                                        <option :value="employee.id" v-for="employee in employeeList" :key="employee.id" >
                                            {{employee.employee_name}}
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="leave_type_id">Leave Type</label>
                                    <select
                                        v-model="form.leave_type_id"
                                        class="custom-select"
                                        name="leave_type_id"
                                        id="leave_type_id"
                                    >
                                        <option selected="">Select Leave Type</option>
                                        <option :value="leaveType.id" v-for="leaveType in leaveTypeList" :key="leaveType.id" >{{leaveType.leave_type.toUpperCase()}}</option>
                                    </select>
                                </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="joining_date">Date From</label>
                                <input
                                    v-model="form.date_from"
                                    type="text"
                                    name="date_from"
                                    class="form-control flatpickr-basic flatpickr-input"
                                    placeholder="YYYY-MM-DD"
                                    readonly="readonly"
                                />
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="date_from">Date To</label>
                                <input
                                    v-model="form.date_to"
                                    type="text"
                                    name="date_to"
                                    class="form-control flatpickr-basic flatpickr-input"
                                    placeholder="YYYY-MM-DD"
                                    readonly="readonly"
                                />
                            </div>
                        </div>
                        <!-- nid_number and religion -->
                        <div class="row">

                            <div class="col-md-6 form-group">
                                <label for="days">Days</label>
                                <input
                                    v-model="setDays"
                                    type="text"
                                    name="days"
                                    class="form-control"
                                    placeholder="DD"
                                    readonly="readonly"
                                />
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="remarks">Remarks</label>
                                <textarea name="remarks"
                                    class="form-control"
                                    v-model="form.remarks"
                                    placeholder="Enter Remarks"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="reason">Reason</label>
                                <textarea name="reason"
                                    class="form-control"
                                    v-model="form.reason"
                                    placeholder="Enter Reason"></textarea>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group col-md-6">
                                    <div class="custom-control custom-checkbox mt-2">
                                        <input
                                        class="custom-control-input"
                                        type="checkbox"
                                        v-model="form.status"
                                        id="status"
                                        name="status"
                                        tabindex="3"
                                        />
                                        <label class="custom-control-label" for="status">
                                        Status
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button
                            type="submit"
                            :disabled="isClicked"
                            @click.prevent="AddLeave"
                            class="btn btn-primary"
                            >
                            {{ isClicked ? "Please Wait..." : "Add Leave" }}
                        </button>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-success"   @click.prevent="hideModal" >
                      close
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Basic trigger modal end -->
        </div>
      </div>
    </section>
</template>


<script>

import Swal from 'sweetalert2';
import LeaveTypeApi from '../../../../api/LeaveTypeApi';
import Form from '../utilites/Form.js'
import ResetForm from '../utilites/ResetForm.js'
export default {
    props:['leave_id'],
    data(){
        return {
            isClicked:false,
            form:{
                leave_type:"",
                description:"",
                status:false
            },
            leaveTypeList:[],
            employeeList:[],
            errors:[]
        }
    },
    computed:{
        hideModal(){
                this.$emit('hideLeaveAddModal',{bool:false});
            },
    },
    methods:{
        AddLeaveType(){
            this.isClicked = true;
            LeaveTypeApi.addLeaveType(Form(this.form))
                .then(({data})=>{
                    this.isClicked = false;
                    ResetForm(this.form);
                    this.hideModal ///hide the edit leave modal
                    Swal.fire('success',data.success,'success'); //then show success message

                })
                .catch(error=>{
                    this.isClicked = false;
                    console.log(error.response);
                    if(error?.response?.status == 422){
                        this.errors = error.response.data.errors
                    }
                    else{
                        Swal.fire('Error!',error.response.data.error,'error');
                    }
                })
        },


    },
    mounted(){

    }
}
</script>






<style scoped>
    .edit_custom_modal{
        position:fixed;top:0;right:0;left:0;bottom:0;
        background:rgba(0,0,0,0.3);
        z-index:99;
        height:100vh;
        overflow-y: scroll;
        width:100vw;
    }
    .modal-dialog{
        z-index:1000000 ;
        width:80%;
        text-align: center;
        position:relative;
        left:-10%;

    }
    #modal_content{
        width:1000px !important;
        /* width:100% */

    }
</style>
