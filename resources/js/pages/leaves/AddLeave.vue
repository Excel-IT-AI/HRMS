<template>
      <div class="content-header row">
        <div class="content-header-left col-md-7 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
            <h2 class="content-header-title float-left mb-0">Add Leave</h2>
            <div class="breadcrumb-wrapper">
                <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <router-link :to="{ name: 'Dashboard' }">Dashboard</router-link>
                </li>
                <li class="breadcrumb-item">
                    <router-link :to="{ name: 'Leaves' }">Leave List</router-link>
                </li>
                <li class="breadcrumb-item active">ADD Leave</li>
                </ol>
            </div>
            </div>
        </div>
        </div>
        <div class="content-header-right text-md-right col-md-5 col-12 d-flex justify-content-end mb-2">
        <!-- <button type="button" class="btn btn-primary mr-2 waves-effect waves-float waves-light">
            Export Excel
        </button>
        <router-link :to="{name:'AddLeave'}" class="btn btn-success waves-effect waves-float waves-light">
            Add Leave
        </router-link> -->
        </div>
  </div>

  <div class="content-body">
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
</template>


<script>
import Swal from 'sweetalert2';
import LeaveApi from '../../api/LeaveApi';
import LeaveTypeApi from '../../api/LeaveTypeApi'
import Form from './utilites/Form';
import ResetForm from './utilites/ResetForm';
import Employee from '../../api/Employee';
import FormPickers from '../../core/form-pickers.js'
export default {
  data(){
    return {
        isClicked:false,
        form:{
            leave_type_id:"",
            date_from:"",
            date_to:"",
            days:"",
            reason:"",
            remarks:"",
            employee_id:"",
            status:false

        },
        leaveTypeList:[],
        employeeList:[]
    }
  },
  computed:{
      setDays(){
            if(this.form.date_to == '' || this.form.date_from == ''){
                return this.form.days;
            }

            let date_from = new Date(this.form.date_from);
            let date_to   = new Date(this.form.date_to);
            // To calculate the time difference of two dates
            let Difference_In_Time = date_to.getTime() - date_from.getTime();
            // To calculate the no. of days between two dates
            //1000 is miliseconds 3600 minutes in 1 day and 24 hours a day
            return this.form.days = Difference_In_Time / (1000 * 3600 * 24);

      }
  },
  methods:{
      AddLeave(){
            this.isClicked = true;
            LeaveApi.addLeave(Form(this.form))
                   .then(({data})=>{
                       this.isClicked = false;
                       ResetForm(this.form);
                       Swal.fire('success',data.success,'success')
                   })
                   .catch(error=>{
                       this.isClicked = false;
                       console.log(error);
                   })
      },
      getLeaveTypes(){
          LeaveTypeApi.getLeaveTypes()
            .then(({data})=>{
                console.log(data.leaveTypeList);
                this.leaveTypeList= data.leaveTypeList;
            })
            .catch(error=>{
                console.log(error);
            })
      },
      getEmployees(){
          Employee.getEmployees()
                .then(({data})=>{
                    console.log(data);
                    this.employeeList = data.employees;
                })
                .catch(error=>{
                    console.log(error)
                })

      }
  },
  mounted(){
      FormPickers();
      this.getLeaveTypes();
      this.getEmployees()
  }
}
</script>
