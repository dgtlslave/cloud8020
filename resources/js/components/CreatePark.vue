<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <span>Create new park</span>
                            <div>
                                <a href="/park" class="btn btn-sm btn-info">Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label for="v_p_name">Vehicle park name</label>
                                <input type="text" class="form-control" placeholder="ATP-153" v-model="form.v_p_name">
                            </div>
                            <div class="form-group">
                                <label for="v_p_address">Vehicle park address</label>
                                <input type="text" name="v_p_address" class="form-control" placeholder="Detroit city, Lincoln str., 17B" v-model="form.v_p_address">
                            </div>
                            <div class="d-flex">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="v_p_address">Beginning of work</label>
                                                <select class="form-control" v-model="form.start" id="role_perm">
                                                    <option selected value="8:00">7:00</option>
                                                    <option value="8:30">7:30</option>
                                                    <option value="9:00">8:00</option>
                                                    <option value="8:30">8:30</option>
                                                    <option value="9:00">9:00</option>
                                                    <option value="9:30">9:30</option>
                                                    <option value="10:00">10:00</option>
                                                    <option value="10:30">10:30</option>
                                                    <option value="11:00">11:00</option>
                                                    <option value="11:30">11:30</option>
                                                    <option value="12:00">12:00</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="v_p_address">End of work</label>
                                                <select class="form-control" v-model="form.end" id="role_perm">
                                                    <option selected value="17:00">17:00</option>
                                                    <option value="17:30">17:30</option>
                                                    <option value="18:00">18:00</option>
                                                    <option value="18:30">18:30</option>
                                                    <option value="19:00">19:00</option>
                                                    <option value="19:30">19:30</option>
                                                    <option value="20:00">20:00</option>
                                                    <option value="20:30">20:30</option>
                                                    <option value="21:00">21:00</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <div class="container">
                                <div class="row mb-2">
                                    <div class="col-md-4 text-center">Vehicle number</div>
                                    <div class="col-md-6 text-center">Driver name</div>
                                    <div class="col-md-2 text-center">
                                        <button @click.prevent="addRow()" class="btn btn-sm btn-success">Add driver</button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <!-- <label class="text-center" for="vehicle_number">Vehicle number</label> -->
                                            <input type="text" class="form-control" v-model="vehicle_number">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <div class="form-group">
                                            <!-- <label class="text-center" for="driver_name">Driver name</label> -->
                                            <input type="text" class="form-control" v-model="driver_name">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <table class="table table-sm" v-show="form.vehicles">
                                        <tbody>
                                            <tr style="width:100%;" v-for="(vehicle, index) in form.vehicles">
                                                <td class="text-center" style="width:9%;">{{ index + 1 }}</td>
                                                <td class="text-center" style="width:20%;">{{ vehicle.number }}</td>
                                                <td class="text-left" style="width:34%;">{{ vehicle.driver }}</td>
                                                <td class="text-right" style="width:27%;">
                                                    <button class="btn btn-danger btn-sm" @click.prevent="removeRow(index)">Remove</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <button type="submit" @click.prevent="saveForm()" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import swal from 'sweetalert2'
import axios from 'axios'

export default {
    data(){
        return {
            vehicle_number: '',
            driver_name: '',
            form: {
               vehicles: [],
               v_p_address: '',
               v_p_name: '',
               start: '',
               end: '',
            },
            errors: ''
        }
    },
    methods: {
        addRow() {
            if(this.vehicle_number.length != 0 && this.driver_name.length != 0) {
                let number = this.vehicle_number
                number = number.trim().replace(/\s/g, "").toUpperCase()
                this.form.vehicles.push({'number': number, 'driver': this.driver_name })
                this.vehicle_number = ''
                this.driver_name = ''
                number = ''
            } else {
                return alert('You need paste all line!')
            }
        },
        removeRow(index) {
            this.form.vehicles.splice(index, 1)
        },
        saveForm() {
            axios.post('/savePark', this.form).then((response)=>{
                if(response.data == true){
                    swal.fire('Success', 'Park successfuly saved', 'success').then((result) => {
                        window.location.href = 'https://atptest.site/park'
                    })
                } else {
                    swal.fire('Error','Something went wrong','error')
                }
            }).catch((errors)=>{
                if(errors.response.data.errors.v_p_name) {
                    swal.fire('Error', 'Please fill park name field and try again. Thanks.', 'error' )
                } else if(errors.response.data.errors.v_p_address) {
                    swal.fire('Error', 'Please fill park address field and try again. Thanks.', 'error' )
                }
                console.log(errors.response.data.errors);

            })
        }


    },

    mounted() {

    },
}

</script>
